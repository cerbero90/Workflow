<?php namespace Cerbero\Workflow\Scaffolding;

use Cerbero\Workflow\WorkflowDataTransfer as Workflow;
use Illuminate\View\Factory as View;
use Illuminate\Filesystem\Filesystem as File;

/**
 * Compile templates from views.
 *
 * @author	Andrea Marco Sartori
 */
class ViewCompiler implements CompilerInterface
{

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Illuminate\View\Factory	$view	Views factory.
	 */
	protected $view;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Illuminate\Filesystem\Filesystem	$file	Laravel filesystem.
	 */
	protected $file;
	
	/**
	 * Set the dependencies.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Illuminate\View\Factory	$view
	 * @return	void
	 */
	public function __construct(View $view, File $file)
	{
		$this->view = $view;

		$this->file = $file;
	}

	/**
	 * Compile the template.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$template
	 * @param	Cerbero\Workflow\WorkflowDataTransfer	$workflow
	 * @return	string
	 */
	public function compile($template, Workflow $workflow)
	{
		$content = $this->getContent($template);

		return $this->templatePopulatedBy($workflow, $content);
	}

	/**
	 * Retrieve the content of a template.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$template
	 * @return	string
	 */
	protected function getContent($template)
	{
		$path = $this->view->make("workflow::{$template}")->getPath();

		return $this->file->get($path);
	}

	/**
	 * Replace the placeholders.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Cerbero\Workflow\WorkflowDataTransfer	$workflow
	 * @param	string	$content
	 * @return	string
	 */
	protected function templatePopulatedBy(Workflow $workflow, $content)
	{
		$content = $this->nestTemplates($workflow, $content);

		return preg_replace_callback('/\$([a-z]+)\$/', function($matches) use($workflow)
		{
			return $workflow->{$matches[1]};

		}, $content);
	}

	/**
	 * Put one template inside another.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Cerbero\Workflow\WorkflowDataTransfer	$workflow
	 * @param	string	$content
	 * @return	string
	 */
	protected function nestTemplates(Workflow $workflow, $content)
	{
		for($i = 0; $i < count($decos = $workflow->decorators); $i++)
		{
			$bind = $this->compileBind($decos[$i], $i + 1);

			$content = str_replace('#bind#', $bind, $content);
		}
		return str_replace('#bind#', '$namespace$\$name$', $content);
	}

	/**
	 * Compile a bind template.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$decorator
	 * @return	string
	 */
	protected function compileBind($decorator, $tabs)
	{
		$bind = $this->getContent('bind');

		$tab = str_repeat("\t", $tabs);

		return str_replace(['$decorator$', '$tab$'], [$decorator, $tab], $bind);
	}

}
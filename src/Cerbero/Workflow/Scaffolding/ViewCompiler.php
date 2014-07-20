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
		$path = $this->view->make("workflow::{$template}")->getPath();

		$content = $this->file->get($path);

		return $this->templatePopulatedBy($workflow, $content);
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
		return preg_replace_callback('/\$([a-z]+)\$/', function($matches) use($workflow)
		{
			return $workflow->{$matches[1]};

		}, $content);
	}

}
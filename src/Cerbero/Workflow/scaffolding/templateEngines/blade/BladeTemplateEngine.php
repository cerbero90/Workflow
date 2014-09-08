<?php namespace Cerbero\Workflow\Scaffolding\TemplateEngines\Blade;

use Cerbero\Workflow\Scaffolding\TemplateEngines\TemplateEngineInterface;
use Illuminate\View\Factory as Blade;

/**
 * Blade implementation of template engine.
 *
 * @author	Andrea Marco Sartori
 */
class BladeTemplateEngine implements TemplateEngineInterface
{

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Illuminate\View\Factory	$blade	Laravel view maker using Blade template engine.
	 */
	protected $blade;
	
	/**
	 * Set the dependencies.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Illuminate\View\Factory	$blade
	 * @return	void
	 */
	public function __construct(Blade $blade)
	{
		$this->blade = $blade;
	}

	/**
	 * Render the template with custom values.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$template
	 * @param	array	$data
	 * @return	string
	 */
	public function render($template, array $data)
	{
		return $this->blade->make($template, $data)->render();
	}

}
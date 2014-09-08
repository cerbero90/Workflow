<?php namespace Cerbero\Workflow\Scaffolding\Generators;

use Cerbero\Workflow\Scaffolding\TemplateEngines\TemplateEngineInterface;
use Illuminate\Filesystem\Filesystem;

/**
 * Abstract implementation of a generator.
 *
 * @author	Andrea Marco Sartori
 */
abstract class AbstractGenerator implements GeneratorInterface
{

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Cerbero\Workflow\Scaffolding\TemplateEngines\TemplateEngineInterface	$template	Template engine.
	 */
	protected $template;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Illuinate\Filesystem\Filesystem	$file	File system.
	 */
	protected $file;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		array	$data	Template context.
	 */
	protected $data;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		boolean	$append	Allow appending content to an existing file.
	 */
	protected $append = false;
	
	/**
	 * Set the dependencies.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Cerbero\Workflow\Scaffolding\TemplateEngines\TemplateEngineInterface	$template
	 * @return	void
	 */
	public function __construct(TemplateEngineInterface $template, Filesystem $file)
	{
		$this->template = $template;

		$this->file = $file;
	}

	/**
	 * Generate the scaffolding files.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array	$data
	 * @return	boolean
	 */
	public function generate(array $data)
	{
		$this->data = $data;

		if($this->alreadyExists()) return true;

		$this->createFoldersIfNotExist($path = $this->getPath());

		$content = $this->template->render($this->getTemplate(), $data);

		return $this->createOrAppend($path, $content);
	}

	/**
	 * Retrieve the template name.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string
	 */
	abstract protected function getTemplate();

	/**
	 * Retrieve the filename relative to the workflow path.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string
	 */
	abstract protected function getFilename();

	/**
	 * Determine whether a file has been already generated.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	boolean
	 */
	protected function alreadyExists()
	{
		$path = $this->getPath();

		return $this->file->exists($path) && ! $this->append;
	}

	/**
	 * Retrieve the file destination.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string
	 */
	protected function getPath()
	{
		$path = $this->data['path'];

		$filename = $this->getFilename();

		return str_replace(['///', '//'], '/', "{$path}/{$filename}");
	}

	/**
	 * Create folders if they don't exist.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$filename
	 * @return	void
	 */
	private function createFoldersIfNotExist($path)
	{
		$folder = substr($path, 0, strrpos($path, '/'));

		if( ! $this->file->exists($folder))
		{
			$this->file->makeDirectory($folder, 0755, true);
		}
	}

	/**
	 * Create a new file or append content to an existing one.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$path
	 * @param	string	$content
	 * @return	boolean
	 */
	private function createOrAppend($path, $content)
	{
		$method = $this->append ? 'append' : 'put';

		return $this->file->$method($path, $content) !== false;
	}

}
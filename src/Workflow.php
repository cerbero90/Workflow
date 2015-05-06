<?php namespace Cerbero\Workflow;

use Cerbero\Workflow\Repositories\PipelineRepositoryInterface;
use Cerbero\Workflow\Wrappers\PipingDispatcherInterface;
use Cerbero\Workflow\Inflectors\InflectorInterface;
use Illuminate\Contracts\Container\Container;

/**
 * Hub of the pipelines.
 *
 * @author	Andrea Marco Sartori
 */
class Workflow {

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Cerbero\Workflow\Repositories\PipelineRepositoryInterface	$pipelines	Pipelines repository.
	 */
	protected $pipelines;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Cerbero\Workflow\Wrappers\PipingDispatcherInterface	$dispatcher	Bus dispatcher.
	 */
	protected $dispatcher;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Cerbero\Workflow\Inflectors\InflectorInterface	$inflector	Inflector.
	 */
	protected $inflector;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Illuminate\Contracts\Container\Container	$container	Service container.
	 */
	protected $container;
	
	/**
	 * Set the dependencies.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Cerbero\Workflow\Repositories\PipelineRepositoryInterface	$pipelines
	 * @param	Cerbero\Workflow\Wrappers\PipingDispatcherInterface	$dispatcher
	 * @param	Cerbero\Workflow\Inflectors\InflectorInterface	$inflector
	 * @param	Illuminate\Contracts\Container\Container	$container
	 * @return	void
	 */
	public function __construct(
		PipelineRepositoryInterface $pipelines,
		PipingDispatcherInterface $dispatcher,
		InflectorInterface $inflector,
		Container $container
	) {
		$this->pipelines  = $pipelines;
		$this->dispatcher = $dispatcher;
		$this->inflector  = $inflector;
		$this->container  = $container;
	}

	/**
	 * Dynamically call pipelines.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$name
	 * @param	array	$arguments
	 * @return	mixed
	 */
	public function __call($name, $arguments)
	{
		$this->failIfNotExists($name);

		$this->inflector->of($name);

		return $this->dispatchWorkflow($name);
	}

	/**
	 * Throw an exception if the given workflow does not exist.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$workflow
	 * @return	void
	 */
	protected function failIfNotExists($workflow)
	{
		if( ! $this->pipelines->exists($workflow))
		{
			$error = "The workflow [$workflow] does not exist.";

			throw new \BadFunctionCallException($error);
		}
	}

	/**
	 * Dispatch the given workflow.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$workflow
	 * @return	mixed
	 */
	protected function dispatchWorkflow($workflow)
	{
		$request = $this->resolveRequest();

		$command = $this->inflector->getCommand();

		$pipes = $this->pipelines->getPipesByPipeline($workflow);

		$parameters = $this->container->make('router')->current()->parameters();

		return $this->dispatcher->pipeThrough($pipes)->dispatchFrom($command, $request, $parameters);
	}

	/**
	 * Resolve the apter request.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	Illuminate\Http\Request
	 */
	protected function resolveRequest()
	{
		if(class_exists($request = $this->inflector->getRequest()))
		{
			return $this->container->make($request);
		}

		return $this->container->make('Illuminate\Http\Request');
	}

}

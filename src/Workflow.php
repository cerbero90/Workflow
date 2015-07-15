<?php namespace Cerbero\Workflow;

use Cerbero\Workflow\Repositories\PipelineRepositoryInterface;
use Cerbero\Workflow\Inflectors\InflectorInterface;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Bus\Dispatcher;

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
	 * @var		Cerbero\Workflow\Inflectors\InflectorInterface	$inflector	Inflector.
	 */
	protected $inflector;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Illuminate\Contracts\Container\Container	$container	Service container.
	 */
	protected $container;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Illuminate\Contracts\Bus\Dispatcher	$dispatcher	Bus dispatcher.
	 */
	protected $dispatcher;
	
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
		InflectorInterface $inflector,
		Container $container,
		Dispatcher $dispatcher
	) {
		$this->pipelines  = $pipelines;
		$this->inflector  = $inflector;
		$this->container  = $container;
		$this->dispatcher = $dispatcher;
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
		$job = $this->inflector->getJob();

		$request = $this->resolveRequest();

		$pipes = $this->pipelines->getPipesByPipeline($workflow);

		$parameters = $this->container->make('router')->current()->parameters();

		return $this->dispatcher->pipeThrough($pipes)->dispatchFrom($job, $request, $parameters);
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

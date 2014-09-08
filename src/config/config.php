<?php

return [

	/*
	 * The directory to put files in.
	 */
	'path' => app_path('workflows'),

	/*
	 * The namespace of the generated classes.
	 */
	'namespace' => 'Workflows',

	/*
	 * The default method name to run the workflow.
	 */
	'method' => 'run',

	/*
	 * Your name in PHP comments, set NULL to disable it.
	 */
	'author' => null,

	/*
	 * Process to run after validation failure.
	 */
	'validation_failure' => function(Cerbero\Workflow\Common\Validation\Exception $exception)
	{
		return Redirect::back()->withInput()->withErrors($exception->errors);
	},

];
<?php

return [

	/*
	 * The main folder to place the workflows
	 */
	'folder' => 'workflows',

	/*
	 * Your Laravel project namespace
	 */
	'namespace' => '',

	/*
	 * Process to run after validation failure
	 */
	'validation_failure' => function(Cerbero\Workflow\Validation\Exception $exception)
	{
		return Redirect::back()->withInput()->withErrors($exception->errors);
	},

];
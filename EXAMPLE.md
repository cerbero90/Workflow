# Sample Workflow: Registration #

Let's imagine we want to create a workflow to register users to our application.

Our main goal is storing user's information, but we also want to validate inputs and notify the user about the successfully registration.

Let's create the workflow:
```
php artisan workflow registration
```
Artisan will ask us the name of the method to run the registration, `register` sounds good.

Now we are prompted to write the decorators list, let's insert `validator notifier`.

These are the generated files:
```
workflows/
  Registration/
    decorators/
      Notifier.php
      Validator.php
    Registration.php
    RegistrationInterface.php
  bindings.php
```
You may see how the registration workflow is resolved by the IoC container in `workflows/bindings.php`

Now we have to make all these files visible to our application. To do this, add this line to the end of `app/start/global.php`:
```
require app_path('workflows/bindings.php');
```

add the workflows directory to `composer.json` like so:
```
"autoload": {
	"classmap": [
		"app/workflows"
	]
}
```
and finally run `composer dump-autoload -o`

For demostration purpose, let's add some outputs to the `register()` methods:

in `app/workflows/Registration/Registration.php`:
```
	public function register($data = null)
	{
		$credentials = json_encode($data);

		return "<br>I'm storing {$credentials}";
	}
```

in `app/workflows/Registration/decorators/Notifier.php`:
```
	public function register($data = null)
	{
		// Note that registration comes first
		return $this->registration->register($data) .

		"<br>I'm sending a welcome email to {$data['email']}";
	}
```

in `app/workflows/Registration/decorators/Validator.php`:
```
	public function register($data = null)
	{
		return "I'm validating " . json_encode($data) .
		// Note that registration comes later
		$this->registration->register($data);
	}
```

Finally we can inject the `RegistrationInterface` to a controller and run the workflow.

You may use the [SampleWorkflowController](http://laravel.io/bin/W3ozK) I've created for this example and register this route:
```
Route::get('sample-workflow', 'SampleWorkflowController@registration');
```

Now if you browse `/sample-workflows` you should see:
```
I'm validating {"email":"foo@example.com","password":"bar"}
I'm storing {"email":"foo@example.com","password":"bar"}
I'm sending a welcome email to foo@example.com
```

Basically this means that now you are able to add and remove functionality to your application features simply by adding or removing decorators.

You can keep controllers lightweight while letting Laravel know what things have to get done before and after a workflow has been run.

![](http://imageshack.com/a/img674/6060/59edf2.png "Workflow")
# Workflow #

This Laravel package adds an Artisan command to help you create extensible and maintainable projects by leveraging the [decorator pattern](http://en.wikipedia.org/wiki/Decorator_pattern).

### Installation ###

Run this command in your application root:
```
composer require --dev cerbero/workflow:1.*
```

Add this item to the `providers` array in `app/config/app.php`:
```
'Cerbero\Workflow\WorkflowServiceProvider',
```

#### Important ####

**Only after creating the first workflow** (see below) add this line to the end of `app/start/global.php`:
```
require app_path('workflows/bindings.php');
```

and the workflows directory to `composer.json` like so:
```
	"autoload": {
		"classmap": [
			"app/workflows"
		]
	}
```

### Basic Usage ###

Run this command to create a new workflow:
```
php artisan workflow YourWorkflowName
```

You will be prompted to insert two *optional* information:
 * the method name to run the workflow, if not provided `run()` will be used.
 * a list of decorators, you may separate them with any non-letter characters.

If this is the first workflow you created, be sure to follow the [last step of the installation](https://github.com/cerbero90/Workflow#important).

### Advanced Usage ###

You may set a different folder to save your workflows:
```
php artisan workflow --folder="YourFolder" YourWorkflowName
```

You may also set the namespace used by your project:
```
php artisan workflow --namespace="Your\Namespace" YourWorkflowName
```

To avoid adding the previous options every time, you may run:
```
php artisan config:publish cerbero/workflow
```
and edit `app/config/packages/cerbero/workflow/config.php`

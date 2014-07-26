![](http://imageshack.com/a/img674/6060/59edf2.png "Workflow")
# Workflow #

This Laravel package adds an Artisan command to help you create extensible and maintainable projects by leveraging the decorator pattern. You can find an [example here](https://github.com/cerbero90/Workflow/blob/master/EXAMPLE.md).

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
and finally run `composer dump-autoload -o`

### Usage ###

Run this command to create a new workflow:
```
php artisan workflow YourWorkflowName
```

You will be prompted to insert two *optional* information:
 * the method name to run the workflow, if not provided `run()` will be used.
 * a list of decorators, you may separate them with any non-letter characters.

If this is the first workflow you have created, be sure to follow the [last step of the installation](#important).

> **Note**: when a decorator contains *validat* in its name, it is automatically generated as a form validator

### Customization ###

To set your project namespace and a different folder to save the workflows, run:
```
php artisan config:publish cerbero/workflow
```
and edit `app/config/packages/cerbero/workflow/config.php`

---

To change the templates of the generated files, run:
```
php artisan view:publish cerbero/workflow
```
and edit the files in `app/views/packages/cerbero/workflow/`

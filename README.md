![](http://imageshack.com/a/img674/6060/59edf2.png "Workflow")
# Workflow #

This Laravel package adds an Artisan command to help you create extensible and maintainable projects by leveraging the decorators design pattern. You can see an [example here](https://github.com/cerbero90/workflow-demo).

Let's assume we want to develop a registration process: the main thing is to store the user data, but we also want to validate input and send a welcome email.

Since the main thing is data storing, everything else becomes a *decorator* of the registration workflow.

The idea behind this package is to automate the generation of classes and interfaces necessary for the decorators pattern as well as bind the generated files to the IoC container.

## Installation ##

Run this command in your application root:
```
composer require --dev cerbero/workflow:2.*
```

Add this item to the `providers` array in `app/config/app.php`:
```
'Cerbero\Workflow\WorkflowServiceProvider',
```

## Create a new workflow ##

Taking the previous example, we will be creating the registration workflow to illustrate the package functionality.

Run this command to create the new workflow:

```
php artisan workflow:create registration --decorators="validator notifier" --method="register"
```

Only the workflow name is mandatory, let's examine all the available options:

Option       | Description
------------ | -----------
--decorators | the list of the workflow decorators
--method     | the name of the method that triggers the workflow (default is `run`)
--path       | the directory to put files in (default is `app/workflows`)
--namespace  | the namespace of the generated files (default is `Workflows`)
--author     | your name in the generated files comments

The previous command generates the following files in `app/workflows`:

File (click to see an example)                      | Description
--------------------------------------------------- | -----------
[bindings.php][bindings]                            | bind workflows to the IoC container
[Registration/RegistrationInterface.php][interface] | interface shared by the main class and decorators
[Registration/Registration.php][main]               | the main class (i.e.: the one which stores user data)
[Registration/Decorators/Notifier.php][decorator]   | the decorator to send the welcome email
[Registration/Decorators/Validator.php][validator]  | the decorator to validate user input

[bindings]: https://github.com/cerbero90/workflow-demo/blob/master/app/workflows/bindings.php
[interface]: https://github.com/cerbero90/workflow-demo/blob/master/app/workflows/Registration/RegistrationInterface.php
[main]: https://github.com/cerbero90/workflow-demo/blob/master/app/workflows/Registration/Registration.php
[decorator]: https://github.com/cerbero90/workflow-demo/blob/master/app/workflows/Registration/decorators/Notifier.php
[validator]: https://github.com/cerbero90/workflow-demo/blob/master/app/workflows/Registration/decorators/Validator.php

### Autoload workflows ###

In order to let Laravel know how to load our workflows, we have to follow these steps once:

* add this line to the end of `app/start/global.php`:
```
require app_path('workflows/bindings.php');
```

* make sure the workflows directory is loaded, you may add it to `composer.json` like so:
```
"autoload": {
    "classmap": [
        "app/workflows"
    ]
}
```
* run `composer dump-autoload -o`

### Validators ###

When a decorator contains the part *validat* in its name, a form validator is automatically generated.

That means you only have to specify the rules within the `getRules()` method of the validator and the whole validation process just works.

By default when validation fails, the user is redirected back with input and errors: you may change this behavior by editing the package configuration.

### Configuration ###

To modify the package configuration, simply run:
```
php artisan config:publish cerbero/workflow
```

In `app/config/packages/cerbero/workflow/config.php` you may set default options to avoid inserting them everytime you create a new workflow.

Also, you may customize the process to run when validations fail.

## Drop an existing workflow ##

To irreversibly remove and unbind an existing workflow, i.e.: the previous registration workflow, run:

```
php artisan workflow:drop registration
```

A confirmation dialog will appear, just press ENTER to confirm or type `no` to deny.

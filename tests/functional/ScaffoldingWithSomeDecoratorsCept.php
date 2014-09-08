<?php 
$I = new FunctionalTester($scenario);
$I->am('developer');
$I->wantTo('generate a workflow with some decorators');

$I->cleanTemporaryFiles();
$I->runCommand('workflow:create login -d "foo bar baz"');

$I->seeInShellOutput('The workflow [Login] has been created successfully.');
$I->seeSameContentsIn('bindings.php', 'some_decorators/bindings.stub');
$I->seeSameContentsIn('Login/LoginInterface.php', 'some_decorators/interface.stub');
$I->seeSameContentsIn('Login/Login.php', 'some_decorators/main.stub');
$I->seeSameContentsIn('Login/Decorators/Foo.php', 'some_decorators/foo.stub');
$I->seeSameContentsIn('Login/Decorators/Bar.php', 'some_decorators/bar.stub');
$I->seeSameContentsIn('Login/Decorators/Baz.php', 'some_decorators/baz.stub');

$I->cleanTemporaryFiles();
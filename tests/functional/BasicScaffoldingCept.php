<?php 
$I = new FunctionalTester($scenario);
$I->am('developer');
$I->wantTo('generate a workflow with no decorators or custom options');

$I->cleanTemporaryFiles();
$I->runCommand('workflow:create registration');

$I->seeInShellOutput('The workflow [Registration] has been created successfully.');
$I->seeSameContentsIn('bindings.php', 'basic/bindings.stub');
$I->seeSameContentsIn('Registration/RegistrationInterface.php', 'basic/interface.stub');
$I->seeSameContentsIn('Registration/Registration.php', 'basic/main.stub');

$I->cleanTemporaryFiles();
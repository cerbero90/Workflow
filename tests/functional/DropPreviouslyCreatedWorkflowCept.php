<?php 
$I = new FunctionalTester($scenario);
$I->am('developer');
$I->wantTo('drop a previously created workflow');

$I->cleanTemporaryFiles();
$I->runCommand('workflow:create registration -d "validator notifier logger"');
$I->runNonInteractiveCommand('workflow:drop registration');

$I->seeInShellOutput('The workflow [Registration] has been dropped successfully.');
$I->seeSameContentsIn('bindings.php', 'drop_previously/bindings.stub');
$I->dontSeeDirectory('Registration');

$I->cleanTemporaryFiles();
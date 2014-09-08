<?php 
$I = new FunctionalTester($scenario);
$I->am('developer');
$I->wantTo('generate a workflow with a validator');

$I->cleanTemporaryFiles();
$I->runCommand('workflow:create hello -d validator');

$I->seeInShellOutput('The workflow [Hello] has been created successfully.');
$I->seeSameContentsIn('Hello/Decorators/Validator.php', 'validator/validator.stub');

$I->cleanTemporaryFiles();
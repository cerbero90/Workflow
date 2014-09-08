<?php 
$I = new FunctionalTester($scenario);
$I->am('developer');
$I->wantTo('generate a workflow using custom options');

$I->cleanTemporaryFiles();
$I->runCommand('workflow:create whatever -d "foo validator" --method="trigger" --namespace="FooSpace" --author="me"');

$I->seeInShellOutput('The workflow [Whatever] has been created successfully.');
$I->seeSameContentsIn('Whatever/WhateverInterface.php', 'custom_options/interface.stub');
$I->seeSameContentsIn('Whatever/Whatever.php', 'custom_options/main.stub');
$I->seeSameContentsIn('Whatever/Decorators/Foo.php', 'custom_options/decorator.stub');
$I->seeSameContentsIn('Whatever/Decorators/Validator.php', 'custom_options/validator.stub');

$I->cleanTemporaryFiles();
<?php 
$I = new FunctionalTester($scenario);
$I->am('developer');
$I->wantTo('generate a workflow using shortcuts');

$I->cleanTemporaryFiles();
$I->runCommand('workflow:create whatever -d "foo validator" -m trigger -s FooSpace -a me');

$I->seeInShellOutput('The workflow [Whatever] has been created successfully.');
$I->seeSameContentsIn('Whatever/WhateverInterface.php', 'shortcuts/interface.stub');
$I->seeSameContentsIn('Whatever/Whatever.php', 'shortcuts/main.stub');
$I->seeSameContentsIn('Whatever/Decorators/Foo.php', 'shortcuts/decorator.stub');
$I->seeSameContentsIn('Whatever/Decorators/Validator.php', 'shortcuts/validator.stub');

$I->cleanTemporaryFiles();
<?php

$I = new FunctionalTester($scenario);
$I->wantTo('see an error if the workflow to create already exists');

$I->runArtisan('workflow:create registerUser');
$I->seeInShellOutput('Workflow created successfully.');

$I->runArtisan('workflow:create registerUser');
$I->seeInShellOutput('The workflow [RegisterUser] already exists.');

$I->clearWorkflow('RegisterUser');

<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('create a workflow with no pipes');

$I->runArtisan('workflow:create LoginUser');

$I->seeInCommand('LoginUserCommand', 'NoPipes/LoginUserCommand.stub');
$I->seeInRequest('LoginUserRequest', 'NoPipes/LoginUserRequest.stub');
$I->seeInWorkflows('NoPipes/workflows.stub');
$I->seeInShellOutput('Command created successfully.');
$I->seeInShellOutput('Request created successfully.');
$I->dontSeeInShellOutput('Pipe created successfully.');
$I->seeInShellOutput('Workflow created successfully.');

$I->clearWorkflow('LoginUser');
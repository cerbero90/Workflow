<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('create a workflow with many pipes');

$I->runArtisan('workflow:create registerUser -a "Notifier Logger"');

$I->seeInCommand('RegisterUserCommand', 'ManyPipes/RegisterUserCommand.stub');
$I->seeInRequest('RegisterUserRequest', 'ManyPipes/RegisterUserRequest.stub');
$I->seeInPipe('RegisterUser/Notifier', 'ManyPipes/Notifier.stub');
$I->seeInPipe('RegisterUser/Logger', 'ManyPipes/Logger.stub');
$I->seeInWorkflows('ManyPipes/workflows.stub');
$I->seeInShellOutput('Command created successfully.');
$I->seeInShellOutput('Request created successfully.');
$I->seeInShellOutput('Pipe created successfully.');
$I->seeInShellOutput('Workflow created successfully.');

$I->clearWorkflow('RegisterUser');
<?php

$I = new FunctionalTester($scenario);
$I->wantTo('create a workflow with many pipes');

$I->runArtisan('workflow:create registerUser -a "Notifier Logger"');

$I->seeInJob('RegisterUserJob', 'ManyPipes/RegisterUserJob.stub');
$I->seeInRequest('RegisterUserRequest', 'ManyPipes/RegisterUserRequest.stub');
$I->seeInPipe('RegisterUser/Notifier', 'ManyPipes/Notifier.stub');
$I->seeInPipe('RegisterUser/Logger', 'ManyPipes/Logger.stub');
$I->seeInWorkflows('ManyPipes/workflows.stub');
$I->seeInShellOutput('Job created successfully.');
$I->seeInShellOutput('Request created successfully.');
$I->seeInShellOutput('Pipe created successfully.');
$I->seeInShellOutput('Workflow created successfully.');

$I->clearWorkflow('RegisterUser');

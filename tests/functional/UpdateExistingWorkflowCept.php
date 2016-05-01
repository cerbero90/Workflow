<?php

$I = new FunctionalTester($scenario);
$I->wantTo('update an existing workflow');

$I->runArtisan('workflow:create loginUser -a Notifier');
$I->runArtisan('workflow:create registerUser -a "Notifier Logger"');
$I->runArtisan('workflow:update registerUser -a Buzzer -d Notifier');

$I->seePipe('LoginUser/Notifier');
$I->seePipe('RegisterUser/Notifier'); // because --force is not set
$I->seeInPipe('RegisterUser/Buzzer', 'Update/Buzzer.stub');
$I->seePipe('RegisterUser/Logger');
$I->seeInWorkflows('Update/workflows.stub');
$I->seeInShellOutput('Workflow updated successfully.');

$I->clearWorkflow('LoginUser');
$I->clearWorkflow('RegisterUser');

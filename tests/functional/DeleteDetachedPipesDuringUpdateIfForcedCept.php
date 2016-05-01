<?php

$I = new FunctionalTester($scenario);
$I->wantTo('delete the detached pipes during an update');

$I->runArtisan('workflow:create registerUser -a "Notifier Logger"');
$I->runArtisan('workflow:update registerUser -a Buzzer -d Notifier --force');

$I->dontSeePipe('RegisterUser/Notifier');
$I->seePipe('RegisterUser/Buzzer');
$I->seePipe('RegisterUser/Logger');
$I->seeInWorkflows('DeleteDetached/workflows.stub');
$I->seeInShellOutput('Workflow updated successfully.');

$I->clearWorkflow('RegisterUser');

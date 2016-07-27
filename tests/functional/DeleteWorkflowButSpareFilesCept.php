<?php

$I = new FunctionalTester($scenario);
$I->wantTo('delete a workflow keeping its files');

$I->runArtisan('workflow:create publishPost -a Notifier');
$I->runArtisan('workflow:create banUser -a Logger');
$I->runArtisan('workflow:delete banUser');

$I->seeJob('BanUserJob');
$I->seeRequest('BanUserRequest');
$I->seePipe('BanUser/Logger');
$I->seeJob('PublishPostJob');
$I->seeRequest('PublishPostRequest');
$I->seePipe('PublishPost/Notifier');
$I->seeInWorkflows('Delete/workflows.stub');
$I->seeInShellOutput('Workflow deleted successfully.');

$I->clearWorkflow('BanUser');

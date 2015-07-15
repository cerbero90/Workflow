<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('delete a workflow and its files');

$I->runArtisan('workflow:create publishPost -a Notifier');
$I->runArtisan('workflow:create banUser -a Logger');
$I->runArtisan('workflow:delete banUser -f');

$I->dontSeeJob('BanUserJob');
$I->dontSeeRequest('BanUserRequest');
$I->dontSeePipe('BanUser/Logger');
$I->seeJob('PublishPostJob');
$I->seeRequest('PublishPostRequest');
$I->seePipe('PublishPost/Notifier');
$I->seeInWorkflows('Delete/workflows.stub');
$I->seeInShellOutput('Workflow deleted successfully.');

$I->clearWorkflow('PublishPost');
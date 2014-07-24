<?php 
$I = new FunctionalTester($scenario);
$I->am('developer');
$I->wantTo('see my workflow files generated');

$I->deleteDir(app_path('workflows'));
$I->runArtisan('workflow Registration');
$I->amInWorkflows();

$I->seeWorkflowBound('Registration');

$I->openFile('Registration/RegistrationInterface.php');
$I->seeInThisFile('interface RegistrationInterface');
$I->seeInThisFile('run($data)');

$I->openFile('Registration/Registration.php');
$I->seeInThisFile('class Registration implements RegistrationInterface');
$I->seeInThisFile('run($data)');

$I->seeInShellOutput('The workflow [Registration] has been created successfully.');

$I->deleteDir(app_path('workflows'));
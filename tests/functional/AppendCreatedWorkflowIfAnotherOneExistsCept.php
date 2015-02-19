<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('append the newly created workflow if another one exists');

$I->runArtisan('workflow:create updateUser -a Notifier');
$I->runArtisan('workflow:create deleteUser -a Logger');

$I->seeInCommand('UpdateUserCommand', 'Append/UpdateUserCommand.stub');
$I->seeInRequest('UpdateUserRequest', 'Append/UpdateUserRequest.stub');
$I->seeInPipe('UpdateUser/Notifier', 'Append/Notifier.stub');
$I->seeInCommand('DeleteUserCommand', 'Append/DeleteUserCommand.stub');
$I->seeInRequest('DeleteUserRequest', 'Append/DeleteUserRequest.stub');
$I->seeInPipe('DeleteUser/Logger', 'Append/Logger.stub');
$I->seeInWorkflows('Append/workflows.stub');

$I->clearWorkflow('UpdateUser');
$I->clearWorkflow('DeleteUser');
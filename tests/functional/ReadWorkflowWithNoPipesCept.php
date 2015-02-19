<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('see a workflow with no pipes');

$I->runArtisan('workflow:create UpdatePost');
$I->runArtisan('workflow:read UpdatePost');

$I->seeDrawingIs('zero.stub');

$I->clearWorkflow('UpdatePost');
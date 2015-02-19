<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('see a workflow with many pipes');

$I->runArtisan('workflow:create UpdatePost -a "Logger Buzzer Uploader Composer PipeWithVeryLongName"');
$I->runArtisan('workflow:read UpdatePost');

$I->seeDrawingIs('many.stub');

$I->clearWorkflow('UpdatePost');
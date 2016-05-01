<?php

$I = new FunctionalTester($scenario);
$I->wantTo('see a workflow with one pipe');

$I->runArtisan('workflow:create UpdatePost -a Logger');
$I->runArtisan('workflow:read UpdatePost');

$I->seeDrawingIs('one.stub');

$I->clearWorkflow('UpdatePost');

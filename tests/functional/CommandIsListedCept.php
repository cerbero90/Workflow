<?php 
$I = new FunctionalTester($scenario);
$I->am('developer');
$I->wantTo('check if workflow is listed by artisan');

$I->runArtisan('list');

$I->seeInShellOutput('workflow');
$I->seeInShellOutput('Speed up the workflow to add new features.');
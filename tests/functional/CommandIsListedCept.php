<?php 
$I = new FunctionalTester($scenario);
$I->am('developer');
$I->wantTo('check if workflow is listed by artisan');

$I->runArtisan('list');

$I->seeInShellOutput('workflow:create');
$I->seeInShellOutput('Create a new workflow.');

$I->seeInShellOutput('workflow:drop');
$I->seeInShellOutput('Drop an existing workflow.');
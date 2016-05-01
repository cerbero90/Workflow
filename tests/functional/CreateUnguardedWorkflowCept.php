<?php

$I = new FunctionalTester($scenario);
$I->wantTo('create an unguarded workflow');

$I->runArtisan('workflow:create IndexPosts -u');

$I->dontSeeRequest('IndexPostsRequest');
$I->seeInJob('IndexPostsJob', 'Unguarded/IndexPostsJob.stub');
$I->seeInShellOutput('Job created successfully.');
$I->dontSeeInShellOutput('Request created successfully.');
$I->seeInWorkflows('Unguarded/workflows.stub');
$I->seeInShellOutput('Workflow created successfully.');

$I->clearWorkflow('IndexPosts');

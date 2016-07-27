<?php

$I = new FunctionalTester($scenario);
$I->wantTo('see an error if a workflow does not exist during an update');

$I->runArtisan('workflow:update unknown');

$I->seeInShellOutput('The workflow [Unknown] does not exist.');

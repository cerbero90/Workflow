<?php

$I = new FunctionalTester($scenario);
$I->wantTo('see an error if the workflow to read does not exist');

$I->runArtisan('workflow:read unknown');

$I->seeInShellOutput('The workflow [Unknown] does not exist.');

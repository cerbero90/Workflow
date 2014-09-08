<?php 
$I = new FunctionalTester($scenario);
$I->am('developer');
$I->wantTo('drop the given workflow and keep the others');

$I->cleanTemporaryFiles();
$I->runCommand('workflow:create first -d "foo bar"');
$I->runCommand('workflow:create second -d baz');
$I->runCommand('workflow:drop first');

$I->seeInShellOutput('The workflow [First] has been dropped successfully.');
$I->seeSameContentsIn('bindings.php', 'drop_only_one/bindings.stub');
$I->dontSeeDirectory('First');
$I->seeDirectory('Second');

$I->cleanTemporaryFiles();
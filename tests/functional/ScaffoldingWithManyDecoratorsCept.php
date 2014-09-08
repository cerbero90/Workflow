<?php 
$I = new FunctionalTester($scenario);
$I->am('developer');
$I->wantTo('generate a workflow with many decorators');

$I->cleanTemporaryFiles();
$I->runCommand('workflow:create foo -d "qqq www eee rrr ttt yyy uuu iii ooo ppp aaa sss ddd fff ggg hhh jjj kkk lll"');

$I->seeInShellOutput('The workflow [Foo] has been created successfully.');
$I->seeSameContentsIn('bindings.php', 'many_decorators/bindings.stub');
$I->seeDecoratorsIn('Foo/Decorators', ['Qqq', 'Www', 'Eee', 'Rrr', 'Ttt', 'Yyy', 'Uuu', 'Iii', 'Ooo', 'Ppp', 'Aaa', 'Sss', 'Ddd', 'Fff', 'Ggg', 'Hhh', 'Jjj', 'Kkk', 'Lll']);

$I->cleanTemporaryFiles();
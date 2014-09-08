<?php

use PHPUnit_Framework_Assert as I;

$I = new FunctionalTester($scenario);
$I->wantTo('have all the available commands registered');

$create = $I->grabService('cerbero.workflow.commands.create');
I::assertInstanceOf('Cerbero\Workflow\Commands\CreateCommand', $create);

$drop = $I->grabService('cerbero.workflow.commands.drop');
I::assertInstanceOf('Cerbero\Workflow\Commands\DropCommand', $drop);
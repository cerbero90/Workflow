<?php namespace Cerbero\Workflow\Wrappers;

use Illuminate\Bus\Dispatcher as BusDispatcher;

/**
 * Bus dispatcher.
 *
 * @author	Andrea Marco Sartori
 */
class Dispatcher extends BusDispatcher implements PipingDispatcherInterface {}
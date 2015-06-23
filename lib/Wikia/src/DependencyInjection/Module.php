<?php
namespace Wikia\DependencyInjection;

interface Module {
	/**
	 * add to the DI container's configuration
	 * @return array
	 */
	public function configure();
}

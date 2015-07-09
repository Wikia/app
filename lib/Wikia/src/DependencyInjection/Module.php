<?php
namespace Wikia\DependencyInjection;

interface Module {
	/**
	 * add to the DI container's configuration
	 * @param InjectorBuilder $builder
	 */
	public function configure(InjectorBuilder $builder);
}

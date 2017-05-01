<?php
namespace Wikia\Consul;

use Wikia\DependencyInjection\InjectorBuilder;
use Wikia\DependencyInjection\Module;
use Wikia\Logger\WikiaLogger;
use SensioLabs\Consul\ServiceFactory;

class ConfigurationModule implements Module {
	public function configure( InjectorBuilder $builder ) {
		$builder
			->bind( ServiceFactory::class )->to( function () {
				return new ServiceFactory( [], WikiaLogger::instance() );
			})
			->bind( ConfigurationService::class )->toClass( ConfigurationServiceImpl::class );
	}
}

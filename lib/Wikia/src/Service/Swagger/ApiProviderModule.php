<?php

namespace Wikia\Service\Swagger;

use Wikia\DependencyInjection\InjectorBuilder;
use Wikia\DependencyInjection\Module;
use Wikia\Util\Statistics\BernoulliTrial;

class ApiProviderModule implements Module {

	const API_CLIENT_LOG_SAMPLER = "api_client_log_sampler";
	const SAMPLE_RATE = 0.1;

	public function configure(InjectorBuilder $builder) {
		$builder->bind(self::API_CLIENT_LOG_SAMPLER)->to(new BernoulliTrial(self::SAMPLE_RATE));
	}
}

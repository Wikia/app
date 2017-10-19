<?php
namespace Wikia\Service\Swagger;

use Wikia\Service\Gateway\KubernetesUrlProvider;
use Wikia\Util\Statistics\BernoulliTrial;

/**
 * Temporary class to assist in migration until all services use Kubernetes
 * @package Wikia\Service\Swagger
 */
class KubernetesApiProvider extends ApiProvider {
	/**
	 * @Inject({
	 *   Wikia\Service\Gateway\KubernetesUrlProvider::class,
	 *   Wikia\Service\Swagger\ApiProviderModule::API_CLIENT_LOG_SAMPLER})
	 * @param KubernetesUrlProvider $urlProvider
	 * @param BernoulliTrial $clientLogSampler
	 */
	public function __construct(
		KubernetesUrlProvider $urlProvider, BernoulliTrial $clientLogSampler
	) {
		parent::__construct( $urlProvider, $clientLogSampler );
	}
}

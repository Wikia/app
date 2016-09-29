<?php

use Swagger\Client\ApiException;
use Swagger\Client\Discussion\Api\SitesApi;
use Swagger\Client\Discussion\Models\SiteInput;
use Wikia\DependencyInjection\Injector;
use Wikia\Service\Swagger\ApiProvider;

class DiscussionsApi {

    const SERVICE_NAME = 'discussion';
    const TIMEOUT = 5;
    const SITE_NAME_MAX_LENGTH = 256;


    private $sitesResourceApi;
    private $logger;

    public function __construct() {
        $this->sitesResourceApi = $this->getSitesApi();
        $this->logger = Wikia\Logger\WikiaLogger::instance();
    }
    
    public function activateDiscussions() {
        if ( $this->isDiscussionsActive() ) {
            return;
        }

        $siteInput = $this->getSiteInput();
        try {
            $this->sitesResourceApi->createSite( $siteInput, F::app()->wg->TheSchwartzSecretToken );
        } catch ( ApiException $e ) {
            $this->logAndThrowError( $e );
        }
    }

    private function getSiteInput() : SiteInput {
        $app = F::app();
        return new SiteInput(
            [
                'id' => $app->wg->CityId,
                'name' => substr( $app->wg->Sitename, 0, self::SITE_NAME_MAX_LENGTH ),
                'language_code' => $app->wg->ContLang->getCode()
            ]
        );
    }

    public function isDiscussionsActive() {
        $siteId = F::app()->wg->CityId;
        try {
            $this->sitesResourceApi->getSite( $siteId );
            return true;
        } catch ( ApiException $e ) {
            $this->logger->debug( 'Getting site caused an error',
                [
                    'siteId' => $siteId,
                    'error' => $e->getMessage(),
                ] );
        }
        return false;
    }

    private function getSitesApi() {
        /** @var ApiProvider $apiProvider */
        $apiProvider = Injector::getInjector()->get( ApiProvider::class );
        /** @var SitesApi $api */
        $api = $apiProvider->getApi( self::SERVICE_NAME, SitesApi::class );
        $api->getApiClient()->getConfig()->setCurlTimeout( self::TIMEOUT );

        return $api;
    }

    private function logAndThrowError( Exception $e ) {
        $this->logger->error(
            'Creating site caused an error',
            [
                'siteId' => F::app()->wg->CityId,
                'error' => $e->getMessage()
            ]
        );
        throw new ErrorPageError( 'unknown-error', 'discussions-activate-error' );
    }
}

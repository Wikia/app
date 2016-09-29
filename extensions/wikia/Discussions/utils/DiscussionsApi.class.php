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
    private $cityId;
    private $cityName;
    private $cityLang;

    public function __construct( $cityId = null, $cityName = null, $cityLang = null ) {
        $this->cityId = $cityId ?? F::app()->wg->CityId;
        $this->cityName = $cityName ?? F::app()->wg->Sitename;
        $this->cityLang = $cityLang ?? F::app()->wg->ContLang->getCode();
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
        return new SiteInput(
            [
                'id' => $this->cityId,
                'name' => substr( $this->cityName, 0, self::SITE_NAME_MAX_LENGTH ),
                'language_code' => $this->cityLang
            ]
        );
    }

    public function isDiscussionsActive() {
        try {
            $this->sitesResourceApi->getSite( $this->cityId );
            return true;
        } catch ( ApiException $e ) {
            $this->logger->debug( 'Getting site caused an error',
                [
                    'siteId' => $this->cityId,
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
                'siteId' => $this->cityId,
                'error' => $e->getMessage()
            ]
        );
        throw new ErrorPageError( 'unknown-error', 'discussions-activate-error' );
    }
}

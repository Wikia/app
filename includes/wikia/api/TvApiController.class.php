<?php
use Wikia\Search\Config, Wikia\Search\QueryService\Factory, Wikia\Search\QueryService\DependencyContainer;
class TvApiController extends WikiaApiController {

	//const PARAMETER_NAMESPACES = 'namespaces';
	const LIMIT_SETTING = 1;
	const RANK_SETTING = 'default';
	const LANG_SETTING = 'en';

	public function getArticle() {
		$this->setResponseFromConfig( $this->getConfigFromRequest() );
	}

	protected function getWikiId(){
		$config = $this->getConfigCrossWiki();
		$resultSet = (new Factory)->getFromConfig( $config )->search();

		foreach( $resultSet->getResults() as $result ) {
			if ( $result['id'] ) {
				return $result['id'];
			}
		}
	}

	protected function getConfigCrossWiki() {
		$request = $this->getRequest();
		$searchConfig = new Wikia\Search\Config;
		$searchConfig->setQuery( $request->getVal( 'seriesName', null ) )
			->setLimit( static::LIMIT_SETTING )
			->setRank( 'default' )
			->setInterWiki( true )
			->setCommercialUse( $this->hideNonCommercialContent() )
			->setLanguageCode( static::LANG_SETTING )
			->setHub( 'Entertainment' )
		;
		return $searchConfig;
	}

	/**
	 * Inspects request and sets config accordingly.
	 * @return Wikia\Search\Config
	 */
	protected function getConfigFromRequest() {
		$request = $this->getRequest();
		$searchConfig = new Wikia\Search\Config;
		$searchConfig->setQuery( $request->getVal( 'episodeName', null ) )
			->setLimit( static::LIMIT_SETTING )
			->setPage( 1 )
			->setLanguageCode( static::LANG_SETTING )
			->setRank( static::RANK_SETTING )
			->setWikiId($this->getWikiId())
			->setVideoSearch( false )
			->setOnWiki(true)
			->setNamespaces([0,14]);
		;
		//return $this->validateNamespacesForConfig( $searchConfig );
		return $searchConfig;
	}


	/**
	 * Validates user-provided namespaces.
	 * @param Wikia\Search\Config $searchConfig
	 * @throws InvalidParameterApiException
	 * @return Wikia\Search\Config
	 */
	/*protected function validateNamespacesForConfig( $searchConfig ) {
		$namespaces = $this->getRequest()->getArray( 'namespaces', [] );
		if (! empty( $namespaces ) ) {
			foreach ( $namespaces as &$n ) {
				if (! is_numeric( $n ) ) {
					throw new InvalidParameterApiException( self::PARAMETER_NAMESPACES );
				}
			}

			$searchConfig->setNamespaces( $namespaces );
		}
		return $searchConfig;
	}*/

	protected function setResponseFromConfig( Wikia\Search\Config $searchConfig ) {
		if (! $searchConfig->getQuery()->hasTerms() ) {
			throw new InvalidParameterApiException( 'episodeName' );
		}

		//Standard Wikia API response with pagination values
		$responseValues = (new Factory)->getFromConfig( $searchConfig )->searchAsApi( ['pageid' => 'id', 'title', 'url', 'ns' ], true );

		if ( empty( $responseValues['items'] ) ) {
			throw new NotFoundApiException();
		}

		$response = $this->getResponse();
		$response->setValues( $responseValues );

		$response->setCacheValidity(
			86400 /* 24h */,
			86400 /* 24h */,
			array(
				WikiaResponse::CACHE_TARGET_BROWSER,
				WikiaResponse::CACHE_TARGET_VARNISH
			)
		);
	}


}
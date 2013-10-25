<?php
use Wikia\Search\Config, Wikia\Search\QueryService\Factory, Wikia\Search\QueryService\DependencyContainer;
class TvApiController extends WikiaApiController {

	const API_URL = 'wikia.php?controller=JsonFormatApi&method=getJsonFormatAsText&article=';

	/**
	 * @var wikiId
	 */
	private $wikiId;

	/**
	 * @var url for wikiId
	 */
	private $url;

	public function getArticle() {

		$this->setWikiVariables();

		$config = $this->getConfigFromRequest();
		$this->setResponseFromConfig( $config);
	}


	protected function setWikiVariables(){
		$config = $this->getConfigCrossWiki();
		$resultSet = (new Factory)->getFromConfig( $config )->search();

		foreach( $resultSet->getResults() as $result ) {
			if ( $result['id'] && $result['url'] ) {
				$this->wikiId = $result['id'];
				$this->url = $result['url'];
				return ;
			}
		}

		throw new InvalidParameterApiException( 'seriesName' );

	}


	protected function getConfigCrossWiki() {
		$request = $this->getRequest();
		$searchConfig = new Wikia\Search\Config;
		$searchConfig->setQuery( $request->getVal( 'seriesName', null ) )
			->setLimit( 1 )
			->setPage( 1 )
			->setRank( 'default' )
			->setInterWiki( true )
			->setCommercialUse( $this->hideNonCommercialContent() )
			->setLanguageCode( $request->getVal( 'lang', 'en' ) )
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
			->setLimit( $request->getInt( 'limit', 1 ) )
			->setPage( $request->getVal( 'batch', 1 ) )
			->setLanguageCode($request->getVal( 'lang', 'en' ))
			->setRank( $request->getVal( 'rank', 'default' ) )
			->setWikiId($this->wikiId)
			->setVideoSearch( false  )
			->setOnWiki(true)
			->setNamespaces([0,14]);
		;

		return $searchConfig;
	}

	protected function setResponseFromConfig( Wikia\Search\Config $searchConfig ) {
		if (! $searchConfig->getQuery()->hasTerms() ) {
			throw new InvalidParameterApiException( 'episodeName' );
		}

		//Standard Wikia API response with pagination values
		$responseValues = (new Factory)->getFromConfig( $searchConfig )->searchAsApi( ['pageid' => 'id', 'title', 'url', 'ns' ], true );

		if ( empty( $responseValues['items'] ) ) {
			throw new NotFoundApiException();
		}

		foreach($responseValues['items'] as &$item)
		{
			$item['contentUrl'] = $this->url.self::API_URL.$item['pageid'];
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
<?php 

class WikiaSearchArticleMatch {
	
	/**
	 * The page ID corresponding to the term that generated it. 
	 */
	protected $pageId;
	
	/**
	 * MediaWiki interface
	 * @var \Wikia\Search\MediaWikiInterface
	 */
	protected $interface;
	
	/**
	 * Accepts an article and performs all necessary logic to also store a redirect
	 * @param Article $article
	 */
	public function __construct( $pageId ) {
		$this->pageId = $pageId;
	}
	
	/**
	 * Transforms article match into search result.
	 * @return WikiaSearchResult
	 */
	public function getResult() {
		$wikiId = $this->interface->getWikiId();

		$fieldsArray = array(
				'id'            => sprintf( '%s_%s', $wikiId, $this->pageId ), 
				'wid'           => $wikiId,
				'title'         => $this->interface->getTitleStringFromPageId( $this->pageId ),
				'url'           => urldecode( $this->interface->getUrlFromPageId( $this->pageId ) ),
				'score'         => 'PTT',
				'isArticleMatch'=> true,
				'ns'            => $this->interface->getNamespaceFromPageId( $this->pageId ),
				'pageId'        => $this->interface->getCanonicalPageIdFromPageId( $this->pageId ),
				'created'       => $this->interface->getFirstRevisionTimestampForPageId( $this->pageId ),
				'touched'       => $this->interface->getLastRevisionTimestampForPageId( $this->pageId ),
				);

		$result = new WikiaSearchResult( $fieldsArray );
		
		$result->setText( $this->interface->getSnippetForPageId( $this->pageId ) );
		if ( $this->hasRedirect() ) {
			$result->setVar( 'redirectTitle', $this->interface->getNonCanonicalTitleString( $this->pageId ) );
		}
		return $result;
	}
	
	/**
	 * Says whether we found a redirect during construct
	 * @return boolean
	 */
	public function hasRedirect() {
		return $this->interface->getCanonicalPageIdFromPageId( $this->pageId ) !== $this->pageId;
	}
}
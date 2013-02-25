<?php
/**
 * Class definition for Wikia\Search\Match\Article
 */
namespace Wikia\Search\Match;
use \Wikia\Search\Result as Result;

class Article extends AbstractMatch
{
	/**
	 * Creates a result instance.
	 * @see \Wikia\Search\Match\AbstractMatch::createResult()
	 * @return Result
	 */
	public function createResult() {
		$wikiId = $this->interface->getWikiId();
		$fieldsArray = array(
				'id'            => sprintf( '%s_%s', $wikiId, $this->id ),
				'wid'           => $wikiId,
				'title'         => $this->interface->getTitleStringFromPageId( $this->id ),
				'url'           => urldecode( $this->interface->getUrlFromPageId( $this->id ) ),
				'score'         => 'PTT',
				'isArticleMatch'=> true,
				'ns'            => $this->interface->getNamespaceFromPageId( $this->id ),
				'pageId'        => $this->interface->getCanonicalPageIdFromPageId( $this->id ),
				'created'       => $this->interface->getFirstRevisionTimestampForPageId( $this->id ),
				'touched'       => $this->interface->getLastRevisionTimestampForPageId( $this->id ),
			);
		$result = new Result( $fieldsArray );
		$result->setText( $this->interface->getSnippetForPageId( $this->id ) );
		if ( $this->hasRedirect() ) {
			$result->setVar( 'redirectTitle', $this->interface->getNonCanonicalTitleString( $this->id ) );
			$result->setVar( 'redirectUrl', $this->interface->getNonCanonicalUrlFromPageId( $this->id ) );
		}
		return $result;
	}
	
	/**
	 * Says whether we found a redirect during construct
	 * @return boolean
	 */
	public function hasRedirect() {
		return $this->interface->getCanonicalPageIdFromPageId( $this->id ) !== $this->id;
	}
}
<?php
/**
 * Class definition for Wikia\Search\Match\Article
 */
namespace Wikia\Search\Match;
use \Wikia\Search\Result as Result;
/**
 * This class correlates a page ID to a MediaWiki article (via interface), and creates a result based on it.
 * @author relwell
 * @package Search
 * @subpackage Match
 */
class Article extends AbstractMatch
{
	/**
	 * Creates a result instance.
	 * @see \Wikia\Search\Match\AbstractMatch::createResult()
	 * @return Result
	 */
	public function createResult() {
		NS_BLOG;
		/**@var $this->service Wikia\Search\MediaWikiService*/
		$wikiId = $this->service->getWikiId();
		$pageId = $this->service->getCanonicalPageIdFromPageId( $this->id );
		$fieldsArray = array(
				'id'            => sprintf( '%s_%s', $wikiId, $pageId ),
				'pageid'        => $pageId,
				'wid'           => $wikiId,
				'title'         => $this->service->getTitleStringFromPageId( $this->id ),
				'url'           => $this->service->getUrlFromPageId( $this->id ) ,
				'score'         => 'PTT',
				'isArticleMatch'=> true,
				'ns'            => $this->service->getNamespaceFromPageId( $this->id ),
				'created'       => $this->service->getFirstRevisionTimestampForPageId( $this->id ),
				'touched'       => $this->service->getLastRevisionTimestampForPageId( $this->id ),
			);
		$result = new Result( $fieldsArray );
		$result->setText( $this->service->getSnippetForPageId( $this->id ) );
		if ( $this->hasRedirect() ) {
			$result->setVar( 'redirectTitle', $this->service->getNonCanonicalTitleStringFromPageId( $this->id ) );
			$result->setVar( 'redirectUrl', $this->service->getNonCanonicalUrlFromPageId( $this->id ) );
		}
		return $result;
	}
	
	/**
	 * Says whether we found a redirect during construct
	 * @return boolean
	 */
	public function hasRedirect() {
		return $this->service->getCanonicalPageIdFromPageId( $this->id ) !== $this->id;
	}
}
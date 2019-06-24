<?php
/**
 * ArticleExporter methods for getting and processing articles
 *
 * @author Lore team
 * @package ArticleExporter
 */
class ArticleExporter {
	const SPACE_SEQUENCE_REGEXP = "/\s+/";

	public function build($cityId, $ids) {
		$articles = [];
		foreach ( $ids as $id ) {
			$article = $this->getArticle( $id );
			$title = $this->loadTitle( $id ); // some items not available through parse api

			if ( $article ) {
				$articles[$id] = [
					'wikiId' => $cityId,
					'lang' => $this->getContentLang(),
					'pageId' => $id,
					'namespace' => $title->getNamespace(),
					'mainPage' => $title->isMainPage(),
					'revisionId' => strval( $article['parse']['revid'] ),
					'title' => $article['parse']['title'],
					'url' => $title->getFullURL(),
					'plaintextContent' => $this->getPlaintext( $article['parse']['text']['*'] ),
					'categories' => $this->getCategories( $article['parse']['categories'] ),
					'linkedPageTitles' => $this->getPageTitles( $article['parse']['links'] ),
					'updatedUtc' => $this->getUpdated( $article['parse']['revid'] ),
				];
			}
		}

		return $articles;
	}

	public function getArticle( $pageId ) {
		return \ApiService::call(
			[
				'pageid' => $pageId,
				'action' => 'parse',
				'prop' => 'text|revid|categories|links|displaytitle',
			]
		);
	}

	public function getContentLang() {
		global $wgContLanguageCode;
		return $wgContLanguageCode;
	}

	// Return a quick plaintext version of the article content. Ideally we want to pull out things
	// like "Edit" and the TOC - but for the first version this should get us 99% of the way there
	public function getPlaintext( $text ) {
		$text = html_entity_decode( strip_tags( $text ), ENT_COMPAT, 'UTF-8' );
		$text = preg_replace( self::SPACE_SEQUENCE_REGEXP, ' ', $text );

		return str_replace( [ "&lt;", "&gt;" ], "", $text );
	}

	public function loadTitle( $id ) {
		return Title::newFromID($id);
	}

	public function getCategories( $rawCategories ) {
		$categories = [];
		foreach ( $rawCategories as $category ) {
			array_push( $categories, $category['*'] );
		}
		return $categories;
	}

	public function getPageTitles( $links ) {
		$linkedPageTitles = [];
		foreach ( $links as $link ) {
			array_push( $linkedPageTitles, $link['*'] );
		}
		return $linkedPageTitles;
	}

	public function getUpdated( $revid ) {
		$lastRev = \Revision::newFromId( $revid );
		$timestamp = empty( $lastRev ) ? '' : $lastRev->getTimestamp();
		return wfTimestamp( TS_ISO_8601, $timestamp ) ;
	}
}

<?php
/**
* Controller to get article content for the taxonomy content classifier
*
* @author Lore team
* @package ArticleExporter
* @subpackage Controller
*/
class ArticleExporterApiController extends WikiaApiController {
	const SPACE_SEQUENCE_REGEXP = "/\s+/";

	public function getArticles() {
		global $wgRequest;
		global $wgCityId;

		$ids = $wgRequest->getArray( 'ids' );

		$articles = [];
		foreach ( $ids as $id ) {
			$article = $this->getArticle( $id );

			if ( $article ) {
				$articles[$id] = [
					'wikiId' => $wgCityId,
					'pageId' => $id,
					'revisionId' => strval( $article['parse']['revid'] ),
					'title' => $article['parse']['title'],
					'url' => $this->getPageUrl( $id ),
					'plaintextContent' => $this->getPlaintext( $article['parse']['text']['*'] ),
					'categories' => $this->getCategories( $article['parse']['categories'] ),
					'linkedPageTitles' => $this->getPageTitles( $article['parse']['links'] ),
					'updatedUtc' => $this->getUpdated( $article['parse']['revid'] ),
				];

				var_dump( $articles[$id]['plaintextContent'] );
			}

		}

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setValues( [ 'articles' => $articles ] );
	}

	protected function getArticle( $pageId ) {
		return \ApiService::call(
			[
				'pageid' => $pageId,
				'action' => 'parse',
				'prop' => 'text|revid|categories|links|displaytitle',
			]
		);
	}

	// Return a quick plaintext version of the article content. Ideally we want to pull out things
	// like "Edit" and the TOC - but for the first version this should get us 99% of the way there
	protected function getPlaintext( $text ) {
		$text = html_entity_decode( strip_tags( $text ), ENT_COMPAT, 'UTF-8' );
		$text = preg_replace( self::SPACE_SEQUENCE_REGEXP, ' ', $text );

		return str_replace( [ "&lt;", "&gt;" ], "", $text );
	}

	protected function getPageUrl( $id ) {
		return Title::newFromId( $id )->getFullURL();
	}

	protected function getCategories( $rawCategories ) {
		$categories = [];
		foreach ( $rawCategories as $category ) {
			array_push( $categories, $category['*'] );
		}
		return $categories;
	}

	protected function getPageTitles( $links ) {
		$linkedPageTitles = [];
		foreach ( $links as $link ) {
			array_push( $linkedPageTitles, $link['*'] );
		}
		return $linkedPageTitles;
	}

	protected function getUpdated( $revid ) {
		$lastRev = \Revision::newFromId( $revid );
		$timestamp = empty( $lastRev ) ? '' : $lastRev->getTimestamp();
		return wfTimestamp( TS_ISO_8601, $timestamp ) ;
	}
}

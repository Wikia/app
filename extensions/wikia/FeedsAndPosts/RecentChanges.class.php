<?php

namespace Wikia\FeedsAndPosts;

class RecentChanges {

	const LIMIT = 4;
	const MINOR_CHANGE_THRESHOLD = 100;

	const IMAGE_WIDTH = 150;
	const IMAGE_RATIO = 3 / 4;

	private function requestAPI( $params ) {
		$api = new \ApiMain( new \FauxRequest( $params ) );
		$api->execute();

		return $api->GetResultData();
	}

	private function getImage( $title, $width, $ratio ) {
		$response = $this->requestAPI( [
			'action' => 'imageserving',
			'wisTitle' => $title,
		] );

		if ( isset( $response['image']['imageserving'] ) ) {
			return Thumbnails::getThumbnailUrl( $response['image']['imageserving'], $width, $ratio );
		}

		return null;
	}

	private function filterByDifferenceSize($articles, $mainPageId, $titlesMap, $onlyMajor) {
		$result = [];

		foreach ( $articles as $article ) {
			$diffSize = abs( $article['newlen'] - $article['oldlen'] );
			$title = $article['title'];

			// filter out main page and pages we've already seen
			if ( $article['pageid'] !== $mainPageId && empty( $titlesMap[$title] ) ) {
				$isMajor = $diffSize >= self::MINOR_CHANGE_THRESHOLD;

				if ( ( $isMajor && $onlyMajor ) || ( !$isMajor && !$onlyMajor ) ) {
					$result[] = $article;
					$titlesMap[$title] = true;
				}
			}

			if ( count( $result ) === self::LIMIT ) {
				break;
			}
		}

		return $result;
	}

	private function filterOutSmallChangesAndCleanUp( $articles ) {
		$titlesMap = [];
		$mainPageId = \Title::newMainPage()->getArticleID();
		$articlesWithMajorChange =
			$this->filterByDifferenceSize( $articles, $mainPageId, $titlesMap, true );
		$resultArticles = array_slice( $articlesWithMajorChange, 0, self::LIMIT );

		if ( count( $resultArticles ) < self::LIMIT ) {
			$articlesWithMinorChange =
				$this->filterByDifferenceSize( $articles, $mainPageId, $titlesMap, false );
			$resultArticles =
				array_slice(
					array_merge( $articlesWithMajorChange, $articlesWithMinorChange ),
					0,
					self::LIMIT
				);
		}

		$resultTitles =
			\TitleBatch::newFromIds( array_map( function ( $article ) {
				return $article['pageid'];
			}, $resultArticles ), DB_SLAVE );

		return array_map( function ( $article ) use ( $resultTitles ) {
			$title = $resultTitles[$article['pageid']];

			return [
				'title' => $title->getText(),
				'url' => $title->getLocalURL(),
			];
		}, $resultArticles );
	}

	private function getRecentChanges() {
		global $wgContentNamespaces;

		$response = $this->requestAPI( [
			'action' => 'query',
			'list' => 'recentchanges',
			'rcprop' => 'title|sizes|ids',
			'rcshow' => '!bot|!minor|!redirect',
			'rcnamespace' => implode( '|', $wgContentNamespaces ),
		    'rctype' => 'edit|new',
			// load 20 times more items so we'll be able to filter out articles with minor changes
			'rclimit' => self::LIMIT * 20,
		] );

		if ( isset( $response['query']['recentchanges'] ) ) {
			return $this->filterOutSmallChangesAndCleanUp( $response['query']['recentchanges'] );
		}

		return [];
	}

	public function get() {
		$cacheTTL = 3600; // an hour

		return \WikiaDataAccess::cache( wfMemcKey( 'feeds-recent-changes' ), $cacheTTL, function () {
			$recentChanges = $this->getRecentChanges();

			foreach ( $recentChanges as &$article ) {
				$article['image'] =
					$this->getImage( $article['title'], self::IMAGE_WIDTH, self::IMAGE_RATIO );
			}

			return $recentChanges;
		} );
	}

}

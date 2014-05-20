<?php

namespace Wikia\Search\Services;

class FeedEntitySearchService extends EntitySearchService {

	const ALLOWED_NAMESPACE = 0;
	const ROWS_NUMBER = 100;
	private $urls;

	protected function prepareQuery( $query ) {
		$select = $this->getSelect();

		$dismax = $select->getDisMax();
		$dismax->setQueryParser( 'edismax' );

		$select->setQuery( $this->createQuery( $query ) );
		$select->createFilterQuery( 'ns' )->setQuery( '+(ns:' . static::ALLOWED_NAMESPACE . ')' );
		$select->createFilterQuery( 'mp' )->setQuery( '-(is_main_page:true)' );
		$select->setRows( static::ROWS_NUMBER );

		return $select;
	}

	public function setUrls( $data ) {
		foreach ( $data as $item ) {
			$this->urls[ ] = '"http://' . $item . '"';
		}
	}

	private function createQuery( $query ) {
		$q = $this->getQuality();
		$l = $this->getLang();
		$wid = $this->getWikiId();
		if ( !empty( $wid ) ) {
			$wids = is_array( $wid ) ? $wid : [ $wid ];
		}
		$hub = $this->getHubs();
		if ( !empty( $hub ) ) {
			$hubs = is_array( $hub ) ? $hub : [ $hub ];
		}
		$query .= '+url:(' . implode( ' | ', $this->urls ) . ')'
			. ( isset( $q ) ? ' AND +(article_quality_i:[' . $q . ' TO *])' : '' )
			. ( isset( $l ) ? ' AND +(lang:' . $l . ')' : '' )
			. ( isset( $wids ) ? ' AND +wid:( ' . implode( ' | ', $wids ) . ')' : '' )
			. ( isset( $hubs ) ? ' AND +hub:( ' . implode( ' | ', $hubs ) . ')' : '' );
		return $query;
	}

	protected function consumeResponse( $response ) {
		$items = [ ];
		foreach ( $response as $res ) {
			$items[ ] = [
				'id' => $res[ 'id' ],
				'url' => $res[ 'url' ],
				'title' => $res[ $this->withLang( 'title', $this->getLang() ) ],
				'timestamp' => strtotime( $res[ 'touched' ] ),
				'description' => substr( $res[ $this->withLang( 'html', $this->getLang() ) ], 0, 100 ),
				'host' => $res[ 'host' ],
				'wid' => $res[ 'wid' ]
			];
		}
		return $items;
	}
}

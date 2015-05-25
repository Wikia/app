<?php

/**
 * A query module to generate pageviews
 */
class WikiaApiQueryPageinfo extends ApiQueryInfo {

	public function execute() {
		$prop = array();
		$params = $this->extractRequestParams();
		if ( isset( $params['prop'] ) ) {
			$prop = array_flip( $params['prop'] );
		}

		$result = $this->getResult();

		foreach ( $prop as $param => $id ) {
			switch ( $param ) {
				case "views" 	: $this->getPageViews( $result ); break;
				case "revcount" : $this->getRevCount( $result ); break;
				case "created"	: $this->getCreateDate( $result ); break;
				case "redirect"	: $this->getRedirectName( $result ); break;
			}
		}
		parent :: execute();
	}

	private function getPageViews( ApiResult $result ) {
		/**
		 * Do not run for an empty set of pages
		 *
		 * Otherwise we run the query without the WHERE that results with all wiki articles being returned to PHP:
		 * SELECT article_id,count as page_counter  FROM `page_visited`
		 *
		 * @see PLATFORM-913
		 */
		$aTitles = $this->getPageSet()->getGoodTitles();
		if ( empty( $aTitles ) ) {
			return;
		}

		$res = $result->getData();

		if ( isset( $res['query'] ) && isset( $res['query']['pages'] ) ) {
			# ---
			$this->resetQueryParams();
			$this->addFields( array( 'article_id', 'count as page_counter' ) );
			# --- table
			$this->addTables( 'page_visited' );
			# --- where
			$this->addWhereFld( 'article_id', array_keys( $aTitles ) );
			# --- select
			$db = $this->getDB();
			$oRes = $this->select( __METHOD__ );
			$pageviews = array();
			while ( $oRow = $db->fetchObject( $oRes ) ) {
				$pageviews[$oRow->article_id] = $oRow->page_counter;
			}
			$db->freeResult( $oRes );

			foreach ( $aTitles as $page_id => $oTitle ) {
				if ( isset( $res ['query']['pages'][$page_id] ) ) {
					$result->addValue( array( "query", "pages", $page_id ), "views", ( isset( $pageviews[$page_id] ) )  ? intval( $pageviews[$page_id] ) : 0 );
				}
			}
		}
	}

	private function getCreateDate( ApiResult $result ) {
		$res = $result->getData();

		if ( isset( $res['query'] ) && isset( $res['query']['pages'] ) ) {
			$aTitles = $this->getPageSet()->getGoodTitles();
			# ---
			if ( !empty( $aTitles ) && is_array( $aTitles ) ) {
				foreach ( $aTitles as $page_id => $oTitle ) {
					$this->resetQueryParams();
					$this->addFields( array( 'min(rev_timestamp) as created' ) );
					# --- table
					$this->addTables( 'revision' );
					# --- where
					$this->addWhereFld( 'rev_page', $page_id );
					# --- select
					$db = $this->getDB();
					$oRes = $this->select( __METHOD__ );
					$created = "";
					if ( $oRow = $db->fetchObject( $oRes ) ) {
						$created = wfTimestamp( TS_ISO_8601, $oRow->created );
					}
					$db->freeResult( $oRes );

					if ( isset( $res ['query']['pages'][$page_id] ) ) {
						$result->addValue( array( "query", "pages", $page_id ), "created", $created );
					}
				}
			}
		}
	}

	private function getRevCount( ApiResult $result ) {
		$res = $result->getData();
		$db = $this->getDB();
		if ( isset( $res['query'] ) && isset( $res['query']['pages'] ) ) {
			foreach ( $this->getPageSet()->getGoodTitles() as $page_id => $oTitle ) {
				if ( isset( $res['query']['pages'][$page_id] ) ) {
					$revcount = Revision :: countByPageId( $db, $page_id );
					$result->addValue( array( "query", "pages", $page_id ), "revcount", intval( $revcount ) );
				}
			}
		}
	}

	private function getRedirectName( ApiResult $result ) {
		$res = &$result->getData();
		if ( isset( $res['query'] ) && isset( $res['query']['pages'] ) ) {
			foreach ( $this->getPageSet()->getGoodTitles() as $page_id => $oTitle ) {
				$res['query']['pages'][$page_id]['redirectto'] = "";
				if ( $oTitle->isRedirect() ) {
					$oArticle = new Article( $oTitle );
					$oRedirTitle = $oArticle->getRedirectTarget();
					if ( $oRedirTitle instanceof Title ) {
						$result->addValue( array( "query", "pages", $page_id ), "redirectto", Title::makeName( $oRedirTitle->getNamespace(), $oRedirTitle->getDBkey() ) );
					}
				}
			}
		}
	}

	public function getExamples() {
		return array_merge(
			parent::getExamples(),
			array (
				"Get a pageviews of [[Main Page]] ",
				"  api.php?action=query&prop=info&titles=Main%20Page&inprop=views|revcount"
			)
		);
	}

	public function getAllowedParams() {
		$params = parent :: getAllowedParams();
		$params['prop'][ApiBase :: PARAM_TYPE] = array_merge(
			$params['prop'][ApiBase :: PARAM_TYPE],
			array (
				'views',
				'revcount',
				'created',
				'redirect'
			)
		);
		return $params;
	}

	public function getParamDescription() {
		$description = parent :: getParamDescription();
		$description['prop'] = array_merge(
			$description['prop'],
			array (
				' "views"        - The number of pageviews of each page',
				' "revcount"     - The number of all revisions of each page',
				' "created"		 - Creation date of each page',
				' "redirect"     - Name of redirected page'
			)
		);
		return $description;
	}

}

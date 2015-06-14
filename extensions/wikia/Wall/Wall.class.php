<?php

class Wall extends WikiaModel {
	const DESCRIPTION_CACHE_TTL = 3600;

	protected $mTitle;
	protected $mCityId;

	protected $mMaxPerPage = false;
	protected $mSorting = false;
	protected $mRelatedPageId = false;
	protected $cacheable = true;

	/**
	 * @param $id
	 * @param int $flags
	 *
	 * @return null|Wall
	 */
	static public function newFromId( $id, $flags = 0 ) {
		$title = Title::newFromId( $id, $flags );
		if ( empty( $title ) ) {
			return null;
		}
		return self::newFromTitle( $title );
	}

	/**
	 * @param Title $title
	 *
	 * @return null|Wall
	 */
	static public function newFromTitle( Title $title ) {
		wfProfileIn( __METHOD__ );
		if ( !( $title instanceof Title ) ) {
			wfProfileOut( __METHOD__ );
			return null;
		}

		$wall = self::getEmpty();
		$wall->mTitle = $title;
		$wall->mCityId = F::app()->wg->CityId;
		wfProfileOut( __METHOD__ );
		return $wall;
	}

	static public function newFromRelatedPages( Title $title, $relatedPageId ) {
		wfProfileIn( __METHOD__ );
		if ( !( $title instanceof Title ) ) {
			wfProfileOut( __METHOD__ );
			return null;
		}
		$wall = self::getEmpty();
		$wall->mTitle = $title;
		$wall->mCityId = F::app()->wg->CityId;
		$wall->mRelatedPageId = (int) $relatedPageId;
		wfProfileOut( __METHOD__ );
		return $wall;
	}

	/**
	 * @return Wall
	 */
	static public function getEmpty() {
		/* small work around for problem with static constructors and inheritance */
		// TODO: Look in to Late Static Bindings
		$className = get_called_class();
		return new $className();
	}

	public function getId() {
		return $this->mTitle->getArticleId();
	}

	public function getTitle() {
		return $this->mTitle;
	}

	/**
	 * @desc Returns raw (unparsed) wikitext.
	 *
	 * @return string raw wikitext
	 */
	public function getRawDescription() {
		$oArticle = new Article( $this->getTitle() );

		return $oArticle->getRawText();
	}


	/**
	 * @desc Returns wikitext without parsed templates (removes templates from wikitext).
	 *
	 * @return string parsed description
	 */
	public function getDescriptionWithoutTemplates() {
		$title = $this->getTitle();
		$memcKey = wfMemcKey( __METHOD__, $title->getArticleID(), $title->getTouchedCached(), 'without_template' );
		$res = $this->wg->memc->get( $memcKey );
		if ( !is_string( $res ) ) {
			$res = $this->getDescriptionParsed( true );

			$this->wg->memc->set( $memcKey, $res, self::DESCRIPTION_CACHE_TTL );
		}
		return $res;
	}


	/**
	 * @desc Returns parsed description.
	 *
	 * @param boolean $bStripTemplates Parse templates as empty strings.
	 *
	 * @return string Parsed description.
	 */
	private function getDescriptionParsed( $bStripTemplates = false ) {
		wfProfileIn( __METHOD__ );

		$oArticle = new Article( $this->getTitle() );

		$oApp = F::App();
		$oParserOptions = $oApp->wg->Out->parserOptions();

		// Functionality based on request https://wikia-inc.atlassian.net/browse/DAR-330
		if ( $bStripTemplates ) {

			$sSourceWithoutTemplates = trim( preg_replace( '/({{[^}]+}})/', '', $oArticle->getText() ) );

			$oParserOut = $oApp->wg->Parser->parse( $sSourceWithoutTemplates, $oApp->wg->Title, $oParserOptions );

		} else {
			// just parse
			$oParserOut = $oApp->wg->Parser->parse( $oArticle->getText(), $oApp->wg->Title, $oParserOptions );
		}

		$aOutput = array();
		// Take the content out of an HTML P element and strip whitespace from the beginning and end.
		$res = $oParserOut->getText();
		if ( preg_match( '/^<p>\\s*(.*)\\s*<\/p>$/su', $res, $aOutput ) ) {
			$res = $aOutput[1];
		}

		wfProfileOut( __METHOD__ );
		return $res;
	}

	public function getDescription ( $bParse = true ) {
		/** @var $title Title */
		$title = $this->getTitle();
		$memcKey = wfmemcKey( __METHOD__, $title->getArticleID(), $title->getTouchedCached(), 'parsed' );
		$res = $this->wg->memc->get( $memcKey );
		if ( !is_string( $res ) ) {

			if ( !$bParse ) {
				$oArticle = new Article( $title );
				return $oArticle->getText();
			}

			$res = $this->getDescriptionParsed( false );

			$this->wg->memc->set( $memcKey, $res, self::DESCRIPTION_CACHE_TTL );
		}
		return $res;
	}

	public function getRelatedPageId() {
		return $this->mRelatedPageId;
	}

	public function getUser() {
		return User::newFromName( $this->mTitle->getBaseText(), false );
	}

	public function exists() {
		$id = (int) $this->getId();
		if ( $id != 0 ) {
			return true;
		}
		return false;
	}

	public function getUrl() {
		wfProfileIn( __METHOD__ );
		$title = Title::newFromText( $this->getUser()->getName(), NS_USER_WALL );
		wfProfileOut( __METHOD__ );
		if ( $title instanceof Title ) {
			return $title->getFullUrl();
		} else {
			\Wikia\Logger\WikiaLogger::instance()->error( 'Wall: no wall title found', [
				'userName' => $this->getUser()->getName(),
			] );
			return '';
		}
	}

	public function disableCache() {
		$this->cacheable = false;
	}

	/**
	 * This can return false instead of where condition in case the where would
	 * ask for parent_page_id equal 0
	 */
	protected function getWhere() {
		wfProfileIn( __METHOD__ );

		if ( empty( $this->mRelatedPageId ) ) {
			$pageId = $this->mTitle->getArticleID();
			if ( empty( $pageId ) ) {
				// bugid:95249 - empty($pageId) means the Wall does not exist yet, so we shouldn't query for anything
				// otherwise we will get some strange results like WikiaBot's posts on Empty's wall
				$where = false;
			} else {
				$where = "parent_page_id = $pageId  and deleted = 0 and removed = 0";
			}
		} else {
			$where = "comment_id in (select comment_id from wall_related_pages where page_id = {$this->mRelatedPageId})";
		}

		wfProfileOut( __METHOD__ );
		return $where;
	}

	/*
	 * most replies in 7 days
	 */

	protected function getLast7daysOrder( $master = false ) {
		wfProfileIn( __METHOD__ );

		$out = array();
		$where = $this->getWhere();

		if ( $where ) {
			$db = wfGetDB( $master ? DB_MASTER : DB_SLAVE );

			$time = date ( "Y-m-d H:i:s", time() - 24 * 7 * 60 * 60 ) ;

			$res = $db->select(
				array( 'comments_index' ),
				array( 'parent_comment_id, count(*) as cnt' ),
				array(
					$where,
					'parent_comment_id != 0',
					"last_touched BETWEEN '$time' AND NOW()",
				),
				__METHOD__,
				array(
					'ORDER BY' => 'cnt desc',
					'LIMIT' => 100,
					'GROUP BY' => 'parent_comment_id'
				)
			);

			while ( $row = $db->fetchObject( $res ) ) {
				$out[] = $row->parent_comment_id;
			}
		}


		if ( !empty( $out ) ) {
			/* look a lit bit complicated but it is fast, tested on 150000 rows, we are expecing less then that. */
			$ids = implode( ',', $out );
			$out = "CASE WHEN comment_id in (" . $ids . ") THEN Field(comment_id," . $ids . ")
				ELSE 1e12 END asc, comment_id desc ";
		} else {
			$out = 'comment_id DESC';
		}

		wfProfileOut( __METHOD__ );
		return $out;
	}

	protected function getOrderBy() {
		wfProfileIn( __METHOD__ );

		$this->getLast7daysOrder();

		switch( $this->mSorting ) {
			case 'nt': // newest threads first
			default:
				wfProfileOut( __METHOD__ );
				return 'comment_id desc';
			case 'ot': // oldest threads first
				wfProfileOut( __METHOD__ );
				return 'comment_id asc';
			case 'nr': // threads with newest reply first
				wfProfileOut( __METHOD__ );
				return 'last_child_comment_id desc';
			case 'mr': // most replies in 7 days first
				$out = $this->getLast7daysOrder();
				wfProfileOut( __METHOD__ );
				return $out;
		}
	}

	public function getThreads( $page = 1, $master = false ) {
		wfProfileIn( __METHOD__ );
		// get list of threads (article IDs) on Message Wall
		$db = wfGetDB( $master ? DB_MASTER : DB_SLAVE );

		$offset = ( $page - 1 ) * $this->mMaxPerPage;

		$out = array();
		$where = $this->getWhere();

		if ( $where ) {
			$where .= ' and parent_comment_id = 0 ';

			$orderBy = $this->getOrderBy();

			$query = "
			SELECT comment_id FROM comments_index
				WHERE $where
				ORDER BY $orderBy
				LIMIT $offset, {$this->mMaxPerPage}
			";

			$res = $db->query( $query );



			while ( $row = $db->fetchObject( $res ) ) {
				$out[] = WallThread::newFromId( $row->comment_id );
			}
		}

		wfProfileOut( __METHOD__ );
		return $out;
	}

	public function getThreadCount( $master = false ) {
		wfProfileIn( __METHOD__ );
		$where = $this->getWhere();
		if ( !$where ) {
			$count = 0;
		} else {
			$db = wfGetDB( $master ? DB_MASTER : DB_SLAVE );

			$count = $db->selectField(
				array( 'comments_index' ),
				array( 'count(distinct comment_id) cnt' ),
				array(
					'parent_comment_id' => 0,
					$where
				),
				__METHOD__
			);
		}

		wfProfileOut( __METHOD__ );
		return $count;
	}

	public function moveAllThread( Wall $dest ) {
		CommentsIndex::changeParent( $this->getId(), $dest->getId() );

		$wallHistory = new WallHistory( $this->mCityId );
		$wallHistory->moveThreads( $this->getId(), $dest->getId() );
	}

	public function setMaxPerPage( $val ) {
 		$this->mMaxPerPage = $val;
	}

	public function setSorting( $val ) {
 		$this->mSorting = $val;
	}

	public function invalidateCache() {
		// TODO: implent it
		return true;
	}
}

<?

class PhalanxPager extends ReverseChronologicalPager {
	private $app = null;
	
	public function __construct() {
		parent::__construct();
		$this->app = F::app();

		$this->mDb = wfGetDB( DB_SLAVE, array(), $this->wg->ExternalSharedDB );
		$this->mSearchText = $this->wg->Request->getText( 'wpPhalanxCheckBlocker', null );
		$this->mSearchFilter = $this->wg->Request->getArray( 'wpPhalanxTypeFilter' );
		$this->mSearchId = $this->wg->Request->getInt( 'id' );
	}

	function getQueryInfo() {
		$query['tables'] = 'phalanx';
		$query['fields'] = '*';

		if ( $this->mSearchId ) {
			$query['conds'][] = "p_id = {$this->mSearchId}";
		} else {
			if ( !empty( $this->mSearchText ) ) {
				$query['conds'][] = '(p_text like "%' . $this->mDb->escapeLike( $this->mSearchText ) . '%")';
			}

			if ( !empty( $this->mSearchFilter ) ) {
				$typemask = 0;
				foreach ( $this->mSearchFilter as $type ) {
					$typemask |= $type;
				}

				$query['conds'][] = "p_type & $typemask <> 0";
			}
		}

		return $query;
	}

	function getIndexField() {
		return 'p_timestamp';
	}

	function getStartBody() {
		return '<ul>';
	}

	function getEndBody() {
		return '</ul>';
	}

	function formatRow( $row ) {
		// hide e-mail filters
		if ( ( $row->p_type & Phalanx::TYPE_EMAIL ) && !$this->wg->User->isAllowed( 'phalanxemailblock' ) ) {
			return '';
		}

		$author = F::build('User', array( $row->p_author_id ), 'newFromId');
		$authorName = $author->getName();
		$authorUrl = $author->getUserPage()->getFullUrl();

		$phalanxPage = F::build( 'Title', array( 'Phalanx', NS_SPECIAL ), 'newFromText' );
		$phalanxUrl = $phalanxPage->getFullUrl( array( 'id' => $row->p_id ) );

		$phalanxStatsPage = F::build( 'Title', array( 'PhalanxStats', NS_SPECIAL ), 'newFromText' );
		$statsUrl = sprintf( "%s/%s", $phalanxStatsPage->getFullUrl(), $row->p_id );

		$html  = Html::openElement( 'li', array( 'id' => 'phalanx-block-' . $row->p_id ) );
		$html .= Html::element( 'b', array(), htmlspecialchars( $row->p_text ) ); 
		$html .= sprintf( " (%s%s%s) ", 
			( $row->p_regex ? 'regex' : 'plain' ),
			( $row->p_case  ? ',case' : '' ),
			( $row->p_exact ? ',exact': '' )
		);

		/* control links */
		$html .= sprintf( " &bull; %s &bull; %s &bull; %s <br />", 
			Html::element( 'a', array( 'class' => 'unblock', 'href' => $phalanxUrl ), $this->wf->Msg('phalanx-link-unblock') ),
			Html::element( 'a', array( 'class' => 'modify', 'href' => $phalanxUrl ), $this->wf->Msg('phalanx-link-modify') ),			  
			Html::element( 'a', array( 'class' => 'stats', 'href' => $statsUrl ), $this->wf->Msg('phalanx-link-stats') )
		);
		
		/* types */
		$html .= $this->wf->Msg('phalanx-display-row-blocks', implode( ', ', Phalanx::getTypeNames( $row->p_type ) ) );

		$html .= sprintf( " &bull; %s ", $this->wf->MsgExt( 'phalanx-display-row-created', array('parseinline'), $authorName, $this->wg->Lang->timeanddate( $row->p_timestamp ) ) );

		$html .= Html::closeElement( "li" );

		return $html;
	}
}

class PhalanxStatsPager extends ReverseChronologicalPager {
	private $app = null;
	
	public function __construct( $id ) {
		parent::__construct();
		$this->app = F::app();
		$this->mDb = $this->wf->GetDB( DB_SLAVE, array(), $this->wg->ExternalDatawareDB );
		$this->mBlockId = (int) $id;
		$this->mDefaultQuery['blockId'] = (int) $id;
	}

	function getQueryInfo() {
		$query['tables'] = 'phalanx_stats';
		$query['fields'] = '*';
		$query['conds'] = array(
			'ps_blocker_id' => $this->mBlockId,
		);

		return $query;
	}

	function getPagingQueries() {
		$queries = parent::getPagingQueries();

		foreach ( $queries as $type => $query ) {
			if ( $query === false ) {
				continue;
			}
			$query['blockId'] = $this->mBlockId;
			$queries[$type] = $query;
		}

		return $queries;
	}

	function getIndexField() {
		return 'ps_timestamp';
	}

	function getStartBody() {
		return Html::openElement( 'ul', array( "id" => 'phalanx-block-' . $this->mBlockId . '-stats' ) );
	}

	function getEndBody() {
		return Html::closeElement( 'ul' );
	}

	function formatRow( $row ) {
		$type = implode( Phalanx::getTypeNames( $row->ps_blocker_type ) );
		$username = $row->ps_blocked_user;
		$timestamp = $this->wg->Lang->timeanddate( $row->ps_timestamp );
		$oWiki = WikiFactory::getWikiById( $row->ps_wiki_id );
		$url = $oWiki->city_url;

		$html  = Html::openElement( 'li' );
		$html .= $this->wf->MsgExt( 'phalanx-stats-row', array('parseinline'), $type, $username, $url, $timestamp );
		$html .= Html::closeElement( 'li' );

		return $html;
	}
}

class PhalanxStatsWikiaPager extends ReverseChronologicalPager {
	private $app = null;
	
	public function __construct( $id ) {
		parent::__construct();
		$this->app = F::app();
		$this->mDb = $this->wf->GetDB( DB_SLAVE, array(), $this->wg->ExternalDatawareDB );

		$this->mWikiId = (int) $id;
		$this->mTitle = F::build( 'Title', array( 'Phalanx', NS_SPECIAL ), 'newFromText' );
		$this->mTitleStats = F::build( 'Title', array( 'PhalanxStats', NS_SPECIAL ), 'newFromText' );
		$this->mSkin = RequestContext::getMain()->getSkin();
	}

	function getQueryInfo() {
		$query['tables'] = 'phalanx_stats';
		$query['fields'] = '*';
		$query['conds'] = array(
			'ps_wiki_id' => $this->mWikiId,
		);

		return $query;
	}

	function getPagingQueries() {
		$queries = parent::getPagingQueries();

		foreach ( $queries as $type => $query ) {
			if ( $query === false ) {
				continue;
			}
			$query['wikiId'] = $this->mWikiId;
			$queries[$type] = $query;
		}

		return $queries;
	}

	function getIndexField() {
		return 'ps_timestamp';
	}

	function getStartBody() {
		return Html::openElement( 'ul', array( "id" => 'phalanx-block-wiki-' . $this->mWikiId . '-stats' ) );
	}

	function getEndBody() {
		return Html::closeElement( 'ul' );
	}
	
	function formatRow( $row ) {
		$type = implode( Phalanx::getTypeNames( $row->ps_blocker_type ) );
		$username = $row->ps_blocked_user;
		$timestamp = $this->wg->Lang->timeanddate( $row->ps_timestamp );
		$blockId = (int) $row->ps_blocker_id;
		# block
		$phalanxUrl = $this->mSkin->makeLinkObj( $this->mTitle, $blockId, 'id=' . $blockId );
		# stats
		$statsUrl = $this->mSkin->makeLinkObj( $this->mTitleStats, $this->wf->Msg('phalanx-link-stats'), 'blockId=' . $blockId );

		$html  = Html::openElement( 'li' );
		$html .= $this->wf->MsgExt( 'phalanx-stats-row-per-wiki', array('parseinline', 'replaceafter'), $type, $username, $phalanxUrl, $timestamp, $statsUrl );
		$html .= Html::closeElement( 'li' );

		return $html;
	}
}

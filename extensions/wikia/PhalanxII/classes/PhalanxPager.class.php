<?

class PhalanxPager extends ReverseChronologicalPager {
	private $app = null;
	private $id = 0;
	private $pInx = '';

	public function __construct() {
		parent::__construct();
		$this->app = F::app();

		$this->mDb = wfGetDB( DB_SLAVE, array(), $this->app->wg->ExternalSharedDB );
		$this->mSearchText = $this->app->wg->Request->getText( 'wpPhalanxCheckBlocker', null );
		$this->mSearchFilter = $this->app->wg->Request->getArray( 'wpPhalanxTypeFilter' );
		$this->mSearchId = $this->app->wg->Request->getInt( 'id' );

		$this->mTitle = F::build( 'Title', array( 'Phalanx/stats', NS_SPECIAL ), 'newFromText' );
		$this->mTitleStats = F::build( 'Title', array( 'PhalanxStats', NS_SPECIAL ), 'newFromText' );
		$this->mSkin = RequestContext::getMain()->getSkin();
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
		return Html::openElement( 'ul', array( "id" => 'phalanx-block-' . $this->pInx . '-' . $this->id . '-stats' ) );
	}

	function getEndBody() {
		return Html::closeElement( 'ul' );
	}

	function formatRow( $row ) {
		// hide e-mail filters
		if ( ( $row->p_type & Phalanx::TYPE_EMAIL ) && !$this->app->wg->User->isAllowed( 'phalanxemailblock' ) ) {
			return '';
		}

		$author = F::build('User', array( $row->p_author_id ), 'newFromId');
		$authorName = $author->getName();
		$authorUrl = $author->getUserPage()->getFullUrl();

		$phalanxPage = SpecialPage::getTitleFor('Phalanx');
		$phalanxModifyPage = SpecialPage::getTitleFor('Phalanx', 'edit');

		$phalanxStatsPage = F::build( 'Title', array( 'PhalanxStats', NS_SPECIAL ), 'newFromText' );
		$statsUrl = sprintf( "%s/%s", $phalanxStatsPage->getLocalUrl(), $row->p_id );

		$html  = Html::openElement( 'li', array( 'id' => 'phalanx-block-' . $row->p_id ) );
		$html .= Html::element( 'b', array(), htmlspecialchars( $row->p_text ) );
		$html .= sprintf( " (%s%s%s) ",
			( $row->p_regex ? 'regex' : 'plain' ),
			( $row->p_case  ? ',case' : '' ),
			( $row->p_exact ? ',exact': '' )
		);

		/* control links */
		$html .= sprintf( " &bull; %s &bull; %s &bull; %s <br />",
			Html::element( 'a', array(
				'class' => 'unblock',
				'href' => $phalanxPage->getLocalUrl( array( 'id' => $row->p_id ) )
			), $this->app->wf->Msg('phalanx-link-unblock') ),
			Html::element( 'a', array(
				'class' => 'modify',
				'href' => $phalanxModifyPage->getLocalUrl( array( 'id' => $row->p_id ) )
			), $this->app->wf->Msg('phalanx-link-modify') ),
			Html::element( 'a', array(
				'class' => 'stats',
				'href' => $statsUrl
			), $this->app->wf->Msg('phalanx-link-stats') )
		);

		/* types */
		$html .= $this->app->wf->Msg('phalanx-display-row-blocks', implode( ', ', Phalanx::getTypeNames( $row->p_type ) ) );

		$html .= sprintf( " &bull; %s ", $this->app->wf->MsgExt( 'phalanx-display-row-created', array('parseinline'), $authorName, $this->app->wg->Lang->timeanddate( $row->p_timestamp ) ) );

		$html .= Html::closeElement( "li" );

		return $html;
	}
}

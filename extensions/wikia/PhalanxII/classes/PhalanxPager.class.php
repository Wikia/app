<?php

class PhalanxPager extends ReverseChronologicalPager {
	protected $app = null;
	protected $id = 0;
	private $pInx = '';

	/** @var Skin|Linker $mSkin */
	protected $mSkin;

	public function __construct() {
		parent::__construct();
		$this->app = F::app();

		$this->mDb = wfGetDB( DB_SLAVE, [], $this->app->wg->ExternalSharedDB );

		$request = $this->getRequest();
		$this->mSearchText = $request->getText( 'wpPhalanxCheckBlocker', null );
		$this->mSearchFilter = $request->getArray( 'wpPhalanxTypeFilter' );
		$this->mSearchId = $request->getInt( 'id' );

		// handle "type" parameter from URLs coming from hook messages
		$type = $request->getInt( 'type' );
		if ( $type > 0 ) {
			$this->mSearchFilter = [ $type ];
		}

		$this->mTitle = Title::newFromText( 'Phalanx/stats', NS_SPECIAL );

		$this->phalanxPage = SpecialPage::getTitleFor( 'Phalanx' );
		$this->phalanxStatsPage = SpecialPage::getTitleFor( 'PhalanxStats' );

		$this->mSkin = $this->getSkin();
	}

	/**
	 * Get types filter as key/value collection:
	 *
	 * array(
	 *  typeId => true
	 * )
	 *
	 * @return Array
	 */
	function getSearchFilter() {
		if ( is_array( $this->mSearchFilter ) ) {
			$filters = array_map( 'intval', $this->mSearchFilter );
			return array_fill_keys( $filters, true );
		} else {
			return [];
		}
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
		return Html::openElement( 'ul', [ "id" => 'phalanx-block-' . $this->pInx . '-' . $this->id . '-stats' ] );
	}

	function getEndBody() {
		return Html::closeElement( 'ul' );
	}

	function getEmptyBody() {
		return Html::element( 'div', [ 'class' => 'error' ], $this->msg( 'phalanx-no-results' )->text() );
	}

	function formatRow( $row ) {
		// hide e-mail filters
		if ( ( $row->p_type & Phalanx::TYPE_EMAIL ) && !$this->getUser()->isAllowed( 'phalanxemailblock' ) ) {
			return '';
		}

		// SUS-270: Get author from correct field
		if ( isset( $row->p_authorId ) ) {
			$author = User::newFromId( $row->p_authorId );
			$authorName = $author->getName();
		} else {
			$authorName = '';
		}

		$statsUrl = sprintf( "%s/%s", $this->phalanxStatsPage->getLocalUrl(), $row->p_id );

		$html = Html::openElement( 'li', [ 'id' => 'phalanx-block-' . $row->p_id ] );
		$html .= Html::element( 'b', [ 'class' => 'blockContent' ], $row->p_text );
		$html .= sprintf( " (%s%s%s) ",
			( !empty( $row->p_regex ) ? 'regex' : 'plain' ),
			( !empty( $row->p_case ) ? ',case' : '' ),
			( !empty( $row->p_exact ) ? ',exact' : '' )
		);

		/* control links */
		$html .= sprintf( " &bull; %s &bull; %s",
			Html::element( 'a', [
				'class' => 'modify',
				'href' => $this->phalanxPage->getLocalUrl( [ 'id' => $row->p_id ] ),
			], $this->msg( 'phalanx-link-modify' )->text() ),
			Html::element( 'a', [
				'class' => 'stats',
				'href' => $statsUrl,
			], $this->msg( 'phalanx-link-stats' )->text() )
		);

		/* remove block button - handled via AJAX */
		$html .= Html::element( 'button', [
			'class' => 'unblock',
			'data-id' => $row->p_id,
		], $this->msg( 'phalanx-link-unblock' )->text() );

		$html .= Html::element( 'br' );

		/* types */
		$html .= $this->msg( 'phalanx-display-row-blocks', implode( ', ', Phalanx::getTypeNames( $row->p_type ) ) )->escaped();

		/* created */
		if ( isset( $row->p_timestamp ) ) {
			$html .= ' &bull; ';
			$html .= $this->msg( 'phalanx-display-row-created' )
					->params( $authorName, $this->getLanguage()->timeanddate( $row->p_timestamp ) )
					->parse();
		}

		/* valid till */
		if ( property_exists( $row, 'p_expire' ) ) {
			if ( is_null( $row->p_expire ) ) {
				$html .= ' &bull; ';
				$html .= $this->msg( 'phalanx-display-row-expire-infinity' )->escaped();
			} elseif ( is_numeric( $row->p_expire ) ) {
				$html .= ' &bull; ';
				$html .= $this->msg( 'phalanx-display-row-expire' )
					->params( $this->getLanguage()->timeanddate( $row->p_expire ) )
					->escaped();
			}
		}

		$html .= Html::closeElement( "li" );

		return $html;
	}
}

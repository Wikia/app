<?

class PhalanxPager extends ReverseChronologicalPager {
	public function __construct() {
		parent::__construct();
		$app = F::app();

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

		$author = User::newFromId( $row->p_author_id );
		$authorName = $author->getName();
		$authorUrl = $author->getUserPage()->getFullUrl();

		$phalanxUrl = Title::newFromText( 'Phalanx', NS_SPECIAL )->getFullUrl( array( 'id' => $row->p_id ) );
		$statsUrl = Title::newFromText( 'PhalanxStats', NS_SPECIAL )->getFullUrl() . '/' . $row->p_id;

		$html = '<li id="phalanx-block-' . $row->p_id . '">';

		$html .= '<b>' . htmlspecialchars( $row->p_text ) . '</b> (' ;

		$html .= $row->p_regex ? 'regex' : 'plain';
		if( $row->p_case ) {
			$html .= ',case';
		}
		if( $row->p_exact ) {
			$html .= ',exact';
		}
		$html .= ') ';

		// control links
		$html .= " &bull; <a class='unblock' href='{$phalanxUrl}'>" . wfMsg('phalanx-link-unblock') . '</a>';
		$html .= " &bull; <a class='modify' href='{$phalanxUrl}'>" . wfMsg('phalanx-link-modify') . '</a>';
		$html .= " &bull; <a class='stats' href='{$statsUrl}'>" . wfMsg('phalanx-link-stats') . '</a>';

		// types
		$html .= '<br /> ' . wfMsg('phalanx-display-row-blocks', implode( ', ', Phalanx::getTypeNames( $row->p_type ) ) );

		$html .= ' &bull; ' . wfMsgExt('phalanx-display-row-created', array('parseinline'), $authorName, $wgLang->timeanddate( $row->p_timestamp ));

		$html .= '</li>';

		return $html;
	}
}

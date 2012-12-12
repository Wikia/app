<?php

class SpecialPhalanx extends SpecialPage {

	var $mDefaultExpire;

	function __construct() {
		$this->mDefaultExpire = '1 year';
		parent::__construct('Phalanx', 'phalanx' /* restrictions */, true /* listed */);
	}

	function execute( $par ) {
		wfProfileIn(__METHOD__);
		global $wgOut, $wgRequest, $wgExtensionsPath, $wgStylePath;
		global $wgPhalanxSupportedLanguages, $wgUser, $wgTitle;

		// check restrictions
		if ( !$this->userCanExecute( $wgUser ) ) {
			$this->displayRestrictionError();
			wfProfileOut(__METHOD__);
			return;
		}

		$this->setHeaders();
		$wgOut->addStyle( "$wgExtensionsPath/wikia/Phalanx/css/Phalanx.css" );
		$wgOut->addScript("<script type='text/javascript' src='$wgExtensionsPath/wikia/Phalanx/js/Phalanx.js'></script>\n");
		$wgOut->addExtensionStyle("{$wgStylePath}/common/wikia_ui/tabs.css");
		$wgOut->setPageTitle( wfMsg('phalanx-title') );

		$template = new EasyTemplate(dirname(__FILE__).'/templates');

		$pager = new PhalanxPager();

		$listing = $pager->getNavigationBar();
		$listing .= $pager->getBody();
		$listing .= $pager->getNavigationBar();

		$data = $this->prefillForm();

		$template->set_vars(array(
			'expiries' => Phalanx::getExpireValues(),
			'languages' => $wgPhalanxSupportedLanguages,
			'listing' => $listing,
			'data' => $data,
			'action' => $wgTitle->getFullURL(),
			'showEmail' => $wgUser->isAllowed( 'phalanxemailblock' )
		));

		$wgOut->addHTML($template->render('phalanx'));

		wfProfileOut(__METHOD__);

	}

	function prefillForm() {
		global $wgRequest;

		$data = array();

		$id = $wgRequest->getInt( 'id' );
		if ( $id ) {
			$data = Phalanx::getFromId( $id );
			$data['type'] = Phalanx::getTypeNames( $data['type'] );
			$data['checkBlocker'] = '';
			$data['typeFilter'] = array();;
		} else {
			$data['type'] = array_fill_keys( $wgRequest->getArray( 'type', array() ), true );
			$data['checkBlocker'] = $wgRequest->getText( 'wpPhalanxCheckBlocker', '' );
			$data['typeFilter'] = array_fill_keys( $wgRequest->getArray( 'wpPhalanxTypeFilter', array() ), true );
		}

		$data['checkId'] = $id;

		$data['text'] = $wgRequest->getText( 'ip' );
		$data['text'] = $wgRequest->getText( 'target', $data['text'] );
		$data['text'] = $wgRequest->getText( 'text', $data['text'] );

		$data['text'] = self::decodeValue( $data['text'] ) ;

		$data['case'] = $wgRequest->getCheck( 'case' );
		$data['regex'] = $wgRequest->getCheck( 'regex' );
		$data['exact'] = $wgRequest->getCheck( 'exact' );

		$data['expire'] = $wgRequest->getText( 'expire', $this->mDefaultExpire );

		$data['lang'] = $wgRequest->getText( 'lang', 'all' );

		$data['reason'] = self::decodeValue( $wgRequest->getText( 'reason' ) );

		// test form input
		$data['test'] = self::decodeValue( $wgRequest->getText( 'test' ) );

		return $data;
	}

	static function decodeValue( $input ) {
		return htmlspecialchars( str_replace( '_', ' ', urldecode( $input ) ) );
	}
}

class PhalanxPager extends ReverseChronologicalPager {
	public function __construct() {
		global $wgExternalSharedDB, $wgRequest;

		parent::__construct();
		$this->mDb = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );

		$this->mSearchText = $wgRequest->getText( 'wpPhalanxCheckBlocker', null );
		$this->mSearchFilter = $wgRequest->getArray( 'wpPhalanxTypeFilter' );
		$this->mSearchId = $wgRequest->getInt( 'id' );
	}

	function getQueryInfo() {
		$query['tables'] = 'phalanx';
		$query['fields'] = '*';

		if ($this->mSearchId) {
			$query['conds'][] = "p_id = {$this->mSearchId}";
		} else {
			if ( !empty( $this->mSearchText ) ) {
				$query['conds'][] = '(p_text like "%' . $this->mDb->escapeLike( $this->mSearchText ) . '%")';
			}

			if ( !empty( $this->mSearchFilter ) ) {
				$typemask = 0;
				foreach ($this->mSearchFilter as $type ) {
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
		global $wgLang, $wgUser;

		// hide e-mail filters
		if ( $row->p_type & Phalanx::TYPE_EMAIL && !$wgUser->isAllowed( 'phalanxemailblock' ) ) {
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

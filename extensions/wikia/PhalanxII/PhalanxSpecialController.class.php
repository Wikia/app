<?php

class PhalanxSpecialController extends WikiaSpecialPageController {
	private $mDefaultExpire = '1 year';

	public function __construct() {
		parent::__construct('Phalanx');
		$this->includable(false);
	}
	
	public function index() {
		$this->wf->profileIn( __METHOD__ );
		
		$this->wg->Out->setPageTitle( $this->wf->Msg('phalanx-title') );
		if ( !$this->userCanExecute( $this->wg->User ) ) {
			$this->displayRestrictionError();
			$this->wf->profileOut( __METHOD__ );
			return false;
		}
		
		$this->response->addAsset('extensions/wikia/Phalanx/css/Phalanx.css');
		$this->response->addAsset('extensions/wikia/Phalanx/js/Phalanx.js');
		//$wgOut->addExtensionStyle("{$wgStylePath}/common/wikia_ui/tabs.css");

		/* set pager */
		$pager = new PhalanxPager();
		$listing  = $pager->getNavigationBar();
		$listing .= $pager->getBody();
		$listing .= $pager->getNavigationBar();

		$this->setVal( 'expiries', Phalanx::getExpireValues(),
		$this->setVal( 'languages', $this->wg->PhalanxSupportedLanguages );
		$this->setVal( 'listing', $listing );
		$this->setVal( 'data', $this->formData() );
		$this->setVal( 'action', $this->wg->Title->getFullUrl() );
		$this->setVal( 'showEmail', $this->wg->User->isAllowed( 'phalanxemailblock' ) );
		
		$this->wf->profileOut( __METHOD__ );
	}

	function formData() {
		$data = array();

		$id = $this->wg->Request->getInt( 'id' );
		if ( $id ) {
			$data = Phalanx::newFromId( $id );
			$data['type'] = Phalanx::getTypeNames( $data['type'] );
			$data['checkBlocker'] = '';
			$data['typeFilter'] = array();;
		} else {
			$data['type'] = array_fill_keys( $this->wg->Request->getArray( 'type', array() ), true );
			$data['checkBlocker'] = $this->wg->Request->getText( 'wpPhalanxCheckBlocker', '' );
			$data['typeFilter'] = array_fill_keys( $this->wg->Request->getArray( 'wpPhalanxTypeFilter', array() ), true );
		}

		$data['checkId'] = $id;

		$data['text'] = $this->wg->Request->getText( 'ip' );
		$data['text'] = $this->wg->Request->getText( 'target', $data['text'] );
		$data['text'] = $this->wg->Request->getText( 'text', $data['text'] );
		$data['text'] = $this->decodeValue( $data['text'] ) ;

		$data['case'] = $this->wg->Request->getCheck( 'case' );
		$data['regex'] = $this->wg->Request->getCheck( 'regex' );
		$data['exact'] = $this->wg->Request->getCheck( 'exact' );

		$data['expire'] = $this->wg->Request->getText( 'expire', $this->mDefaultExpire );

		$data['lang'] = $this->wg->Request->getText( 'lang', 'all' );

		$data['reason'] = $this->decodeValue( $this->wg->Request->getText( 'reason' ) );

		$data['test'] = $this->decodeValue( $this->wg->Request->getText( 'test' ) );

		return $data;
	}

	private function decodeValue( $input ) {
		return htmlspecialchars( str_replace( '_', ' ', urldecode( $input ) ) );
	}
}

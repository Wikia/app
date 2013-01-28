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
		
		$this->setVal( 'url', $oPlaceModel->getStaticMapUrl() );
		$this->setVal( 'align', $oPlaceModel->getAlign() );
		$this->setVal( 'width', $oPlaceModel->getWidth() );
		$this->setVal( 'height', $oPlaceModel->getHeight() );
		$this->setVal( 'lat', $oPlaceModel->getLat() );
		$this->setVal( 'lon', $oPlaceModel->getLon() );
		$this->setVal( 'zoom', $oPlaceModel->getZoom() );
		$this->setVal( 'categories', $oPlaceModel->getCategoriesAsText() );
		$this->setVal( 'caption', $oPlaceModel->getCaption() );
		$this->setVal( 'rteData', $rteData );
		
		$this->wf->profileOut( __METHOD__ );
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


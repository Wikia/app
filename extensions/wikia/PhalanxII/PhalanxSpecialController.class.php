<?php

class PhalanxSpecialController extends WikiaSpecialPageController {
	private $mDefaultExpire = '1 year';
	private $title = null;
	private $errorMsg = '';

	public function __construct() {
		parent::__construct('Phalanx');
		$this->includable(false);
		$this->title = Title::newFromText( 'Phalanx', NS_SPECIAL );
	}
	
	public function index() {
		$this->wf->profileIn( __METHOD__ );
		
		$this->wg->Out->setPageTitle( $this->wf->Msg('phalanx-title') );
		if ( !$this->userCanExecute( $this->wg->User ) ) {
			$this->displayRestrictionError();
			$this->wf->profileOut( __METHOD__ );
			return false;
		}
		
		if ( $this->wg->Request->wasPosted() ) {
			$id = $this->postForm();
			$this->response->redirect( $this->title->getFullUrl( array( 'id' => $id ) ) );
			return true;
		}
		
		$this->response->addAsset('extensions/wikia/Phalanx/css/Phalanx.css');
		$this->response->addAsset('extensions/wikia/Phalanx/js/Phalanx.js');
		//$wgOut->addExtensionStyle("{$wgStylePath}/common/wikia_ui/tabs.css");

		/* set pager */
		$pager = new PhalanxPager();
		$listing  = $pager->getNavigationBar();
		$listing .= $pager->getBody();
		$listing .= $pager->getNavigationBar();

		$this->setVal( 'expiries', Phalanx::getExpireValues() );
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
	
	private function postForm() {
		$this->wf->profileIn( __METHOD__ );

		$phalanx = F::build( 'Phalanx', array( F::app() ) );
		$values = $this->wg->Request->getValues();
		
		$typemask = 0;
		foreach( $values['wpPhalanxType'] as $type ) {
			$typemask |= $type;
		}

		if ( ( empty( $values['wpPhalanxFilter'] ) && empty( $values['wpPhalanxFilterBulk'] ) ) || empty( $typemask ) ) {
			$this->wf->profileOut( __METHOD__ );
			$this->errorMsg = $this->wf->Msg( 'phalanx-block-failure' );
			return false;
		}

		if ( $values['wpPhalanxLanguages'] == 'all' ) {
			$values['wpPhalanxLanguages'] = null;
		}

		if ( $values['wpPhalanxExpire'] != 'infinite' ) {
			$expire = strtotime( $values['wpPhalanxExpire'] );
			if ( $expire < 0 || $expire === false ) {
				$this->wf->profileOut( __METHOD__ );
				$this->errorMsg = $this->wf->Msg( 'phalanx-block-failure' );
				return false;
			}
			$values['wpPhalanxExpire'] = wfTimestamp( TS_MW, $expire );
		} else {
			$values['wpPhalanxExpire'] = null ;
		}
		
		if ( empty( $values['wpPhalanxFilterBulk'] ) ) {
			//single mode
			if ( empty( $values['id'] ) ) {
				$status = PhalanxHelper::save( $values );
				$reason = $status ? wfMsg( 'phalanx-block-success' ) : wfMsg( 'phalanx-block-failure' );
			} else {
				$data['id'] = $id;
				$status = PhalanxHelper::update( $data );
				$reason = $status ? wfMsg( 'phalanx-modify-success' ) : wfMsg( 'phalanx-block-failure' );
			}
		}
		else {
			// non-empty bulk field
			$bulkdata = explode("\n", $filterbulk);
			if( count($bulkdata) ) {
				$reasons = array('s' => 0, 'f' => 0);
				foreach($bulkdata as $bulkrow)
				{
					$bulkrow = trim($bulkrow);
					$data['text'] = $bulkrow;

					$bstatus = PhalanxHelper::save( $data );
					if($bstatus) {
						$reasons[ 's' ] ++;
					} else {
						$reasons[ 'f' ] ++;
					}

				}
				$status = true;
				$reason = "[" . $reasons['s'] . "] success and [" . $reasons['f'] . "] fails";
			}
			else
			{
				$status = false;
				$reason = "nothing to block";
			}
		}

		$id = $this->wg->Request->getVal( 'id', false ); 
		$filter = $this->wg->Request->getText( 'wpPhalanxFilter' );
		$filterbulk = $wgRequest->getText( 'wpPhalanxFilterBulk' );
		$regex = $wgRequest->getCheck( 'wpPhalanxFormatRegex' ) ? 1 : 0;
		$exact = $wgRequest->getCheck( 'wpPhalanxFormatExact' ) ? 1 : 0;
		$case = $wgRequest->getCheck( 'wpPhalanxFormatCase' ) ? 1 : 0;
		$expiry = $wgRequest->getText( 'wpPhalanxExpire' );
		$types = $wgRequest->getArray( 'wpPhalanxType' );
		$reason = $wgRequest->getText( 'wpPhalanxReason' );
		$lang = $wgRequest->getVal( 'wpPhalanxLanguages', null );

		$data = array(
			'text' => $filter,
			'exact' => $exact,
			'case' => $case,
			'regex' => $regex,
			'timestamp' => wfTimestampNow(),
			'expire' => $expire,
			'author_id' => $wgUser->getId(),
			'reason' => $reason,
			'lang' => $lang,
			'type' => $typemask
		);


		wfProfileOut( __METHOD__ );
		return array(
			'error' => !$status,
			'text'  => $reason
		);
	}
}

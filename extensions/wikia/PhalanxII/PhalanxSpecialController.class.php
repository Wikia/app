<?php

class PhalanxSpecialController extends WikiaSpecialPageController {
	private $mDefaultExpire = '1 year';
	private $title = null;
	private $errorMsg = '';
	private $valid = false;

	public function __construct() {
		parent::__construct('Phalanx');
		$this->includable(false);
		$this->title = SpecialPage::getTitleFor('Phalanx');
	}

	public function isValid() {
		return $this->valid;
	}

	public function index() {
		$this->wf->profileIn( __METHOD__ );

		$this->wg->Out->setPageTitle( $this->wf->Msg('phalanx-title') );
		if ( !$this->userCanExecute( $this->wg->User ) ) {
			$this->displayRestrictionError();
			$this->wf->profileOut( __METHOD__ );
			return false;
		}

		// select the current tab
		switch($this->getPar()) {
			case 'test':
				$currentTab = 'test';
				break;

			default:
				$currentTab = 'main';
		}

		$this->setVal('currentTab', $currentTab);

		if ( $this->wg->Request->wasPosted() ) {
			$res = $this->handlePost($currentTab);

			// TODO: handle errors
		}

		$this->response->addAsset('extensions/wikia/Phalanx/css/Phalanx.css');
		//$this->response->addAsset('extensions/wikia/Phalanx/js/Phalanx.js');

		/* set pager */
		$pager = new PhalanxPager();
		$listing  = $pager->getNavigationBar();
		$listing .= $pager->getBody();
		$listing .= $pager->getNavigationBar();

		$this->setVal( 'expiries', Phalanx::getExpireValues() );
		$this->setVal( 'languages', $this->wg->PhalanxSupportedLanguages );
		$this->setVal( 'listing', $listing );
		$this->setVal( 'data', $this->blockDataForForm() );
		$this->setVal( 'action', $this->title->getLocalURL() );
		$this->setVal( 'showEmail', $this->wg->User->isAllowed( 'phalanxemailblock' ) );

		$this->wf->profileOut( __METHOD__ );
	}

	private function blockDataForForm() {
		$data = array();

		$id = $this->wg->Request->getInt( 'id' );
		if ( $id > 0 ) {
			// block edit
			$data = Phalanx::newFromId($id);
			$data['type'] = Phalanx::getTypeNames( $data['type'] );
			$data['checkId'] = $this->wg->Request->getIntOrNull( 'id' );
			$data['checkBlocker'] = '';
			$data['typeFilter'] = array();
		}
		else {
			// block search
			$data['checkBlocker'] = $this->wg->Request->getText( 'wpPhalanxCheckBlocker' , '');
			$data['checkId'] = $this->wg->Request->getIntOrNull( 'id' );
			$data['type'] = $this->wg->Request->getArray( 'wpPhalanxType' );
			$data['typeFilter'] = $this->wg->Request->getArray( 'wpPhalanxTypeFilter' );
			$data['text'] = '';
			$data['lang'] = '';
			$data['expire'] = '';
			$data['reason'] = '';
		}
		return $data;
	}

	private function handlePost() {
		$this->wf->profileIn( __METHOD__ );

		$id = $this->wg->Request->getInt( 'id', 0 );
		$multitext = $this->wg->Request->getText( 'wpPhalanxFilterBulk' );

		/* init Phalanx helper class */
		$phalanx = F::build( 'Phalanx', array( $id ) );

		$phalanx['text'] = $this->wg->Request->getText( 'wpPhalanxFilter' );
		$phalanx['exact'] = $this->wg->Request->getCheck( 'wpPhalanxFormatExact' ) ? 1 : 0;
		$phalanx['case'] = $this->wg->Request->getCheck( 'wpPhalanxFormatCase' ) ? 1 : 0;
		$phalanx['regex'] = $this->wg->Request->getCheck( 'wpPhalanxFormatRegex' ) ? 1 : 0;
		$phalanx['timestamp'] = wfTimestampNow();
		$phalanx['expire'] = $this->wg->Request->getText( 'wpPhalanxExpire' );
		$phalanx['author_id'] = $this->wg->User->getId();
		$phalanx['reason'] = $this->wg->Request->getText( 'wpPhalanxReason' );
		$phalanx['lang'] = $this->wg->Request->getVal( 'wpPhalanxLanguages', null );
		$phalanx['type'] = $this->wg->Request->getArray( 'wpPhalanxType' );

		$typemask = 0;
		if ( is_array( $phalanx['type'] ) ) {
			foreach ( $phalanx['type'] as $type ) {
				$typemask |= $type;
			}
		}

		if ( ( empty( $phalanx['text'] ) && empty( $multitext ) ) || empty( $typemask ) ) {
			$this->wf->profileOut( __METHOD__ );
			$this->errorMsg = $this->wf->Msg( 'phalanx-block-failure' );
			return false;
		}

		if ( $phalanx['lang'] == 'all' ) {
			$phalanx['lang'] = null;
		}

		if ( $phalanx['expire'] != 'infinite' ) {
			$expire = strtotime( $phalanx['expire'] );
			if ( $expire < 0 || $expire === false ) {
				$this->wf->profileOut( __METHOD__ );
				$this->errorMsg = $this->wf->Msg( 'phalanx-block-failure' );
				return false;
			}
			$phalanx['expire'] = wfTimestamp( TS_MW, $expire );
		} else {
			$phalanx['expire'] = null ;
		}

		if ( empty( $multitext ) ) {
			/* single mode - insert/update record */
			$id = $phalanx->save();
			$result = $id ? array( "success" => array( $id ), "failed" => 0 ) : false;
		}
		else {
			/* non-empty bulk field */
			$bulkdata = explode( "\n", $multitext );
			if ( count($bulkdata) > 0 ) {
				$result = array( 'success' => array(), 'failed' => 0 );
				foreach ( $bulkdata as $bulkrow ) {
					$bulkrow = trim($bulkrow);
					$phalanx['text'] = $bulkrow;

					$id = $phalanx->save();
					if ( $id ) {
						$result[ 'success' ][] = $id;
					} else {
						$result[ 'failed' ]++;
					}
				}
			} else {
				$result = false;
			}
		}

		if ( $result !== false ) {
			$this->refresh( $result["success"] );
		}

		$this->wf->profileOut( __METHOD__ );

		return $result;
	}

	public function delete( $id, $token ) {
		$this->wf->profileIn( __METHOD__ );

		$phalanx = F::build( 'Phalanx', array( $id ) );

		if ( $token != $this->wg->User->getEditToken() ) {
			$this->displayRestrictionError();
			$this->wf->profileOut( __METHOD__ );
			return false;
		}

		$id = $phalanx->delete();
		if ( $id ) {
			$result = array( "success" => array( $id ), "failed" => 0 );
			$this->refresh( $result["success"] );
		} else {
			$result = false;
		}

		$this->wf->profileOut( __METHOD__ );

		return $result;
	}

	public function check() {
		$block = $this->request->getVal( 'block' );
		$token = $this->request->getVal( 'token' );

		if ( $token != $this->wg->User->getEditToken() ) {
			$this->wf->profileOut( __METHOD__ );
			return false;
		}
		$phalanxService = F::build('PhalanxService');
		$this->valid = $phalanxService->validate( $block );
	}

	private function refresh( /*Array*/ $ids )  {
		$phalanxService = F::build('PhalanxService');
		$this->valid = $phalanxService->reload( $ids );
	}
}

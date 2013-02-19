<?php

class PhalanxSpecialController extends WikiaSpecialPageController {
	private $title = null;
	private $errorMsg = '';
	private $service = null;

	public function __construct() {
		parent::__construct('Phalanx', 'phalanx' /* restrictions */);
		$this->includable(false);

		$this->title = SpecialPage::getTitleFor('Phalanx');
		$this->service = new PhalanxService();
	}

	/**
	 * Special page main entry point
	 */
	public function index() {
		$this->wf->profileIn( __METHOD__ );

		$this->wg->Out->setPageTitle( $this->wf->Msg('phalanx-title') );
		if ( !$this->userCanExecute( $this->wg->User ) ) {
			$this->displayRestrictionError();
			$this->wf->profileOut( __METHOD__ );
			return;
		}

		// select the current tab
		switch($this->getPar()) {
			case 'test':
				$currentTab = 'test';
				break;

			default:
				$currentTab = 'main';
		}

		// load resource loader module
		$this->wg->Out->addModules('ext.wikia.Phalanx');
		$this->wg->Out->addJsConfigVars('wgPhalanxToken', $this->getToken());
		F::build('JSMessages')->enqueuePackage('PhalanxSpecial', JSMessages::INLINE);

		$this->forward('PhalanxSpecial', $currentTab);

		$this->wf->profileOut( __METHOD__ );
	}

	/**
	 * Renders first tab - blocks creation / edit
	 */
	public function main() {
		$this->wf->profileIn( __METHOD__ );

		if ( $this->wg->Request->wasPosted() ) {
			$res = $this->handleBlockPost();
			$message = wfMsg( ($res !== false) ? 'phalanx-block-success' : 'phalanx-block-failure' );
		}

		/* set pager */
		$pager = new PhalanxPager();
		$listing  = $pager->getNavigationBar();
		$listing .= $pager->getBody();
		$listing .= $pager->getNavigationBar();

		$data = $this->blockDataForForm();
		$editMode = !empty($data['id']);

		$expiries = Phalanx::getExpireValues();
		if ($editMode) {
			$expiries = array_merge(array('' => wfMsg('phalanx-expiries-select')), $expiries);
		}

		$this->setVal( 'expiries', $expiries );
		$this->setVal( 'languages', $this->wg->PhalanxSupportedLanguages );
		$this->setVal( 'listing', $listing );
		$this->setVal( 'data',  $data);
		$this->setVal( 'editMode',  $editMode);
		$this->setVal( 'action', $this->title->getLocalURL() );
		$this->setVal( 'showEmail', $this->wg->User->isAllowed( 'phalanxemailblock' ) );
		$this->setVal( 'message', isset($message) ? $message : '' );

		$this->wf->profileOut( __METHOD__ );
	}

	/**
	 * Renders second tab - blocks testing
	 */
	public function test() {
		$title = SpecialPage::getTitleFor('Phalanx', 'test');
		$this->setVal( 'action', $title->getLocalURL() );

		$blockText = $this->wg->Request->getText('wpBlockText');
		$this->setVal( 'blockText', $blockText );

		// check the text against all blocks
		if ($blockText !== '') {
			$this->setVal( 'listing', $this->handleBlockTest($blockText) );
		}
	}

	/**
	 * Renders navigation tabs on special page
	 */
	public function tabs() {
		$this->setVal('currentTab', $this->getVal('currentTab'));
		$this->setVal('phalanxMainTitle', $this->title);
		$this->setVal('phalanxTestTitle', SpecialPage::getTitleFor('Phalanx', 'test'));
	}

	/**
	 * Returns current block data
	 *
	 * @return array
	 */
	private function blockDataForForm() {
		$data = array();

		$id = $this->wg->Request->getInt( 'id' );
		if ( $id > 0 ) {
			// block edit
			$data = Phalanx::newFromId($id);
			$data['type'] = Phalanx::getTypeNames( $data['type'] );
			$data['checkId'] = $id;
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

	/**
	 * Handle POST request to edit / create a block
	 *
	 * @return array|bool
	 */
	private function handleBlockPost() {
		$this->wf->profileIn( __METHOD__ );

		$id = $this->wg->Request->getInt( 'id', 0 );
		$multitext = $this->wg->Request->getText( 'wpPhalanxFilterBulk' );

		/* init Phalanx helper class */
		$phalanx = Phalanx::newFromId($id);

		$phalanx['text'] = $this->wg->Request->getText( 'wpPhalanxFilter' );
		$phalanx['exact'] = $this->wg->Request->getCheck( 'wpPhalanxFormatExact' ) ? 1 : 0;
		$phalanx['case'] = $this->wg->Request->getCheck( 'wpPhalanxFormatCase' ) ? 1 : 0;
		$phalanx['regex'] = $this->wg->Request->getCheck( 'wpPhalanxFormatRegex' ) ? 1 : 0;
		$phalanx['timestamp'] = wfTimestampNow();
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

		$phalanx['type'] = $typemask;
		$expire = $this->wg->Request->getText('wpPhalanxExpire');
		if ( !empty( $expire ) ) {
			$phalanx['expire'] = $expire;
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
					$phalanx['id'] = null;
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

	/**
	 * Get HTML with the list of block that apply for given text
	 *
	 * @param $blockText string text to be test against all blocks
	 * @return string HTML
	 */
	private function handleBlockTest($blockText) {
		$this->wf->profileIn( __METHOD__ );

		$service = new PhalanxService();
		$service->setLimit(20);

		$listing = '';
		$noMatches = true;

		foreach(Phalanx::getAllTypeNames() as $blockType) {
			$res = $service->match($blockType, $blockText);

			if (empty($res)) {
				continue;
			}

			$noMatches = false;

			$pager = new PhalanxBlockTestPager($blockType);
			$pager->setRows($res);
			$listing .= $pager->getHeader();
			$listing .= $pager->getBody();
		}

		if ($noMatches) {
			$pager = new PhalanxBlockTestPager(0);
			$listing .= $pager->getEmptyBody();
		}

		$this->wf->profileOut( __METHOD__ );
		return $listing;
	}

	/**
	 * Method called via AJAX from Special:Phalanx to remove blocks
	 */
	public function unblock() {
		$this->wf->profileIn( __METHOD__ );

		$this->response->setFormat('json');
		$this->setVal('success', false);

		if ( !$this->userCanExecute( $this->wg->User ) ) {
			$this->setVal('error', 'permission');

			$this->wf->profileOut( __METHOD__ );
			return;
		}

		$id = $this->request->getInt( 'blockId' );
		$token = $this->request->getVal( 'token' );

		// validate input
		if (!$id) {
			$this->setVal('error', 'id');

			$this->wf->profileOut( __METHOD__ );
			return;
		}

		if ($token != $this->getToken()) {
			$this->setVal('error', 'token');

			$this->wf->profileOut( __METHOD__ );
			return;
		}

		// delete a block
		$phalanx = Phalanx::newFromId($id);

		$id = $phalanx->delete();
		if ( $id ) {
			$result = array( "success" => array( $id ), "failed" => 0 );
			$this->refresh( $result["success"] );
		} else {
			$result = false;
		}

		$this->setVal('success', $result !== false);
		$this->wf->profileOut( __METHOD__ );
	}

	/**
	 * Method called via AJAX from Special:Phalanx to validate regexp
	 */
	public function validate() {
		$this->wf->profileIn( __METHOD__ );

		$this->response->setFormat('json');
		$this->setVal( 'valid', false);

		$regexp = $this->request->getVal( 'regexp' );
		$token = $this->request->getVal( 'token' );

		if ( !$this->userCanExecute( $this->wg->User ) ) {
			$this->setVal('error', 'permission');

			$this->wf->profileOut( __METHOD__ );
			return;
		}

		if ( $token == $this->getToken() ) {
			$this->setVal( 'valid', $this->service->validate( $regexp ) );
		}

		$this->wf->profileOut( __METHOD__ );
	}

	public function matchBlock() {
		$result = array();
		$token = $this->request->getVal( 'token' );
		$block = $this->request->getVal( 'block' );

		if ( $token == $this->getToken() ) {
			foreach ( Phalanx::getAllTypeNames() as $type => $typeName ) {
				$blocks = $this->service->match( $type, $block );
				if ( !empty( $blocks ) ) {
					$result[$type] = $blocks;
				}
			}
		}
		$this->setVal('blocks', $result);
	}

	private function refresh( /*Array*/ $ids )  {
		$this->setVal('valid', $this->service->reload( $ids ));
	}

	private function getToken() {
		return $this->wg->User->getEditToken();
	}
}

<?php

class PhalanxSpecialController extends WikiaSpecialPageController {
	const RESULT_BLOCK_ADDED = 1;
	const RESULT_BLOCK_UPDATED = 2;
	const RESULT_ERROR = 3;

	private $title;

	public function __construct() {
		parent::__construct( 'Phalanx', 'phalanx' /* restrictions */ );
		$this->includable( false );

		$this->title = SpecialPage::getTitleFor( 'Phalanx' );
	}

	/**
	 * Special page main entry point
	 */
	public function index() {
		wfProfileIn( __METHOD__ );

		$this->wg->Out->setPageTitle( wfMsg( 'phalanx-title' ) );
		if ( !$this->userCanExecute( $this->wg->User ) ) {
			wfProfileOut( __METHOD__ );
			$this->displayRestrictionError();
			return;
		}

		// select the current tab
		switch( $this->getPar() ) {
			case 'test':
				$currentTab = 'test';
				break;

			default:
				$currentTab = 'main';
		}

		// load resource loader module
		$this->wg->Out->addModules( 'ext.wikia.Phalanx' );
		$this->wg->Out->addJsConfigVars( 'wgPhalanxToken', $this->getToken() );

		$this->forward( 'PhalanxSpecial', $currentTab );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Renders first tab - blocks creation / edit
	 */
	public function main() {
		wfProfileIn( __METHOD__ );

		if ( !$this->userCanExecute( $this->wg->User ) ) {
			wfProfileOut( __METHOD__ );
			$this->displayRestrictionError();
			return false;
		}

		// creating / editing a block
		if ( $this->wg->Request->wasPosted() ) {
			$res = $this->handleBlockPost();

			// add a message that will be shown after the redirect
			if ( $res === self::RESULT_ERROR ) {
				BannerNotificationsController::addConfirmation(
					wfMsg( 'phalanx-block-failure' ),
					BannerNotificationsController::CONFIRMATION_ERROR
				);
			}
			else {
				BannerNotificationsController::addConfirmation(
					wfMsg( $res === self::RESULT_BLOCK_ADDED ?  'phalanx-block-success' :  'phalanx-modify-success' ),
					BannerNotificationsController::CONFIRMATION_CONFIRM
				);
			}

			$this->wg->Out->redirect( $this->title->getFullURL() );

			wfProfileOut( __METHOD__ );

			// SUS-1078: Don't render template when handling a POST request (block save) to prevent warnings
			// We will be redirected back to Special:Phalanx anyways
			$this->skipRendering();
			return false;
		}

		// set pager
		$pager = new PhalanxPager();
		$pager->setContext( $this->getContext() );
		$listing  = $pager->getNavigationBar();
		$listing .= $pager->getBody();
		$listing .= $pager->getNavigationBar();

		$data = $this->blockDataForForm();
		$editMode = !empty( $data['id'] );

		$expiries = Phalanx::getExpireValues();
		if ( $editMode ) {
			$expiries = array_merge( array( '' => wfMsg( 'phalanx-expiries-select' ) ), $expiries );
		}

		// SOAP should not be allowed to block emails in Phalanx
		$showEmailBlock = $this->wg->User->isAllowed( 'phalanxemailblock' );
		$blockTypes  = Phalanx::getSupportedTypeNames();

		$typeSections = [
			'page-edition' => [
				Phalanx::TYPE_CONTENT,
				Phalanx::TYPE_SUMMARY,
				Phalanx::TYPE_TITLE,
				Phalanx::TYPE_USER,
				Phalanx::TYPE_DEVICE,
			],
			'account-creation' => [
				Phalanx::TYPE_EMAIL,
			],
			'wiki-creation' => [
				Phalanx::TYPE_WIKI_CREATION,
			],
		];

		if ( !$showEmailBlock ) {
			unset( $typeSections['account-creation'] );
		}

		$this->setVal( 'expiries', $expiries );
		$this->setVal( 'languages', $this->wg->PhalanxSupportedLanguages );
		$this->setVal( 'listing', $listing );
		$this->setVal( 'data',  $data );
		$this->setVal( 'editMode',  $editMode );
		$this->setVal( 'action', $this->title->getLocalURL() );
		$this->setVal( 'typeFilter', $pager->getSearchFilter() );
		$this->setVal( 'blockTypes', $blockTypes );
		$this->setVal( 'type', $this->wg->Request->getInt( 'type' ) );
		$this->setVal( 'typeSections', $typeSections );

		// SUS-270: preload username into filter search box
		$this->setVal( 'checkBlocker', $data['checkBlocker'] !== '' ? $data['checkBlocker'] : $data['text'] );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Renders second tab - blocks testing
	 */
	public function test() {
		if ( !$this->userCanExecute( $this->wg->User ) ) {
			$this->displayRestrictionError();
			return;
		}

		$title = SpecialPage::getTitleFor( 'Phalanx', 'test' );
		$this->setVal( 'action', $title->getLocalURL() );

		$blockText = $this->wg->Request->getText( 'wpBlockText' );
		$this->setVal( 'blockText', $blockText );

		// check the text against all blocks
		if ( $blockText !== '' ) {
			$this->setVal( 'listing', $this->handleBlockTest( $blockText ) );
		}
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
			$data = Phalanx::newFromId( $id );

			if ( ( $data['type'] & Phalanx::TYPE_EMAIL ) && !$this->app->wg->User->isAllowed( 'phalanxemailblock' ) ) {
				// SOAP members should not be able to view email blocks
				$data = [];
			}
			else {
				$data['type'] = Phalanx::getTypeNames( $data['type'] );
				$data['checkId'] = $id;
				$data['checkBlocker'] = '';

				return $data;
			}
		}

		// block creation
		$pager = new PhalanxPager();

		$data['checkBlocker'] = $this->wg->Request->getText( 'wpPhalanxCheckBlocker' , '' );
		$data['checkId'] = $this->wg->Request->getIntOrNull( 'id' );
		$data['type'] = $pager->getSearchFilter();
		$data['text'] = $this->wg->Request->getText( 'target' , '' ); // prefill the filter content using target URL parameter
		$data['lang'] = '';
		$data['expire'] = '';
		$data['reason'] = '';
		$data['comment'] = '';

		return $data;
	}

	/**
	 * Handle POST request to edit / create a block
	 *
	 * @return int
	 */
	private function handleBlockPost() {
		$request = $this->getContext()->getRequest();

		$expire = $request->getText( 'wpPhalanxExpire' );
		if ( $expire === 'custom' ) {
			$expire = $request->getText( 'wpPhalanxExpireCustom' );
		}

		$id = $request->getInt( 'id', 0 );
		$isBlockUpdate = ( $id !== 0 );
		$data = [
			'id'         => $id,
			'text'       => $request->getText( 'wpPhalanxFilter' ),
			'exact'      => $request->getCheck( 'wpPhalanxFormatExact' ) ? 1 : 0,
			'case'       => $request->getCheck( 'wpPhalanxFormatCase' ) ? 1 : 0,
			'regex'      => $request->getCheck( 'wpPhalanxFormatRegex' ) ? 1 : 0,
			'timestamp'  => wfTimestampNow(),
			'author_id'  => $this->getUser()->getId(),
			'reason'     => $request->getText( 'wpPhalanxReason' ),
			'comment'    => $request->getText( 'wpPhalanxComment' ),
			'lang'       => $request->getVal( 'wpPhalanxLanguages', null ),
			'type'       => (array) $request->getArray( 'wpPhalanxType' ),
			'multitext'  => $request->getText( 'wpPhalanxFilterBulk' ),
			'expire'     => $expire
		];

		// SUS-1207: call handler directly, don't use hook dispatcher for single handler
		if ( !PhalanxHooks::onEditPhalanxBlock( $data ) ) {
			return self::RESULT_ERROR;
		}

		return $isBlockUpdate ? self::RESULT_BLOCK_UPDATED : self::RESULT_BLOCK_ADDED;
	}

	/**
	 * Get HTML with the list of block that apply for given text
	 *
	 * @param $blockText string text to be test against all blocks
	 * @return string HTML
	 */
	private function handleBlockTest( $blockText ) {
		wfProfileIn( __METHOD__ );

		$phalanxService = PhalanxServiceFactory::getServiceInstance();
		$phalanxMatchParams = PhalanxMatchParams::withGlobalDefaults()->content( $blockText );

		$listing = '';
		$noMatches = true;

		foreach ( Phalanx::getSupportedTypeNames() as $blockType ) {
			try {
				$phalanxMatchParams->type( $blockType );
				$res = $phalanxService->doMatch( $phalanxMatchParams );

				if ( empty( $res ) ) {
					continue;
				}

				$noMatches = false;

				$pager = new PhalanxBlockTestPager( $blockType );
				$pager->setContext( $this->getContext() );
				$pager->setRows( $res );
				$listing .= $pager->getHeader();
				$listing .= $pager->getBody();
			} catch ( PhalanxServiceException $phalanxServiceException ) {
				\Wikia\Logger\WikiaLogger::instance()->error( 'Phalanx service failed' );
			}
		}

		if ( $noMatches ) {
			$pager = new PhalanxBlockTestPager( 0 );
			$listing .= $pager->getEmptyBody();
		}

		wfProfileOut( __METHOD__ );
		return $listing;
	}

	/**
	 * Method called via AJAX from Special:Phalanx to remove blocks
	 */
	public function unblock() {
		wfProfileIn( __METHOD__ );

		if ( !$this->userCanExecute( $this->wg->User ) ) {
			wfProfileOut( __METHOD__ );
			$this->displayRestrictionError();
			return;
		}

		$this->response->setFormat( 'json' );
		$this->setVal( 'success', false );

		if ( !$this->userCanExecute( $this->wg->User ) ) {
			$this->setVal( 'error', 'permission' );

			wfProfileOut( __METHOD__ );
			return;
		}

		$id = $this->request->getInt( 'blockId' );
		$token = $this->request->getVal( 'token' );

		// validate input
		if ( !$id ) {
			$this->setVal( 'error', 'id' );

			wfProfileOut( __METHOD__ );
			return;
		}

		if ( $token != $this->getToken() ) {
			$this->setVal( 'error', 'token' );

			wfProfileOut( __METHOD__ );
			return;
		}

		// delete a block
		// SUS-1207: call handler directly, don't use hook dispatcher for single handler
		if ( !PhalanxHooks::onDeletePhalanxBlock( $id ) ) {
			$result = false;
		} else {
			$result = true;
		}

		$this->setVal( 'success', $result !== false );
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Method called via AJAX from Special:Phalanx to validate regexp
	 */
	public function validate() {
		wfProfileIn( __METHOD__ );

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->setVal( 'valid', false );

		$regexp = $this->request->getVal( 'regexp' );
		$token = $this->request->getVal( 'token' );

		if ( !$this->userCanExecute( $this->wg->User ) ) {
			$this->setVal( 'error', 'permission' );

			wfProfileOut( __METHOD__ );

			return;
		}

		if ( $token == $this->getToken() ) {
			try {
				$phalanxService = PhalanxServiceFactory::getServiceInstance();
				$this->setVal( 'valid', $phalanxService->doRegexValidation( $regexp ) );
			}
			catch ( Exception $exception ) {
				\Wikia\Logger\WikiaLogger::instance()
					->error( 'Phalanx service failed', [ $exception ] );
			}
		}

		wfProfileOut( __METHOD__ );
	}

	private function getToken() {
		return $this->wg->User->getEditToken();
	}
}

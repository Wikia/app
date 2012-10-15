<?php

/**
 * @addtogroup API
 */
class ApiWOMSetObjectModel extends ApiBase {

	public function __construct( $main, $action ) {
		parent :: __construct( $main, $action );
	}

	public function execute() {
		global $wgUser;
		$params = $this->extractRequestParams();

		if ( is_null( $params['title'] ) )
			$this->dieUsageMsg( array( 'missingparam', 'title' ) );
		if ( is_null( $params['xpath'] ) )
			$this->dieUsage( array( 'missingparam', 'xpath' ) );

		$titleObj = Title::newFromText( $params['title'] );
		if ( !$titleObj || $titleObj->isExternal() )
			$this->dieUsageMsg( array( 'invalidtitle', $params['title'] ) );

		// Some functions depend on $wgTitle == $ep->mTitle
		global $wgTitle;
		$wgTitle = $titleObj;

		if ( $params['nocreate'] && !$titleObj->exists() )
			$this->dieUsageMsg( array( 'nocreate-missing' ) );

		// Now let's check whether we're even allowed to do this
		$errors = $titleObj->getUserPermissionsErrors( 'edit', $wgUser );
		if ( !$titleObj->exists() )
			$errors = array_merge( $errors, $titleObj->getUserPermissionsErrors( 'create', $wgUser ) );
		if ( count( $errors ) )
			$this->dieUsageMsg( $errors[0] );

		$articleObj = new Article( $titleObj );

		if ( !is_null( $params['rid'] ) ) {
			$revObj = Revision::newFromID( $params['rid'] );
			if ( is_null( $revObj ) || $revObj->isDeleted( Revision::DELETED_TEXT ) )
				$this->dieUsageMsg( array( 'nosuchrevid', $params['rid'] ) );
			if ( $revObj->getPage() != $articleObj->getID() )
				$this->dieUsageMsg( array( 'revwrongpage', $revObj->getID(), $titleObj->getPrefixedText() ) );
			if ( !$params['force_update'] && !$revObj->isCurrent() )
				$this->dieUsage( "Page revision id is not current '{$titleObj->getPrefixedText()} ({$params['rid']})'", 'revnotcurrent' );
		} else {
			$params['rid'] = 0;
		}

		$verb = $params['verb'];
		$xpath = $params['xpath'];

		try {
			$wom = WOMProcessor::getPageObject( $titleObj, $params['rid'] );
			$obj_ids = WOMProcessor::getObjIdByXPath2( $wom, $xpath );
			$obj_id = null;
			foreach ( $obj_ids as $id ) {
				if ( $id != '' ) {
					$obj_id = $id;
					break;
				}
			}
			if ( $obj_id == null ) {
				throw new MWException( __METHOD__ . ": object does not found, xpath: {$xpath}" );
			}

			if ( $verb == 'remove' ) {
				$wom->removePageObject( $obj_id );
			} elseif ( $verb == 'removeall' ) {
				foreach ( $obj_ids as $id ) {
					if ( $id == '' ) continue;
					$wom->removePageObject( $id );
				}
			} else {
				if ( is_null( $params['text'] ) )
					$this->dieUsageMsg( array( 'missingparam', 'text' ) );
				$toMD5 = $params['text'];
				// See if the MD5 hash checks out
				if ( !is_null( $params['md5'] ) && md5( $toMD5 ) !== $params['md5'] )
					$this->dieUsageMsg( array( 'hashcheckfailed' ) );

				$text = $params['text'];
				if ( $verb == 'insert' ) {
					$text = WOMProcessor::getValidText( $text, $wom->getObject( $obj_id )->getParent(), $wom );
					// no need to parse or merge object model but use text
					$wom->insertPageObject( new WOMTextModel( $text ), $obj_id );
				} elseif ( $verb == 'update' ) {
					$text = WOMProcessor::getValidText( $text, $wom->getObject( $obj_id )->getParent(), $wom );
					$wom->updatePageObject( new WOMTextModel( $text ), $obj_id );
				} elseif ( $verb == 'append' ) {
					$parent = $wom->getObject( $obj_id );
					if ( !( $parent instanceof WikiObjectModelCollection ) ) {
						throw new MWException( __METHOD__ . ": Object is not a collection object '{$title} ({$revision_id}) - {$obj_id}'" );
					}
					$text = WOMProcessor::getValidText( $text, $parent, $wom );
					$wom->appendChildObject( new WOMTextModel( $text ), $obj_id );
				} elseif ( $verb == 'attribute' ) {
					$obj = $wom->getObject( $obj_id );
					$kv = explode( '=', $text, 2 );
					if ( count( $kv ) != 2 ) {
						throw new MWException( __METHOD__ . ": value should be 'key=value' in attribute mode" );
					}
					$obj->setXMLAttribute( trim( $kv[0] ), trim( $kv[1] ) );
				}
			}

			$ep = new EditPage( $articleObj );
			// EditPage wants to parse its stuff from a WebRequest
			// That interface kind of sucks, but it's workable
			$reqArr = array( 'wpTextbox1' => $wom->getWikiText(),
					'wpEditToken' => $params['token'],
					'wpIgnoreBlankSummary' => '',
					'wpSection' => ''
			);

			if ( !is_null( $params['summary'] ) )
				$reqArr['wpSummary'] = $params['summary'];

			// Watch out for basetimestamp == ''
			// wfTimestamp() treats it as NOW, almost certainly causing an edit conflict
			if ( !is_null( $params['basetimestamp'] ) && $params['basetimestamp'] != '' )
				$reqArr['wpEdittime'] = wfTimestamp( TS_MW, $params['basetimestamp'] );
			else
				$reqArr['wpEdittime'] = $articleObj->getTimestamp();

			if ( !is_null( $params['starttimestamp'] ) && $params['starttimestamp'] != '' )
				$reqArr['wpStarttime'] = wfTimestamp( TS_MW, $params['starttimestamp'] );
			else
				$reqArr['wpStarttime'] = $reqArr['wpEdittime'];	// Fake wpStartime

			if ( $params['minor'] || ( !$params['notminor'] && $wgUser->getOption( 'minordefault' ) ) )
				$reqArr['wpMinoredit'] = '';

			// Handle watchlist settings
			switch ( $params['watchlist'] )
			{
				case 'watch':
					$watch = true;
					break;
				case 'unwatch':
					$watch = false;
					break;
				case 'preferences':
					if ( $titleObj->exists() )
						$watch = $wgUser->getOption( 'watchdefault' ) || $titleObj->userIsWatching();
					else
						$watch = $wgUser->getOption( 'watchcreations' );
					break;
				case 'nochange':
				default:
					$watch = $titleObj->userIsWatching();
			}
			// Deprecated parameters
			if ( $params['watch'] )
				$watch = true;
			elseif ( $params['unwatch'] )
				$watch = false;

			if ( $watch )
				$reqArr['wpWatchthis'] = '';

			$req = new FauxRequest( $reqArr, true );
			$ep->importFormData( $req );

			// Run hooks
			// Handle CAPTCHA parameters
			global $wgRequest;
			if ( !is_null( $params['captchaid'] ) )
				$wgRequest->setVal( 'wpCaptchaId', $params['captchaid'] );
			if ( !is_null( $params['captchaword'] ) )
				$wgRequest->setVal( 'wpCaptchaWord', $params['captchaword'] );

			$r = array();
			if ( !wfRunHooks( 'APIEditBeforeSave', array( $ep, $ep->textbox1, &$r ) ) )
			{
				if ( count( $r ) )
				{
					$r['result'] = "Failure";
					$this->getResult()->addValue( null, $this->getModuleName(), $r );
					return;
				}
				else
					$this->dieUsageMsg( array( 'hookaborted' ) );
			}


			// Do the actual save
			$oldRevId = $articleObj->getRevIdFetched();
			$result = null;
			// Fake $wgRequest for some hooks inside EditPage
			// FIXME: This interface SUCKS
			$oldRequest = $wgRequest;
			$wgRequest = $req;

			$retval = $ep->internalAttemptSave( $result, $wgUser->isAllowed( 'bot' ) && $params['bot'] );
			$wgRequest = $oldRequest;
			switch( $retval )
			{
				case EditPage::AS_HOOK_ERROR:
				case EditPage::AS_HOOK_ERROR_EXPECTED:
					$this->dieUsageMsg( array( 'hookaborted' ) );

				case EditPage::AS_IMAGE_REDIRECT_ANON:
					$this->dieUsageMsg( array( 'noimageredirect-anon' ) );

				case EditPage::AS_IMAGE_REDIRECT_LOGGED:
					$this->dieUsageMsg( array( 'noimageredirect-logged' ) );

				case EditPage::AS_SPAM_ERROR:
					$this->dieUsageMsg( array( 'spamdetected', $result['spam'] ) );

				case EditPage::AS_FILTERING:
					$this->dieUsageMsg( array( 'filtered' ) );

				case EditPage::AS_BLOCKED_PAGE_FOR_USER:
					$this->dieUsageMsg( array( 'blockedtext' ) );

				case EditPage::AS_MAX_ARTICLE_SIZE_EXCEEDED:
				case EditPage::AS_CONTENT_TOO_BIG:
					global $wgMaxArticleSize;
					$this->dieUsageMsg( array( 'contenttoobig', $wgMaxArticleSize ) );

				case EditPage::AS_READ_ONLY_PAGE_ANON:
					$this->dieUsageMsg( array( 'noedit-anon' ) );

				case EditPage::AS_READ_ONLY_PAGE_LOGGED:
					$this->dieUsageMsg( array( 'noedit' ) );

				case EditPage::AS_READ_ONLY_PAGE:
					$this->dieReadOnly();

				case EditPage::AS_RATE_LIMITED:
					$this->dieUsageMsg( array( 'actionthrottledtext' ) );

				case EditPage::AS_ARTICLE_WAS_DELETED:
					$this->dieUsageMsg( array( 'wasdeleted' ) );

				case EditPage::AS_NO_CREATE_PERMISSION:
					$this->dieUsageMsg( array( 'nocreate-loggedin' ) );

				case EditPage::AS_BLANK_ARTICLE:
					$this->dieUsageMsg( array( 'blankpage' ) );

				case EditPage::AS_CONFLICT_DETECTED:
					$this->dieUsageMsg( array( 'editconflict' ) );

				// case EditPage::AS_SUMMARY_NEEDED: Can't happen since we set wpIgnoreBlankSummary
				case EditPage::AS_TEXTBOX_EMPTY:
					$this->dieUsageMsg( array( 'emptynewsection' ) );

				case EditPage::AS_SUCCESS_NEW_ARTICLE:
					$r['new'] = '';
				case EditPage::AS_SUCCESS_UPDATE:
					$r['result'] = "Success";
					$r['pageid'] = intval( $titleObj->getArticleID() );
					$r['title'] = $titleObj->getPrefixedText();
					// HACK: We create a new Article object here because getRevIdFetched()
					// refuses to be run twice, and because Title::getLatestRevId()
					// won't fetch from the master unless we select for update, which we
					// don't want to do.
					$newArticle = new Article( $titleObj );
					$newRevId = $newArticle->getRevIdFetched();
					if ( $newRevId == $oldRevId )
						$r['nochange'] = '';
					else
					{
						$r['oldrevid'] = intval( $oldRevId );
						$r['newrevid'] = intval( $newRevId );
						$r['newtimestamp'] = wfTimestamp( TS_ISO_8601,
							$newArticle->getTimestamp() );
					}
					break;

				case EditPage::AS_END:
					// This usually means some kind of race condition
					// or DB weirdness occurred. Fall through to throw an unknown
					// error.

					// This needs fixing higher up, as Article::doEdit should be
					// used rather than Article::updateArticle, so that specific
					// error conditions can be returned
				default:
					$this->dieUsageMsg( array( 'unknownerror', $retval ) );
			}

			$this->getResult()->addValue( null, $this->getModuleName(), $r );
		} catch ( Exception $e ) {
			$this->dieUsage( $e->getMessage(), 'WOM error' );
		}
	}

	public function mustBePosted() {
		return true;
	}

	public function isWriteMode() {
		return true;
	}

	public function getPossibleErrors() {
		global $wgMaxArticleSize;

		return array_merge( parent::getPossibleErrors(), array(
			array( 'missingparam', 'title' ),
			array( 'missingparam', 'xpath' ),
			array( 'missingparam', 'text' ),
			array( 'invalidtitle', 'title' ),
			array( 'nocreate-missing' ),
			array( 'nosuchrevid', 'rid' ),
			array( 'revwrongpage', 'id', 'text' ),
			array( 'hashcheckfailed' ),
			array( 'hookaborted' ),
			array( 'noimageredirect-anon' ),
			array( 'noimageredirect-logged' ),
			array( 'spamdetected', 'spam' ),
			array( 'filtered' ),
			array( 'blockedtext' ),
			array( 'contenttoobig', $wgMaxArticleSize ),
			array( 'noedit-anon' ),
			array( 'noedit' ),
			array( 'actionthrottledtext' ),
			array( 'wasdeleted' ),
			array( 'nocreate-loggedin' ),
			array( 'blankpage' ),
			array( 'editconflict' ),
			array( 'unknownerror', 'retval' ),
		) );
	}

	protected function getAllowedParams() {
		return array (
			'title' => null,
			'verb' => array(
				ApiBase :: PARAM_DFLT => 'update',
				ApiBase :: PARAM_TYPE => array(
					'update',
					'attribute',
					'insert',
					'append',
					'remove',
					'removeall',
				),
			),
			'xpath' => null,
			'text' => null,
			'summary' => null,
			'rid' => array (
            	ApiBase :: PARAM_TYPE => 'integer',
                ApiBase :: PARAM_MIN => 1
            ),
			'force_update' => false,
			'token' => null,
			'minor' => false,
			'notminor' => false,
			'bot' => false,
			'basetimestamp' => null,
			'starttimestamp' => null,
			'nocreate' => false,
			'captchaword' => null,
			'captchaid' => null,
			'watch' => array(
				ApiBase :: PARAM_DFLT => false,
				ApiBase :: PARAM_DEPRECATED => true,
			),
			'unwatch' => array(
				ApiBase :: PARAM_DFLT => false,
				ApiBase :: PARAM_DEPRECATED => true,
			),
			'watchlist' => array(
				ApiBase :: PARAM_DFLT => 'preferences',
				ApiBase :: PARAM_TYPE => array(
					'watch',
					'unwatch',
					'preferences',
					'nochange'
				),
			),
			'md5' => null,
		);
	}

	protected function getParamDescription() {
		return array (
			'title' => 'Title of the page to modify',
			'verb' => 'Action verb to set to change wiki object instances',
			'xpath' => array(
				'DOM-like xpath to locate WOM object instances (http://www.w3schools.com/xpath/xpath_syntax.asp)',
				'verb = update, xpath to elements to be updated',
				'verb = attribute, xpath to elements, the attribute will be updated',
				'verb = insert, the element will be inserted right before the element specified by xpath',
				'verb = append, the element will be appended right to the element children elements specified by xpath',
				'verb = remove, xpath to element to be removed',
				'verb = removeall, xpath to elements to be removed',
			),
			'text' => array(
				'Value to set',
				'verb = attribute, attribute_name=attribute_value',
			),
			'summary' => 'Edit summary',
			'rid' => 'Revision id of specified page - by dafault latest updated revision (0) is used',
			'force_update' => array(
				'Force to update even if the revision id does not match the latest edition',
				'force_update = false, return "revision not match" exception if rid is not the latest one',
				'force_update = true, update anyway',
			),
			'token' => 'Edit token. You can get one of these through prop=info',
			'minor' => 'Minor edit',
			'notminor' => 'Non-minor edit',
			'bot' => 'Mark this edit as bot',
			'basetimestamp' => array( 'Timestamp of the base revision (gotten through prop=revisions&rvprop=timestamp).',
						'Used to detect edit conflicts; leave unset to ignore conflicts.'
			),
			'starttimestamp' => array( 'Timestamp when you obtained the edit token.',
						'Used to detect edit conflicts; leave unset to ignore conflicts.'
			),
			'nocreate' => 'Throw an error if the page doesn\'t exist',
			'watch' => 'Add the page to your watchlist',
			'unwatch' => 'Remove the page from your watchlist',
			'watchlist' => 'Unconditionally add or remove the page from your watchlist, use preferences or do not change watch',
			'captchaid' => 'CAPTCHA ID from previous request',
			'captchaword' => 'Answer to the CAPTCHA',
			'md5' => array(	'The MD5 hash of the text parameter, or the prependtext and appendtext parameters concatenated.',
				 	'If set, the edit won\'t be done unless the hash is correct' ),
		);
	}

	protected function getDescription() {
		return 'Call to set object values to MW page, by Wiki Object Model';
	}

	public function getTokenSalt() {
		return '';
	}

	public function getExamples() {
		return array (
			'api.php?action=womset&title=Somepage&xpath=//template[@name=SomeTempate]/template_field[@key=templateparam]&text=It+works!&token=%2B\\'
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}
}

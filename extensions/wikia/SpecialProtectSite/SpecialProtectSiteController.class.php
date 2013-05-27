<?php

/* Class that handles the actual Special:Protectsite page */

class SpecialProtectSiteController extends WikiaSpecialPageController {

	var $action, $persist_data, $isMagicUser;
	protected static $dbKey = wfMemcKey( 'protectsite2' );

	public function __construct() {
		parent::__construct( "Protectsite", "protectsite", true );
	}

	public function index() {
		wfProfileIn( __METHOD__ );

		$out = $this->getContext()->getOutput();
		$user = $this->getContext()->getUser();
		$request = $this->getContext()->getRequest();

		# Show a message if the database is in read-only mode
		if ( wfReadOnly() ) {
			$out->readOnlyPage();
			wfProfileOut( __METHOD__ );
			return;
		}

		if ( !$this->userCanExecute( $user ) ) {
			$this->displayRestrictionError();
			wfProfileOut( __METHOD__ );
			return;
		}

		# If user is blocked, s/he doesn't need to access this page
		if ( $user->isBlocked() ) {
			wfProfileOut( __METHOD__ );
			throw new UserBlockedError( $user->mBlock );
		}

		$titleObj = Title::makeTitle( NS_SPECIAL, 'Protectsite' );
		$this->action = htmlspecialchars( $titleObj->getLocalURL() );

		$out->setPageTitle( wfMessage( 'protectsite' )->text() );

		$this->persist_data = new MediaWikiBagOStuff(array());

		/* Get data into the value variable/array */
		$prot = $this->wg->memc->get( $this->dbKey );
		if( !$prot ) {
			# ?
		}

		// are there any groups that should not get affected by Protectsite's lockdown?
		if( !empty( $this->wg->ProtectsiteExempt ) && is_array( $this->wg->ProtectsiteExempt ) ) {
			//there are some, so check if we are any of them
			if( array_intersect( $user->getEffectiveGroups(), $this->wg->ProtectsiteExempt ) ) {
				$this->isMagicUser = true;
			}
		}

		/* If this was a GET request */
		if ( !$request->wasPosted() )
		{
			/* If $value is an array, protection is set, allow unsetting */
			if ( is_array( $prot ) ) {
				$this->forward( 'SpecialProtectSite', 'unProtectsiteForm' );
			} else {
				/* If $value is not an array, protection is not set */
				$this->forward( 'SpecialProtectSite', 'setProtectsiteForm' );
			}
		} else {
			// If this was a POST request, process the data sent.
			if ( $request->getVal( 'protect' ) ) {
				$this->setProtectsite();
			} else {
				$this->unProtectsite();
			}
		}

		wfProfileOut( __METHOD__ );
	}

	private function setProtectsite() {
		wfProfileIn( __METHOD__ );

		$out = $this->getContext()->getOutput();
		$user = $this->getContext()->getUser();

		/* Get the request data */
		$request = $this->getContext()->getRequest()->getValues();

		/* Check to see if the time limit exceeds the limit. */
		$curr_time = time();
		if ( ( ( $until = strtotime( '+' . $request['timeout'], $curr_time ) ) === false ) ||
			 ( $until < $curr_time ) ) {
			$out->addWikiMsg( 'protectsite-timeout-error' );
			$this->forward( 'SpecialProtectSite', 'setProtectsiteForm' );
		} else {
			/* Set the array values */
			$prot['createaccount'] = $request['createaccount'];
			$prot['createpage'] = $request['createpage'];
			$prot['edit'] = $request['edit'];
			$prot['move'] = $request['move'];
			$prot['upload'] = $request['upload'];
			$prot['comment'] = isset( $request['comment'] ) ? $request['comment'] : '';

			if( isset( $this->wg->ProtectsiteLimit ) && !$this->isMagicUser ) {
				if( $until > strtotime('+' . $this->wg->ProtectsiteLimit, $curr_time) ) {
					$request['timeout'] = $this->wg->ProtectsiteLimit;
				}
			}

			/* Set the limits */
			$prot['until'] = strtotime('+' . $request['timeout'], $curr_time);
			$prot['timeout'] = $request['timeout'];

			/* Write the setting out to the "database" */
			$this->wg->memc->set( $this->dbKey, $prot, $prot['until'] );

			$doLog = true;
			if ( !empty($request['nolog']) && $this->isMagicUser ) {
				$doLog = false;
			}

			/* Create a log entry
			As of March 2013, always show log
			Suppress option now only suppresses time value */
				$log = new LogPage( 'protect' );
				$log->addEntry( 'protect', Title::makeTitle(NS_SPECIAL, 'Allpages'),
					$doLog ? $prot['timeout'] : wfMessage( 'protectsite-log-suppressed' )->text() .
					( strlen($prot['comment']) > 0 ? '; ' . $prot['comment'] : '' ) );

				/* Call the Unprotect Form function to display the current state. */
			$this->overrideTemplate( 'unProtectsiteForm' );
			$this->unProtectsiteForm( $prot );
		}
		wfProfileOut( __METHOD__ );
	}

	private function unProtectsite() {
		wfProfileIn( __METHOD__ );

		/* Get the request data */
		$request = $this->getContext()->getRequest()->getValues();

		/* Remove the data from the database to disable extension. */
		$this->wg->memc->delete( $this->dbKey );

		$doLog = true;
		if ( $this->isMagicUser && !empty($request['nolog']) ) {
			$doLog = false;
		}

		/* As of March 2013, remove ability to unsuppress unprotect log */
			$log = new LogPage('protect');
			$log->addEntry( 'unprotect', Title::makeTitle(NS_SPECIAL, 'Allpages'),
				$request['ucomment'] );

		/* Call the Protect Form function to display the current state. */
		$this->forward( 'SpecialProtectSite', 'setProtectsiteForm' );
		wfProfileOut( __METHOD__ );
	}

	private function unProtectsiteForm ( $prot ) {
		wfProfileIn( __METHOD__ );

		$restrictions = array(
			'createaccount' => $prot['createaccount'],
			'createpage' => $prot['createpage'],
			'edit' => $prot['edit'],
			'move' => $prot['move'],
			'upload' => $prot['upload']
		);

		$this->setVal( 'action', $this->action );
		$this->setVal( 'lang', $this->getContext()->getLanguage() );
		$this->setVal( 'restrictions', $restrictions );
		$this->setVal( 'comment', $prot['comment'] );
		$this->setVal( 'until', $prot['until'] );

		wfProfileOut( __METHOD__ );
	}

	private function setProtectsiteForm() {
		wfProfileIn( __METHOD__ );

		$request = $this->getContext()->getRequest()->getValues();
		$createaccount = array(0 => false, 1 => false, 2 => false);
		$createaccount[(isset($request['createaccount']) ? $request['createaccount'] : 0)] = true;
		$createpage = array(0 => false, 1 => false, 2 => false);
		$createpage[(isset($request['createpage']) ? $request['createpage'] : 0)] = true;
		$edit = array(0 => false, 1 => false, 2 => false);
		$edit[(isset($request['edit']) ? $request['edit'] : 0)] = true;
		$move = array(0 => false, 1 => false);
		$move[(isset($request['move']) ? $request['move'] : 0)] = true;
		$upload = array(0 => false, 1 => false);
		$upload[(isset($request['upload']) ? $request['upload'] : 0)] = true;

		$radios = array(
			'createaccount' => $createaccount,
			'createpage' => $createpage,
			'edit' => $edit,
			'move' => $move,
			'upload' => $upload
		);

		$timelimitText = '';
		if( isset( $this->wg->ProtectsiteLimit ) ) {
			$timelimitText = ' (' . wfMessage( 'protectsite-maxtimeout' )->text() . $this->wg->ProtectsiteLimit . ')';
			if( $this->isMagicUser ) {
				$timelimitText = "<del title='you are exempt from the limit'>". $timelimitText .'</del>';
			}
		}

		$noLogCheck = $this->isMagicUser ? true : false;
		$this->setVal( 'noLogCheck', $noLogCheck );
		$this->setVal( 'radios', $radios );
		$this->setVal( 'action', $this->action ); 
		$this->setVal( 'comment', isset( $request['comment'] ) ? $request['comment'] : '' );
		$this->setVal( 'default_timeout', $this->wg->ProtectsiteDefaultTimeout );
		$this->setVal( 'timelimitText', $timelimitText );

		wfProfileOut( __METHOD__ );
	}
}

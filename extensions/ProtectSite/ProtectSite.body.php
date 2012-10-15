<?php
/**
 * Two classes for providing Special:ProtectSite page.
 * @file
 * @ingroup Extensions
 */

class ProtectSite extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'ProtectSite'/*class*/, 'protectsite'/*restriction*/ );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgOut, $wgUser, $wgRequest;

		// If the user doesn't have 'protectsite' permission, display an error
		if ( !$wgUser->isAllowed( 'protectsite' ) ) {
			$this->displayRestrictionError();
			return;
		}

		// Show a message if the database is in read-only mode
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		// If user is blocked, s/he doesn't need to access this page
		if ( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}

		$this->setHeaders();

		$form = new ProtectSiteForm( $wgRequest );
	}

}

/**
 * Class that handles the actual Special:ProtectSite page
 * This is a modified version of the ancient HTMLForm class.
 * @todo FIXME: could probably be rewritten to use the modern HTMLForm :)
 */
class ProtectSiteForm {
	var $mRequest, $action, $persist_data;

	/* Constructor */
	function __construct( &$request ) {
		global $wgMemc;

		if( !class_exists( 'BagOStuff' ) || !class_exists( 'MediaWikiBagOStuff' ) ) {
			global $IP;
			require_once( $IP . '/includes/BagOStuff.php' );
		}
		$titleObj = SpecialPage::getTitleFor( 'ProtectSite' );
		$this->action = $titleObj->escapeLocalURL();
		$this->mRequest =& $request;
		$this->persist_data = new MediaWikiBagOStuff();

		/* Get data into the value variable/array */
		$prot = $wgMemc->get( wfMemcKey( 'protectsite' ) );
		if( !$prot ) {
			$prot = $this->persist_data->get( 'protectsite' );
		}

		/* If this was a GET request */
		if( !$this->mRequest->wasPosted() ) {
			/* If $value is an array, protection is set, allow unsetting */
			if( is_array( $prot ) ) {
				$this->unProtectSiteForm( $prot );
			} else {
				/* If $value is not an array, protection is not set */
				$this->setProtectSiteForm();
			}
		} else {
			/* If this was a POST request, process the data sent */
			if( $this->mRequest->getVal( 'protect' ) ) {
				$this->setProtectSite();
			} else {
				$this->unProtectSite();
			}
		}
	}

	function setProtectSite() {
		global $wgOut, $wgMemc, $wgProtectSiteLimit;

		/* Get the request data */
		$request = $this->mRequest->getValues();

		/* Check to see if the time limit exceeds the limit. */
		$curr_time = time();
		if(
			( ( $until = strtotime( '+' . $request['timeout'], $curr_time ) ) === false ) ||
			( $until < $curr_time )
		) {
			$wgOut->addWikiMsg( 'protectsite-timeout-error' );
			$this->setProtectSiteForm();
		} else {
			/* Set the array values */
			$prot['createaccount'] = $request['createaccount'];
			$prot['createpage'] = $request['createpage'];
			$prot['edit'] = $request['edit'];
			$prot['move'] = $request['move'];
			$prot['upload'] = $request['upload'];
			$prot['comment'] = isset( $request['comment'] ) ? $request['comment'] : '';

			if( isset( $wgProtectSiteLimit ) &&
				( $until > strtotime( '+' . $wgProtectSiteLimit, $curr_time ) )
			) {
				$request['timeout'] = $wgProtectSiteLimit;
			}

			/* Set the limits */
			$prot['until'] = strtotime( '+' . $request['timeout'], $curr_time );
			$prot['timeout'] = $request['timeout'];

			/* Write the array out to the database */
			$this->persist_data->set( 'protectsite', $prot, $prot['until'] );
			$wgMemc->set( wfMemcKey( 'protectsite' ), $prot, $prot['until'] );

			/* Create a log entry */
			$log = new LogPage( 'protect' );
			$log->addEntry(
				'protect',
				SpecialPage::getTitleFor( 'Allpages' ),
				$prot['timeout'] .
				( strlen( $prot['comment'] ) > 0 ? '; ' . $prot['comment'] : '' )
			);

			/* Call the Unprotect Form function to display the current state. */
			$this->unProtectSiteForm( $prot );
		}
	}

	function unProtectSite() {
		global $wgMemc;

		/* Get the request data */
		$request = $this->mRequest->getValues();

		/* Remove the data from the database to disable extension. */
		$this->persist_data->delete( 'protectsite' );
		$wgMemc->delete( wfMemcKey( 'protectsite' ) );

		/* Create a log entry */
		$log = new LogPage( 'protect' );
		$log->addEntry(
			'unprotect',
			SpecialPage::getTitleFor( 'Allpages' ),
			$request['ucomment']
		);

		/* Call the Protect Form function to display the current state. */
		$this->setProtectSiteForm();
	}

	/**
	 * @param $name String: name of the fieldset.
	 * @param $content String: HTML content to put in.
	 * @return string HTML fieldset
	 */
	private function fieldset( $name, $content ) {
		return '<fieldset><legend>' . wfMsg( 'protectsite-' . $name ) .
			"</legend>\n" . $content . "\n</fieldset>\n";
	}

	/**
	 * Override the broken function in the HTMLForm class
	 * This was fixed in r16320 of the MW source; WM bugzilla bug #7188.
	 */
	private function radiobox( $varname, $fields ) {
		$s = '';
		foreach( $fields as $value => $checked ) {
			$s .= "<div><label><input type=\"radio\" name=\"{$varname}\" value=\"{$value}\"" . ( $checked ? ' checked="checked"' : '' ) . ' />'
			. wfMsg( 'protectsite-' . $varname . '-' . $value ) .
			"</label></div>\n";
		}

		return $this->fieldset( $varname, $s );
	}

	/**
	 * Overridden textbox method, allowing for the inclusion of something
	 * after the text box itself.
	 */
	private function textbox( $varname, $value = '', $append = '' ) {
		if( $this->mRequest->wasPosted() ) {
			$value = $this->mRequest->getText( $varname, $value );
		}

		$value = htmlspecialchars( $value );
		return '<div><label>' . wfMsg( 'protectsite-' . $varname ) .
				"<input type=\"text\" name=\"{$varname}\" value=\"{$value}\" /> " .
				$append .
				"</label></div>\n";
	}

	/* This function outputs the field status. */
	private function showField( $name, $state ) {
		return '<b>' . wfMsg( 'protectsite-' . $name ) . ' - <i>' .
					'<span style="color: ' . ( ( $state > 0 ) ? 'red' : 'green' ) . '">' .
					wfMsg( 'protectsite-' . $name . '-' . $state ) . '</span>' .
					"</i></b><br />\n";
	}

	function unProtectsiteForm( $prot ) {
		global $wgOut, $wgLang;

		/* Construct page data and add to output. */
		$wgOut->addWikiMsg( 'protectsite-text-unprotect' );
		$wgOut->addHTML(
			'<form name="unProtectsite" action="' . $this->action . '" method="post">' . "\n" .
				$this->fieldset( 'title',
					$this->showField( 'createaccount', $prot['createaccount'] ) .
					$this->showField( 'createpage', $prot['createpage'] ) .
					$this->showField( 'edit', $prot['edit'] ) .
					$this->showField( 'move', $prot['move'] ) .
					$this->showField( 'upload', $prot['upload'] ) .
					'<b>' . wfMsg( 'protectsite-timeout' ) . ' </b> ' .
					'<i>' . $wgLang->timeAndDate( wfTimestamp( TS_MW, $prot['until'] ), true ) . '</i>' .
					'<br />' .
					( $prot['comment'] != '' ?
					'<b>' . wfMsg( 'protectsite-comment' ) . ' </b> ' .
					'<i>' . $prot['comment'] . '</i>' .
					'<br />' : '' ) .
					"<br />\n" .
					$this->textbox( 'ucomment' ) .
					'<br />' .
					Xml::element( 'input', array(
						'type'	=> 'submit',
						'name'	=> 'unprotect',
						'value' => wfMsg( 'protectsite-unprotect' ) )
					)
				) .
			'</form>'
		);
	}

	function setProtectSiteForm() {
		global $wgOut, $wgProtectSiteDefaultTimeout, $wgProtectSiteLimit;

		$request = $this->mRequest->getValues();
		$createaccount = array( 0 => false, 1 => false, 2 => false );
		$createaccount[(isset( $request['createaccount'] ) ? $request['createaccount'] : 0)] = true;
		$createpage = array( 0 => false, 1 => false, 2 => false );
		$createpage[(isset( $request['createpage'] ) ? $request['createpage'] : 0)] = true;
		$edit = array( 0 => false, 1 => false, 2 => false );
		$edit[(isset( $request['edit'] ) ? $request['edit'] : 0)] = true;
		$move = array( 0 => false, 1 => false );
		$move[(isset( $request['move'] ) ? $request['move'] : 0)] = true;
		$upload = array( 0 => false, 1 => false );
		$upload[(isset( $request['upload'] ) ? $request['upload'] : 0)] = true;

		/* Construct page data and add to output. */
		$wgOut->addWikiMsg( 'protectsite-text-protect' );
		$wgOut->addHTML(
			'<form name="Protectsite" action="' . $this->action . '" method="post">' . "\n" .
				$this->fieldset( 'title',
					$this->radiobox( 'createaccount', $createaccount ) .
					$this->radiobox( 'createpage', $createpage ) .
					$this->radiobox( 'edit', $edit ) .
					$this->radiobox( 'move', $move ) .
					$this->radiobox( 'upload', $upload ) .
					$this->textbox( 'timeout', $wgProtectSiteDefaultTimeout,
					( isset( $wgProtectSiteLimit ) ?
						' (' . wfMsg( 'protectsite-maxtimeout', $wgProtectSiteLimit ) . ')' :
						''
					)) .
					"\n<br />" .
					$this->textbox( 'comment', isset( $request['comment'] ) ? $request['comment'] : '' ) .
					"\n<br />" .
					Xml::element( 'input', array(
						'type'	=> 'submit',
						'name'	=> 'protect',
						'value' => wfMsg( 'protectsite-protect' ) )
					)
				) .
			'</form>'
		);
	}
}
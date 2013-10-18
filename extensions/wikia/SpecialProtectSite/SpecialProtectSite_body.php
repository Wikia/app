<?php

/* Class that handles the actual Special:Protectsite page */

class ProtectsiteForm extends SpecialPage
{
	var $mName, $mRequest, $action, $persist_data, $isMagicUser;

	public function __construct() {
		parent::__construct( "Protectsite", "protectsite", true );
	}

	public function execute( $subpage ) {

		global $wgOut, $wgMemc, $wgUser, $wgRequest;

		# Show a message if the database is in read-only mode
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		if ( !$this->userCanExecute( $wgUser ) ) {
			$this->displayRestrictionError();
			return;
		}

		# If user is blocked, s/he doesn't need to access this page
		if ( $wgUser->isBlocked() ) {
			throw new UserBlockedError( $this->getUser()->mBlock );
		}

		$titleObj = Title::makeTitle( NS_SPECIAL, 'Protectsite' );
		$this->action = htmlspecialchars($titleObj->getLocalURL());
		$this->mRequest =& $wgRequest;
		$this->mName = 'protectsite';

		$wgOut->setPagetitle( wfMsg( $this->mName ) );

		$this->persist_data = new MediaWikiBagOStuff(array());

		/* Get data into the value variable/array */
		$prot = $wgMemc->get( self::key() );
		if( !$prot ) {
			# ?
		}

		global $wgProtectsiteExempt;
		// are there any groups that should not get affected by Protectsite's lockdown?
		if( !empty($wgProtectsiteExempt) && is_array($wgProtectsiteExempt) ) {
			//there are some, so check if we are any of them
			if( array_intersect( $wgUser->getEffectiveGroups(), $wgProtectsiteExempt ) ) {
				$this->isMagicUser = true;
			}
		}

		/* If this was a GET request */
		if (!$this->mRequest->wasPosted())
		{
			/* If $value is an array, protection is set, allow unsetting */
			if (is_array($prot)) {
				$this->unProtectsiteForm($prot);
			}
			else {
				/* If $value is not an array, protection is not set */
				$this->setProtectsiteForm();
			}
		}
		else
		/* If this was a POST request, process the data sent */
		{
			if ($this->mRequest->getVal('protect')) {
				$this->setProtectsite();
			}
			else {
				$this->unProtectsite();
			}
		}
	}

	static public function key() {
		return wfMemcKey( 'protectsite2' );
	}

	function setProtectsite()
	{
		global $wgOut, $wgUser, $wgProtectsiteLimit, $wgMemc;

		/* Get the request data */
		$request = $this->mRequest->getValues();

		/* Check to see if the time limit exceeds the limit. */
		$curr_time = time();
		if ((($until =strtotime('+' . $request['timeout'], $curr_time)) === false) ||
			 ($until < $curr_time))
		{
			$wgOut->addWikiMsg( $this->mName . '-timeout-error' );
			$this->setProtectsiteForm();
		}
		else
		{
			/* Set the array values */
			$prot['createaccount'] = $request['createaccount'];
			$prot['createpage'] = $request['createpage'];
			$prot['edit'] = $request['edit'];
			$prot['move'] = $request['move'];
			$prot['upload'] = $request['upload'];
			$prot['comment'] = isset($request['comment']) ? $request['comment'] : '';

			if( isset($wgProtectsiteLimit) && !$this->isMagicUser ) {
				if( $until > strtotime('+' . $wgProtectsiteLimit, $curr_time) ) {
					$request['timeout'] = $wgProtectsiteLimit;
				}
			}

			/* Set the limits */
			$prot['until'] = strtotime('+' . $request['timeout'], $curr_time);
			$prot['timeout'] = $request['timeout'];

			/* Write the setting out to the "database" */
			$wgMemc->set( self::key(), $prot, $prot['until']);

			$doLog = true;
			if( !empty($request['nolog']) && $this->isMagicUser ) {
				$doLog = false;
			}

			/* Create a log entry
			As of March 2013, always show log
			Suppress option now only suppresses time value */
				$log = new LogPage('protect');
				$log->addEntry('protect', Title::makeTitle(NS_SPECIAL, 'Allpages'),
					$doLog ? $prot['timeout'] : wfMsg('protectsite-log-suppressed') .
					(strlen($prot['comment']) > 0 ? '; ' . $prot['comment'] : ''));

			/* Call the Unprotect Form function to display the current state. */
			$this->unProtectsiteForm($prot);
		}
	}

	function unProtectsite()
	{
		global $wgOut, $wgMemc;

		/* Get the request data */
		$request = $this->mRequest->getValues();

		/* Remove the data from the database to disable extension. */
		$wgMemc->delete( self::key() );

		$doLog = true;
		if( $this->isMagicUser && !empty($request['nolog']) ) {
			$doLog = false;
		}

		/* As of March 2013, remove ability to unsuppress unprotect log */
			$log = new LogPage('protect');
			$log->addEntry('unprotect', Title::makeTitle(NS_SPECIAL, 'Allpages'),
				$request['ucomment']);

		/* Call the Protect Form function to display the current state. */
		$this->setProtectsiteForm();
	}

	function unProtectsiteForm($prot)
	{
		global $wgOut, $wgLang;

		/* Construct page data and add to output. */
		$wgOut->addWikiMsg( 'protectsite-text-unprotect' );

		$wgOut->addHTML(
			'<form name="unProtectsite" action="' . $this->action . '" method="post">' . "\n" .
				$this->fieldset('title',
					$this->showField('createaccount', $prot['createaccount']) .
					$this->showField('createpage', $prot['createpage']) .
					$this->showField('edit', $prot['edit']) .
					$this->showField('move', $prot['move']) .
					$this->showField('upload', $prot['upload']) .
					'<b>' . wfMsg($this->mName . '-timeout') . '</b> ' .
					'<i>' . $wgLang->timeAndDate(wfTimestamp(TS_MW, $prot['until']), true) . '</i>' .
					'<br />' .
					($prot['comment'] != '' ?
					'<b>' . wfMsg($this->mName . '-comment') . '</b> ' .
					'<i>' . $prot['comment'] . '</i>' .
					"<br />" : '') .
					"<br />\n" .
					$this->textbox('ucomment') .
					'<br />' .
					Xml::Element('input', array(
						'type'	=> 'submit',
						'name'	=> 'unprotect',
						'value' => wfMsg($this->mName . '-unprotect'))
					)
				) .
			'</form>'
		);
	}

	function setProtectsiteForm()
	{
		global $wgOut, $wgProtectsiteDefaultTimeout, $wgProtectsiteLimit;

		$request = $this->mRequest->getValues();
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

		/* Construct page data and add to output. */
		$wgOut->addWikiMsg( 'protectsite-text-protect' );

		$timelimitText = '';
		if( isset($wgProtectsiteLimit) ) {
			$timelimitText = ' (' . wfMsg('protectsite-maxtimeout') . $wgProtectsiteLimit . ')';
			if( $this->isMagicUser ) {
				$timelimitText = "<s title='you are exempt from the limit'>". $timelimitText .'</s>';
			}
		}

		$noLogCheck = '';
		if( $this->isMagicUser ) {
			$noLogCheck = "<div><label>" . wfMsg('protectsite-hide-time-length') .
						 "<input type='checkbox' name=\"nolog\" />" .
						 "</label></div>\n";
		}

		$wgOut->addHTML(
			'<form name="Protectsite" action="' . $this->action . '" method="post">' . "\n" .
				$this->fieldset('title',
					$this->radiobox('createaccount', $createaccount) .
					$this->radiobox('createpage', $createpage) .
					$this->radiobox('edit', $edit) .
					$this->radiobox('move', $move) .
					$this->radiobox('upload', $upload) .
					$this->textbox('timeout', $wgProtectsiteDefaultTimeout, $timelimitText) .
					$this->textbox('comment', isset($request['comment']) ? $request['comment'] : '') .
					$noLogCheck .
					"\n<br />" .
					Xml::Element('input', array(
						'type'	=> 'submit',
						'name'	=> 'protect',
						'value' => wfMsg($this->mName . '-protect'))
					)
				) .
			'</form>'
		);
	}


	/* These we left over from when this was extended from HTMLForm class
	 * They will be removed when this extension gets proper templating.
	 */
	private function radiobox($varname, $fields) {
		$s = '';
		foreach ($fields as $value => $checked)
		{
			$s .= "<div><label><input type='radio' name=\"{$varname}\" value=\"{$value}\"" .
				($checked ? ' checked="checked"' : '') . " />" .
				wfMsg($this->mName . '-' . $varname . '-' . $value) .
				"</label></div>\n";
		}

		return $this->fieldset($varname, $s);
	}

	private function textbox($varname, $value='', $append='') {
		if ($this->mRequest->wasPosted())
		{ $value = $this->mRequest->getText( $varname, $value ); }

		$value = htmlspecialchars( $value );
		return "<div><label>". wfMsg( $this->mName.'-'.$varname ) .
					 "<input type='text' name=\"{$varname}\" value=\"{$value}\"" .
					 " /> " . $append . "</label></div>\n";
	}

	/* Used by the "locked" screen. */
	private function showField($name, $state) {
		return '<b>' . wfMsg($this->mName . '-' . $name) . ' - <i>' .
					 '<span style="color: ' . (($state > 0) ? 'red' : 'green') . '">' .
					 wfMsg($this->mName . '-' . $name . '-' . $state) . '</span>' .
					 "</i></b><br />\n";
	}

	private function fieldset( $name, $content ) {
		return "<fieldset><legend>".wfMsg($this->mName.'-'.$name)."</legend>\n" .
			$content . "\n</fieldset>\n";
	}
}

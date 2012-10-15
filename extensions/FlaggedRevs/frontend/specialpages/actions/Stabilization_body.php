<?php

// Assumes $wgFlaggedRevsProtection is off
class Stabilization extends UnlistedSpecialPage {
	protected $form = null;

	public function __construct() {
		parent::__construct( 'Stabilization', 'stablesettings' );
	}

	public function execute( $par ) {
		$out = $this->getOutput();
		$user = $this->getUser();
		$request = $this->getRequest();

		$confirmed = $user->matchEditToken( $request->getVal( 'wpEditToken' ) );

		# Let anyone view, but not submit...
		if ( $request->wasPosted() ) {
			if ( !$user->isAllowed( 'stablesettings' ) ) {
				throw new PermissionsError( 'stablesettings' );
			}
			$block = $user->getBlock( !$confirmed );
			if ( $block ) {
				throw new UserBlockedError( $block );
			} elseif ( wfReadOnly() ) {
				throw new ReadOnlyError();
			}
		}
		# Set page title
		$this->setHeaders();

		# Target page
		$title = Title::newFromURL( $request->getVal( 'page', $par ) );
		if ( !$title ) {
			$out->showErrorPage( 'notargettitle', 'notargettext' );
			return;
		}
	
		$this->form = new PageStabilityGeneralForm( $user );
		$form = $this->form; // convenience

		$form->setPage( $title );
		# Watch checkbox
		$form->setWatchThis( (bool)$request->getCheck( 'wpWatchthis' ) );
		# Get auto-review option...
		$form->setReviewThis( $request->getBool( 'wpReviewthis', true ) );
		# Reason
		$form->setReasonExtra( $request->getText( 'wpReason' ) );
		$form->setReasonSelection( $request->getVal( 'wpReasonSelection' ) );
		# Expiry
		$form->setExpiryCustom( $request->getText( 'mwStabilize-expiry' ) );
		$form->setExpirySelection( $request->getVal( 'wpExpirySelection' ) );
		# Default version
		$form->setOverride( (int)$request->getBool( 'wpStableconfig-override' ) );
		# Get autoreview restrictions...
		$form->setAutoreview( $request->getVal( 'mwProtect-level-autoreview' ) );
		$form->ready(); // params all set

		$status = $form->checkTarget();
		if ( $status === 'stabilize_page_notexists' ) {
			$out->addWikiMsg( 'stabilization-notexists', $title->getPrefixedText() );
			return;
		} elseif ( $status === 'stabilize_page_unreviewable' ) {
			$out->addWikiMsg( 'stabilization-notcontent', $title->getPrefixedText() );
			return;
		}

		# Form POST request...
		if ( $request->wasPosted() && $confirmed && $form->isAllowed() ) {
			$status = $form->submit();
			if ( $status === true ) {
				$out->redirect( $title->getFullUrl() );
			} else {
				$this->showForm( wfMsg( $status ) );
			}
		# Form GET request...
		} else {
			$form->preload();
			$this->showForm();
		}
	}

	public function showForm( $err = null ) {
		$out = $this->getOutput();

		$form = $this->form; // convenience
		$title = $this->form->getPage();
		$oldConfig = $form->getOldConfig();

		$s = ''; // form HTML string
		# Add any error messages
		if ( "" != $err ) {
			$out->setSubtitle( wfMsgHtml( 'formerror' ) );
			$out->addHTML( "<p class='error'>{$err}</p>\n" );
		}
		# Add header text
		if ( !$form->isAllowed() ) {
			$s .= wfMsgExt( 'stabilization-perm', 'parse', $title->getPrefixedText() );
		} else {
			$s .= wfMsgExt( 'stabilization-text', 'parse', $title->getPrefixedText() );
		}
		# Borrow some protection messages for dropdowns
		$reasonDropDown = Xml::listDropDown(
			'wpReasonSelection',
			wfMsgForContent( 'protect-dropdown' ),
			wfMsgForContent( 'protect-otherreason-op' ),
			$form->getReasonSelection(),
			'mwStabilize-reason',
			4
		);
		$scExpiryOptions = wfMsgForContent( 'protect-expiry-options' );
		$showProtectOptions = ( $scExpiryOptions !== '-' && $form->isAllowed() );
		$dropdownOptions = array(); // array of <label,value>
		# Add the current expiry as a dropdown option
		if ( $oldConfig['expiry'] && $oldConfig['expiry'] != Block::infinity() ) {
			$timestamp = $this->getLang()->timeanddate( $oldConfig['expiry'] );
			$d = $this->getLang()->date( $oldConfig['expiry'] );
			$t = $this->getLang()->time( $oldConfig['expiry'] );
			$dropdownOptions[] = array(
				wfMsg( 'protect-existing-expiry', $timestamp, $d, $t ), 'existing' );
		}
		# Add "other time" expiry dropdown option
		$dropdownOptions[] = array( wfMsg( 'protect-othertime-op' ), 'othertime' );
		# Add custom expiry dropdown options (from MediaWiki message)
		foreach( explode( ',', $scExpiryOptions ) as $option ) {
			if ( strpos( $option, ":" ) === false ) {
				$show = $value = $option;
			} else {
				list( $show, $value ) = explode( ":", $option );
			}
			$dropdownOptions[] = array( $show, $value );
		}
		
		# Actually build the options HTML...
		$expiryFormOptions = '';
		foreach ( $dropdownOptions as $option ) {
			$show = htmlspecialchars( $option[0] );
			$value = htmlspecialchars( $option[1] );
			$expiryFormOptions .= Xml::option( $show, $value,
				$form->getExpirySelection() === $value ) . "\n";
		}

		# Build up the form...
		$s .= Xml::openElement( 'form', array( 'name' => 'stabilization',
			'action' => $this->getTitle()->getLocalUrl(), 'method' => 'post' ) );
		# Add stable version override and selection options
		$s .=
			Xml::fieldset( wfMsg( 'stabilization-def' ), false ) . "\n" .
			Xml::radioLabel( wfMsg( 'stabilization-def1' ), 'wpStableconfig-override', 1,
				'default-stable', 1 == $form->getOverride(), $this->disabledAttr() ) .
				'<br />' . "\n" .
			Xml::radioLabel( wfMsg( 'stabilization-def2' ), 'wpStableconfig-override', 0,
				'default-current', 0 == $form->getOverride(), $this->disabledAttr() ) . "\n" .
			Xml::closeElement( 'fieldset' );
		# Add autoreview restriction select
		$s .= Xml::fieldset( wfMsg( 'stabilization-restrict' ), false ) .
			$this->buildSelector( $form->getAutoreview() ) .
			Xml::closeElement( 'fieldset' ) .

			Xml::fieldset( wfMsg( 'stabilization-leg' ), false ) .
			Xml::openElement( 'table' );
		# Add expiry dropdown to form...
		if ( $showProtectOptions && $form->isAllowed() ) {
			$s .= "
				<tr>
					<td class='mw-label'>" .
						Xml::label( wfMsg( 'stabilization-expiry' ),
							'mwStabilizeExpirySelection' ) .
					"</td>
					<td class='mw-input'>" .
						Xml::tags( 'select',
							array(
								'id'        => 'mwStabilizeExpirySelection',
								'name'      => 'wpExpirySelection',
								'onchange'  => 'onFRChangeExpiryDropdown()',
							) + $this->disabledAttr(),
							$expiryFormOptions ) .
					"</td>
				</tr>";
		}
		# Add custom expiry field to form...
		$attribs = array( 'id' => "mwStabilizeExpiryOther",
			'onkeyup' => 'onFRChangeExpiryField()' ) + $this->disabledAttr();
		$s .= "
			<tr>
				<td class='mw-label'>" .
					Xml::label( wfMsg( 'stabilization-othertime' ), 'mwStabilizeExpiryOther' ) .
				'</td>
				<td class="mw-input">' .
					Xml::input( "mwStabilize-expiry", 50, $form->getExpiryCustom(), $attribs ) .
				'</td>
			</tr>';
		# Add comment input and submit button
		if ( $form->isAllowed() ) {
			$watchLabel = wfMsgExt( 'watchthis', 'parseinline' );
			$watchAttribs = array( 'accesskey' => wfMsg( 'accesskey-watch' ),
				'id' => 'wpWatchthis' );
			$watchChecked = ( $this->getUser()->getOption( 'watchdefault' )
				|| $title->userIsWatching() );
			$reviewLabel = wfMsgExt( 'stabilization-review', 'parseinline' );

			$s .= ' <tr>
					<td class="mw-label">' .
						xml::label( wfMsg( 'stabilization-comment' ), 'wpReasonSelection' ) .
					'</td>
					<td class="mw-input">' .
						$reasonDropDown .
					'</td>
				</tr>
				<tr>
					<td class="mw-label">' .
						Xml::label( wfMsg( 'stabilization-otherreason' ), 'wpReason' ) .
					'</td>
					<td class="mw-input">' .
						Xml::input( 'wpReason', 70, $form->getReasonExtra(),
							array( 'id' => 'wpReason', 'maxlength' => 255 ) ) .
					'</td>
				</tr>
				<tr>
					<td></td>
					<td class="mw-input">' .
						Xml::check( 'wpReviewthis', $form->getReviewThis(),
							array( 'id' => 'wpReviewthis' ) ) .
						"<label for='wpReviewthis'>{$reviewLabel}</label>" .
						'&#160;&#160;&#160;&#160;&#160;' .
						Xml::check( 'wpWatchthis', $watchChecked, $watchAttribs ) .
						"&#160;<label for='wpWatchthis' " .
						Xml::expandAttributes(
							array( 'title' => Linker::titleAttrib( 'watch', 'withaccess' ) ) ) .
						">{$watchLabel}</label>" .
					'</td>
				</tr>
				<tr>
					<td></td>
					<td class="mw-submit">' .
						Xml::submitButton( wfMsg( 'stabilization-submit' ) ) .
					'</td>
				</tr>' . Xml::closeElement( 'table' ) .
				Html::hidden( 'title', $this->getTitle()->getPrefixedDBKey() ) .
				Html::hidden( 'page', $title->getPrefixedText() ) .
				Html::hidden( 'wpEditToken', $this->getUser()->editToken() );
		} else {
			$s .= Xml::closeElement( 'table' );
		}
		$s .= Xml::closeElement( 'fieldset' ) . Xml::closeElement( 'form' );

		$out->addHTML( $s );

		$out->addHTML( Xml::element( 'h2', null,
			htmlspecialchars( LogPage::logName( 'stable' ) ) ) );
		LogEventsList::showLogExtract( $out, 'stable',
			$title->getPrefixedText(), '', array( 'lim' => 25 ) );

		# Add some javascript for expiry dropdowns
		$out->addScript(
			"<script type=\"text/javascript\">
				function onFRChangeExpiryDropdown() {
					document.getElementById('mwStabilizeExpiryOther').value = '';
				}
				function onFRChangeExpiryField() {
					document.getElementById('mwStabilizeExpirySelection').value = 'othertime';
				}
			</script>"
		);
	}

	protected function buildSelector( $selected ) {
		$allowedLevels = array();
		$levels = FlaggedRevs::getRestrictionLevels();
		array_unshift( $levels, '' ); // Add a "none" level
		foreach ( $levels as $key ) {
			# Don't let them choose levels they can't set, 
			# but *show* them all when the form is disabled.
			if ( $this->form->isAllowed()
				&& !FlaggedRevs::userCanSetAutoreviewLevel( $this->getUser(), $key ) )
			{
				continue;
			}
			$allowedLevels[] = $key;
		}
		$id = 'mwProtect-level-autoreview';
		$attribs = array(
			'id' => $id,
			'name' => $id,
			'size' => count( $allowedLevels ),
		) + $this->disabledAttr();

		$out = Xml::openElement( 'select', $attribs );
		foreach ( $allowedLevels as $key ) {
			$out .= Xml::option( $this->getOptionLabel( $key ), $key, $key == $selected );
		}
		$out .= Xml::closeElement( 'select' );
		return $out;
	}

	/**
	 * Prepare the label for a protection selector option
	 *
	 * @param string $permission Permission required
	 * @return string
	 */
	protected function getOptionLabel( $permission ) {
		if ( $permission == '' ) {
			return wfMsg( 'stabilization-restrict-none' );
		} else {
			$key = "protect-level-{$permission}";
			$msg = wfMsg( $key );
			if ( wfEmptyMsg( $key, $msg ) ) {
				$msg = wfMsg( 'protect-fallback', $permission );
			}
			return $msg;
		}
	}

	// If the this form is disabled, then return the "disabled" attr array
	protected function disabledAttr() {
		return $this->form->isAllowed()
			? array()
			: array( 'disabled' => 'disabled' );
	}
}

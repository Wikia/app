<?php
if ( !defined( 'MEDIAWIKI' ) )   die( "Not an entry point." );
if ( !defined( 'RECORDADMIN_VERSION' ) ) die( "The RecordAdmin special page depends on the main RecordAdmin extension." );

$wgAutoloadClasses['SpecialRecordAdmin'] = dirname( __FILE__ ) . '/RecordAdmin_body.php';
$wgSpecialPages['RecordAdmin']           = 'SpecialRecordAdmin';
$wgSpecialPageGroups['RecordAdmin']      = 'wiki';

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'Record administration',
	'author'         => array( '[http://www.organicdesign.co.nz/nad Aran Dunkley]', 'Bertrand GRONDIN', 'Siebrand Mazeland' ),
	'descriptionmsg' => 'recordadmin-specialdesc',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:RecordAdmin',
	'version'        => RECORDADMIN_VERSION,
);

class SpecialRecordAdmin extends SpecialPage {

	var $title;
	var $template;

	function __construct() {
		parent::__construct( 'RecordAdmin', 'recordadmin', true, false, 'default', true );
	}

	function execute( $param ) {
		global $wgOut, $wgRequest, $wgRecordAdmin, $wgSecurityProtectRecords;
		if ( !isset( $wgSecurityProtectRecords ) ) $wgSecurityProtectRecords = false;

		$this->setHeaders();
		$type     = $wgRequest->getText( 'wpType' ) or $type = $param;
		$newtype  = $wgRequest->getText( 'wpNewType' );
		$invert   = $wgRequest->getText( 'wpInvert' );
		$record   = $wgRecordAdmin->record = $wgRequest->getText( 'wpRecord' );
		$title    = $this->title = SpecialPage::getTitleFor( 'RecordAdmin' );
		$action   = $title->getLocalURL( 'action=submit' );
		$wpTitle  = trim( $wgRequest->getText( 'wpTitle' ) );
		$this->template = Title::makeTitle( NS_TEMPLATE, $type );

		$wgOut->addHTML(
			'<div class="recordadmin-menubar"><a href="' . $title->getLocalURL() . "/$type\">" . wfMsg( 'recordadmin-newsearch', $type ) . '</a>'
			. '&#160;'
			. '<a href="' . $title->getLocalURL() . '">' . wfMsg( 'recordadmin-newrecord' ) . '</a></div>'."\n"
		);

		# Get posted form values if any
		$posted = array();
		foreach ( $_REQUEST as $k => $v ) if ( preg_match( "|^ra_(\\w+)|", $k, $m ) ) $posted[$m[1]] = is_array( $v ) ? join( "\n", $v ) : $v;

		# Read in and prepare the form for this record type if one has been selected
		if ( $type ) $wgRecordAdmin->preProcessForm( $type );

		# Extract the input names and types used in the form
		$wgRecordAdmin->examineForm();

		# Process Create New Type form if submitted and user permitted
		if ( $newtype ) {
			$wgRecordAdmin->createRecordType( $newtype );
			$type = '';
		}

		# If no type selected, render form for record types and create record-type
		if ( empty( $type ) ) {
			$wgOut->addHTML( Xml::element( 'form', array( 'class' => 'recordadmin', 'action' => $action, 'method' => 'post' ), null ) );
			$wgOut->addWikiText( "<div class='visualClear'></div>\n==" . wfMsg( 'recordadmin-select' ) . "==\n" );

			# Render type select list
			$options = "";
			foreach( $wgRecordAdmin->getRecordTypes() as $option ) $options .= "<option>$option</option>";
			if ( $options ) $wgOut->addHTML(
				"<select name='wpType'>$options</select>&#160;"
				. Xml::element( 'input', array( 'type' => 'submit', 'value' => wfMsg( 'recordadmin-submit' ) ) )
			); else $wgOut->AddWikiText( wfMsg( 'recordadmin-noforms' ) );

			# Render type create
			$wgOut->addWikiText( "<br />\n==" . wfMsg( 'recordadmin-createtype' ) . "==\n" );
			$wgOut->addHTML( Xml::element( 'input', array( 'name' => 'wpNewType', 'type' => 'text' ) )
				. '&#160;'
				. Xml::element( 'input', array( 'type' => 'submit', 'value' => wfMsg( 'recordadmin-buttoncreate' ) ) )
				. '</form>'
			);

		}

		# Record type known, render form for searching or creating
		else {

			# Process Create submission
			if ( count( $posted ) && $wgRequest->getText( 'wpCreate' ) ) {
				if ( empty( $wpTitle ) ) $wpTitle = $wgRecordAdmin->guid;
				$t = Title::newFromText( $wpTitle );
				if ( is_object( $t ) ) {
					if ( $t->exists() ) $wgOut->addHTML( "<div class='errorbox'>" . wfMsg( 'recordadmin-alreadyexist' , $wpTitle ) . "</div>\n" );
					else {

						# Attempt to create the article
						$article = new Article( $t );
						$summary = "[[Special:RecordAdmin/$type|" . wfMsgForContent( 'recordadmin' ) . "]]: " . wfMsg( 'recordadmin-summary-typecreated', $type );
						$success = $article->doEdit( $wgRecordAdmin->valuesToText( $type, $posted ), $summary, EDIT_NEW );

						# Redirect to view the record if successfully updated
						if ( $success ) {
							$wgOut->disable();
							wfResetOutputBuffers();
							header( "Location: " . $t->getFullUrl() );
						}

						# Or stay in edit view and report error
						else $wgOut->addHTML( "<div class='errorbox'>" . wfMsg( 'recordadmin-createerror', $type ) . "</div>\n" );
					}
				} else $wgOut->addHTML( "<div class='errorbox'>" . wfMsg( 'recordadmin-badtitle' ) . "</div>\n" );
				$wgOut->addHTML( "<br /><br /><br /><br />\n" );
			}

			# Populate the search form with any posted values
			$wgRecordAdmin->populateForm( $posted );

			# Process Find submission (select and render records)
			if ( count( $posted ) && $wgRequest->getText( 'wpFind' ) ) {
				$wgOut->addWikiText( "== " . wfMsg( 'recordadmin-searchresult' ) . " ==\n" );
				$records = $wgRecordAdmin->getRecords( $type, $posted, '=', $wpTitle, $invert );
				$wgOut->addHTML( $wgRecordAdmin->renderRecords( $records ) );
			}

			# Render the form
			$wgOut->addHTML( "<br /><form class=\"{$wgRecordAdmin->formClass}\"{$wgRecordAdmin->formAtts} action=\"$action\" method=\"POST\">" );
			$wgOut->addWikiText( "==" . wfMsg( 'recordadmin-create', $type ) . "==\n" );
			$wgOut->addHTML(
				'<table class="recordadmin-create">'
				. '<tr><td class="recordadmin-create-id"><b>' . wfMsg( 'recordadmin-recordid' ) . '</b>&#160;' . Xml::element( 'input', array( 'id' => 'ra-title', 'name' => 'wpTitle', 'size' => 30, 'value' => $wpTitle ) )
				. '&#160;&#160;&#160;' . Xml::element( 'input', array( 'name' => 'wpInvert', 'type' => 'checkbox' ) ) . ' ' . wfMsg( 'recordadmin-invert' )
				. '</td></tr>'
				. '<tr><td>' . $wgRecordAdmin->form . '</td></tr>'
				. '<tr><td>' . Xml::element( 'input', array( 'type' => 'hidden', 'id' => 'ra-type', 'name' => 'wpType', 'value' => $type ) ) . '</td></tr>'
				. '<tr><td>'
				. Xml::element( 'input', array( 'type' => 'submit', 'name' => 'wpFind', 'id' => 'ra-find', 'value' => wfMsg( 'recordadmin-buttonsearch' ) ) )
				. Xml::element( 'input', array( 'type' => 'submit', 'name' => 'wpCreate', 'id' => 'ra-create', 'value' => wfMsg( 'recordadmin-buttoncreate' ) ) )
				. Xml::element( 'input', array( 'type' => 'reset', 'value' => wfMsg( 'recordadmin-buttonreset' ) ) )
				. '</td></tr>'
				. '</table></form>'
			);
		}
	}
}

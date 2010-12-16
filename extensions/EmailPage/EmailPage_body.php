<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

class SpecialEmailPage extends SpecialPage {

	var $recipients = array();
	var $title;
	var $subject;
	var $header;
	var $cat;
	var $group;
	var $list;
	var $textonly;
	var $css;
	var $record;
	var $db;
	var $parser;
	var $args;

	public function __construct() {
		global $wgEmailPageGroup;
		SpecialPage::SpecialPage( 'EmailPage', $wgEmailPageGroup );
	}

	/**
	 * Override SpecialPage::execute($param = '')
	 */
	function execute( $param ) {
		global $wgOut, $wgUser, $wgRequest, $wgParser, $wgEmailPageContactsCat, $wgGroupPermissions, $wgSitename,
			$wgRecordAdminCategory, $wgEmailPageCss, $wgEmailPageAllowAllUsers;

		$db = wfGetDB(DB_SLAVE);		
		$param = str_replace( '_', ' ', $param );
		wfLoadExtensionMessages( 'EmailPage' );
		$this->setHeaders();

		# Get info from request or set to defaults
		$this->title    = $wgRequest->getText( 'ea-title', $param );
		$this->subject  = $wgRequest->getText( 'ea-subject', wfMsg( 'ea-pagesend', $this->title, $wgSitename ) );
		$this->header   = $wgRequest->getText( 'ea-header' );
		$this->cat      = $wgRequest->getText( 'ea-cat' );
		$this->group    = $wgRequest->getText( 'ea-group' );
		$this->list     = $wgRequest->getText( 'ea-list' );
		$this->textonly = $wgRequest->getText( 'ea-textonly', false );
		$this->css      = $wgRequest->getText( 'ea-css', $wgEmailPageCss );
		$this->record   = $wgRequest->getText( 'ea-record', false );
		$this->db = $db;
		$this->parser = $wgParser;

		# Bail if no page title to send has been specified
		if ( $this->title ) $wgOut->addWikiText( wfMsg( 'ea-heading', $this->title ) );
		else return $wgOut->addWikiText( wfMsg( 'ea-nopage' ) );

		# If the send button was clicked, attempt to send and exit
		if ( isset( $_REQUEST['ea-send'] ) ) return $this->send();

		# Render form
		$special = Title::makeTitle( NS_SPECIAL, 'EmailPage' );
		$wgOut->addHTML( Xml::element( 'form', array(
			'class'  => 'EmailPage',
			'action' => $special->getLocalURL( 'action=submit' ),
			'method' => 'POST'
		), null ) );
		$wgOut->addHTML( '<fieldset><legend>' . wfMsg( 'ea-selectrecipients' ) . '</legend>' );
		$wgOut->addHTML( '<table style="padding:0;margin:0;border:none;">' );

		# If $wgEmailPageContactsCat is set, create a select list of all categories
		if ( $wgEmailPageContactsCat ) {
			$cats = '';
			$res = $db->select(
				'categorylinks',
				'cl_from',
				'cl_to = '.$db->addQuotes( $wgEmailPageContactsCat ),
				__METHOD__,
				array( 'ORDER BY' => 'cl_sortkey' )
			);
			while ( $row = $db->fetchRow( $res ) ) {
				$t = Title::newFromID( $row[0] );
				if ( $t->getNamespace() == NS_CATEGORY ) {
					$cat = $t->getText();
					$selected = $cat == $this->cat ? ' selected' : '';
					$cats .= "<option$selected>$cat</option>";
				}
			}
			$db->freeResult( $res );
			if ( $cats ) $wgOut->addHTML( "<tr><td>From category:</td><td><select name=\"ea-cat\"><option/>$cats</select></td></tr>\n" );
		}

		# Allow selection of a group
		$groups = "<option />";
		foreach ( array_keys( $wgGroupPermissions ) as $group ) if ( $group != '*' && $group != 'user' ) {
			$selected = $group == $this->group ? ' selected' : '';
			$groups .= "<option$selected>$group</option>";
		}
		if ( $wgEmailPageAllowAllUsers ) {
			$selected = 'user' == $this->group ? ' selected' : '';
			$groups .= "<option$selected value='user'>ALL USERS</option>";
		}
		$wgOut->addHTML( "<tr><td>" . wfMsg( 'ea-fromgroup' ) . "</td><td><select name=\"ea-group\">$groups</select></td></tr>\n" );
		$wgOut->addHTML( "</table>" );

		# Addition of named list
		$wgOut->addWikiText( wfMsg( 'ea-selectlist' ) );
		$wgOut->addHTML( "<textarea name=\"ea-list\" rows=\"5\">{$this->list}</textarea><br />\n" );
		$wgOut->addHTML( "</fieldset>" );

		$wgOut->addHTML( "<fieldset><legend>" . wfMsg( 'ea-compose' ) . "</legend>" );

		# Subject
		$wgOut->addWikiText( wfMsg( 'ea-subject' ) );
		$wgOut->addHTML(
			Xml::element( 'input', array( 'type' => 'text', 'name' => 'ea-subject', 'value' => $this->subject, 'style' => "width:100%" ) )
		);

		# Header
		$wgOut->addWikiText( wfMsg( 'ea-header' ) );
		$wgOut->addHTML( "<textarea name=\"ea-header\" rows=\"5\">{$this->header}</textarea><br />\n" );

		# CSS
		$options = "<option value=''>$wgEmailPageCss</option>";
		$res = $db->select(
			'page',
			'page_id',
			'page_title LIKE \'%.css\'',
			__METHOD__,
			array( 'ORDER BY' => 'page_title' )
		);
		while ( $row = $db->fetchRow( $res ) ) {
			$t = Title::newFromID( $row[0] )->getPrefixedText();
			$selected = $t == $this->css ? ' selected' : '';
			$options .= "<option$selected>$t</option>";
		}
		$db->freeResult( $res );
		if ( $options ) $wgOut->addHTML( wfMsg( 'ea-selectcss' ) . " <select name=\"ea-css\">$options</select><br />\n" );

		# Get titles in Category:Records and build option list
		$options = "<option />";
		$cl   = $db->tableName( 'categorylinks' );
		$cat  = $db->addQuotes( $wgRecordAdminCategory ? $wgRecordAdminCategory : 'Records' );
		$res  = $db->select( $cl, 'cl_from', "cl_to = $cat", __METHOD__, array( 'ORDER BY' => 'cl_sortkey' ) );
		while ( $row = $db->fetchRow( $res ) ) {
			$t = Title::newFromID( $row[0] )->getText();
			$selected = $t == $this->record ? ' selected' : '';
			$options .= "<option$selected>$t</option>";
		}
		$db->freeResult( $res );
		$wgOut->addHTML( wfMsg( 'ea-selectrecord' ) . " <select name=\"ea-record\">$options</select>" );
		$wgOut->addHTML( "</fieldset>" );

		# Submit buttons & hidden values
		$wgOut->addHTML(Xml::element( 'input', array( 'type' => 'submit', 'name' => 'ea-send', 'value' => wfMsg( 'ea-send' ) ) ) . '&nbsp;' );
		$wgOut->addHTML(Xml::element( 'input', array( 'type' => 'submit', 'name' => 'ea-show', 'value' => wfMsg( 'ea-show' ) ) ) );
		$wgOut->addHTML(Xml::element( 'input', array( 'type' => 'hidden', 'name' => 'ea-title', 'value' => $this->title ) ) );

		$wgOut->addHTML( "</form>" );

		# If the show button was clicked, render the list
		if ( isset( $_REQUEST['ea-show'] ) ) return $this->send( false );
	}

	/**
	 * Send the message to the recipients (or just list them if arg = false)
	 */
	function send( $send = true ) {
		global $wgOut, $wgUser, $wgParser, $wgServer, $wgScript, $wgArticlePath, $wgScriptPath,
			$wgEmailPageCss, $wgEmailPageGroup, $wgEmailPageAllowRemoteAddr, $wgEmailPageAllowAllUsers;

		# Set error and bail if user not in postmaster group, and request not from trusted address
		if ( $wgEmailPageGroup && !in_array( $wgEmailPageGroup, $wgUser->getGroups() )
		&& !in_array( $_SERVER['REMOTE_ADDR'], $wgEmailPageAllowRemoteAddr ) ) {
			$denied = wfMsg( 'ea-denied' );
			$wgOut->addWikiText( wfMsg( 'ea-error', $this->title, $denied ) );
			return false;
		}

		$db    = wfGetDB( DB_SLAVE );
		$title = Title::newFromText( $this->title );
		$opt   = new ParserOptions;

		# Get contact page titles from selected cat
		if ( $this->cat ) {
			$res = $db->select(
				'categorylinks',
				'cl_from',
				'cl_to = '.$db->addQuotes( $this->cat ),
				__METHOD__,
				array( 'ORDER BY' => 'cl_sortkey' )
			);
			if ( $res ) while ( $row = $db->fetchRow( $res ) ) $this->addRecipient( Title::newFromID( $row[0] ) );
			$db->freeResult( $res );
		}

		# Get email addresses from users in selected group
		if ( $this->group && ( $wgEmailPageAllowAllUsers || $this->group != 'user' ) ) {
			$group = $db->addQuotes( $this->group );
			$res = $this->group == 'user'
				? $db->select( 'user', 'user_email', 'user_email != \'\'', __METHOD__ )
				: $db->select( array( 'user', 'user_groups' ), 'user_email', "ug_user = user_id AND ug_group = $group", __METHOD__ );
			while ( $row = $db->fetchRow( $res ) ) $this->addRecipient( $row[0] );
			$db->freeResult( $res );
		}

		# Recipients from list (expand templates in wikitext)
		$list = $wgParser->preprocess( $this->list, $title, $opt );
		foreach ( preg_split( "/[\\x00-\\x1f,;*]+/", $list ) as $item ) $this->addRecipient( $item );

		# Compose the wikitext content of the page to send
		$page = new Article( $title );
		$message = $page->getContent();
		if ( $this->header ) $message = "{$this->header}\n\n$message";

		# Convert the message text to html unless textonly
		if ( $this->textonly == '' ) {

			# Parse the wikitext using absolute URL's for local page links
			$tmp           = array($wgArticlePath, $wgScriptPath, $wgScript);
			$wgArticlePath = $wgServer.$wgArticlePath;
			$wgScriptPath  = $wgServer.$wgScriptPath;
			$wgScript      = $wgServer.$wgScript;
			$message       = $wgParser->parse($message, $title, $opt, true, true)->getText();
			list($wgArticlePath,$wgScriptPath,$wgScript) = $tmp;

			# Get CSS content if any
			if ( $this->css ) {
				$page = new Article( Title::newFromText( $this->css ) );
				$css  = "<style type='text/css'>" . $page->getContent() . "</style>";
			} else $css = '';

			# Create a html wrapper for the message
			$doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
			$head    = "<head>$css</head>";
			$message = "$doctype\n<html>$head<body style=\"margin:10px\"><div id=\"bodyContent\">$message</div></body></html>";
		}

		# Send message or list recipients
		$count = count( $this->recipients );
		if ( $count > 0 ) {

			# Set up new mailer instance if sending
			if ( $send ) {
				$mail           = new PHPMailer();
				$mail->From     = $wgUser->isValidEmailAddr( $wgUser->getEmail() ) ? $wgUser->getEmail() : "wiki@$wgServer";
				$mail->FromName = User::whoIsReal( $wgUser->getId() );
				$mail->Subject  = $this->subject;
				$mail->Body     = $message;
				$mail->IsHTML( !$this->textonly );
			}
			else $msg = wfMsg( 'ea-listrecipients', $count );

			# Loop through recipients sending or adding to list
			foreach ( $this->recipients as $recipient ) {
				$error = '';
				if ( $send ) {
					if ( $this->record ) $mail->Body = $this->replaceFields( $message, $recipient );
					$mail->AddAddress( $recipient );
					if ( $state = $mail->Send() ) $msg = wfMsg( 'ea-sent', $this->title, $count, $wgUser->getName() );
					else $error .= "Couldn't send to $recipient: {$mail->ErrorInfo}<br />\n";
					$mail->ClearAddresses();
				} else $msg .= "\n*[mailto:$recipient $recipient]";
				if ( $error ) $msg = wfMsg( 'ea-error', $this->title, $error );
			}
		}
		else $msg = wfMsg( 'ea-error', $this->title, wfMsg( 'ea-norecipients' ) );

		$wgOut->addWikiText( $msg );
		return $send ? $state : $count;
	}

	/**
	 * Add a recipient the list
	 * - accepts title objects for page containing email address, or string of actual address
	 */
	function addRecipient( $recipient ) {
		if ( is_object( $recipient ) && $recipient->exists() ) {
			$page = new Article( $recipient );
			if ( preg_match( "|[a-z0-9_.-]+@[a-z0-9_.-]+|i", $page->getContent(), $emails ) ) $recipient = $emails[0];
			else $recipient = '';
		}
		if ( $valid = User::isValidEmailAddr( $recipient ) ) $this->recipients[] = $recipient;
		return $valid;
	}

	/**
	 * Replace fields in message (enclosed in single braces)
	 * - fields can have a default value, eg {name|default}
	 */
	function replaceFields( $text, $email ) {
		
		# Scan all records of this type for the first containing matching email address
		$dbr  = $this->db;
		$tbl  = $dbr->tableName( 'templatelinks' );
		$type = $dbr->addQuotes( $this->record );
		$res  = $dbr->select( $tbl, 'tl_from', "tl_namespace = 10 AND tl_title = $type", __METHOD__ );
		while ( $row = $dbr->fetchRow( $res ) ) {
			$a = new Article( Title::newFromID( $row[0] ) );
			$c = $a->getContent();
			
			# Check if this records email address matches
			if ( preg_match( "|\s*\|\s*\w+\s*=\s*$email\s*(?=[\|\}])|s", $c ) ) {

				# Extract all the fields from the content (should use examineBraces here)
				$this->args = array();
				preg_match_all( "|\|\s*(.+?)\s*=\s*(.*?)\s*(?=[\|\}])|s", $c, $m );
				foreach ( $m[1] as $i => $k ) $this->args[strtolower( $k )] = $m[2][$i];

				# Replace any fields in the message text with our extracted args (should use wiki parser for this)
				$text = preg_replace_callback( "|\{(\w+)(\|(.+?))?\}|s", array( $this, 'replaceField' ), $text );
				
				break;
			}
		}
		$dbr->freeResult( $res );
		return $text;
	}

	/**
	 * Replace a single field
	 */
	function replaceField( $match ) {
		$key = strtolower( $match[1] );
		$default = isset( $match[3] ) ? $match[3] : false;
		if ( array_key_exists( $key, $this->args ) ) $replace = $this->args[$key];
		else $replace = $default ? $default : $match[0];
		return $replace;
	}
}

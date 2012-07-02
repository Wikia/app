<?php

class WikiTrustBase {
	## Cache time that results are valid for.  Currently 1 day.
	const TRUST_CACHE_VALID = 31556926;

	## Types of analysis to perform.
	const TRUST_EVAL_VOTE = 0;
	const TRUST_EVAL_EDIT = 10;

	## Trust normalization values;
	const MAX_TRUST_VALUE = 9;
	const MIN_TRUST_VALUE = 0;
	const TRUST_MULTIPLIER = 10;

	## Server forms
	const NOT_FOUND_TEXT_TOKEN = "TEXT_NOT_FOUND";

	## Context for communicating with the trust server
	const TRUST_TIMEOUT = 10;

	## Default median to avoid div by 0 errors
	const TRUST_DEFAULT_MEDIAN = 1;

	## Median Value of Trust
	static $median = 1.0;

	## Already rendered HTML?
	static $html_rendered = false;

	## Don't close the first opening span tag
	static $first_span = true;

	## Stores the colored text between function calls
	static $colored_text = "";

	## Has the colored text been loaded?
	static $colored_text_loaded = false;

	## map trust values to html color codes
	static $COLORS = array(
		"trust0",
		"trust1",
		"trust2",
		"trust3",
		"trust4",
		"trust5",
		"trust6",
		"trust7",
		"trust9",
		"trust10",
	);


	/**
	 * Records the vote.
	 * Called via ajax, so this must be static.
	 */
	static function ajax_recordVote( $user_name_raw, $page_id_raw = 0,
		$rev_id_raw = 0, $page_title_raw = "" )
	{

		global $wgMemc;
		wfWikiTrustDebug( __FILE__.":".__LINE__
			. ": Handling vote from $user_name_raw $page_title_raw" );
		$dbr = wfGetDB( DB_SLAVE );

		$userName = $dbr->strencode( $user_name_raw, $dbr );
		$page_id = $dbr->strencode( $page_id_raw, $dbr );
		$rev_id = $dbr->strencode( $rev_id_raw, $dbr );
		$pageTitle = $dbr->strencode( $page_title_raw, $dbr );

		if ( !$page_id || !$userName || !$rev_id || !$pageTitle )
			return new AjaxResponse( "0" );

		$user_id = self::user_getIdFName( $dbr, $userName) ;
		if ( !$user_id )
			$user_id = 0;
		wfWikiTrustDebug( __FILE__.":".__LINE__.": UserId: $user_id" );

		// Invalidate the cache.
		$memcKey = wfMemcKey( 'revisiontext', 'revid', $rev_id );
		$wgMemc->delete( $memcKey );

		return WikiTrust::vote_recordVote( $dbr, $userName, $page_id, $rev_id, $pageTitle );
	}


	static function vote_recordVote( &$dbr, $userName, $page_id, $rev_id, $pageTitle )
	{
		// Now see if this user has not already voted,
		// and count the vote if its the first time though.
		$res = $dbr->select( self::util_getDbTable( 'wikitrust_vote' ),
			array( 'revision_id' ),
			array( 'revision_id' => $rev_id, 'voter_name' => $userName ),
			array() );
		if ( !$res ) {
			// TODO: do we also need to $dbr->freeResult($res)?
			$dbr->freeResult( $res );
			return new AjaxResponse( "0" );
		}

		$row = $dbr->fetchRow( $res );
		$dbr->freeResult( $res );
		if ( $row['revision_id'] ) return new AjaxResponse( "Already Voted" );

		$insert_vals = array(
			"revision_id" => $rev_id,
			"page_id" => $page_id ,
			"voter_name" => $userName,
			"voted_on" => wfTimestampNow()
		);

		wfWikiTrustDebug(__FILE__ . ":"
			. __LINE__ . " Inserting vote values: ".print_r( $insert_vals, true ) );

		$dbw = wfGetDB( DB_MASTER );
		if ( $dbw->insert( self::util_getDbTable( 'wikitrust_vote' ), $insert_vals ) ) {
			$dbw->commit();
			self::runEvalEdit( self::TRUST_EVAL_VOTE, $rev_id, $page_id, $userName );
			return new AjaxResponse( implode( ",", $insert_vals ) );
		} else {
			return new AjaxResponse( "0" );
		}
	}

	static function ucscOutputBeforeHTML( &$out, &$text ) {
		# We are done if the trust tab isn't selected
		global $wgRequest;
		$use_trust = $wgRequest->getVal( 'trust' );
		if ( !isset( $use_trust ) ||
			( ( $wgRequest->getVal( 'action' ) &&
			( $wgRequest->getVal( 'action' ) != 'purge' ) ) ) )
			return true;

		self::color_addFileRefs( $out );
		$rev_id = self::util_getRevFOut( $out );
		$colored_text = self::$colored_text;
		if ( !self::$colored_text_loaded ) {
			list( $page_title, $page_id, $rev_id ) = self::util_ResolveRevSpec( null, 0, $rev_id );
			$colored_text = WikiTrust::color_getColorData( $page_title, $page_id, $rev_id );

			self::color_fixup( $colored_text );
		}

		if ( !$colored_text ) {
			wfWikiTrustDebug( __FILE__ . ":"
				. __LINE__ . " $rev_id: colored text not found." );
			// text not found.
			global $wgUser, $wgParser, $wgTitle;
			$options = ParserOptions::newFromUser( $wgUser );
			$msg = $wgParser->parse( wfMsgNoTrans( "wgNoTrustExplanation" ),
				$wgTitle,
				$options );
			$text = $msg->getText() . $text;
		} else {
			self::color_Wiki2Html( $colored_text, $text, $rev_id );
			self::vote_showButton( $text );
			self::color_addTracker( $text );
		}

		return true;
	}

	// Add a Google Analytics tracker if one is set.
	static function color_addTracker( &$text ) {
		global $wgWikiTrustGATag;
		if ( $wgWikiTrustGATag ){
			$text .= "
<script type=\"text/javascript\">
				var gaJsHost = ((\"https:\" == document.location.protocol) ? \"https://ssl.\" : \"http://www.\");
				document.write(unescape(\"%3Cscript src='\" + gaJsHost + \"google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E\"));
				</script>
				<script type=\"text/javascript\">
				var pageTracker = _gat._getTracker(\"" . $wgWikiTrustGATag . "\");
				pageTracker._trackPageview();
</script>";
		}
	}

	static function color_addFileRefs( &$out ) {
		global $wgScriptPath;
		$out->addScript( "<script type=\"text/javascript\" src=\""
			. $wgScriptPath
			. "/extensions/WikiTrust/js/trust.js\"></script>" );
		$out->addScript( "<link rel=\"stylesheet\" type=\"text/css\" href=\""
			. $wgScriptPath . "/extensions/WikiTrust/css/trust.css\">" );
	}

	static function vote_showButton( &$text )
	{
		global $wgWikiTrustShowVoteButton, $wgUseAjax;

		if ( $wgWikiTrustShowVoteButton && $wgUseAjax ) {
			$text = "<div id='vote-button'><input id='wt-vote-button' type='button' name='vote' "
			. "value='"
			. wfMsgNoTrans( "wgTrustVote" )
			. "' onclick='startVote()' /></div><div id='vote-button-done'>"
			. wfMsgNoTrans( "wgTrustVoteDone" )
			. "</div>"
			. $text;
		}
	}

	static function voteToProcess($rev_id)
	{
		$voteToProcess = false;
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( self::util_getDbTable( 'wikitrust_vote' ), 'processed',
			array( 'revision_id' => $rev_id ),
			array() );
		if ( $res && $dbr->numRows( $res ) > 0 ) {
			$row = $dbr->fetchRow( $res );
			if ( !$row[0] ) {
				$voteToProcess = true;
			}
		}
		$dbr->freeResult( $res );
		return $voteToProcess;
	}

	static function color_getColorData( $page_title, $page_id=0, $rev_id=0 )
	{
		wfWikiTrustDebug( __FILE__ . ":" . __LINE__ . ": " . __METHOD__ );

		if ( !$rev_id )
			return '';

		if ( !$page_id )
			return '';

		$colored_text = "";

		$dbr = wfGetDB( DB_SLAVE );

		global $wgWikiTrustBlobPath;
		wfWikiTrustDebug( __FILE__ . ":" . __LINE__ . ": Looks in the database." );
		$res = $dbr->select( self::util_getDbTable( 'wikitrust_revision' ),
			'blob_id',
			array( 'revision_id' => $rev_id ),
			array() );
		if ( !$res || $dbr->numRows( $res ) == 0 ) {
			wfWikiTrustDebug( __FILE__ . ":" . __LINE__ . ": Calls the evaluation." );
			self::runEvalEdit( self::TRUST_EVAL_EDIT );
			return '';
		}
		wfWikiTrustDebug( __FILE__ . ":" . __LINE__ . ": It thinks it has found colored text." );
		$row = $dbr->fetchRow( $res );
		$blob_id = $row[0];

		if ( !$wgWikiTrustBlobPath ) {
			$new_blob_id = sprintf( "%012d%012d", $page_id, $blob_id );
			wfWikiTrustDebug( __FILE__ . ":" . __LINE__ . ": fetching content from wikitrust_blob, blob_id = " . $new_blob_id );
			$res = $dbr->select( self::util_getDbTable( 'wikitrust_blob' ),
				'blob_content',
				array( 'blob_id' => $new_blob_id ),
				array() );
			if ( !$res || $dbr->numRows($res) == 0 ) {
				wfWikiTrustDebug( __FILE__ . ":" . __LINE__ . ": Calls the evaluation." );
				self::runEvalEdit( self::TRUST_EVAL_EDIT );
				return '';
			}
			$row = $dbr->fetchRow( $res );
			$blob_content = gzinflate( substr( $row[0], 10 ) );
			$colored_text = self::util_extractFromBlob( $rev_id, $blob_content );
			$dbr->freeResult( $res );
		} else {
			$file = self::util_getRevFilename( $page_id, $blob_id );
			wfWikiTrustDebug( __FILE__ . ":" . __LINE__ . ": Fetching from disk; file=[$file]" );
			// TODO: file_get_contents() didn't used to support BINARY
			// what version of PHP are we requiring?  -Bo
			if ( 1 ) {
				$gzdata = @file_get_contents( $file, FILE_BINARY, null );
			} else {
				$gzdata = '';
				$fh = @fopen( $file, "r" );
				if ( $fh ) {
					$gzdata = fread( $fh, filesize( $file ) );
					fclose( $fh );
				}
			}
			if ( !$gzdata ) {
				self::runEvalEdit( self::TRUST_EVAL_EDIT );
				return '';
			}
			$blob_content = gzinflate( substr( $gzdata, 10 ) );
			$colored_text = self::util_extractFromBlob( $rev_id, $blob_content );
		}

		// wfWikiTrustDebug( __FILE__ . ":" . __LINE__ . "/* $colored_text */" );

		$res = $dbr->select( self::util_getDbTable( 'wikitrust_global' ), 'median', array(), array() );
		if ( $res && $dbr->numRows( $res ) > 0 ) {
			$row = $dbr->fetchRow( $res );
			self::$median = $row[0];
			if ( $row[0] == 0 ) {
				self::$median = self::TRUST_DEFAULT_MEDIAN;
			}
		}
		$dbr->freeResult( $res );

		return $colored_text;
	}

	static function color_parseWiki( $colored_text, $rev_id, &$options )
	{
		global $wgTitle, $wgParser;
		$parsed = $wgParser->parse( $colored_text, $wgTitle, $options );
		return $parsed->getText();
	}

	static function color_Wiki2Html( &$colored_text, &$text, $rev_id )
	{
		global $wgParser, $wgUser, $wgTitle;
		$count = 0;

		if ( self::$html_rendered ){
			$text = $colored_text;
		} else {

			// fix trust tags around links
			$colored_text = preg_replace_callback( "/\{\{#t:(\d+),(\d+),([^}]+)\}\}\s*\[\[([^\]]+)\]\]\s*(?=\{\{#t:|$)/D",
				"WikiTrust::regex_fixBracketTrust",
				$colored_text,
				-1,
				$count );
			// fix trust tags around semicolon lines
			$colored_text = preg_replace_callback( "/^;\s*\{\{#t:(\d+),(\d+),([^}]+)\}\}(\s*[^\{<]*?)(?=\{|<|$)/m",
				"WikiTrust::regex_fixTextTrust",
				$colored_text,
				-1,
				$count );


			$options = ParserOptions::newFromUser( $wgUser );
			$text = WikiTrust::color_parseWiki( $colored_text, $rev_id, $options );

			// Fix broken dt tags -- caused by ;
			$text = preg_replace("/<dt>\{\{#t<\/dt>\n<dd>(.*?)<\/dd>/",
				"<dt>{{#t:$1</dt>",
				$text,
				-1,
				$count );

			// Fix edit section links
			$text = preg_replace_callback(
				"/<span class=\"editsection\"([^>]*?)>(.*?) title=\"(.*?)\">/",
				"WikiTrust::regex_fixSectionEdit",
				$text,
				-1,
				$count );

			// Update the trust tags
			$text = preg_replace_callback( "/\{\{#t:(\d+),(\d+),([^}]+)\}\}([^\{<]++[^<]*?)(?=\{\{#t:|<|$)/D",
				"WikiTrust::regex_fixTextTrust",
				$text,
				-1,
				$count );


			// Remove all of the trust tags which we can not handle at the moment.
			$text = preg_replace( "/\{\{#t:\d+,\d+,[^}]+\}\}/",
				"",
				$text,
				-1,
				$count );

			global $wgScriptPath;
			$text = '<script type="text/javascript" src="'
				. $wgScriptPath
				. '/extensions/WikiTrust/js/wz_tooltip.js"></script>' . $text;

			$msg = $wgParser->parse( wfMsgNoTrans( "wgTrustExplanation" ),
				$wgTitle,
				$options );
			$text .= $msg->getText();
			WikiTrust::color_shareHTML($text, $rev_id);
		}
	}

	static function regex_fixSectionEdit($matches){
		$result = preg_replace("/\{\{#t:\d+,\d+,[^}]+\}\}/",
			"",
			$matches[3],
			-1,
			$count );
		return '<span class="editsection"'. $matches[1] . '>'
			. $matches[2] .' title="$result">';
	}

	static function regex_fixTextTrust( $matches ){

		//print_r($matches);
		global $wgWikiTrustShowMouseOrigin;

		$normalized_value = min( self::MAX_TRUST_VALUE,
			max( self::MIN_TRUST_VALUE,
				( ( $matches[1] + .5 ) *
				self::TRUST_MULTIPLIER)
				/ self::$median ) );
		$class = self::$COLORS[$normalized_value];

		$output = "";
		if ( $wgWikiTrustShowMouseOrigin ){
			# Need to escape single quotes
			$matches[3]= str_replace( "'", "\\'",$matches[3] );
			$matches[3]= str_replace( "&apos;", "\\'",$matches[3] );
			$matches[3]= str_replace( "&#39;", "\\'",$matches[3] );
			$output = "<span class=\"$class\""
				. " onmouseover=\"Tip('" . $matches[3]
				."')\" onmouseout=\"UnTip()\""
				. " onclick=\"showOrigin("
				. $matches[2] . ")\">" . $matches[4]
				. "</span>";
		} else {
			$output = "<span class=\"$class\""
				. " onclick=\"showOrigin("
				. $matches[2] . ")\">" . $matches[4]
				. "</span>";
		}
		return $output;
	}

	static function regex_fixBracketTrust( $matches ) {
		global $wgWikiTrustShowMouseOrigin;
		$normalized_value = min( self::MAX_TRUST_VALUE,
			max( self::MIN_TRUST_VALUE,
				( ( $matches[1] + .5 ) *
				 self::TRUST_MULTIPLIER )
				/ self::$median ) );
		$class = self::$COLORS[$normalized_value];

		$output = "";

		if ( $wgWikiTrustShowMouseOrigin ) {
			$output = "<span class=\"$class\""
				. " onmouseover=\"Tip('".str_replace( "&#39;","\\'",$matches[3] )
				. "')\" onmouseout=\"UnTip()\""
				. " onclick=\"showOrigin("
				. $matches[2] . ")\">"
				. "[[" . $matches[4] . "]]"
				. "</span>";
		} else {
			$output = "<span class=\"$class\""
				. " onclick=\"showOrigin("
				. $matches[2] . ")\">"
				. "[[" . $matches[4] . "]]"
				. "</span>";
		}
		return $output;
	}

	static function color_t2trust( $matches ) {
		return "{{#trust:" . $matches[1] . "," . $matches[2] . "," . $matches[3] . "}}";
	}

	static function color_fixup( &$colored_text )
	{
		if ( 0 ) {
			// TODO: I think these replacements are from broken XML parser?
			// Still needed?  (Luca working on fixing unpacking...) -Bo
			$colored_text = preg_replace( "/&apos;/", "'", $colored_text, -1 );
			$colored_text = preg_replace( "/&amp;/", "&", $colored_text, -1 );
			$colored_text = preg_replace( "/&lt;/", "<", $colored_text, -1 );
			$colored_text = preg_replace( "/&gt;/", ">", $colored_text, -1 );
		}
	}


	public static function ucscArticleSaveComplete( &$article,
		&$user, $text, $summary,
		&$minoredit, $watchthis,
		$sectionanchor, &$flags,
		$revision, &$status, $baseRevId )
	{
		$page_id = $article->getTitle()->getArticleID();
		$rev_id = $revision->getID();
		$user_id = $user->getID();

		if ( self::runEvalEdit( self::TRUST_EVAL_EDIT,
			$rev_id,
			$page_id,
			$user_id ) >= 0 ) {
			return true;
		}
		return false;
	}

	// Cache control -- invalidate the cache if someone voted on the
	// page recently, or if the colored page is invalid.
	// This function does this by making the sure the last
	// modified time of the page is set to now() if we don't want
	// output cached.
	public static function ucscOutputModified( &$modified_times )
	{
		# We are done if the trust tab isn't selected
		global $wgRequest;
		$use_trust = $wgRequest->getVal( 'trust' );
		if ( !isset( $use_trust ) ||
			( ( $wgRequest->getVal( 'action' ) &&
			( $wgRequest->getVal( 'action' ) != 'purge' ) ) ) )
			return true;
		wfWikiTrustDebug(__FILE__.":".__LINE__
			. ": " . print_r( $modified_times, true ) );

		// Load the colored text if the text is available.
		// We do it here because this is the first hook to be fired as a page
		// is rendered.
		// We don't need to check if colored_text is already present, because
		// of this hook ordering.
		// We need to know if the colored text is missing or not, and just getting
		// it seems like the easiest way to figure this out.
		$rev_id = self::util_getRev();
		list( $page_title, $page_id, $rev_id ) = self::util_ResolveRevSpec( null, 0, $rev_id );
		$colored_text = WikiTrust::color_getColorData( $page_title, $page_id, $rev_id );
		self::color_fixup( $colored_text );
		self::$colored_text = $colored_text;
		self::$colored_text_loaded = true;

		// Update the cache with the current time if we need to invalide it
		//   for this page.
		// Reasons for this are missing text or a vote which needs to be
		//   processed still.
		if ( !self::$colored_text || WikiTrust::voteToProcess( $rev_id ) ) {
			$modified_times['page'] = wfTimestampNow();
			wfWikiTrustDebug( __FILE__ . ":" . __LINE__
				. ": new times - " . print_r( $modified_times, true ) );
		}
		return true;
	}

	// TrustTabSkin - add trust tab to display, and select if appropriate
	public static function ucscTrustTemplate( $skin, &$content_actions )
	{
		global $wgRequest;

		$url = $_SERVER[REQUEST_URI];
		wfWikiTrustDebug( __FILE__ . ":" . __LINE__ . ": Original URL: $url" );
		if ( !preg_match( "/[?&]trust\b/", $url ) ) {
			$url = preg_replace("/&?action=\w+\b/", '', $url);
			$url = preg_replace("/&?diff=\d+\b/", '', $url);
			$connector = '&';
			if ( !preg_match( "/\?/", $url ) ) $connector = '?';
				$url = $url . $connector . 'trust';
		}

		$content_actions['trust'] = array (
			'class' => '',
			'text' => wfMsgNoTrans( "wgTrustTabText" ),
			'href' => $url
		);

		$use_trust = $wgRequest->getVal( 'trust' );
		if ( isset( $use_trust ) ) {
			$content_actions['trust']['class'] = 'selected';
			$content_actions['nstab-main']['class'] = '';
			$content_actions['nstab-main']['href'] .= '';
		} else {
			$content_actions['trust']['href'] .= '';
		}
		return true;
	}

	/**
	 * Returns colored markup.
	 *
	 * @return colored markup.
	 */
	static function ajax_getColoredText( $page_title,
		$page_id = 0,
		$rev_id = 0 )
	{
		global $wgTitle, $wgMemc;
		wfWikiTrustDebug( __FILE__ . ":" . __LINE__
			. ": ajax_getColoredText($page_title, $page_id, $rev_id)" );

		list( $page_title, $page_id, $rev_id ) = self::util_ResolveRevSpec( $page_title, $page_id, $rev_id );

		wfWikiTrustDebug( __FILE__ . ":" . __LINE__ . ": computed=($page_title, $page_id, $rev_id)" );

		// See if we have a cached version of the colored text, or if
		// we need to generate new text.
		$memcKey = wfMemcKey( 'revisiontext', 'revid', $rev_id );
		$cached_text = $wgMemc->get( $memcKey );
		if ( $cached_text ) {
			wfWikiTrustDebug( __FILE__ . ":"
				. __LINE__ . " $rev_id: using cached text." );
			$response = new AjaxResponse( "" );
			$response->addText( $cached_text );
			return $response;
		}

		wfWikiTrustDebug(__FILE__ . ":"
			. __LINE__ . " $memcKey: not cached.");

		try {
			$colored_text = WikiTrust::color_getColorData( $page_title, $page_id, $rev_id );
			self::color_fixup( $colored_text );
		} catch ( Exception $e ) {
			wfWikiTrustDebug( __FILE__ . ":" . __LINE__
			. ": exception caught: " . $e->getMessage() );
		}
		$text = '';

		if ( !$colored_text ) {
			wfWikiTrustDebug( __FILE__ . ":"
			. __LINE__ . " $rev_id: colored text not found." );
			// text not found.
			global $wgUser, $wgParser, $wgTitle;
			$options = ParserOptions::newFromUser( $wgUser );
			$msg = $wgParser->parse( wfMsgNoTrans( "wgNoTrustExplanation" ),
				$wgTitle,
				$options );
			$text = $msg->getText() . $text;
		} else {
			self::color_Wiki2Html( $colored_text, $text, $rev_id );
			self::vote_showButton( $text );
			self::color_addTracker( $text );
			// Save the finished text in the cache.
			$wgMemc->set( $memcKey, $text );
			wfWikiTrustDebug( __FILE__ . ":"
				. __LINE__ . " $memcKey: saving to cache. " );
		}
		return new AjaxResponse( $text );
	}

	/**
	 * Actually run the eval edit program.
	 * Returns -1 on error, the process id of the launched eval process
	 * otherwise.
	 */
	private static function runEvalEdit( $eval_type = self::TRUST_EVAL_EDIT,
		$rev_id = -1, $page_id = -1,
		$voter_name = "" )
	{
		global $wgDBname, $wgDBuser, $wgDBpassword, $wgDBserver, $wgDBtype, $wgWikiTrustCmd, $wgWikiTrustLog, $wgWikiTrustDebugLog, $wgWikiTrustRepSpeed, $wgDBprefix, $wgWikiTrustCmdExtraArgs, $wgWikiTrustBlobPath, $wgWikiTrustRobots;

		if ( $wgWikiTrustBlobPath ) {
			$wgWikiTrustCmdExtraArgs .= " -blob_base_path " . $wgWikiTrustBlobPath;
		}

		if ( $wgWikiTrustRobots ) {
			$wgWikiTrustCmdExtraArgs .= " -robots " . $wgWikiTrustRobots;
		}

		$process = -1;
		$command = "";
		// Get the db.
		$dbr = wfGetDB( DB_SLAVE );

		// Do we use a DB prefix?
		$prefix = ($wgDBprefix)? "-db_prefix " . $dbr->strencode($wgDBprefix): "";

		switch ($eval_type) {
		case self::TRUST_EVAL_EDIT:
			$command = escapeshellcmd("$wgWikiTrustCmd -rep_speed $wgWikiTrustRepSpeed -log_file $wgWikiTrustLog -db_host $wgDBserver -db_user $wgDBuser -db_pass $wgDBpassword -db_name $wgDBname $prefix $wgWikiTrustCmdExtraArgs") . " &";
			break;
		case self::TRUST_EVAL_VOTE:
			if ( $rev_id == -1 || $page_id == -1 || $voter_name == "" )
				return -1;
			$command = escapeshellcmd("$wgWikiTrustCmd -eval_vote -rev_id " . $dbr->strencode($rev_id) . " -voter_name " . $dbr->strencode($voter_name) . " -page_id " . $dbr->strencode($page_id) . " -rep_speed $wgWikiTrustRepSpeed -log_file $wgWikiTrustLog -db_host $wgDBserver -db_user $wgDBuser -db_pass $wgDBpassword -db_name $wgDBname $prefix $wgWikiTrustCmdExtraArgs") . " &";
			break;
		}

		$descriptorspec = array(
			0 => array("pipe", "r"),
			1 => array("file", escapeshellcmd($wgWikiTrustDebugLog), "a"),
			2 => array("file", escapeshellcmd($wgWikiTrustDebugLog), "a")
		);

		$cwd = '/tmp';
		$env = array();
		wfWikiTrustDebug( __FILE__ . ":" . __LINE__
			. ": runEvalEdit: " . $command);
		$process = proc_open($command, $descriptorspec, $pipes, $cwd, $env);

		return $process;
	}


	static function user_GetIdFName( &$dbr, $userName )
	{
		if ( preg_match( "/^\d+\.\d+\.\d+\.\d+$/", $userName ) )
			return 0; // IP addrs are anonymous

		$res = $dbr->select( 'user', array( 'user_id' ),
			array( 'user_name' => $userName ), array() );
		if ( $res && $dbr->numRows( $res ) > 0 ) {
			$row = $dbr->fetchRow( $res );
			$user_id = $row['user_id'];
			if ( !$user_id )
				$user_id = 0;
		}
		$dbr->freeResult( $res );

		return $user_id;
	}

	static function util_ResolveRevSpec( $page_title, $page_id=0, $rev_id=0 )
	{
		global $wgTitle;

		$dbr = wfGetDB( DB_SLAVE );

		if ( $rev_id && !$page_id ) {
			$rev = Revision::loadFromId( $dbr, $rev_id );
			if ( $rev ) $page_id = $rev->getPage();
		}
		if ( $page_id && !$page_title )
			$wgTitle = Title::newFromID( $page_id );
		if ( $page_title )
			$wgTitle = Title::newFromDBkey( $page_title );

		$article = new Article( $wgTitle );
		$title_db = $wgTitle->getDBkey();
		$page_id_db = $wgTitle->getArticleID();
		$rev_id_db = $article->getLatest();
		if ( !$page_id ) $page_id = $page_id_db;
		if ( !$rev_id ) $rev_id = $rev_id_db;
		if ( !$page_title ) $page_title = $title_db;
		if ( $page_id != $page_id_db )
			wfWikiTrustWarn( __FILE__ . ":" . __LINE__ . ": mismatched pageId: $page_id != $page_id_db" );
		if ($page_title != $title_db)
			wfWikiTrustWarn( __FILE__ . ":" . __LINE__ . ": mismatched title: $page_title != $title_db" );

		return array($page_title, $page_id, $rev_id);
	}


	/**
	 * Utility function which returns the revid of the revision which is
	 * currently being displayed.
	 *
	 * This is a replacement for getRevFTitle() and eliminates 1 db call.
	 */
	static function util_getRevFArticle()
	{
		global $wgTitle;
		return $wgTitle->getLatestRevID();
	}

	// Returns the current revid from the $out object.
	static function util_getRevFOut( $out )
	{
		if ( method_exists( $out, "getRevisionId" ) )
			$rev_id = $out->getRevisionId();
		else
			$rev_id = $out->mRevisionId;

		if ( !$rev_id ) {
			$rev_id = self::util_getRevFArticle();
		}

		return $rev_id;
	}

	// Likewise, this returns the current revid.
	// If oldid is set, it returns this.
	// Otherwise, it called util_getRevFArticle().
	static function util_getRev()
	{
		global $wgRequest;
		$rev_id = $wgRequest->getVal( 'oldid' );
		if ( !$rev_id ) {
			$rev_id = self::util_getRevFArticle();
		}

		return $rev_id;
	}

	// Extract text from a blob
	static function util_extractFromBlob( $rev_id, $blob_content ) {
		$parts = explode( ":", $blob_content, 2 );
		$headers = array();
		preg_match_all( "/\((\d+) (\d+) (\d+)\)/", $parts[0], $headers, PREG_SET_ORDER );

		$offset = 0;
		$size = 0;
		for ( $i = 0; $i < count( $headers ); $i++ ) {
			if ( $headers[$i][1] == $rev_id ) {
				$offset = $headers[$i][2];
				$size = $headers[$i][3];
			}
		}

		return substr( $parts[1], $offset, $size );
	}

	static function util_getRevFilename( $page_id, $blob_id )
	{
		$page_str = sprintf( "%012d", $page_id );
		$blob_str = sprintf( "%09d", $blob_id );
		global $wgWikiTrustBlobPath;
		$path = $wgWikiTrustBlobPath;
		for ( $i = 0; $i <= 3; $i++ ){
			$path .= "/" . substr( $page_str, $i*3, 3 );
		}
		//$path .= "/" . substr($rev_str, 6, 3);
		if ( $blob_id >= 1000 ) {
			$path .= "/" . sprintf( "%06d", $blob_id );
		}
		$path .= "/" . $page_str . "_" . $blob_str . ".gz";
		return $path;
	}

	static function util_getDbTable( $table )
	{
		global $wgDBprefix;
		return ( $wgDBprefix ? $wgDBprefix . $table : $table );
	}

	static function debug( $msg, $level )
	{
		global $wgWikiTrustDebugLog, $wgWikiTrustDebugVerbosity;

		if ( $level >= $wgWikiTrustDebugVerbosity )
			file_put_contents( $wgWikiTrustDebugLog,
				$msg . PHP_EOL,
				FILE_APPEND | LOCK_EX );
	}
}

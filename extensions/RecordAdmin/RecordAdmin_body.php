<?php
/**
 * Define a new class based on the SpecialPage class
 */
class SpecialRecordAdmin extends SpecialPage {

	var $form      = '';
	var $formClass = '';
	var $formAtts  = '';
	var $type      = '';
	var $editable  = false;
	var $record    = '';
	var $types     = array();
	var $values    = array();
	var $orderBy   = '';
	var $desc      = false;
	var $guid      = '';
	var $quid      = '';
	var $filter    = array();
	var $acturl    = '';
	var $done      = false;

	function __construct() {
		global $wgHooks, $wgParser, $wgRequest, $wgRecordAdminTag, $wgRecordAdminCategory,
			$wgRecordAdminTag, $wgRecordAdminTableMagic, $wgRecordAdminDataMagic;

		# Name to use for creating a new record either via RecordAdmin or a public form
		# todo: should add a hook here for custom default-naming
		$this->guid = strftime( '%Y%m%d', time() ) . '-' . substr( strtoupper( uniqid('', true) ), -5 );
		wfLoadExtensionMessages ( 'RecordAdmin' );
		SpecialPage::SpecialPage( 'RecordAdmin', 'recordadmin', true, false, 'default', true );

		# Make recordID's of articles created with public forms available via recordid tag
		$wgParser->setHook( $wgRecordAdminTag, array( $this, 'expandTag' ) );

		# Add the parser-functions
		$wgParser->setFunctionHook( $wgRecordAdminTableMagic, array( $this, 'expandTableMagic' ) );
		$wgParser->setFunctionHook( $wgRecordAdminDataMagic,  array( $this, 'expandDataMagic'  ) );

		# A minimal hook so we know if the page has been rendered or not
		# (so that record tables don't execute when run from the job-queue - looking for a better way to do this)
		$wgHooks['BeforePageDisplay'][] = $this;

		# Get the current title accounting for redirect
		$title = Title::newFromText( $wgRequest->getText( 'title' ) );
		if ( is_object( $title ) && $title->isRedirect() ) {
			$article = new Article( $title );
			$content = $article->getContent();
			if ( preg_match( '/\[\[(.+?)\]\]/', $content, $m ) ) $title = Title::newFromText( $m[1] );
		}

		if ( is_object( $title ) ) {

			# Check if posting a public creation form
			if ( $title->getNamespace() != NS_SPECIAL && $wgRequest->getText( 'wpType' ) && $wgRequest->getText( 'wpCreate' ) )
				$this->createRecord();

			# Add some hooks if the current title is a record
			$uses = '';
			$id   = $title->getArticleID();
			$dbr  = &wfGetDB( DB_SLAVE );
			$cat  = $dbr->addQuotes( $wgRecordAdminCategory );
			$cl   = $dbr->tableName( 'categorylinks' );
			$tl   = $dbr->tableName( 'templatelinks' );
			$res  = $dbr->select( $cl, 'cl_from', "cl_to = $cat" );
			while ( $row = $dbr->fetchRow( $res ) ) $uses .= " OR tl_title=" . $dbr->addQuotes( Title::newFromID( $row[0] )->getText() );
			$dbr->freeResult( $res );
			if ( $uses && $row = $dbr->selectRow( $tl, 'tl_title', "tl_from = $id AND (0 $uses)" ) ) {
				global $wgRecordAdminEditWithForm, $wgRecordAdminAddTitleInfo;
				$this->type = $row->tl_title;

				# Add title info
				if ( $wgRecordAdminAddTitleInfo ) $wgHooks['OutputPageBeforeHTML'][] = $this;

				# Add an "edit with form" action link
				if ( $wgRecordAdminEditWithForm ) {
					$wgHooks['SkinTemplateTabs'][] = $this;
					$qs = "wpType={$this->type}&wpRecord=" . $title->getPrefixedText();
					$this->acturl = Title::makeTitle( NS_SPECIAL, 'RecordAdmin' )->getLocalURL( $qs );
				}
			}
		}
	}

	/**
	 * Store the fact that this hook has executed so we don't run record tables from job queue
	 */
	function onBeforePageDisplay( &$out, $skin = false ) {
		return $this->done = true;
	}

	/**
	 * Add record type info below title
	 */
	function onOutputPageBeforeHTML( &$out, &$text ) {
		$text = '<div class="recordadmin-typeinfo">' . wfMsg( 'recordadmin-typeinfo', $this->type ) . "</div>\n" . $text;
		return true;
	}

	/**
	 * Add action link
	 */
	function onSkinTemplateTabs( $skin, &$actions ) {
		$tmp = array();
		foreach ( $actions as $k => $v ) {
			$tmp[$k] = $v;
			if ( $k == 'edit' ) $tmp['editwithform'] = array(
				'text' => wfMsg( 'recordadmin-editwithform' ),
				'class' => false,
				'href' => $this->acturl
			);
		}
		$actions = $tmp;
		return true;
	}

	/**
	 * Override SpecialPage::execute()
	 */
	function execute( $param ) {
		global $wgVersion, $wgOut, $wgRequest, $wgRecordAdminUseNamespaces, $wgLang, $wgRecordAdminCategory, $wgSecurityProtectRecords;
		if ( !isset( $wgSecurityProtectRecords ) ) $wgSecurityProtectRecords = false;
		$this->setHeaders();
		$type     = $wgRequest->getText( 'wpType' ) or $type = $param;
		$newtype  = $wgRequest->getText( 'wpNewType' );
		$invert   = $wgRequest->getText( 'wpInvert' );
		$record   = $this->record = $wgRequest->getText( 'wpRecord' );
		$title    = $this->title = Title::makeTitle( NS_SPECIAL, 'RecordAdmin' );
		$action   = $title->getLocalURL( 'action=submit' );
		$wpTitle  = trim( $wgRequest->getText( 'wpTitle' ) );
		$this->template = Title::makeTitle( NS_TEMPLATE, $type );

		if ( $type && $wgRecordAdminUseNamespaces ) {
			if ( $wpTitle && !ereg( "^$type:.+$", $wpTitle ) ) $wpTitle = "$type:$wpTitle";
		}
		$wgOut->addHTML(
			'<div class="recordadmin-menubar"><a href="' . $title->getLocalURL() . "/$type\">" . wfMsg( 'recordadmin-newsearch', $type ) . '</a>'
			. '&nbsp;'
			. '<a href="' . $title->getLocalURL() . '">' . wfMsg( 'recordadmin-newrecord' ) . '</a></div>'."\n"
		);

		# Get posted form values if any
		$posted = array();
		foreach ( $_REQUEST as $k => $v ) if ( preg_match( '|^ra_(\\w+)|', $k, $m ) ) $posted[$m[1]] = is_array( $v ) ? join( "\n", $v ) : $v;
		$this->filter = $posted;

		# Read in and prepare the form for this record type if one has been selected
		if ( $type ) $this->preProcessForm( $type );

		# Extract the input names and types used in the form
		$this->examineForm();

		# Process Create New Type form if submitted and user permitted
		if ( $newtype ) {
			$this->createRecordType( $newtype );
			$type = '';
		}

		# If no type selected, render form for record types and create record-type
		if ( empty( $type ) ) {
			$wgOut->addHTML( Xml::element( 'form', array( 'class' => 'recordadmin', 'action' => $action, 'method' => 'post' ), null ) );
			$wgOut->addWikiText( "<div class='visualClear'></div>\n==" . wfMsg( 'recordadmin-select' ) . "==\n" );

			# Get titles in $wgRecordAdminCategory and build option list
			$options = '';
			$dbr  = wfGetDB( DB_SLAVE );
			$cl   = $dbr->tableName( 'categorylinks' );
			$cat  = $dbr->addQuotes( $wgRecordAdminCategory );
			$res  = $dbr->select( $cl, 'cl_from', "cl_to = $cat", __METHOD__, array( 'ORDER BY' => 'cl_sortkey' ) );
			while ( $row = $dbr->fetchRow( $res ) ) $options .= '<option>' . Title::newFromID( $row[0] )->getText() . '</option>';

			# Render type select list
			if ( $options ) $wgOut->addHTML(
				"<select name='wpType'>$options</select>&nbsp;"
				. Xml::element( 'input', array( 'type' => 'submit', 'value' => wfMsg( 'recordadmin-submit' ) ) )
			);
			else {
				# No records found in $wgRecordAdminCategory
				$cat = Title::newFromText( $wgRecordAdminCategory, NS_CATEGORY );
				$wgOut->AddWikiText( wfMsg( 'recordadmin-categoryempty', $cat->getPrefixedText() ) );
			}

			# Render type create
			$wgOut->addWikiText( "<br />\n==" . wfMsg( 'recordadmin-createtype' ) . "==\n" );
			$wgOut->addHTML( Xml::element( 'input', array( 'name' => 'wpNewType', 'type' => 'text' ) )
				. '&nbsp;'
				. Xml::element( 'input', array( 'type' => 'submit', 'value' => wfMsg( 'recordadmin-buttoncreate' ) ) )
				. '</form>'
			);

		}

		# Record type known, but no record selected, render form for searching or creating
		elseif ( empty( $record ) ) {

			# Process Create submission
			if ( count( $posted ) && $wgRequest->getText( 'wpCreate' ) ) {
				if ( empty( $wpTitle ) ) {
					$wpTitle = $this->guid;
					if ( $wgRecordAdminUseNamespaces ) $wpTitle = "$type:$wpTitle";
				}
				$t = Title::newFromText( $wpTitle );
				if ( is_object( $t ) ) {
					if ( $t->exists() ) $wgOut->addHTML( "<div class='errorbox'>" . wfMsg( 'recordadmin-alreadyexist' , $wpTitle ) . "</div>\n" );
					else {

						# Attempt to create the article
						$article = new Article( $t );
						$summary = "[[Special:RecordAdmin/$type|" . wfMsgForContent( 'recordadmin' ) . "]]: " . wfMsg( 'recordadmin-summary-typecreated', $type );
						$success = $article->doEdit( $this->valuesToText( $type, $posted ), $summary, EDIT_NEW );

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
			$this->populateForm( $posted );

			# Process Find submission (select and render records)
			if ( count( $posted ) && $wgRequest->getText( 'wpFind' ) ) {
				$wgOut->addWikiText( "== " . wfMsg( 'recordadmin-searchresult' ) . " ==\n" );
				$records = $this->getRecords( $type, $posted, '=', $wpTitle, $invert );
				$wgOut->addHTML( $this->renderRecords( $records ) );
			}

			# Render the form
			$wgOut->addHTML( "<br /><form class=\"{$this->formClass}\"{$this->formAtts} action=\"$action\" method=\"POST\">" );
			$wgOut->addWikiText( "==" . wfMsg( 'recordadmin-create', $type ) . "==\n" );
			$wgOut->addHTML(
				'<table class="recordadmin-create">'
				. '<tr><td class="recordadmin-create-id"><b>' . wfMsg( 'recordadmin-recordid' ) . '</b>&nbsp;' . Xml::element( 'input', array( 'name' => 'wpTitle', 'size' => 30, 'value' => $wpTitle ) )
				. '&nbsp;&nbsp;&nbsp;' . Xml::element( 'input', array( 'name' => 'wpInvert', 'type' => 'checkbox' ) ) . ' ' . wfMsg( 'recordadmin-invert' )
				. '</td></tr>'
				. '<tr><td>' . $this->form . '</td></tr>'
				. '<tr><td>' . Xml::element( 'input', array( 'type' => 'hidden', 'name' => 'wpType', 'value' => $type ) ) . '</td></tr>'
				. '<tr><td>'
				. Xml::element( 'input', array( 'type' => 'submit', 'name' => 'wpFind', 'id' => 'ra-find', 'value' => wfMsg( 'recordadmin-buttonsearch' ) ) )
				. Xml::element( 'input', array( 'type' => 'submit', 'name' => 'wpCreate', 'id' => 'ra-create', 'value' => wfMsg( 'recordadmin-buttoncreate' ) ) )
				. Xml::element( 'input', array( 'type' => 'reset', 'value' => wfMsg( 'recordadmin-buttonreset' ) ) )
				. '</td></tr>'
				. '</table></form>'
			);
		}

		# A specific record has been selected, render form for updating
		else {
			if ( !$wgSecurityProtectRecords || $this->template->userCan( 'read' ) ) {
				$rtitle = Title::newFromText( $record );
				$article = new Article( $rtitle );
				$text = $article->fetchContent();
				$wgOut->addWikiText( "== " . wfMsg( 'recordadmin-edit', $rtitle->getPrefixedText(), $type ) . " ==\n" );

				# Update article if form posted
				if ( count( $posted ) && $rtitle->userCan( 'edit', false ) ) {
					$summary = $wgRequest->getText( 'wpSummary' ) or $summary = wfMsgForContent( 'recordadmin-typeupdated', $type );
					$minor   = $wgRequest->getText( 'wpMinoredit' ) ? EDIT_MINOR : 0;
					$watch   = $wgRequest->getText( 'wpWatchthis' );

					# Get the location and length of the record braces to replace
					foreach ( $this->examineBraces( $text ) as $brace ) if ( $brace['NAME'] == $type ) $braces = $brace;

					# Attempt to save the article if allowed
					if ( !$wgSecurityProtectRecords || $this->template->userCan( 'edit' ) ) {
						$summary = "[[Special:RecordAdmin/$type|" . wfMsgForContent( 'recordadmin' ) . "]]: $summary";
						$text = substr_replace( $text, $this->valuesToText( $type, $posted, $text ), $braces['OFFSET'], $braces['LENGTH'] );
						$success = $article->doEdit( $text, $summary, EDIT_UPDATE|$minor );
						if ($watch) $article->doWatch();
					} else $success = false;

					# Redirect to view the record if successfully updated
					if ( $success ) {
						$wgOut->disable();
						wfResetOutputBuffers();
						header( "Location: " . $rtitle->getFullUrl() );
					}

					# Stay at edit form and render error if not edited successfully
					else $wgOut->addHTML( "<div class='errorbox'>" . wfMsg( 'recordadmin-updateerror' ) . "</div>\n" );
					$wgOut->addHTML( "<br /><br /><br /><br />\n" );
				}

				# Extract current values from article
				$braces = false;
				foreach ( $this->examineBraces( $text ) as $brace ) if ( $brace['NAME'] == $type ) $braces = $brace;
				if ( $braces ) {

					# Fill in current values
					$this->populateForm( substr( $text, $braces['OFFSET'], $braces['LENGTH'] ) );

					# Render the form
					$wgOut->addHTML( "<form class=\"{$this->formClass}\"{$this->formAtts} action=\"$action\" method=\"POST\">" );
					$wgOut->addHTML( $this->form );
					$wgOut->addHTML( Xml::element( 'input', array( 'type' => 'hidden', 'name' => 'wpType', 'value' => $type ) ) );
					$wgOut->addHTML( Xml::element( 'input', array( 'type' => 'hidden', 'name' => 'wpRecord', 'value' => $record ) ) );
					$wgOut->addHTML( '<br /><hr /><br />'
						. "<span id='wpSummaryLabel'><label for='wpSummary'>Summary:</label></span>&nbsp;"
						. Xml::element( 'input', array( 'type' => 'text', 'name' => 'wpSummary', 'id' => 'wpSummary', 'maxlength' => '200', 'size' => '60' ) )
						. "<br />\n"
						. Xml::element( 'input', array( 'type' => 'checkbox', 'name' => 'wpMinoredit', 'value' => '1', 'id' => 'wpMinoredit', 'accesskey' => 'i' ) )
						. "&nbsp;<label for='wpMinoredit' title='Mark this as a minor edit [i]' accesskey='i'>This is a minor edit</label>&nbsp;"
						. Xml::element( 'input', array( 'type' => 'checkbox', 'name' => 'wpWatchthis', 'value' => '1', 'id' => 'wpWatchthis', 'accesskey' => 'w' ) )
						. "&nbsp;<label for='wpWatchthis' title='Add this page to your watchlist [w]' accesskey='w'>Watch this page</label>\n"
						. "<br />\n"
						. ( ( !$wgSecurityProtectRecords || $this->template->userCan( 'edit' ) )
							? Xml::element( 'input', array( 'type' => 'submit', 'value' => wfMsg( 'recordadmin-buttonsave' ) ) ) . '&nbsp;'
							: '' )
						. Xml::element( 'input', array( 'type' => 'reset', 'value' => wfMsg( 'recordadmin-buttonreset' ) ) ) . '</form>'
					);
				}

				# No instance of the template found, just display the article content
				else $wgOut->addWikiText( $text );
			}
			
			else {
				$wgOut->addWikiText( wfMsg( 'badaccess-read', $record ) );
			}
		}
	}

	/**
	 * Return an array of records given type and other criteria
	 */
	function getRecords( $type, $posted, $operator, $wpTitle = '', $invert = false, $orderby = 'created desc', $groupby = false, $format = false ) {
		global $wgRequest;

		# If the page is already rendered, don't run this query
		if ( $this->done ) return array();

		# Generate a unique id for this set of parameters
		$this->quid = md5( var_export( array( $type, $posted ), true ) );
		
		# If an export has been requested but not for this query-id, then bail with empty set
		if ( ( $export = $wgRequest->getText( 'quid' ) ) && $export != $this->quid ) return array();

		# First get all the articles using the type's template
		$records = array();
		$dbr  = wfGetDB( DB_SLAVE );
		$tbl  = $dbr->tableName( 'templatelinks' );
		$ty   = $dbr->addQuotes( $type );
		$res  = $dbr->select( $tbl, 'tl_from', "tl_namespace = 10 AND tl_title = $ty", __METHOD__ );

		# Loop through them adding only those that match the regex fields
		while ( $row = $dbr->fetchRow( $res ) ) {
			$t = Title::newFromID( $row[0] );
			if ( empty( $wpTitle ) || eregi( $wpTitle, $t->getPrefixedText() ) ) {
				$a = new Article( $t );
				$text = $a->getContent();
				$match = true;
				$r = array( 0 => $t, 'title' => $t->getPrefixedText() );
				foreach ( array_keys( $this->types ) as $k ) {
					$v = isset( $posted[$k] ) ? ( $this->types[$k] == 'bool' ? 'yes' : $posted[$k] ) : '';
					$ek = str_replace( '|', '\|', $k );
					if ( !preg_match( "|\s*\|\s*$ek\s*=|", $text ) ) $text .= "\n|$k=\n|"; # Treat non-existent fields as existing but empty
					$i = preg_match( "|^\s*\|\s*$ek\s*= *(.*?) *(?=^\s*[\|\}])|sm", $text, $m );
					$r[$k] = trim( isset( $m[1] ) ? $m[1] : '' );
					if ( $v && !( $i && $this->cmpCallback( $r[$k], $v, $operator[$k] ) ) ) $match = false;
				}
				if ( $invert ) $match = !$match;
				if ( $match ) $records[] = $r;
			}
		}
		$dbr->freeResult( $res );

		# Add the creation and modified date columns to the records
		foreach ( $records as $i => $r ) {
			$t = $r[0];
			$id = $t->getArticleID();
			$tbl = $dbr->tableName( 'revision' );
			$row = $dbr->selectRow(
				$tbl,
				'rev_timestamp',
				"rev_page = $id",
				__METHOD__,
				array( 'ORDER BY' => 'rev_timestamp' )
			);
			$records[$i]['created'] = $row->rev_timestamp;
			$row = $dbr->selectRow(
				$tbl,
				'rev_timestamp',
				"rev_page = $id",
				__METHOD__,
				array( 'ORDER BY' => 'rev_timestamp DESC' )
			);
			$records[$i]['modified'] = $row->rev_timestamp;
		}

		# Sort the records according to "orderby" parameter
		if ( $this->desc = eregi( ' +desc *$', $orderby ) ) $orderby = eregi_replace( ' +desc *$', '', $orderby );
		$this->orderBy = $orderby;
		usort( $records, array( $this, 'sortCallback' ) );

		# Group the records according to the "groupby" parameter
		if ( $groupby ) {
			$groupby = preg_split( '/\s*,\s*/', $groupby );
			$tmp = array();
			foreach ( $records as $r ) {
				$v0 = $r[$groupby[0]];
				unset( $r[$groupby[0]] );
				if ( !isset( $tmp[$v0] ) || !is_array( $tmp[$v0] ) ) $tmp[$v0] = array();
				if ( isset( $groupby[1] ) ) {
					$v1 = $r[$groupby[1]];
					unset( $r[$groupby[1]] );
					if ( !isset( $tmp[$v0][$v1] ) || !is_array( $tmp[$v0][$v1] ) ) $tmp[$v0][$v1] = array();
					$tmp[$v0][$v1][] = $r;
				} else $tmp[$v0][] = $r;
			}
			$records = $tmp;
		}
		$this->format  = $format;

		return $records;
	}

	/**
	 * Compares a field value according to its operator
	 * - $a is the field value for the current row
	 * - $b is the expression from the recordtable query
	 */
	function cmpCallback( $a, $b, $operator ) {
		$b = str_replace( '/', '\/', $b );
		switch ( $operator ) {
			case '=':
				$cond = preg_match( "/$b/i", $a );
			break;
			
			case '!=':
				$cond = !preg_match( "/$b/i", $a );
			break;
			
			default:
				$a = preg_replace( '|(\d\d)[-/](\d\d)[-/](\d\d\d\d)|', '$3/$2/$1', $a ); # hack for dd/mm/yyyy format - best to use yyyy-mm-dd
				$b = preg_replace( '|(\d\d)[-/](\d\d)[-/](\d\d\d\d)|', '$3/$2/$1', $b );
				if ( !is_numeric( $b ) && ereg( '[0-9]{4}', $b ) && $tmp = strtotime( $b ) ) {
					$b = $tmp;
					$a = strtotime( $a );
				}
				eval( "\$cond = \$a $operator \$b;" );
			break;
		}
		return $cond;
	}

	/**
	 * Compares two arrays by column
	 */
	function sortCallback( $row1, $row2 ) {
		if ( !isset( $row1[$this->orderBy] ) || !isset( $row1[$this->orderBy] ) ) return 0;
		if ( $row1[$this->orderBy] == $row2[$this->orderBy] ) return 0;
		$cmp = $row1[$this->orderBy] > $row2[$this->orderBy] ? 1 : -1;
		return $this->desc ? -$cmp : $cmp;
	}

	/**
	 * Render a set of records returned by getRecords() as an HTML table
	 */
	function renderRecords( $records, $cols = false, $sortable = true, $template = false, $name = 'wpSelect', $export = true, $groupby = false ) {
		global $wgParser, $wgTitle, $wgRequest;
		if ( count( $records ) < 1 ) return wfMsg( 'recordadmin-nomatch' );
		if ( $groupby ) $groupby = preg_split( '/\s*,\s*/', $groupby );

		$special  = Title::makeTitle( NS_SPECIAL, 'RecordAdmin' );
		$type     = $this->type;
		$sortable = $sortable ? ' sortable' : '';
		$br       = $sortable ? '<br />' : '';

		# Table header (col0-3 class atts are for backward compatibility, only use named from now on)
		$table = "<table class='recordadmin$sortable $type-record'>\n<tr>";
		$th = array(
			'select'   => "<th class='col-select'>"        . wfMsg( 'recordadmin-select' )       . "$br</th>",
			'title'    => "<th class='col0 col-title'>"    . wfMsg( 'recordadmin-title', $type ) . "$br</th>",
			'actions'  => "<th class='col1 col-actions'>"  . wfMsg( 'recordadmin-actions' )      . "$br</th>",
			'created'  => "<th class='col2 col-created'>"  . wfMsg( 'recordadmin-created' )      . "$br</th>",
			'modified' => "<th class='col3 col-modified'>" . wfMsg( 'recordadmin-modified' )     . "$br</th>"
		);
		foreach ( array_keys( $this->types ) as $col ) {
			$class = 'col' . preg_replace( '|\W|', '-', $col );
			$th[$col] = "<th class='$class'>$col$br</th>";
		}
		$tmp = array();
		$cols = $cols ? $cols : array_keys( $th );
		foreach ( $cols as $col ) {
			if ( $groupby == false || !in_array( $col, $groupby ) ) {
				$html = isset( $th[$col] ) ? $th[$col] : "<th>$col</th>";
				$table .= "$html\n";
				$tmp[] = $col;
			}
		}
		$cols = $tmp;
		$ncol = count( $cols );
		$table .= "</tr>\n";

		# If using grouping, reconstruct the record tree as a list including headings
		if ( $groupby ) {
			$td  = "<td colspan=\"$ncol\">";
			$tmp = array();
			foreach( $records as $k1 => $v1 ) {
				if ( empty( $k1 ) ) {
					$k1 = wfMsg( 'recordadmin-notset', $groupby[0] );
				}
				$tmp[] = "$td<h2>$k1</h2></td>\n";
				foreach( $v1 as $k2 => $v2 ) {
					if ( isset( $groupby[1] ) ) {
						if ( empty( $k2 ) ) {
							$k2 = wfMsg( 'recordadmin-notset', $groupby[1] );
						}
						$tmp[] = "$td<h3>$k2</h3></td>\n";
						foreach( $v2 as $v3 ) $tmp[] = $v3;
					} else $tmp[] = $v2;
				}
			}
			$records = $tmp;
		}

		# Table rows
		$stripe = '';
		foreach ( $records as $r ) {
			$stripe = $stripe ? '' : ' class="stripe"';
			if ( !is_array( $r ) ) {
				$stripe = '';
				$table .= "<tr>$r</tr>"; # Just add as HTML content if not a row
			} else {
				$table .= "<tr$stripe>";

				# Create special values for this row
				$tsc    = $this->formatDate( $r['created'] );
				$tsm    = $this->formatDate( $r['modified'] );
				$t      = $r[0];
				$u      = $t->getLocalURL();
				$col    = $r['title'];
				$ecol   = urlencode( $col );
				$sel    = "<input type='checkbox' name='{$name}[]' value='$col' checked />";

				# Render this row
				if ( $template ) {
					$text = '{'.'{'."$template|select=%SELECT%|title=$col|created=$tsc|modified=$tsm";
					foreach ( array_keys( $this->types ) as $col ) {
						$v = isset( $r[$col] ) ? $r[$col] : '';
						$text .= "|$col=$v";
					}
					$text .= '}}';
					$text = $wgParser->parse( $text, $wgTitle, $wgParser->mOptions, true, false )->getText();
					$text = preg_replace( "|&lt;(/?td.*?)&gt;|", "<$1>", $text );
					$text = str_replace( '%SELECT%', $sel, $text );
					$table .= "$text\n";
				} else {
					$row = array(
						'select'   => "<td class='col-select'>$sel</td>\n",
						'title'    => "<td class='col0 col-title'><a href='$u'>$col</a></td>",
						'actions'  => "<td class='col1 col-actions'><a href='" . $special->getLocalURL( "wpType=$type&wpRecord=$ecol" ) . "'>"
									  . wfMsg( 'recordadmin-editlink' ) . "</a></td>",
						'created'  => "<td class='col2 col-created'>$tsc</td>\n",
						'modified' => "<td class='col3 col-modified'>$tsm</td>\n",
					);
					foreach ( $cols as $col ) {
						if ( !isset( $row[$col] ) ) {
							$v = isset( $r[$col] ) ? $wgParser->parse( $r[$col], $wgTitle, $wgParser->mOptions, true, false )->getText() : '&nbsp;';
							$class = 'col' . preg_replace( '|\W|', '-', $col );
							$row[$col] = "<td class='$class'>$v</td>";
						}
						$table .= "$row[$col]\n";
					}
				}
				$table .= "</tr>\n";
			}
		}
		$table .= "</table>\n";

		# If export requested convert the table to csv and disable output etc
		if ( $quid = $wgRequest->getText( 'quid' ) ) {
			global $wgOut;
			$wgOut->disable();

			# PDF export
			if ( $wgRequest->getText( 'format' ) == 'pdf' ) {
				global $wgUploadDirectory;
				$file = "$wgUploadDirectory/" . uniqid( 'recordadmin' );
				$table = str_replace( '<table', '<table border', $table );
				file_put_contents( $file, $table );
				header("Content-Type: application/pdf");
				header( "Content-Disposition: attachment; filename=\"$quid.pdf\"" );
				putenv( "HTMLDOC_NOCGI=1" );
				$options = "--left 1cm --right 1cm --top 1cm --bottom 1cm --header ... --footer ... --bodyfont Arial --fontsize 8";
				passthru( "htmldoc -t pdf --format pdf14 $options --webpage $file" );
				@unlink( $file );
			}

			# CSV export
			else {
				header("Content-Type: text/html");
				header("Content-Disposition: attachment; filename=\"$quid.csv\"");
				preg_match_all( "|<td.*?>\s*(.*?)\s*</td>|s", $table, $data );
				$cols = $cols ? $cols : array_keys( $th );
				$csv = join( "\t", $cols );
				foreach ( $data[1] as $i => $cell ) {
					if ( $i % count( $cols ) == 0 ) {
						$csv .= "\n";
						$sep = "";
					} else $sep = "\t";
					$cell = strip_tags( $cell );
					$cell = preg_replace( "/[\\r\\n]+/m", "\\n", $cell );
					$csv .= "$sep$cell";
				}
				print $csv;
			}
			$table = '';
		}

		# Otherwise add export links
		elseif ( $export ) {
			$export = $export === true ? array( 'pdf', 'csv' ) : preg_split( "/\s*,\s*/", strtolower( $export ) );
			$qs = "wpType=$type&wpFind=1&quid={$this->quid}";
			foreach ( $this->filter as $k => $v ) $qs .= "&ra_$k=" . urlencode( $v );
			$url = $wgTitle->getLocalURL( $qs );
			if ( in_array( 'csv', $export ) ) {
				$table .= "\n<a class=\"recordadmin-export-csv\" href=\"$url\">" . wfMsg( 'recordadmin-export-csv' ) . "</a>";
			}
			if ( in_array( 'pdf', $export ) ) {
				$table .= "\n<a class=\"recordadmin-export-pdf\" href=\"$url&format=pdf\">" . wfMsg( 'recordadmin-export-pdf' ) . "</a>";
			}
		}

		return $table;
	}

	/**
	 * Take a MediaWiki timestamp and return a formatted date appropriate for sortable table
	 */
	function formatDate( $ts ) {
		global $wgLang;
		$ts = preg_replace( "|^(....)(..)(..)(..)(..)(..)|", "$1-$2-$3 $4:$5:$6", $wgLang->userAdjust( $ts ) );
		return date( 'd M Y, H:i', strtotime( $ts ) );
	}

	/**
	 * Read in and prepare the form (for use as a search filter) for passed record type
	 * - we're using the record's own form as a filter for searching for records
	 * - extract only the content from between the form tags and remove any submit inputs
	 * - also record the forms attributes and class if any
	 */
	function preProcessForm( $type ) {
		$this->type = $type;
		$this->formClass = strtolower( $type ) . '-record recordadmin';
		$this->formAtts = '';
		$title = Title::newFromText( $type, NS_FORM );
		if ( $title->exists() ) {

			# Get the form content
			$form = new Article( $title );
			$form = $form->getContent();
			
			# Extract form's class and other attributes (except method and action)
			if ( preg_match( "|<form\s*([^>]+)\s*>.+</form>|is", $form, $atts )) {
				if ( preg_match( "|class\s*=\s*[\"'](.+?)['\"]|", $atts[1], $m ) ) $this->formClass .= ' ' . $m[1];
				$this->formAtts = ' ' . trim( preg_replace( "/(class|action|method)\s*=\s*[\"'](.*?)['\"]/", "", $atts[1] ) );
			}
			
			# Process content
			$form = preg_replace( '#<input.+?type=[\'"]?submit["\']?.+?/(input| *)>#i', '', $form );    # remove submits
			$form = preg_replace( '#^.+?<form.*?>#is', '', $form );                                     # remove up to and including form open
			$form = preg_replace( '#</form>.+?$#is', '', $form );                                       # remove form close and everything after
			$form = preg_replace( '#name\s*=\s*([\'"])(.*?)\\1#is', 'name="ra_$2"', $form );            # prefix input names with ra_
			$form = preg_replace( '#(<select.+?>)\s*(?!<option/>)#is', '$1<option selected/>', $form ); # ensure all select lists have default blank
		}
		else {

			# Create a red link to the form if it doesn't exist
			$form = '<b>' . wfMsg( 'recordadmin-noform', $type ) . '</b>'
				. '<br /><a href="' . $title->getLocalURL( 'action=edit' )
				. '">(' . wfMsg( 'recordadmin-createlink' ) . ')</a><br />';
		}
		$this->form = $form;
	}


	/**
	 * Populates the form values from the passed values
	 * - $form is HTML text
	 * - $values may be a hash or wikitext template syntax
	 */
	function populateForm( $values ) {

		# If values are wikitext, convert to hash
		if ( !is_array( $values ) ) $values = $this->values = $this->valuesFromText( $values );

		# Add the values into the form's HTML depending on their type
		foreach( $this->types as $k => $type ) {

			# Get this input element's html text and position and length
			preg_match( "|<([a-z]+)[^<]+?name=\"ra_$k\\[?\\]?\".*?>(.*?</\\1>)?|is", $this->form, $m, PREG_OFFSET_CAPTURE );
			list( $html, $pos ) = $m[0];
			$len = strlen( $html );

			# Modify the element according to its type
			# - clears default value, then adds new value
			$v = isset( $values[$k] ) ? $values[$k] : '';
			switch ( $type ) {
				case 'text':
					$html = preg_replace( "|value\s*=\s*\".*?\"|i", "", $html );
					if ( $v ) $html = preg_replace( "|(/?>)$|", " value=\"$v\" $1", $html );
				break;
				case 'bool':
					$html = preg_replace( "|checked|i", "", $html );
					if ( $v ) $html = preg_replace( "|(/?>)$|", " checked $1", $html );
				break;
				case 'list':
					$html = preg_replace_callback( "|\{\{.+?\}\}|s", array( $this, 'parsePart' ), $html );
					$html = preg_replace( "|(<option[^<>]*) selected|i", "$1", $html ); # remove the currently selected option
					if ( $v ) {
						foreach( split( "\n", $v ) as $v ) {
							$v = htmlentities( preg_replace( "|([\[\]\|\\\(\)])|", "\\$1", $v ) );
							$html = preg_match( "|<option[^>]+value\s*=|is", $html )
								? preg_replace( "|(<option)([^>]+value\s*=\s*[\"']{$v}['\"])|is", "$1 selected$2", $html )
								: preg_replace( "|(<option[^>]*)(?=>$v</option>)|is", "$1 selected", $html );
						}
					}
				break;
				case 'blob':
					$html = preg_replace( "|>.*?(?=</textarea>)|is", ">$v", $html );
				break;
			}

			# Replace the element in the form with the modified html
			$this->form = substr_replace( $this->form, $html, $pos, $len );
		}

		# Parse any brace structures
		global $wgUser, $wgParser;
		$options = ParserOptions::newFromUser( $wgUser );
		$max = 25;
		do {
			$braces = false;
			foreach ( $this->examineBraces( $this->form ) as $brace ) {
				if ( $brace['DEPTH'] == 2 ) $braces = $brace;
			}
			if ( $braces ) {
				$part = substr( $this->form, $braces['OFFSET'], $braces['LENGTH'] );
				$html = $wgParser->parse( $part, $this->title, $options, true, true )->getText();
				$this->form = substr_replace( $this->form, $html, $braces['OFFSET'], $braces['LENGTH'] );
			}
		} while ( --$max > 0 && $braces );

	}

	/**
	 * Used to parse any braces in select lists when populating form
	 */
	function parsePart( $part ) {
		global $wgUser, $wgParser;
		$options = ParserOptions::newFromUser( $wgUser );
		$html = $wgParser->parse( $part[0], $this->title, $options, true, true )->getText();
		return preg_match( "|(<option.+</option>)|is", $html, $m ) ? $m[1] : '';
	}

	/**
	 * Returns an array of types used by the passed HTML text form
	 * - supported types, text, select, checkbox, textarea
	 */
	function examineForm() {
		$this->types = array();
		preg_match_all( "|<([a-z]+)[^<]+?name=\"ra_(.+?)\\[?\\]?\".*?>|i", $this->form, $m );
		foreach ( $m[2] as $i => $k ) {
			$tag = $m[1][$i];
			$type = preg_match( "|type\s*=\s*\"(.+?)\"|i", $m[0][$i], $n ) ? $n[1] : '';
			switch ( $tag ) {
				case 'input':
					switch ( $type ) {
						case 'checkbox':
							$this->types[$k] = 'bool';
						break;
						default:
							$this->types[$k] = 'text';
						break;
					}
				break;
				case 'select':
					$this->types[$k] = 'list';
				break;
				case 'textarea':
					$this->types[$k] = 'blob';
				break;
			}
		}
	}

	/**
	 * Return array of braces used and the name, position, length and depth
	 * See http://www.organicdesign.co.nz/MediaWiki_code_snippets
	 */
	function examineBraces( &$content ) {
		$braces = array();
		$depths = array();
		$depth = 1;
		$index = 0;
		while ( preg_match( "/\\{\\{\\s*([#a-z0-9_]*)|\\}\\}/is", $content, $match, PREG_OFFSET_CAPTURE, $index ) ) {
			$index = $match[0][1] + 2;
			if ( $match[0][0] == '}}' ) {
				$brace =& $braces[$depths[$depth - 1]];
				$brace['LENGTH'] = $match[0][1] - $brace['OFFSET'] + 2;
				$brace['DEPTH']  = $depth--;
			}
			else {
				$depths[$depth++] = count( $braces );
				$braces[] = array(
					'NAME'   => $match[1][0],
					'OFFSET' => $match[0][1]
				);
			}
		}
		return $braces;
	}

	/**
	 * Return array of args represented by passed template syntax
	 */
	function valuesFromText( $text ) {
		$values = array();
		preg_match_all( "|^\s*\|\s*(.+?)\s*= *(.*?) *(?=^\s*[\|\}])|sm", $text, $m );
		foreach ( $m[1] as $i => $k ) $values[$k] = $m[2][$i];
		return $values;
	}

	/**
	 * Return template syntax from passed array of values
	 * - use $current to pass existing text to preserve any values not present in the array
	 * - if $current is not set, then only values defined in the form are used
	 */
	function valuesToText( $type, $values, $current = false ) {
		
		# If there are current values, preserve any that aren't in the passed array
		if ( $current ) {
			foreach ( $this->valuesFromText( $current ) as $k => $v ) {
				if ( !isset( $values[$k] ) ) $values[$k] = $v;
			}
		}
		
		# Build the text from the array
		$text = '';
		foreach ( $values as $k => $v ) if ( $v && ($current || isset( $this->types[$k] ) ) ) {
			$v = trim( $v );
			if ( $this->types[$k] == 'bool' ) $v = 'yes';
			$text .= " | $k = $v\n";
		}
		$text = $text ? "{{" . "$type\n$text}}" : "{{" . "$type}}";

		return $text;
	}

	/**
	 * A callback for processing public forms
	 */
	function createRecord() {
		global $wgRequest, $wgRecordAdminUseNamespaces;
		$type = $wgRequest->getText( 'wpType' );
		$title = $wgRequest->getText( 'wpTitle' );

		# Get types in this kind of record from form
		$this->preProcessForm( $type );
		$this->examineForm();

		# Use guid if no title specified
		if ( empty( $title ) ) {
			$title = $this->guid;
			if ( $wgRecordAdminUseNamespaces ) $title = "$type:$title";
		}

		# Attempt to create the article
		$title = Title::newFromText( $title );
		if ( is_object( $title ) && !$title->exists() ) {
			$article = new Article( $title );
			$summary = wfMsg( 'recordadmin-newcreated' );
			$success = $article->doEdit( $this->valuesToText( $type, $_POST ), $summary, EDIT_NEW );
		}
	}

	/**
	 * Create a new record type
	 */
	function createRecordType( $newtype ) {
		global $wgOut, $wgRecordAdminCategory;

		$rtype = wfMsg( 'recordadmin-recordtype' ) . " ($newtype)";
		$ttitle = Title::newFromtext( $newtype, NS_TEMPLATE );
		$ftitle = Title::newFromtext( $newtype, NS_FORM );
		if ( !is_object( $ttitle ) || !is_object( $ftitle ) ) {
			$wgOut->addHTML( "<div class='errorbox'>" . wfMsg( 'recordadmin-createerror', $rtype ) . "</div>\n" );
		}
		$tttext = $ttitle->getPrefixedText();
		$fttext = $ftitle->getPrefixedText();

		# check if the template already exists
		if ( $ttitle->exists() ) {
			$wgOut->addHTML( "<div class='errorbox'>" . wfMsg( 'recordadmin-alreadyexist', $tttext ) . "</div>\n" );
		}

		# check if the form already exists
		elseif ( $ftitle->exists() ) {
			$wgOut->addHTML( "<div class='errorbox'>" . wfMsg( 'recordadmin-alreadyexist', $fttext ) . "</div>\n" );
		}

		# Attempt to create the template and form
		else {
			$summary = "[[Special:RecordAdmin/$newtype|" . wfMsgForContent( 'recordadmin' ) . "]]: " . wfMsg( 'recordadmin-summary-typecreated', $rtype );

			# Compose the content of the new template
			$cat  = Title::newFromText( $wgRecordAdminCategory, NS_CATEGORY )->getPrefixedText();
			$link = "[{{fullurl:$tttext|action=edit}} " . wfMsg( 'recordadmin-needscontent' ) . "]";
			$text = "<noinclude>[[$cat]]</noinclude>\n{| class=recordadmin-template\n\n$link\n\n|}<includeonly>[[Category:{$newtype}s]]</includeonly>";
			$article = new Article( $ttitle );
			$success = $article->doEdit( $text, $summary, EDIT_NEW );

			# If Template created successfully, try and create the form
			if ( $success ) {
				$cat = Title::newFromText( $wgRecordAdminCategory, NS_CATEGORY )->getPrefixedText();
				$url = $ftitle->getLocalUrl( 'action=edit' );
				$link = "<a href=\"$url\">" . wfMsg( 'recordadmin-needscontent' ) . "</a>";
				$text = "<html>\n\t<form>\n\t\t<table>\n\t\t$link\n\t\t</table>\n\t</form>\n</html>";
				$article = new Article( $ftitle );
				$success = $article->doEdit( $text, $summary, EDIT_NEW );
				if ( !$success ) $wgOut->addHTML( "<div class='errorbox'>" . wfMsg( 'recordadmin-createerror', $fttext ) . "</div>\n" );
			} else $wgOut->addHTML( "<div class='errorbox'>" . wfMsg( 'recordadmin-createerror', $tttext ) . "</div>\n" );

			# Report success
			if ( $success ) $wgOut->addHTML( "<div class='successbox'>" . wfMsg( 'recordadmin-createsuccess', $rtype ) . "</div>\n" );
		}
	}

	/**
	 * Render a record search in a parser-function
	 */
	function expandTableMagic( &$parser, $type ) {
		global $wgTitle;
		$parser->mOutput->mCacheTime = -1;
		$filter   = array();
		$op       = array();
		$title    = '';
		$name     = 'wpSelect';
		$invert   = false;
		$orderby  = 'created desc';
		$groupby  = false;
		$format   = false;
		$cols     = false;
		$sortable = true;
		$template = false;
		$count    = false;
		$export   = false;
		foreach ( func_get_args() as $arg ) if ( !is_object( $arg ) ) {
			if ( preg_match( "|^(.+?)\s*([=!<>]+)\s*(.+)$|i", $arg, $match ) ) {
				list( , $k, $o, $v ) = $match;
				if ( $k == 'title' ) $title = $v;
				elseif ( $k == 'name' )     $name     = $v;
				elseif ( $k == 'invert' )   $invert   = $v;
				elseif ( $k == 'orderby' )  $orderby  = $v;
				elseif ( $k == 'groupby' )  $groupby  = $v;
				elseif ( $k == 'format' )   $format   = $v;
				elseif ( $k == 'cols' )     $cols     = preg_split( '/\s*,\s*/', $v );
				elseif ( $k == 'sortable' ) $sortable = eregi( '1|yes|true|on', $v );
				elseif ( $k == 'template' ) $template = $v;
				elseif ( $k == 'count' )    $count    = $v;
				elseif ( $k == 'export' )   $export   = $v;
				else {
					$filter[$k] = $v;
					$op[$k] = $o;
				}
			}
		}
		$this->filter = $filter;
		$tmp = $this->type;
		$this->preProcessForm( $type );
		$this->examineForm();
		$records = $this->getRecords( $type, $filter, $op, $title, $invert, $orderby, $groupby, $format );
		if ( $count ) while ( count( $records ) > $count ) array_pop( $records );
		$table = $this->renderRecords( $records, $cols, $sortable, $template, $name, $export, $groupby, $format );
		$this->type = $tmp;

		return array( $table, 'noparse' => true, 'isHTML' => true );
	}

	/**
	 * Obtain a record or record field value from passed parameters
	 */
	function expandDataMagic( &$parser ) {
		$parser->mOutput->mCacheTime = -1;
		$regexp = '';
		foreach ( func_get_args() as $arg ) if ( !is_object( $arg ) ) {
			if ( preg_match( "|^(.+?)\s*=\s*(.+)$|", $arg, $match ) ) {
				list( , $k, $v ) = $match;
				if ( $k == 'type' ) $type = $v;
				elseif ( $k == 'record' ) $record = $v;
				elseif ( $k == 'field' ) $field = $v;
				else $regexp .= "AND old_text REGEXP('[|] *{$k} *= *{$v}[[:space:]]*[|}]')";
			}
		}
		
		# If a record and field name are specified, return the field value
		if ( isset( $type ) && isset( $record ) && isset( $field ) ) {
			$title = Title::newFromText( $record );
			if ( is_object( $title ) ) {
				$article = new Article( $title );
				$text = $article->getContent();
				$braces = false;
				foreach ( $this->examineBraces( $text ) as $brace ) if ( $brace['NAME'] == $type ) $braces = $brace;
				if ( $braces ) {
					$values = $this->valuesFromText( substr( $text, $braces['OFFSET'], $braces['LENGTH'] ) );
					return isset( $values[$field] ) ? $values[$field] : '';
				}
			}
		}

		# If record is not set, find first record matching the supplied field values
		if ( isset( $type ) && !isset( $record ) ) {
			$dbr = wfGetDB( DB_SLAVE );
			$row = $dbr->selectRow(
				array( 'page', 'revision', 'text', 'templatelinks' ),
				'page_id',
				"rev_id=page_latest AND old_id=rev_text_id AND tl_from=page_id AND tl_title='$type' $regexp",
				__METHOD__
			);
			if ( $row ) return Title::newFromId( $row->page_id )->getPrefixedText();
		}

		return '';
	}

	/**
	 * If a record was created by a public form, make last 5 digits of ID available via a tag
	 */
	function expandTag( $text, $argv, $parser ) {
		$parser->mOutput->mCacheTime = -1;
		return $this->guid ? substr( $this->guid, -5 ) : '';
	}

}

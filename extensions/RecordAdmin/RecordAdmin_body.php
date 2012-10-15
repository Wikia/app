<?php

class RecordAdmin {
	var $form        = '';
	var $formClass   = '';
	var $formAtts    = '';
	var $recordTypes = false;
	var $types       = array();
	var $values      = array();
	var $orderBy     = '';
	var $desc        = false;
	var $guid        = '';
	var $quid        = '';
	var $request     = array();
	var $done        = false;

	function __construct() {
		global $wgHooks, $wgParser, $wgRequest, $wgRecordAdminTag, $wgRecordAdminCategory,
			$wgRecordAdminTag;

		# Name to use for creating a new record either via RecordAdmin or a public form
		$this->guid();

		# Make recordID's of articles created with public forms available via recordid tag
		$wgParser->setHook( $wgRecordAdminTag, array( $this, 'expandTag' ) );

		# Add the parser-functions
		$wgParser->setFunctionHook( 'recordtable', array( $this, 'expandTableMagic' ) );
		$wgParser->setFunctionHook( 'recorddata',  array( $this, 'expandDataMagic'  ) );

		# Add the hooks to handle cache invalidation and edit-forms
		$wgHooks['BeforePageDisplay'][] = $this;
		$wgHooks['ArticleSave'][] = $this;
		$wgHooks['ArticleSaveComplete'][] = $this;
		$wgHooks['EditPage::showEditForm:initial'][] = array( $this, 'onEditPage' );

		# If this is not a request for the current page, don't run record-admin queries
		$this->done = ( $wgRequest->getText( 'oldid' ) > 0 );
	}


	/**
	* Store the fact that this hook has executed so we don't run record tables from job queue
	*/
	function onBeforePageDisplay( &$out, $skin = false ) {
		return $this->done = true;
	}


	/**
	 * Add record forms to page edit view
	 */
	function onEditPage( $editPage ) {
		global $wgOut, $wgJsMimeType, $wgStylePath, $wgRequest;

		# Allow normal edit operation if 'nora' in request
		if( $wgRequest->getText( 'nora' ) ) return true;

		# Extract each of the top-level template calls in the content that have associated forms
		# - note multiple records are now allowed in an article, but only one of each type
		$records = array();
		$content = $editPage->getContent();
		foreach( self::examineBraces( $content ) as $brace ) {
			if( array_key_exists( 'DEPTH', $brace ) && $brace['DEPTH'] == 2 ) {
				$name = $brace['NAME'];
				$form = Title::newFromText( $name, NS_FORM );
				if( is_object( $form ) && $form->exists() ) {
					$offset = $brace['OFFSET'];
					$length = $brace['LENGTH'];
					$records[$name] = substr( $content, $offset, $length );
					$content = substr_replace( $content, "\x07$name" . str_repeat( "\x07", $length - strlen( $name ) - 1 ), $offset, $length );
				}
			}
		}
		$count = count( $records );

		# If any were found, replace them with a simple {{type}} placeholder in the textarea
		if( $count > 0 ) {

			# Strip noincludes if any, they will be put back later
			$content = preg_replace( "|<noinclude>\s*\x07|", "\x07", $content );
			$content = preg_replace( "|(\x07+)\s*</noinclude>|", "$1", $content );

			# Replace the template calls with the simple {{type}} placeholder
			$editPage->textbox1 = preg_replace( "|\x07([^\x07]+)\x07+|", '{{$1}}', $content );

			# Add a tab for each type with a form filled in with the parameters from its template call
			$jsFormsList = array();
			$tabset = "<div class=\"tabset\">";
			$tabset .= "<fieldset><legend>" . wfMsgHtml( 'recordadmin-properties' ) . "</legend>";
			$tabset .= wfMsgExt( 'recordadmin-edit-info', array( 'parse' ), wfExpandUrl( $wgRequest->appendQuery( 'nora=1' ), PROTO_CURRENT ) ) . "</fieldset>";
			foreach( $records as $type => $record ) {
				$jsFormsList[] = "'$type'";
				$this->preProcessForm( $type );
				$this->examineForm();
				$values = $this->valuesFromText( $record );
				$this->populateForm( $values );
				$tabset .= "<fieldset><legend>$type " . strtolower( wfMsgHtml( 'recordadmin-properties' ) ) . "</legend>\n";
				$tabset .= "<form id=\"" . strtolower($type) . "-form\" class=\"{$this->formClass}\"{$this->formAtts}>$this->form</form>\n";
				$tabset .= "</fieldset>";
			}

			$tabset .= "</div>";
			$jsFormsList = join( ', ', $jsFormsList );

			# Add the tabset before the normal edit form
			$editPage->editFormTextTop = $tabset;

			# JS to add an onSubmit method that adds the record forms contents to hidden values in the edit form
			if( is_callable( array( $wgOut, 'addModules' ) ) ) {
				$wgOut->addModules( 'ext.recordadmin' );
			} else {
				global $wgRecordAdminExtPath;
				$wgOut->addScript( "<script type=\"$wgJsMimeType\" src=\"$wgRecordAdminExtPath/recordadmin.js\"></script>" );
				$wgOut->addScript( "<script type=\"$wgJsMimeType\">
					function raAddRecordFormSubmit() { jQuery( '#editform' ).submit( raRecordForms ); }
					$( raAddRecordFormSubmit );</script>"
				);
			}
			$wgOut->addScript( "<script type=\"$wgJsMimeType\">var forms = [ $jsFormsList ];</script>" );

		}


		return true;
	}


	/**
	 * Incorprate any posted record form's data into the article wikitext before saving
	 */
	function onArticleSave( &$article, &$user, &$text ) {

		# Organise the posted record data
		$data = array();
		foreach( $_REQUEST as $key => $value ) {
			if( preg_match( "|(.+):ra_(.+)|", $key, $m ) ) {
				if( is_array( $value ) ) $value = join( "\n", $value );
				$value = urldecode( $value );
				list( $key, $type, $field ) = $m;
				array_key_exists( $type, $data ) ? $data[$type][$field] = $value : $data[$type] = array( $field => $value );
			}
		}

		# Bail if no record data was posted
		if( count( $data ) == 0 ) return true;

		# Build the template syntax for each record and replace the current template or prepend if none
		foreach( $data as $type => $values ) {
			$this->preProcessForm( $type );
			$this->examineForm();
			$template = "<noinclude>" . $this->valuesToText( $type, $values ) . "</noinclude>";

			# Replace any instance of the template in the text with the new parameters
			$text = str_replace( '{{' . $type . '}}', $template, $text, $count );

			# If there were no matches, prepend it (either its newly added, or is a prepended one)
			if( $count == 0 ) $text = "$template\n$text";

		}

		return true;
	}


	/**
	 * Handles cache invalidation after a page is saved
	 */
	function onArticleSaveComplete( &$article, &$user, $text ) {
		return true;
	}


	/**
	 * Return an array of records given type and other criteria
	 */
	function getRecords( $type, $posted, $operator, $wpTitle = '', $invert = false, $orderby = 'created desc', $groupby = false, $format = false ) {
		global $wgRequest;

		# If the page is already rendered, don't run this query
		if( $this->done ) return array();

		# Remember all the args required to reproduce this result (for building export URL's)
		$this->request = array_merge( $posted, $_GET, $_POST );

		# Loop through all records of this type adding only those that match the regex fields
		$records = array();
		foreach( self::getRecordsByType( $type ) as $t ) {
			if( empty( $wpTitle ) || preg_match( "#$wpTitle#i", $t->getPrefixedText() ) ) {
				$a = new Article( $t );
				$text = $a->getContent();
				$match = true;
				$r = array( 0 => $t, 'title' => $t->getPrefixedText() );
				foreach( array_keys( $this->types ) as $k ) {
					$v = isset( $posted[$k] ) ? ( $this->types[$k] == 'bool' ? 'yes' : $posted[$k] ) : '';
					$ek = str_replace( '|', '\|', $k );
					if( !preg_match( "|\s*\|\s*$ek\s*=|", $text ) ) $text .= "\n|$k=\n|"; # Treat non-existent fields as existing but empty
					$i = preg_match( "|^\s*\|\s*$ek\s*= *(.*?) *(?=^\s*[\|\}])|sm", $text, $m );
					$r[$k] = trim( isset( $m[1] ) ? $m[1] : '' );
					if( $v && !( $i && $this->cmpCallback( $r[$k], $v, $operator[$k] ) ) ) $match = false;
				}
				if( $invert ) $match = !$match;
				if( $match ) $records[] = $r;
			}
		}

		# Add the creation and modified date columns to the records
		$dbr  = wfGetDB( DB_SLAVE );
		foreach( $records as $i => $r ) {
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
		if( $this->desc = preg_match( "| +desc *$|", $orderby ) ) $orderby = preg_replace( "| +desc *$|", "", $orderby );
		$this->orderBy = $orderby;
		usort( $records, array( $this, 'sortCallback' ) );

		# Group the records according to the "groupby" parameter
		if( $groupby ) {
			$groupby = self::split( $groupby, ',' );
			$tmp = array();
			foreach( $records as $r ) {
				$v0 = $r[$groupby[0]];
				unset( $r[$groupby[0]] );
				if( !isset( $tmp[$v0] ) || !is_array( $tmp[$v0] ) ) $tmp[$v0] = array();
				if( isset( $groupby[1] ) ) {
					$v1 = $r[$groupby[1]];
					unset( $r[$groupby[1]] );
					if( !isset( $tmp[$v0][$v1] ) || !is_array( $tmp[$v0][$v1] ) ) $tmp[$v0][$v1] = array();
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
		$b = html_entity_decode( $b, ENT_QUOTES );
		$re = preg_match( "|^[/#%]|", $b );
		switch ( $operator ) {
			case '=':
				$cond = $re ? preg_match( $b, $a ) : ( empty( $b ) ? true : ( $a == $b ) );
			break;

			case '!=':
				$cond = $re ? !preg_match( $b, $a ) : ( empty( $b ) ? true : ( $a != $b ) );
			break;

			default:
				$a = preg_replace( "|(\d\d)[-/](\d\d)[-/](\d\d\d\d)|", "$3/$2/$1", $a ); # hack for dd/mm/yyyy format - best to use yyyy-mm-dd
				$b = preg_replace( "|(\d\d)[-/](\d\d)[-/](\d\d\d\d)|", "$3/$2/$1", $b );
				if( !is_numeric( $b ) && preg_match( "|[0-9]{4}|", $b ) && $tmp = strtotime( $b ) ) {
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
		if( !isset( $row1[$this->orderBy] ) || !isset( $row1[$this->orderBy] ) ) return 0;
		if( $row1[$this->orderBy] == $row2[$this->orderBy] ) return 0;
		$cmp = $row1[$this->orderBy] > $row2[$this->orderBy] ? 1 : -1;
		return $this->desc ? -$cmp : $cmp;
	}


	/**
	 * Render a set of records returned by getRecords() as an HTML table
	 */
	function renderRecords( $records, $cols = false, $sortable = true, $template = false, $name = 'wpSelect', $export = true, $groupby = false ) {
		global $wgOut, $wgParser, $wgTitle, $wgRequest;
		if( count( $records ) < 1 ) return wfMsgHtml( 'recordadmin-nomatch' );
		if( $groupby ) $groupby = self::split( $groupby, ',' );

		$type     = $this->type;
		$id       = ( $sortable && $sortable != 1 ) ? " id=\"$sortable\"" : "";
		$sortable = $sortable ? " sortable" : "";
		$br       = $sortable ? "<br />" : "";
		$format   = $wgRequest->getText( 'export' );

		# If exporting as pdf, ensure the parser renders full URL's
		if( $format == 'pdf' ) {
			global $wgServer, $wgScript, $wgArticlePath, $wgScriptPath, $wgUploadPath;
			$wgArticlePath = $wgServer . $wgArticlePath;
			$wgScriptPath  = $wgServer . $wgScriptPath;
			$wgUploadPath  = $wgServer . $wgUploadPath;
			$wgScript      = $wgServer . $wgScript;
		}

		# Table header (col0-3 class atts are for backward compatibility, only use named from now on)
		$table = "<table$id class='recordadmin$sortable $type-record'>\n<tr>";
		$th = array(
			'select'   => "<th class='col-select'>"        . wfMsgHtml( 'recordadmin-select' )       . "$br</th>",
			'title'    => "<th class='col0 col-title'>"    . wfMsgHtml( 'recordadmin-title', htmlspecialchars( $type ) ) . "$br</th>",
			'actions'  => "<th class='col1 col-actions'>"  . wfMsgHtml( 'recordadmin-actions' )      . "$br</th>",
			'created'  => "<th class='col2 col-created'>"  . wfMsgHtml( 'recordadmin-created' )      . "$br</th>",
			'modified' => "<th class='col3 col-modified'>" . wfMsgHtml( 'recordadmin-modified' )     . "$br</th>"
		);
		foreach( array_keys( $this->types ) as $col ) {
			$class = 'col' . preg_replace( "|\W|", "-", $col );
			$th[$col] = "<th class='$class'>$col$br</th>";
		}
		$tmp = array();
		$cols = $cols ? $cols : array_keys( $th );
		foreach( $cols as $col ) {
			if( $groupby == false || !in_array( $col, $groupby ) ) {
				$html = isset( $th[$col] ) ? $th[$col] : "<th>$col</th>";
				$table .= "$html\n";
				$tmp[] = $col;
			}
		}
		$cols = $tmp;
		$ncol = count( $cols );
		$table .= "</tr>\n";

		# If using grouping, reconstruct the record tree as a list including headings
		if( $groupby ) {
			$td  = "<td colspan=\"$ncol\">";
			$tmp = array();
			foreach( $records as $k1 => $v1 ) {
				if( empty( $k1 ) ) {
					$k1 = htmlspecialchars( wfMsg( 'recordadmin-notset', $groupby[0] ) );
				}
				$tmp[] = "$td<h2>$k1</h2></td>\n";
				foreach( $v1 as $k2 => $v2 ) {
					if( isset( $groupby[1] ) ) {
						if( empty( $k2 ) ) {
							$k2 = htmlspecialchars( wfMsg( 'recordadmin-notset', $groupby[1] ) );
						}
						$tmp[] = "$td<h3>$k2</h3></td>\n";
						foreach( $v2 as $v3 ) $tmp[] = $v3;
					} else $tmp[] = $v2;
				}
			}
			$records = $tmp;
		}

		# Pass 1 - Loop through all the rows building a single string of wikitext to parse
		$text = "";
		foreach( $records as $r ) {
			if( is_array( $r ) ) {
				if( $text ) $text .= "^^^";
				if( $template ) {
					$tsc = $this->formatDate( $r['created'] );
					$tsm = $this->formatDate( $r['modified'] );
					$col = $r['title'];
					$text .= '{'.'{'."$template|select=%SELECT%|title=$col|created=$tsc|modified=$tsm";
					foreach( array_keys( $this->types ) as $col ) {
						$v = isset( $r[$col] ) ? $r[$col] : '';
						$text .= "|$col=$v";
					}
					$text .= '}}';
				} else {
					$fcol = true;
					$row = array( 'select', 'title', 'actions', 'created', 'modified' );
					foreach( $cols as $col ) {
						if( !in_array( $col, $row ) ) {
							if( isset( $r[$col] ) ) {
								if( !$fcol ) $text .= "@@@";
								$text .= $r[$col] . "\n";
								$fcol = false;
							}
						}
					}
				}
			}
		}

		# Parse the wikitext block and split into rows
		$prows = explode( "^^^", $wgParser->parse( $text, $wgTitle, $wgParser->mOptions, true, false )->getText() );

		# Pass 2 - Render the table using the array of pre-parsed wikitext cells
		$stripe = '';
		foreach( $records as $r ) {
			$stripe = $stripe ? '' : ' class="stripe"';
			if( !is_array( $r ) ) {
				$stripe = '';
				$table .= "<tr>$r</tr>"; # Just add as HTML content if not a row
			} else {
				$table .= "<tr$stripe>";
				$sel    = "<input type='checkbox' name='{$name}[]' value='$col' checked />";
				if( $template ) {
					$text = array_shift( $prows );
					$text = preg_replace( "|&lt;(/?td.*?)&gt;|", "<$1>", $text );
					$text = str_replace( '%SELECT%', $sel, $text );
					$table .= "$text\n";
				} else {
					$tsc    = '<span style="display:none">' . ( 3e11 + date( 'U', $r['created'] ) ) . '</span>' . $this->formatDate( $r['created'] );
					$tsm    = '<span style="display:none">' . ( 3e11 + date( 'U', $r['modified'] ) ) . '</span>' . $this->formatDate( $r['modified'] );
					$t      = $r[0];
					$u      = $t->getLocalURL();
					$col    = $r['title'];
					$ecol   = urlencode( $col );
					$row = array(
						'select'   => "<td class='col-select'>$sel</td>\n",
						'title'    => "<td class='col0 col-title'><a href='$u'>$col</a></td>",
						'actions'  => "<td class='col1 col-actions'><a href='" . $t->getLocalURL( "action=edit" ) . "'>"
									  . wfMsgHtml( 'recordadmin-editlink' ) . "</a></td>",
						'created'  => "<td class='col2 col-created'>$tsc</td>\n",
						'modified' => "<td class='col3 col-modified'>$tsm</td>\n"
					);
					$pcols = explode( "@@@", array_shift( $prows ) );
					foreach( $cols as $col ) {
						if( !isset( $row[$col] ) ) {
							$v = isset( $r[$col] ) ? array_shift( $pcols ) : '&#160;';
							$class = 'col' . preg_replace( "|\W|", "-", $col );
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
		if( $format ) {
			$wgOut->disable();
			$filename = $wgTitle->getText();

			# PDF export
			if( $format == 'pdf' ) {
				global $wgUploadDirectory;
				$file = "$wgUploadDirectory/" . uniqid( 'recordadmin' );
				$table = str_replace( '<table', '<table border', $table );
				file_put_contents( $file, $table );
				header("Content-Type: application/pdf");
				header( "Content-Disposition: attachment; filename=\"$filename.pdf\"" );
				putenv( "HTMLDOC_NOCGI=1" );
				$options = "--left 1cm --right 1cm --top 1cm --bottom 1cm --header ... --footer ... --linkcolor 3333cc --bodyfont Arial --fontsize 8";
				passthru( "htmldoc -t pdf --format pdf14 $options --webpage $file" );
				@unlink( $file );
			}

			# CSV export
			else {
				header("Content-Type: text/plain");
				header("Content-Disposition: attachment; filename=\"$filename.csv\"");
				preg_match_all( "|<td.*?>\s*(.*?)\s*</td>|s", $table, $data );
				$cols = $cols ? $cols : array_keys( $th );
				$csv = join( ',', $cols );
				foreach( $data[1] as $i => $cell ) {
					if( $i % count( $cols ) == 0 ) {
						$csv .= "\n";
						$sep = '';
					} else $sep = ',';
					$cell = str_replace( '&'.'nbsp;', ' ', $cell );
					$cell = trim( strip_tags( html_entity_decode( $cell ) ) );
					$cell = str_replace( '"', '""', $cell );
					$csv .= "$sep\"$cell\"";
				}
				print $csv;
			}
			$table = '';
		}

		# Otherwise add export links
		elseif( $export ) {
			$export = $export === true ? array( 'pdf', 'csv' ) : self::split( strtolower( $export ), ',' );
			$qs = "wpType=$type&wpFind=1";
			foreach( $this->request as $k => $v ) $qs .= "&$k=$v";
			$url = $wgTitle->getLocalURL( $qs );
			$table .= "\n<a class=\"recordadmin-export-url\" href=\"$url\">URL</a>";
			if( in_array( 'csv', $export ) ) {
				$table .= "\n<a class=\"recordadmin-export-csv\" href=\"$url&export=csv\">" . wfMsgHtml( 'recordadmin-export-csv' ) . "</a>";
			}
			if( in_array( 'pdf', $export ) ) {
				$table .= "\n<a class=\"recordadmin-export-pdf\" href=\"$url&export=pdf\">" . wfMsgHtml( 'recordadmin-export-pdf' ) . "</a>";
			}
		}

		return $table;
	}


	/**
	 * Take a MediaWiki timestamp and return a formatted date appropriate for sortable table
	 */
	function formatDate( $ts ) {
		global $wgLang;
		return $wgLang->sprintfDate( 'd M Y, H:i', $wgLang->userAdjust( $ts ) );
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
		if( is_object( $title ) ) {
			if( $title->exists() ) {

				# Get the form content
				$form = new Article( $title );
				$form = $form->getContent();
				
				# Extract form's class and other attributes (except method and action)
				if( preg_match( "|<form\s*([^>]+)\s*>.+</form>|is", $form, $atts )) {
					if( preg_match( "|class\s*=\s*[\"'](.+?)['\"]|", $atts[1], $m ) ) $this->formClass .= ' ' . $m[1];
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
				$form = '<b>' . wfMsgHtml( 'recordadmin-noform', htmlspecialchars( $type ) ) . '</b>'
					. '<br /><a href="' . $title->getLocalURL( 'action=edit' )
					. '">(' . wfMsgHtml( 'recordadmin-createlink' ) . ')</a><br />';
			}
		} else $form = '';
		$this->form = $form;
	}


	/**
	 * Populates the form values from the passed values
	 * - $form is HTML text
	 * - $values may be a hash or wikitext template syntax
	 */
	function populateForm( $values ) {

		# If values are wikitext, convert to hash
		if( !is_array( $values ) ) $values = $this->values = self::valuesFromText( $values );

		# Add the values into the form's HTML depending on their type
		foreach( $this->types as $k => $type ) {

			# Get this input element's html text and position and length
			preg_match( "|<([a-z]+)[^<]+?name=\"ra_$k\\[?\\]?\".*?>(.*?</\\1>)?|is", $this->form, $m, PREG_OFFSET_CAPTURE );
			list( $html, $pos ) = $m[0];
			$len = strlen( $html );

			# Modify the element according to its type
			# - clears default value, then adds new value
			$v = str_replace( '$', '\$', isset( $values[$k] ) ? $values[$k] : '' );
			switch ( $type ) {
				case 'text':
					$html = preg_replace( "|value\s*=\s*\".*?\"|i", "", $html );
					if( $v ) $html = preg_replace( "|(/?>)$|", " value=\"" . htmlentities( $v ) . "\" $1", $html );
				break;
				case 'bool':
					$html = preg_replace( "|checked|i", "", $html );
					if( $v ) $html = preg_replace( "|(/?>)$|", " checked $1", $html );
				break;
				case 'list':
					$html = preg_replace_callback( "|\{\{.+?\}\}|s", array( $this, 'parsePart' ), $html );
					$html = preg_replace( "|(<option[^<>]*) selected|i", "$1", $html ); # remove the currently selected option
					if( $v ) {
						foreach( self::split( $v ) as $v ) {
							$v = preg_quote( $v, '|' );
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
		global $wgTitle, $wgUser, $wgParser;
		$options = ParserOptions::newFromUser( $wgUser );
		$max = 10;
		do {
			$braces = false;
			foreach( self::examineBraces( $this->form ) as $brace ) {
				if( $brace['DEPTH'] == 2 ) $braces = $brace;
			}
			if( $braces ) {
				$part = substr( $this->form, $braces['OFFSET'], $braces['LENGTH'] );
				$html = $wgParser->parse( $part, $wgTitle, $options, true, true )->getText();
				$this->form = substr_replace( $this->form, $html, $braces['OFFSET'], $braces['LENGTH'] );
			}
		} while( --$max > 0 && $braces );
	}


	/**
	 * Used to parse any braces in select lists when populating form
	 */
	function parsePart( $part ) {
		global $wgTitle, $wgUser, $wgParser;
		$options = ParserOptions::newFromUser( $wgUser );
		$html = $wgParser->parse( $part[0], $wgTitle, $options, true, true )->getText();
		return preg_match( "|(<option.+</option>)|is", $html, $m ) ? $m[1] : '';
	}


	/**
	 * Returns an array of types used by the passed HTML text form
	 * - supported types, text, select, checkbox, textarea
	 */
	function examineForm() {
		$this->types = array();
		preg_match_all( "|<([a-z]+)[^<]+?name=\"ra_(.+?)\\[?\\]?\".*?>|i", $this->form, $m );
		foreach( $m[2] as $i => $k ) {
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
	static function examineBraces( &$content ) {
		$braces = array();
		$depths = array();
		$depth = 1;
		$index = 0;
		while( preg_match( "/\\{\\{\\s*([#a-z0-9_]*)|\\}\\}/is", $content, $match, PREG_OFFSET_CAPTURE, $index ) ) {
			$index = $match[0][1] + 2;
			if( $match[0][0] == '}}' ) {
				if( $depth > 0 && array_key_exists( $depth - 1, $depths ) ) {
					$brace =& $braces[$depths[$depth - 1]];
					$brace['LENGTH'] = $match[0][1] - $brace['OFFSET'] + 2;
					$brace['DEPTH']  = $depth--;
				}
				if( $depth < 0 ) $depth = 0;
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
	 * Get record types (items in the NS_FORM namespace)
	 */
	function getRecordTypes() {
		if ( $this->recordTypes === false ) {
			$this->recordTypes = array();
			$dbr  = wfGetDB( DB_SLAVE );
			$tbl  = $dbr->tableName( 'page' );
			$res  = $dbr->select( $tbl, 'page_title', "page_namespace = " . NS_FORM, __METHOD__ );
			while( $row = $dbr->fetchRow( $res ) ) $this->recordTypes[] = $row[0];
			$dbr->freeResult( $res );
		}
		return $this->recordTypes;
	}

	/**
	 * Return a list of title objects of a specified record type
	 * - set $count to true to return just the number of results
	 */
	static function getRecordsByType( $type, $count = false ) {
		$records = array();
		$dbr  = wfGetDB( DB_SLAVE );
		$tbl  = $dbr->tableName( 'templatelinks' );
		$ty   = $dbr->addQuotes( $type );
		if( $count ) {
			$row = $dbr->selectRow( $tbl, 'count(0) as count', "tl_namespace = 10 AND tl_title = $ty", __METHOD__ );
			$records = $row->count;
		} else {
			$res  = $dbr->select( $tbl, 'tl_from', "tl_namespace = 10 AND tl_title = $ty", __METHOD__ );
			while( $row = $dbr->fetchRow( $res ) ) $records[] = Title::newFromID( $row[0] );
			$dbr->freeResult( $res );
		}
		return $records;
	}


	/**
	 * Get a field value from a record
	 */
	static function getFieldValue( &$args, $multi = false ) {
		$result = '';

		# Build SQL condition from the supplied args, if any
		$regexp = '';
		foreach( $args as $k => $v ) {
			if( $k == 'type' ) $type = $v;
			elseif( $k == 'record' ) $record = $v;
			elseif( $k == 'field' ) $field = $v;
			else $regexp .= "AND old_text REGEXP('[|] *{$k} *= *{$v}[[:space:]]*[|}]')";
		}

		# If a record and field name are specified, return the field value
		if( isset( $type ) && isset( $record ) && isset( $field ) ) {
			$values = self::getRecordArgs( $record, $type );
			$result = isset( $values[$field] ) ? $values[$field] : '';
		}

		# If record is not set, find first record matching the supplied field values
		if( isset( $type ) && !isset( $record ) ) {
			$dbr = wfGetDB( DB_SLAVE );
			$row = $dbr->selectRow(
				array( 'page', 'revision', 'text', 'templatelinks' ),
				'page_id',
				"rev_id=page_latest AND old_id=rev_text_id AND tl_from=page_id AND tl_title='$type' $regexp",
				__METHOD__
			);
			if( $row ) $result = Title::newFromId( $row->page_id )->getPrefixedText();
		}

		if( $multi ) $result = self::split( $result );
		return $result;
	}


	/**
	 * Common function for splitting items by a separator character
	 * - default is newline
	 * - whitespace around separators is removed
	 */
	static function split( $text, $sep = "[\r\n]+" ) {
		return preg_split( "/\s*$sep\s*/", trim( $text ) );
	}


	/**
	 * Get args from a record article
	 * - if type not specified, first template is used
	 */
	static function getRecordArgs( &$record, $type = false ) {
		$values = array();
		if( is_object( $record ) ) $title =& $record; else $title = Title::newFromText( $record );
		if( is_object( $title ) ) {
			$article = new Article( $title );
			$text = $article->getContent();
			$eb = self::examineBraces( $text );
			$braces = false;
			if( $type ) {
				foreach( $eb as $brace ) if( $brace['NAME'] == $type ) $braces = $brace;
			} elseif( count( $eb ) >= 0 ) $braces = $eb[0];
			if( $braces ) $values = self::valuesFromText( substr( $text, $braces['OFFSET'], $braces['LENGTH'] ) );
		}
		return $values;
	}


	/**
	 * Return array of args represented by passed template syntax
	 */
	static function valuesFromText( $text ) {
		$values = array();
		preg_match_all( "|^\s*\|\s*(.+?)\s*= *(.*?) *(?=^\s*[\|\}])|sm", $text, $m );
		foreach( $m[1] as $i => $k ) $values[trim( $k )] = trim( $m[2][$i] );
		return $values;
	}


	/**
	 * Return template syntax from passed array of values
	 * - use $current to pass existing text to preserve any values not present in the array
	 * - if $current is not set, then only values defined in the form are used
	 */
	function valuesToText( $type, $values, $current = false ) {

		# If there are current values, preserve any that aren't in the passed array
		if( $current ) {
			foreach( self::valuesFromText( $current ) as $k => $v ) {
				if( !isset( $values[$k] ) ) $values[$k] = $v;
			}
		}

		# Build the text from the array
		$text = '';
		foreach( $values as $k => $v ) if( $v && ($current || isset( $this->types[$k] ) ) ) {
			$v = trim( $v );
			if( $this->types[$k] == 'bool' ) $v = 'yes';
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
		if( empty( $title ) ) {
			$title = $this->guid;
			if( $wgRecordAdminUseNamespaces ) $title = "$type:$title";
		}

		# Attempt to create the article
		$title = Title::newFromText( $title );
		if( is_object( $title ) && !$title->exists() ) {
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
		if( !is_object( $ttitle ) || !is_object( $ftitle ) ) {
			$wgOut->addHTML( "<div class='errorbox'>" . wfMsgHtml( 'recordadmin-createerror', htmlspecialchars( $rtype ) ) . "</div>\n" );
		}
		$tttext = $ttitle->getPrefixedText();
		$fttext = $ftitle->getPrefixedText();

		# check if the template already exists
		if( $ttitle->exists() ) {
			$wgOut->addHTML( "<div class='errorbox'>" . wfMsgHtml( 'recordadmin-alreadyexist', htmlspecialchars( $tttext ) ) . "</div>\n" );
		}

		# check if the form already exists
		elseif( $ftitle->exists() ) {
			$wgOut->addHTML( "<div class='errorbox'>" . wfMsgHtml( 'recordadmin-alreadyexist', htmlspecialchars( $fttext ) ) . "</div>\n" );
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
			if( $success ) {
				$cat = Title::newFromText( $wgRecordAdminCategory, NS_CATEGORY )->getPrefixedText();
				$url = $ftitle->getLocalUrl( 'action=edit' );
				$link = "<a href=\"$url\">" . wfMsgHtml( 'recordadmin-needscontent' ) . "</a>";
				$text = "<html>\n\t<form>\n\t\t<table>\n\t\t$link\n\t\t</table>\n\t</form>\n</html>";
				$article = new Article( $ftitle );
				$success = $article->doEdit( $text, $summary, EDIT_NEW );
				if( !$success ) $wgOut->addHTML( "<div class='errorbox'>" . wfMsgHtml( 'recordadmin-createerror', htmlspecialchars( $fttext ) ) . "</div>\n" );
			} else $wgOut->addHTML( "<div class='errorbox'>" . wfMsgHtml( 'recordadmin-createerror', htmlspecialchars( $tttext ) ) . "</div>\n" );

			# Report success
			if( $success ) $wgOut->addHTML( "<div class='successbox'>" . wfMsgHtml( 'recordadmin-createsuccess', htmlspecialchars( $rtype ) ) . "</div>\n" );
		}
	}

	/**
	 * Render a record search in a parser-function
	 */
	function expandTableMagic( &$parser, $type ) {
		global $wgTitle;
		$parser->mOutput->mCacheTime = 100;
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
		foreach( func_get_args() as $arg ) if( !is_object( $arg ) ) {
			if( preg_match( "|^(.+?)\s*([=!<>]+)\s*(.+)$|i", $arg, $match ) ) {
				list( , $k, $o, $v ) = $match;
				if( $k == 'title' ) $title = $v;
				elseif( $k == 'name' )     $name     = $v;
				elseif( $k == 'invert' )   $invert   = $v;
				elseif( $k == 'orderby' )  $orderby  = $v;
				elseif( $k == 'groupby' )  $groupby  = $v;
				elseif( $k == 'format' )   $format   = $v;
				elseif( $k == 'cols' )     $cols     = self::split( $v, ',' );
				elseif( $k == 'sortable' ) {
					$sortable = strtolower( $v );
					if( $sortable == 'yes' || $sortable == 'true' ) $sortable = 1;
					if( $sortable == 'no' || $sortable == 'false' ) $sortable = false;
				}
				elseif( $k == 'template' ) $template = $v;
				elseif( $k == 'count' )    $count    = $v;
				elseif( $k == 'export' )   $export   = $v;
				else {
					$filter[$k] = $v;
					$op[$k] = $o;
				}
			}
		}
		$this->preProcessForm( $type );
		$this->examineForm();
		$records = $this->getRecords( $type, $filter, $op, $title, $invert, $orderby, $groupby, $format );
		if( $count ) while( count( $records ) > $count ) array_pop( $records );
		$table = $this->renderRecords( $records, $cols, $sortable, $template, $name, $export, $groupby, $format );

		return array( $table, 'noparse' => true, 'isHTML' => true );
	}

	/**
	 * Obtain a record or record field value from passed parameters
	 */
	function expandDataMagic( &$parser ) {
		$parser->mOutput->mCacheTime = -1;
		$args = array();
		foreach( func_get_args() as $arg ) if( !is_object( $arg ) ) {
			if( preg_match( "|^(.+?)\s*=\s*(.+)$|", $arg, $match ) ) {
				list( , $k, $v ) = $match;
				$args[$k] = $v;
			}
		}
		return self::getFieldValue( $args );
	}

	/**
	 * If a record was created by a public form, make last 5 digits of ID available via a tag
	 */
	function expandTag( $text, $argv, $parser ) {
		$parser->mOutput->mCacheTime = -1;
		return $this->guid ? substr( $this->guid, -5 ) : '';
	}

	/**
	 * Generate a guid - check $wgRecordAdminGuidFormat array for specialised formats
	 */
	function guid() {
		return $this->guid = strftime( '%Y%m%d', time() ) . '-' . substr( strtoupper( uniqid('', true) ), -5 );
	}

	/**
	 * Create DB table for caching queries
	 */
	function createCacheTable() {
		$dbw = wfGetDB( DB_MASTER );
		$tbl = $dbw->tableName( 'recordadmin_querycache' );
		if ( !$dbw->tableExists( $tbl ) ) {
			$query = "CREATE TABLE $tbl (raqc_id INT(32) NOT NULL, raqc_type TINYTEXT, raqc_content TEXT, raqc_state TINYTEXT, PRIMARY KEY (raqc_id));";
			$result = $dbw->query( $query );
			$dbw->freeResult( $result );
		}
	}
}

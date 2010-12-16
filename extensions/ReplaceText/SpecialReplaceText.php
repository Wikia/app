<?php

if ( !defined( 'MEDIAWIKI' ) ) die();

class ReplaceText extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'ReplaceText', 'replacetext' );
		wfLoadExtensionMessages( 'ReplaceText' );
	}

	function execute( $query ) {
		global $wgUser, $wgOut;

		if ( ! $wgUser->isAllowed( 'replacetext' ) ) {
			$wgOut->permissionRequired( 'replacetext' );
			return;
		}

		$this->user = $wgUser;
		$this->setHeaders();
		$this->doSpecialReplaceText();
	}

	function displayConfirmForm( $message ) {
		global $wgOut;

		$formOpts = array( 'method' => 'post', 'action' => $this->getTitle()->getFullUrl() );

		$wgOut->addHTML(
			Xml::openElement( 'form', $formOpts ) . "\n".
			Xml::hidden( 'title', $this->getTitle()->getPrefixedText() ) . "\n".
			Xml::hidden( 'target', $this->target ) . "\n".
			Xml::hidden( 'replacement', $this->replacement ) . "\n".
			Xml::hidden( 'category', $this->category ) . "\n".
			Xml::hidden( 'prefix', $this->prefix ) . "\n".
			Xml::hidden( 'edit_pages', $this->edit_pages ) . "\n".
			Xml::hidden( 'move_pages', $this->move_pages ) . "\n".
			Xml::hidden( 'confirm', 1 ) . "\n"
		);
		foreach ($this->selected_namespaces as $ns) {
			$wgOut->addHTML(
				Xml::hidden( 'ns' . $ns, 1 ) . "\n"
			);
		}
		$wgOut->wrapWikiMsg( '$1', $message );
		$wgOut->addHTML(
			Xml::submitButton( wfMsg( 'replacetext_continue' ) )
		);

		$wgOut->addWikiMsg( 'replacetext_cancel' );
		$wgOut->addHTML( Xml::closeElement( 'form' ) );
	}

	static function getSelectedNamespaces() {
		global $wgRequest;
		$all_namespaces = SearchEngine::searchableNamespaces();
		$selected_namespaces = array();
		foreach ($all_namespaces as $ns => $name) {
			if ($wgRequest->getCheck('ns' . $ns)) {
				$selected_namespaces[] = $ns;
			}
		}
		return $selected_namespaces;
	}

	function doSpecialReplaceText() {
		global $wgUser, $wgOut, $wgRequest, $wgLang;

		$this->target = $wgRequest->getText( 'target' );
		$this->replacement = $wgRequest->getText( 'replacement' );
		$this->category = $wgRequest->getText( 'category' );
		$this->prefix = $wgRequest->getText( 'prefix' );
		$this->edit_pages = ($wgRequest->getVal( 'edit_pages' ) == 1);
		$this->move_pages = ($wgRequest->getVal( 'move_pages' ) == 1);
		$this->selected_namespaces = self::getSelectedNamespaces();

		if ( $wgRequest->getCheck( 'continue' ) ) {
			if ( $this->target === '' ) {
				$this->showForm( 'replacetext_givetarget' );
				return;
			}
		}

		if ( $wgRequest->getCheck( 'replace' ) ) {
			$replacement_params = array();
			$replacement_params['user_id'] = $wgUser->getId();
			$replacement_params['target_str'] = $this->target;
			$replacement_params['replacement_str'] = $this->replacement;
			$replacement_params['edit_summary'] = wfMsgForContent( 'replacetext_editsummary', $this->target, $this->replacement );
			$replacement_params['create_redirect'] = false;
			$replacement_params['watch_page'] = false;
			foreach ( $wgRequest->getValues() as $key => $value ) {
				if ( $key == 'create-redirect' && $value == '1' ) {
					$replacement_params['create_redirect'] = true;
				} elseif ( $key == 'watch-pages' && $value == '1' ) {
					$replacement_params['watch_page'] = true;
				}
			}
			$jobs = array();
			foreach ( $wgRequest->getValues() as $key => $value ) {
				if ( $value == '1' && $key !== 'replace' ) {
					if ( strpos( $key, 'move-' ) !== false ) {
						$title = Title::newFromID( substr( $key, 5 ) );
						$replacement_params['move_page'] = true;
					} else {
						$title = Title::newFromID( $key );
					}
					if ( $title !== null )
						$jobs[] = new ReplaceTextJob( $title, $replacement_params );
				}
			}
			Job::batchInsert( $jobs );

			$count =  $wgLang->formatNum( count( $jobs ) );
			$wgOut->addWikiMsg( 'replacetext_success', "<tt><nowiki>{$this->target}</nowiki></tt>", "<tt><nowiki>{$this->replacement}</nowiki></tt>", $count );

			// Link back
			$sk = $this->user->getSkin();
			$wgOut->addHTML( $sk->makeKnownLinkObj( $this->getTitle(), wfMsgHtml( 'replacetext_return' ) ) );
			return;
		} elseif ( $wgRequest->getCheck( 'target' ) ) { // very long elseif, look for "end elseif"

			// first, check that at least one namespace has been
			// picked, and that either editing or moving pages
			// has been selected
			if ( count( $this->selected_namespaces ) == 0 ) {
				$this->showForm( 'replacetext_nonamespace' );
				return;
			}
			if ( ! $this->edit_pages && ! $this->move_pages ) {
				$this->showForm( 'replacetext_editormove' );
				return;
			}

			$jobs = array();
			$titles_for_edit = array();
			$titles_for_move = array();
			$unmoveable_titles = array();

			// display a page to make the user confirm the
			// replacement, if the replacement string is
			// either blank or found elsewhere on the wiki
			// (since undoing the replacement would be
			// difficult in either case)
			if ( !$wgRequest->getCheck( 'confirm' ) ) {

				$message = false;

				if ( $this->replacement === '' ) {
					$message = 'replacetext_blankwarning';
				} elseif ( $this->edit_pages ) {
					$res = $this->doSearchQuery( $this->replacement, $this->selected_namespaces, $this->category, $this->prefix );
					$count = $res->numRows();
					if ( $count > 0 ) {
						$message = array( 'replacetext_warning', $wgLang->formatNum( $count ), "<tt><nowiki>{$this->replacement}</nowiki></tt>" );
					}
				} elseif ( $this->move_pages ) {
					$res = $this->getMatchingTitles( $this->replacement, $this->selected_namespaces, $this->category, $this->prefix );
					$count = $res->numRows();
					if ( $count > 0 ) {
						$message = array( 'replacetext_warning', $wgLang->formatNum( $count ), $this->replacement );
					}
				}

				if ( $message ) {
					$this->displayConfirmForm( $message );
					return;
				}
			}

			// if user is replacing text within pages...
			if ( $this->edit_pages ) {
				$res = $this->doSearchQuery( $this->target, $this->selected_namespaces, $this->category, $this->prefix );
				foreach ( $res as $row ) {
					$title = Title::makeTitleSafe( $row->page_namespace, $row->page_title );
					$context = $this->extractContext( $row->old_text, $this->target );
					$titles_for_edit[] = array( $title, $context );
				}
			}
			if ( $this->move_pages ) {
				$res = $this->getMatchingTitles( $this->target, $this->selected_namespaces, $this->category, $this->prefix );
				foreach ( $res as $row ) {
					$title = Title::makeTitleSafe( $row->page_namespace, $row->page_title );
					// see if this move can happen
					$cur_page_name = str_replace('_', ' ', $row->page_title);
					$new_page_name = str_replace( $this->target, $this->replacement, $cur_page_name );
					$new_title = Title::makeTitleSafe( $row->page_namespace, $new_page_name );
					$err = $title->isValidMoveOperation( $new_title );
					if ( $title->userCan( 'move', true ) && !is_array( $err ) ) {
						$titles_for_move[] = $title;
					} else {
						$unmoveable_titles[] = $title;
					}
				}
			}
			// if no results were found, check to see if a bad
			// category name was entered
			if ( count($titles_for_edit) == 0 && count($titles_for_move) == 0 ) {
				$sk = $this->user->getSkin();
				$bad_cat_name = false;
				if (! empty($this->category)) {
					$category_title = Title::makeTitleSafe(NS_CATEGORY, $this->category);
					if (! $category_title->exists()) $bad_cat_name = true;
				}
				if ($bad_cat_name) {
					$wgOut->addHTML(wfMsg('replacetext_nosuchcategory', $sk->link($category_title, ucfirst($this->category))));
				} else {
					if ( $this->edit_pages )
						$wgOut->addWikiMsg( 'replacetext_noreplacement', "<tt><nowiki>{$this->target}</nowiki></tt>" );
					if ( $this->move_pages )
						$wgOut->addWikiMsg( 'replacetext_nomove', "<tt><nowiki>{$this->target}</nowiki></tt>" );
				}
				// link back to starting form
				$wgOut->addHTML( '<p>' . $sk->makeKnownLinkObj( $this->getTitle(), wfMsg( 'replacetext_return' ) ) . '</p>' );
			} else {
				$this->pageListForm( $titles_for_edit, $titles_for_move, $unmoveable_titles );
			}
			return;
		}

		// if we're still here, show the starting form
		$this->showForm( 'replacetext_docu' );
	}

	function showForm( $message ) {
		global  $wgOut;
		$wgOut->addHTML(
			Xml::openElement( 'form', array( 'action' => $this->getTitle()->getFullUrl(), 'method' => 'post' ) ) .
			Xml::hidden( 'title', $this->getTitle()->getPrefixedText() ) .
			Xml::hidden( 'continue', 1 )
		);
		$wgOut->addWikiMsg( $message );
		$wgOut->addHTML( '<table><tr><td style="vertical-align: top;">' );
		$wgOut->addWikiMsg( 'replacetext_originaltext' );
		$wgOut->addHTML( '</td><td>' );
		// 'width: auto' style is needed to override MediaWiki's
		// normal 'width: 100%', which causes the textarea to get
		// zero width in IE
		$wgOut->addHTML( Xml::textarea( 'target', $this->target, 50, 2, array( 'style' => 'width: auto;' ) ) );
		$wgOut->addHTML( '</td></tr><tr><td style="vertical-align: top;">' );
		$wgOut->addWikiMsg( 'replacetext_replacementtext' );
		$wgOut->addHTML( '</td><td>' );
		$wgOut->addHTML( Xml::textarea( 'replacement', $this->replacement, 50, 2, array( 'style' => 'width: auto;' ) ) );
		$wgOut->addHTML( '</td></tr></table>' );

		$search_label = wfMsg('powersearch-ns');
		$namespaces = SearchEngine::searchableNamespaces();
		$tables = $this->namespaceTables( $namespaces );
		$wgOut->addHTML( "<fieldset>\n<p>$search_label</p\n>$tables\n</fieldset>" );
		$optional_filters_label = wfMsg('replacetext_optionalfilters');
		$category_search_label = wfMsg('replacetext_categorysearch');
		$prefix_search_label = wfMsg('replacetext_prefixsearch');
		$wgOut->addHTML(
			"<fieldset>\n" .
			"<p>$optional_filters_label</p>\n" .
			"<p>$category_search_label\n" .
			Xml::input( 'category', 20, $this->category ) . '</p>' .
			"<p>$prefix_search_label\n" .
			Xml::input( 'prefix', 20, $this->prefix ) . '</p>' .
			"</fieldset>\n" .
			Xml::checkLabel( wfMsg( 'replacetext_editpages' ), 'edit_pages', 'edit_pages', true ) . '<br />' .
			Xml::checkLabel( wfMsg( 'replacetext_movepages' ), 'move_pages', 'move_pages' ) . '<br /><br />' .
			Xml::submitButton( wfMsg( 'replacetext_continue' ) ) .
			Xml::closeElement( 'form' )
		);
	}

	/**
	 * Copied almost exactly from MediaWiki's SpecialSearch class, i.e.
	 * the search page
	 */
        function namespaceTables( $namespaces, $rowsPerTable = 3 ) {
                global $wgContLang;
                // Group namespaces into rows according to subject.
                // Try not to make too many assumptions about namespace numbering.
                $rows = array();
                $tables = "";
                foreach( $namespaces as $ns => $name ) {
                        $subj = MWNamespace::getSubject( $ns );
                        if( !array_key_exists( $subj, $rows ) ) {
                                $rows[$subj] = "";
                        }
                        $name = str_replace( '_', ' ', $name );
                        if( '' == $name ) {
                                $name = wfMsg( 'blanknamespace' );
                        }
                        $rows[$subj] .= Xml::openElement( 'td', array( 'style' => 'white-space: nowrap' ) ) .
                                Xml::checkLabel( $name, "ns{$ns}", "mw-search-ns{$ns}", in_array( $ns, $namespaces ) ) .
                                Xml::closeElement( 'td' ) . "\n";
                }
                $rows = array_values( $rows );
                $numRows = count( $rows );
                // Lay out namespaces in multiple floating two-column tables so they'll
                // be arranged nicely while still accommodating different screen widths
                // Float to the right on RTL wikis
                $tableStyle = $wgContLang->isRTL() ?
                        'float: right; margin: 0 0 0em 1em' : 'float: left; margin: 0 1em 0em 0';
                // Build the final HTML table...
                for( $i = 0; $i < $numRows; $i += $rowsPerTable ) {
                        $tables .= Xml::openElement( 'table', array( 'style' => $tableStyle ) );
                        for( $j = $i; $j < $i + $rowsPerTable && $j < $numRows; $j++ ) {
                                $tables .= "<tr>\n" . $rows[$j] . "</tr>";
                        }
                        $tables .= Xml::closeElement( 'table' ) . "\n";
                }
                return $tables;
        }


	function pageListForm( $titles_for_edit, $titles_for_move, $unmoveable_titles ) {
		global $wgOut, $wgLang, $wgScript;

		$skin = $this->user->getSkin();

		$formOpts = array( 'id' => 'choose_pages', 'method' => 'post', 'action' => $this->getTitle()->getFullUrl() );
		$wgOut->addHTML(
			Xml::openElement( 'form', $formOpts ) .
			Xml::hidden( 'title', $this->getTitle()->getPrefixedText() ) .
			Xml::hidden( 'target', $this->target ) .
			Xml::hidden( 'replacement', $this->replacement )
		);

		$js = file_get_contents( dirname( __FILE__ ) . '/ReplaceText.js' );
		$js = '<script type="text/javascript">' . $js . '</script>';
		$wgOut->addScript( $js );

		if ( count( $titles_for_edit ) > 0 ) {
			$wgOut->addWikiMsg( 'replacetext_choosepagesforedit', "<tt><nowiki>{$this->target}</nowiki></tt>", "<tt><nowiki>{$this->replacement}</nowiki></tt>",
				$wgLang->formatNum( count( $titles_for_edit ) ) );

			foreach ( $titles_for_edit as $title_and_context ) {
				list( $title, $context ) = $title_and_context;
				$wgOut->addHTML(
					Xml::check( $title->getArticleID(), true ) .
					$skin->makeKnownLinkObj( $title, $title->getPrefixedText() ) . " - <small>$context</small><br />\n"
				);
			}
			$wgOut->addHTML( '<br />' );
		}

		if ( count( $titles_for_move ) > 0 ) {
			$wgOut->addWikiMsg( 'replacetext_choosepagesformove', $this->target, $this->replacement, $wgLang->formatNum( count( $titles_for_move ) ) );
			foreach ( $titles_for_move as $title ) {
				$wgOut->addHTML(
					Xml::check( 'move-' . $title->getArticleID(), true ) .
					$skin->makeLinkObj( $title, $title->prefix( $title->getText() ) ) . "<br />\n"
				);
			}
			$wgOut->addHTML( '<br />' );
			$wgOut->addWikiMsg( 'replacetext_formovedpages' );
			$wgOut->addHTML(
				Xml::checkLabel( wfMsg( 'replacetext_savemovedpages' ), 'create-redirect', 'create-redirect', true ) . "<br />\n" .
				Xml::checkLabel( wfMsg( 'replacetext_watchmovedpages' ), 'watch-pages', 'watch-pages', false )
			);
			$wgOut->addHTML( '<br />' );
		}

		$wgOut->addHTML(
			"<br />\n" .
			Xml::submitButton( wfMsg( 'replacetext_replace' ) ) .
			Xml::hidden( 'replace', 1 )
		);

		// only show "invert selections" link if there are more than five pages
		if ( count( $titles_for_edit ) + count( $titles_for_move ) > 5 ) {
			$buttonOpts = array(
				'type' => 'button',
				'value' => wfMsg( 'replacetext_invertselections' ),
				'onclick' => 'invertSelections(); return false;'
			);

			$wgOut->addHTML(
				Xml::element( 'input', $buttonOpts )
			);
		}

		$wgOut->addHTML( '</form>' );

		if ( count( $unmoveable_titles ) > 0 ) {
			$wgOut->addWikiMsg( 'replacetext_cannotmove', $wgLang->formatNum( count( $unmoveable_titles ) ) );
			$text = "<ul>\n";
			foreach ( $unmoveable_titles as $title ) {
				$text .= "<li>{$skin->makeKnownLinkObj( $title, $title->getPrefixedText() )}<br />\n";
			}
			$text .= "</ul>\n";
			$wgOut->addHTML( $text );
		}
	}


	/**
	 * Extract context and highlights search text
	 */
	function extractContext( $text, $target ) {
		global $wgLang;
		$cw = $this->user->getOption( 'contextchars', 40 );

		// Get all indexes
		$targetq = preg_quote( $target, '/' );
		preg_match_all( "/$targetq/", $text, $matches, PREG_OFFSET_CAPTURE );

		$poss = array();
		foreach ( $matches[0] as $_ ) {
			$poss[] = $_[1];
		}

		$cuts = array();
		for ( $i = 0; $i < count( $poss ); $i++ ) {
			$index = $poss[$i];
			$len = strlen( $target );

			// Merge to the next if possible
			while ( isset( $poss[$i + 1] ) ) {
				if ( $poss[$i + 1] < $index + $len + $cw * 2 ) {
					$len += $poss[$i + 1] - $poss[$i];
					$i++;
				} else {
					break; // Can't merge, exit the inner loop
				}
			}
			$cuts[] = array( $index, $len );
		}

		$context = '';
		foreach ( $cuts as $_ ) {
			list( $index, $len, ) = $_;
			$context .= self::convertWhiteSpaceToHTML( $wgLang->truncate( substr( $text, 0, $index ), - $cw ) );
			$snippet = self::convertWhiteSpaceToHTML( substr( $text, $index, $len ) );
			$targetq = preg_quote( self::convertWhiteSpaceToHTML( $target ), '/' );
			$context .= preg_replace( "/$targetq/i", '<span class="searchmatch">\0</span>', $snippet );
			$context .= self::convertWhiteSpaceToHTML( $wgLang->truncate( substr( $text, $index + $len ), $cw ) );
		}

		return $context;
	}

	public static function convertWhiteSpaceToHTML( $msg ) {
		$msg = htmlspecialchars( $msg );
		$msg = preg_replace( '/^ /m', '&nbsp; ', $msg );
		$msg = preg_replace( '/ $/m', ' &nbsp;', $msg );
		$msg = preg_replace( '/  /', '&nbsp; ', $msg );
		# $msg = str_replace( "\n", '<br />', $msg );
		return $msg;
	}

	function getMatchingTitles( $str, $namespaces, $category, $prefix ) {
		$dbr = wfGetDB( DB_SLAVE );
		$sql_str = $dbr->escapeLike( str_replace( ' ', '_', $str ) );
		$include_ns = $dbr->makeList( $namespaces );
		$tables = array( 'page' );
		$vars = array( 'page_title', 'page_namespace' );
		$conds = array(
			"page_title LIKE '%$sql_str%'",
			"page_namespace IN ($include_ns)",
		);
		if (! empty($category)) {
			$category = str_replace( ' ', '_', $dbr->escapeLike( $category ) );
			$tables[] = 'categorylinks';
			$conds[] = 'page_id = cl_from';
			$conds[] = "cl_to = '$category'";
		}
		if (! empty($prefix)) {
			$prefix = $dbr->escapeLike( str_replace( ' ', '_', $prefix ) );
			$conds[] = "page_title like '$prefix%'";
		}

		return $dbr->select(
			$tables,
			$vars,
			$conds,
			__METHOD__,
			array( 'ORDER BY' => 'page_namespace, page_title' )
		);
	}

	function doSearchQuery( $search, $namespaces, $category, $prefix ) {
		$dbr = wfGetDB( DB_SLAVE );

		$search = $dbr->escapeLike( $search );
		$include_ns = $dbr->makeList( $namespaces );

		$tables = array( 'page', 'revision', 'text' );
		$vars = array( 'page_id', 'page_namespace', 'page_title', 'old_text' );
		$conds = array(
			"old_text like '%$search%'",
			"page_namespace in ($include_ns)",
			'rev_id = page_latest',
			'rev_text_id = old_id'
		);
		if (! empty($category)) {
			$category = str_replace( ' ', '_', $dbr->escapeLike( $category ) );
			$tables[] = 'categorylinks';
			$conds[] = 'page_id = cl_from';
			$conds[] = "cl_to = '$category'";
		}
		if (! empty($prefix)) {
			$prefix = $dbr->escapeLike( str_replace( ' ', '_', $prefix ) );
			$conds[] = "page_title like '$prefix%'";
		}
		$sort = array( 'ORDER BY' => 'page_namespace, page_title' );

		return $dbr->select( $tables, $vars, $conds, __METHOD__ , $sort );
	}

}

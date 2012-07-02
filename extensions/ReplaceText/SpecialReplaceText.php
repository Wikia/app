<?php

class ReplaceText extends SpecialPage {

	public function __construct() {
		parent::__construct( 'ReplaceText', 'replacetext' );
	}

	function execute( $query ) {
		global $wgUser, $wgOut;

		if ( !$wgUser->isAllowed( 'replacetext' ) ) {
			$wgOut->permissionRequired( 'replacetext' );
			return;
		}

		$this->user = $wgUser;
		$this->setHeaders();
		if ( method_exists( $wgOut, 'addModuleStyles' ) &&	 
			!is_null( $wgOut->getResourceLoader()->getModule( 'mediawiki.special' ) ) ) {
			$wgOut->addModuleStyles( 'mediawiki.special' );
		}
		$this->doSpecialReplaceText();
	}

	static function getSelectedNamespaces() {
		global $wgRequest;
		$all_namespaces = SearchEngine::searchableNamespaces();
		$selected_namespaces = array();
		foreach ( $all_namespaces as $ns => $name ) {
			if ( $wgRequest->getCheck( 'ns' . $ns ) ) {
				$selected_namespaces[] = $ns;
			}
		}
		return $selected_namespaces;
	}

	/**
	 * Helper function to display a hidden field for different versions
	 * of MediaWiki.
	 */
	static function hiddenField( $name, $value ) {
		if ( class_exists( 'Html' ) ) {
			return "\t" . Html::hidden( $name, $value ) . "\n";
		} else {
			return "\t" . Xml::hidden( $name, $value ) . "\n";
		}
	}

	function doSpecialReplaceText() {
		global $wgOut, $wgRequest, $wgLang;
		$linker = class_exists( 'DummyLinker' ) ? new DummyLinker : new Linker;

		$this->target = $wgRequest->getText( 'target' );
		$this->replacement = $wgRequest->getText( 'replacement' );
		$this->use_regex = $wgRequest->getBool( 'use_regex' );
		$this->category = $wgRequest->getText( 'category' );
		$this->prefix = $wgRequest->getText( 'prefix' );
		$this->edit_pages = $wgRequest->getBool( 'edit_pages' );
		$this->move_pages = $wgRequest->getBool( 'move_pages' );
		$this->selected_namespaces = self::getSelectedNamespaces();

		if ( $wgRequest->getCheck( 'continue' ) ) {
			if ( $this->target === '' ) {
				$this->showForm( 'replacetext_givetarget' );
				return;
			}
		}

		if ( $wgRequest->getCheck( 'replace' ) ) {
			$replacement_params = array();
			$replacement_params['user_id'] = $this->user->getId();
			$replacement_params['target_str'] = $this->target;
			$replacement_params['replacement_str'] = $this->replacement;
			$replacement_params['use_regex'] = $this->use_regex;
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

			$count = $wgLang->formatNum( count( $jobs ) );
			$wgOut->addWikiMsg( 'replacetext_success', "<tt><nowiki>{$this->target}</nowiki></tt>", "<tt><nowiki>{$this->replacement}</nowiki></tt>", $count );

			// Link back
			$wgOut->addHTML( $linker->link( $this->getTitle(), wfMsgHtml( 'replacetext_return' ) ) );
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

			// if user is replacing text within pages...
			if ( $this->edit_pages ) {
				$res = $this->doSearchQuery( $this->target, $this->selected_namespaces, $this->category, $this->prefix , $this->use_regex );
				foreach ( $res as $row ) {
					$title = Title::makeTitleSafe( $row->page_namespace, $row->page_title );
					$context = $this->extractContext( $row->old_text, $this->target, $this->use_regex );
					$titles_for_edit[] = array( $title, $context );
				}
			}
			if ( $this->move_pages ) {
				$res = $this->getMatchingTitles( $this->target, $this->selected_namespaces, $this->category, $this->prefix, $this->use_regex );
				foreach ( $res as $row ) {
					$title = Title::makeTitleSafe( $row->page_namespace, $row->page_title );
					// see if this move can happen
					$cur_page_name = str_replace( '_', ' ', $row->page_title );
					if ( $this->use_regex ) {
						$new_page_name = preg_replace( "/".$this->target."/U", $this->replacement, $cur_page_name );
					} else {
						$new_page_name = str_replace( $this->target, $this->replacement, $cur_page_name );
					}
					$new_title = Title::makeTitleSafe( $row->page_namespace, $new_page_name );
					$err = $title->isValidMoveOperation( $new_title );
					if ( $title->userCan( 'move' ) && !is_array( $err ) ) {
						$titles_for_move[] = $title;
					} else {
						$unmoveable_titles[] = $title;
					}
				}
			}
			// if no results were found, check to see if a bad
			// category name was entered
			if ( count( $titles_for_edit ) == 0 && count( $titles_for_move ) == 0 ) {
				$bad_cat_name = false;
				if ( ! empty( $this->category ) ) {
					$category_title = Title::makeTitleSafe( NS_CATEGORY, $this->category );
					if ( ! $category_title->exists() ) $bad_cat_name = true;
				}
				if ( $bad_cat_name ) {
					$link = $linker->link( $category_title, htmlspecialchars( ucfirst( $this->category ) ) );
					$wgOut->addHTML( wfMsgHtml( 'replacetext_nosuchcategory', $link ) );
				} else {
					if ( $this->edit_pages )
						$wgOut->addWikiMsg( 'replacetext_noreplacement', "<tt><nowiki>{$this->target}</nowiki></tt>" );
					if ( $this->move_pages )
						$wgOut->addWikiMsg( 'replacetext_nomove', "<tt><nowiki>{$this->target}</nowiki></tt>" );
				}
				// link back to starting form
				//FIXME: raw html message
				$wgOut->addHTML( '<p>' . $linker->link( $this->getTitle(), wfMsgHtml( 'replacetext_return' ) ) . '</p>' );
			} else {
				// Show a warning message if the replacement
				// string is either blank or found elsewhere on
				// the wiki (since undoing the replacement
				// would be difficult in either case).
				$warning_msg = null;

				if ( $this->replacement === '' ) {
					$warning_msg = wfMsg('replacetext_blankwarning');
				} elseif ( count( $titles_for_edit ) > 0 ) {
					$res = $this->doSearchQuery( $this->replacement, $this->selected_namespaces, $this->category, $this->prefix, $this->use_regex );
					$count = $res->numRows();
					if ( $count > 0 ) {
						$warning_msg = wfMsgExt( 'replacetext_warning', 'parsemag',
							$wgLang->formatNum( $count ),
							"<tt><nowiki>{$this->replacement}</nowiki></tt>"
						);
					}
				} elseif ( count( $titles_for_move ) > 0 ) {
					$res = $this->getMatchingTitles( $this->replacement, $this->selected_namespaces, $this->category, $this->prefix, $this->use_regex );
					$count = $res->numRows();
					if ( $count > 0 ) {
						$warning_msg = wfMsgExt( 'replacetext_warning', 'parsemag',
							$wgLang->formatNum( $count ),
							$this->replacement
						);
					}
				}

				if ( ! is_null( $warning_msg ) ) {
					$wgOut->addWikiText("<div class=\"errorbox\">$warning_msg</div><br clear=\"both\" />");
				}

				$this->pageListForm( $titles_for_edit, $titles_for_move, $unmoveable_titles );
			}
			return;
		}

		// if we're still here, show the starting form
		$this->showForm();
	}

	function showForm( $warning_msg = null ) {
		global $wgOut;
		$wgOut->addHTML(
			Xml::openElement( 'form', array( 'id' => 'powersearch', 'action' => $this->getTitle()->getFullUrl(), 'method' => 'post' ) ) . "\n" .
			self::hiddenField( 'title', $this->getTitle()->getPrefixedText() ) .
			self::hiddenField( 'continue', 1 )
		);
		if ( is_null( $warning_msg ) ) {
			$wgOut->addWikiMsg( 'replacetext_docu' );
		} else {
			$wgOut->wrapWikiMsg( "<div class=\"errorbox\">\n$1\n</div><br clear=\"both\" />", $warning_msg );
		}
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
		$wgOut->addHTML( Xml::tags( 'p', null,
				Xml::checkLabel( wfMsg( 'replacetext_useregex' ), 'use_regex', 'use_regex' ) ) . "\n" .
			Xml::element( 'p', array( 'style' => 'font-style: italic' ),
				wfMsg( 'replacetext_regexdocu' ) )
		);

		// The interface is heavily based on the one in Special:Search.
		$search_label = wfMsg( 'powersearch-ns' );
		$namespaces = SearchEngine::searchableNamespaces();
		$tables = $this->namespaceTables( $namespaces );
		$wgOut->addHTML(
			"<div class=\"mw-search-formheader\"></div>\n" .
			"<fieldset id=\"mw-searchoptions\">\n" . 
			Xml::tags( 'h4', null, wfMsgExt( 'powersearch-ns', array( 'parseinline' ) ) )
		);
		// The ability to select/unselect groups of namespaces in the
		// search interface exists only in some skins, like Vector -
		// check for the presence of the 'powersearch-togglelabel'
		// message to see if we can use this functionality here.
		if ( !wfEmptyMsg( 'powersearch-togglelabel', wfMsg( 'powersearch-togglelabel' ) ) ) {
			$wgOut->addHTML(
				Xml::tags(
					'div',
					array( 'id' => 'mw-search-togglebox' ),
					Xml::label( wfMsg( 'powersearch-togglelabel' ), 'mw-search-togglelabel' ) .
					Xml::element(
						'input',
						array(
							'type'=>'button',
							'id' => 'mw-search-toggleall',
							// 'onclick' value needed for MW 1.16
							'onclick' => 'mwToggleSearchCheckboxes("all");',
							'value' => wfMsg( 'powersearch-toggleall' )
						)
					) .
					Xml::element(
						'input',
						array(
							'type'=>'button',
							'id' => 'mw-search-togglenone',
							// 'onclick' value needed for MW 1.16
							'onclick' => 'mwToggleSearchCheckboxes("none");',
							'value' => wfMsg( 'powersearch-togglenone' )
						)
					)
				)
			);
		} // end if
		$wgOut->addHTML(
			Xml::element( 'div', array( 'class' => 'divider' ), '', false ) .
			"$tables\n</fieldset>"
		);
		//FIXME: raw html messages
		$optional_filters_label = wfMsg( 'replacetext_optionalfilters' );
		$category_search_label = wfMsg( 'replacetext_categorysearch' );
		$prefix_search_label = wfMsg( 'replacetext_prefixsearch' );
		$wgOut->addHTML(
			"<fieldset id=\"mw-searchoptions\">\n" . 
			Xml::tags( 'h4', null, wfMsgExt( 'replacetext_optionalfilters', array( 'parseinline' ) ) ) .
			Xml::element( 'div', array( 'class' => 'divider' ), '', false ) .
			"<p>$category_search_label\n" .
			Xml::input( 'category', 20, $this->category, array( 'type' => 'text' ) ) . '</p>' .
			"<p>$prefix_search_label\n" .
			Xml::input( 'prefix', 20, $this->prefix, array( 'type' => 'text' ) ) . '</p>' .
			"</fieldset>\n" .
			"<p>\n" .
			Xml::checkLabel( wfMsg( 'replacetext_editpages' ), 'edit_pages', 'edit_pages', true ) . '<br />' .
			Xml::checkLabel( wfMsg( 'replacetext_movepages' ), 'move_pages', 'move_pages' ) .
			"</p>\n" .
			Xml::submitButton( wfMsg( 'replacetext_continue' ) ) .
			Xml::closeElement( 'form' )
		);
		// Add Javascript specific to Special:Search
		if ( method_exists( $wgOut, 'addModules' ) ) {
			$wgOut->addModules( 'mediawiki.special.search' );
		} else {
			$wgOut->addScriptFile( 'search.js' );
		}
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
		foreach ( $namespaces as $ns => $name ) {
			$subj = MWNamespace::getSubject( $ns );
			if ( !array_key_exists( $subj, $rows ) ) {
				$rows[$subj] = "";
			}
			$name = str_replace( '_', ' ', $name );
			if ( '' == $name ) {
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
		for ( $i = 0; $i < $numRows; $i += $rowsPerTable ) {
			$tables .= Xml::openElement( 'table', array( 'style' => $tableStyle ) );
			for ( $j = $i; $j < $i + $rowsPerTable && $j < $numRows; $j++ ) {
				$tables .= "<tr>\n" . $rows[$j] . "</tr>";
			}
			$tables .= Xml::closeElement( 'table' ) . "\n";
		}
		return $tables;
	}

	function pageListForm( $titles_for_edit, $titles_for_move, $unmoveable_titles ) {
		global $wgOut, $wgLang, $wgScriptPath;
		$linker = class_exists( 'DummyLinker' ) ? new DummyLinker : new Linker;

		$formOpts = array( 'id' => 'choose_pages', 'method' => 'post', 'action' => $this->getTitle()->getFullUrl() );
		$wgOut->addHTML(
			Xml::openElement( 'form', $formOpts ) . "\n" .
			self::hiddenField( 'title', $this->getTitle()->getPrefixedText() ) .
			self::hiddenField( 'target', $this->target ) .
			self::hiddenField( 'replacement', $this->replacement ) .
			self::hiddenField( 'use_regex', $this->use_regex )
		);

		$wgOut->addScriptFile( "$wgScriptPath/extensions/ReplaceText/ReplaceText.js" );

		if ( count( $titles_for_edit ) > 0 ) {
			$wgOut->addWikiMsg( 'replacetext_choosepagesforedit', "<tt><nowiki>{$this->target}</nowiki></tt>", "<tt><nowiki>{$this->replacement}</nowiki></tt>",
				$wgLang->formatNum( count( $titles_for_edit ) ) );

			foreach ( $titles_for_edit as $title_and_context ) {
				list( $title, $context ) = $title_and_context;
				$wgOut->addHTML(
					Xml::check( $title->getArticleID(), true ) .
					$linker->link( $title ) . " - <small>$context</small><br />\n"
				);
			}
			$wgOut->addHTML( '<br />' );
		}

		if ( count( $titles_for_move ) > 0 ) {
			$wgOut->addWikiMsg( 'replacetext_choosepagesformove', $this->target, $this->replacement, $wgLang->formatNum( count( $titles_for_move ) ) );
			foreach ( $titles_for_move as $title ) {
				$wgOut->addHTML(
					Xml::check( 'move-' . $title->getArticleID(), true ) .
					$linker->link( $title ) . "<br />\n"
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
			Xml::submitButton( wfMsg( 'replacetext_replace' ) ) . "\n" .
			self::hiddenField( 'replace', 1 )
		);

		// Only show "invert selections" link if there are more than
		// five pages.
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
				$text .= "<li>{$linker->link( $title )}<br />\n";
			}
			$text .= "</ul>\n";
			$wgOut->addHTML( $text );
		}
	}

	/**
	 * Extract context and highlights search text
	 *
	 * TODO: The bolding needs to be fixed for regular expressions.
	 */
	function extractContext( $text, $target, $use_regex = false ) {
		global $wgLang;

		$cw = $this->user->getOption( 'contextchars', 40 );

		// Get all indexes
		if ( $use_regex ) {
			preg_match_all( "/$target/", $text, $matches, PREG_OFFSET_CAPTURE );
		} else {
			$targetq = preg_quote( $target, '/' );
			preg_match_all( "/$targetq/", $text, $matches, PREG_OFFSET_CAPTURE );
		}
 
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
			$context .= self::convertWhiteSpaceToHTML(
				$wgLang->truncate( substr( $text, 0, $index ), - $cw, '...', false )
			);
			$snippet = self::convertWhiteSpaceToHTML( substr( $text, $index, $len ) );
			if ( $use_regex ) {
				$targetStr = "/$target/U";
			} else {
				$targetq = preg_quote( self::convertWhiteSpaceToHTML( $target ), '/' );
				$targetStr = "/$targetq/i";
			}
			$context .= preg_replace( $targetStr, '<span class="searchmatch">\0</span>', $snippet );

			$context .= self::convertWhiteSpaceToHTML(
				$wgLang->truncate( substr( $text, $index + $len ), $cw, '...', false )
			);
		}
		return $context;
	}

	public static function convertWhiteSpaceToHTML( $msg ) {
		$msg = htmlspecialchars( $msg );
		$msg = preg_replace( '/^ /m', '&#160; ', $msg );
		$msg = preg_replace( '/ $/m', ' &#160;', $msg );
		$msg = preg_replace( '/  /', '&#160; ', $msg );
		# $msg = str_replace( "\n", '<br />', $msg );
		return $msg;
	}

	function getMatchingTitles( $str, $namespaces, $category, $prefix, $use_regex = false ) {
		$dbr = wfGetDB( DB_SLAVE );

		$tables = array( 'page' );
		$vars = array( 'page_title', 'page_namespace' );

		$str = str_replace( ' ', '_', $str );
		if ( $use_regex ) {
			$comparisonCond = 'page_title REGEXP ' . $dbr->addQuotes( $str );
		} else {
			$any = $dbr->anyString();
			$comparisonCond = 'page_title ' . $dbr->buildLike( $any, $str, $any );
		}
		$conds = array(
			$comparisonCond,
			'page_namespace' => $namespaces,
		);

		$this->categoryCondition( $category, $tables, $conds );
		$this->prefixCondition( $prefix, $conds );
		$sort = array( 'ORDER BY' => 'page_namespace, page_title' );

		return $dbr->select( $tables, $vars, $conds, __METHOD__ , $sort );
	}

	function doSearchQuery( $search, $namespaces, $category, $prefix, $use_regex = false ) {
		$dbr = wfGetDB( DB_SLAVE );
		$tables = array( 'page', 'revision', 'text' );
		$vars = array( 'page_id', 'page_namespace', 'page_title', 'old_text' );
		if ( $use_regex ) {
			$comparisonCond = 'old_text REGEXP ' . $dbr->addQuotes( $search );
		} else {
			$any = $dbr->anyString();
			$comparisonCond = 'old_text ' . $dbr->buildLike( $any, $search, $any );
		}
		$conds = array(
			$comparisonCond,
			'page_namespace' => $namespaces,
			'rev_id = page_latest',
			'rev_text_id = old_id'
		);

		$this->categoryCondition( $category, $tables, $conds );
		$this->prefixCondition( $prefix, $conds );
		$sort = array( 'ORDER BY' => 'page_namespace, page_title' );

		return $dbr->select( $tables, $vars, $conds, __METHOD__ , $sort );
	}

	protected function categoryCondition( $category, &$tables, &$conds ) {
		if ( strval( $category ) !== '' ) {
			$category = Title::newFromText( $category )->getDbKey();
			$tables[] = 'categorylinks';
			$conds[] = 'page_id = cl_from';
			$conds['cl_to'] = $category;
		}
	}

	protected function prefixCondition( $prefix, &$conds ) {
		if ( strval( $prefix ) === '' ) {
			return;
		}
			
		$dbr = wfGetDB( DB_SLAVE );
		$prefix = Title::newFromText( $prefix )->getDbKey();
		$any = $dbr->anyString();
		$conds[] = 'page_title ' . $dbr->buildLike( $prefix, $any );
	}

}

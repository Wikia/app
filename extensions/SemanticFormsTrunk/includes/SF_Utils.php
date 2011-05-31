<?php
/**
 * Helper functions for the Semantic Forms extension.
 *
 * @author Yaron Koren
 * @file
 * @ingroup SF
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

class SFUtils {

	/**
	 * Creates a link to a special page, using that page's top-level description as the link text.
	 */
	public static function linkForSpecialPage( $skin, $specialPageName ) {
		$specialPage = SpecialPage::getPage( $specialPageName );
		// link() method was added in MW 1.16
		if ( method_exists( $skin, 'link' ) ) {
			return $skin->link( $specialPage->getTitle(), $specialPage->getDescription() );
		} else {
			return $skin->makeKnownLinkObj( $specialPage->getTitle(), $specialPage->getDescription() );
		}
	}

	public static function isCapitalized( $title ) {
		// Method was added in MW 1.16.
		$realFunction = array( 'MWNamespace', 'isCapitalized' );
		if ( is_callable( $realFunction ) ) {
			return MWNamespace::isCapitalized( $title->getNamespace() );
		} else {
			global $wgCapitalLinks;
			return $wgCapitalLinks;
		}

	}

	/**
	 * Creates the name of the page that appears in the URL;
	 * this method is necessary because Title::getPartialURL(), for
	 * some reason, doesn't include the namespace
	 */
	public static function titleURLString( $title ) {
		$namespace = wfUrlencode( $title->getNsText() );
		if ( $namespace != '' ) {
			$namespace .= ':';
		}
		if ( self::isCapitalized( $title ) ) {
			global $wgContLang;
			return $namespace . $wgContLang->ucfirst( $title->getPartialURL() );
		} else {
			return $namespace . $title->getPartialURL();
		}
	}

	/**
	 * A very similar function to titleURLString(), to get the
	 * non-URL-encoded title string
	 */
	public static function titleString( $title ) {
		$namespace = $title->getNsText();
		if ( $namespace != '' ) {
			$namespace .= ':';
		}
		if ( self::isCapitalized( $title ) ) {
			global $wgContLang;
			return $namespace . $wgContLang->ucfirst( $title->getText() );
		} else {
			return $namespace . $title->getText();
		}
	}

	/**
	 * Helper function to handle getPropertyValues() in both SMW 1.6
	 * and earlier versions.
	 */
	public static function getSMWPropertyValues( $store, $pageName, $pageNamespace, $propID, $requestOptions = null ) {
		// SMWDIProperty was added in SMW 1.6
		if ( class_exists( 'SMWDIProperty' ) ) {
			if ( is_null( $pageName ) ) {
				$page = null;
			} else {
				$page = new SMWDIWikiPage( $pageName, $pageNamespace, null );
			}
			$property = SMWDIProperty::newFromUserLabel( $propID );
			$res = $store->getPropertyValues( $page, $property, $requestOptions );
			$values = array();
			foreach ( $res as $value ) {
				// getSortKey() seems to return the correct
				// value for every data type.
				$values[] = $value->getSortKey();
			}
			return $values;
		} else {
			$title = Title::makeTitleSafe( $pageNamespace, $pageName );
			$property = SMWPropertyValue::makeProperty( $propID );
			$res = $store->getPropertyValues( $title, $property, $requestOptions );
			$values = array();
			foreach ( $res as $value ) {
				if ( method_exists( $value, 'getTitle' ) ) {
					$valueTitle = $value->getTitle();
					if ( !is_null( $valueTitle ) ) {
						$values[] = $valueTitle->getText();
					}
				} else {
					$values[] = str_replace( '_' , ' ', $value->getWikiValue() );
				}
			}
			return array_unique( $values );
		}
	}

	/**
	 * Helper function - gets names of categories for a page;
	 * based on Title::getParentCategories(), but simpler
	 * - this function doubles as a function to get all categories on
	 * the site, if no article is specified
	 */
	public static function getCategoriesForPage( $title = null ) {
		$categories = array();
		$db = wfGetDB( DB_SLAVE );
		$conditions = null;
		if ( !is_null( $title ) ) {
			$titlekey = $title->getArticleId();
			if ( $titlekey == 0 ) {
				// Something's wrong - exit
				return $categories;
			}
			$conditions = "cl_from='$titlekey'";
		}
		$res = $db->select( $db->tableName( 'categorylinks' ),
			'distinct cl_to', $conditions, __METHOD__ );
		if ( $db->numRows( $res ) > 0 ) {
			while ( $row = $db->fetchRow( $res ) ) {
				$categories[] = $row[0];
			}
		}
		$db->freeResult( $res );
		return $categories;
	}

	public static function registerProperty( $id, $typeid, $label ) {
		if ( class_exists( 'SMWDIProperty' ) ) {
			SMWDIProperty::registerProperty( $id, $typeid, $label, true );
		} else {
			SMWPropertyValue::registerProperty( $id, $typeid, $label, true );
		}
	}

	public static function initProperties() {
		global $sfgContLang;
		$sf_props = $sfgContLang->getPropertyLabels();
		if ( array_key_exists( SF_SP_HAS_DEFAULT_FORM, $sf_props ) )
			self::registerProperty( '_SF_DF', '__spf', $sf_props[SF_SP_HAS_DEFAULT_FORM] );
		if ( array_key_exists( SF_SP_HAS_ALTERNATE_FORM, $sf_props ) )
			self::registerProperty( '_SF_AF', '__spf', $sf_props[SF_SP_HAS_ALTERNATE_FORM] );
		if ( array_key_exists( SF_SP_CREATES_PAGES_WITH_FORM, $sf_props ) )
			self::registerProperty( '_SF_CP', '__spf', $sf_props[SF_SP_CREATES_PAGES_WITH_FORM] );
		if ( array_key_exists( SF_SP_PAGE_HAS_DEFAULT_FORM, $sf_props ) )
			self::registerProperty( '_SF_PDF', '__spf', $sf_props[SF_SP_PAGE_HAS_DEFAULT_FORM] );
		if ( array_key_exists( SF_SP_HAS_FIELD_LABEL_FORMAT, $sf_props ) )
			self::registerProperty( '_SF_FLF', '_str', $sf_props[SF_SP_HAS_FIELD_LABEL_FORMAT] );
		// also initialize hardcoded English values, if it's a non-English-language wiki
		self::registerProperty( '_SF_DF_BACKUP', '__spf', 'Has default form' );
		self::registerProperty( '_SF_AF_BACKUP', '__spf', 'Has alternate form' );
		self::registerProperty( '_SF_CP_BACKUP', '__spf', 'Creates pages with form' );
		self::registerProperty( '_SF_PDF_BACKUP', '__spf', 'Page has default form' );
		self::registerProperty( '_SF_FLF_BACKUP', '_str', 'Has field label format' );

		return true;
	}

	/**
	 * Creates HTML linking to a wiki page
	 */
	public static function linkText( $namespace, $name, $text = null ) {
		$title = Title::makeTitleSafe( $namespace, $name );
		if ( is_null( $title ) ) {
			return $name; // TODO maybe report an error here?
		}
		if ( is_null( $text ) ) {
			$text = $title->getText();
		}
		$l = class_exists('DummyLinker') ? new DummyLinker : new Linker;
		return $l->makeLinkObj( $title, htmlspecialchars( $text ) );
	}

	/**
	 * Prints the mini-form contained at the bottom of various pages, that
	 * allows pages to spoof a normal edit page, that can preview, save,
	 * etc.
	 */
	public static function printRedirectForm( $title, $page_contents, $edit_summary, $is_save, $is_preview, $is_diff, $is_minor_edit, $watch_this, $start_time, $edit_time ) {
		global $wgUser, $sfgScriptPath;
		
		if ( $is_save ) {
			$action = "wpSave";
		}
		elseif ( $is_preview ) {
			$action = "wpPreview";
		}
		else { // $is_diff
			$action = "wpDiff";
		}

		$text = <<<END
	<p style="position: absolute; left: 45%; top: 45%;"><img src="$sfgScriptPath/skins/loading.gif" /></p>

END;
		$form_body = "\t" . Html::hidden( 'wpTextbox1', $page_contents ) . "\n";
		$form_body .= "\t" . Html::hidden( 'wpSummary', $edit_summary ) . "\n";
		$form_body .= "\t" . Html::hidden( 'wpStarttime', $start_time ) . "\n";
		$form_body .= "\t" . Html::hidden( 'wpEdittime', $edit_time ) . "\n";
		$form_body .= "\t" . Html::hidden( 'wpEditToken', $wgUser->isLoggedIn() ? $wgUser->editToken() : EDIT_TOKEN_SUFFIX ) . "\n";
		$form_body .= "\t" . Html::hidden( $action, null ) . "\n";

		if ( $is_minor_edit )
			$form_body .= "\t" . Html::hidden( 'wpMinoredit' , null ) . "\n";
		if ( $watch_this )
			$form_body .= "\t" . Html::hidden( 'wpWatchthis', null ) . "\n";
		$text .= Xml::tags(
			'form',
			array(
				'id' => 'editform',
				'name' => 'editform',
				'method' => 'post',
				'action' => $title instanceof Title ? $title->getLocalURL( 'action=submit' ) : $title
			),
			$form_body
		);

		$text .= <<<END
	<script type="text/javascript">
	window.onload = function() {
		document.editform.submit();
	}
	</script>

END;
		wfRunHooks( 'sfPrintRedirectForm', array( $is_save, $is_preview, $is_diff, &$text ) );
		return $text;
	}

	/**
	 * Uses the ResourceLoader (available with MediaWiki 1.17 and higher)
	 * to load all the necessary JS and CSS files for Semantic Forms.
	 */
	public static function loadJavascriptAndCSS( $parser = null ) {
		// Handling depends on whether or not this form is embedded
		// in another page.
		if ( !is_null( $parser ) ) {
			$output = $parser->getOutput();
		} else {
			global $wgOut;
			$output = $wgOut;
		}
		$output->addModules( 'ext.semanticforms.main' );
		$output->addModules( 'ext.semanticforms.fancybox' );
		$output->addModules( 'ext.semanticforms.autogrow' );
		$output->addModules( 'ext.semanticforms.submit' );
		$output->addModules( 'ext.smw.tooltips' );
		$output->addModules( 'ext.smw.sorttable' );
	}

	/**
	 * Javascript files to be added regardless of the MediaWiki version
	 * (i.e., even if the ResourceLoader is installed).
	 */
	public static function addJavascriptFiles( $parser ) {
		global $wgOut, $wgFCKEditorDir, $wgScriptPath, $wgJsMimeType;

		$scripts = array();

		wfRunHooks( 'sfAddJavascriptFiles', array( &$scripts ) );

		// The FCKeditor extension has no defined ResourceLoader
		// modules yet, so we have to call the scripts directly.
		// @TODO Move this code into the FCKeditor extension.
		if ( $wgFCKEditorDir && class_exists( 'FCKEditor' ) ) {
			$scripts[] = "$wgScriptPath/$wgFCKEditorDir/fckeditor.js";
		}

		foreach ( $scripts as $js ) {
			if ( $parser ) {
				$script = "<script type=\"$wgJsMimeType\" src=\"$js\"></script>\n";
				$parser->getOutput()->addHeadItem( $script );
			} else {
				$wgOut->addScriptFile( $js );
			}
		}
	}

	/**
	 * Includes the necessary Javascript and CSS files for the form
	 * to display and work correctly
	 * 
	 * Accepts an optional Parser instance, or uses $wgOut if omitted.
	 */
	public static function addJavascriptAndCSS( $parser = null ) {
		global $wgOut;

		if ( !$parser ) {
			$wgOut->addMeta( 'robots', 'noindex,nofollow' );
		}

		self::addJavascriptFiles( $parser );

		// MW 1.17 +
		if ( class_exists( 'ResourceLoader' ) ) {
			self::loadJavascriptAndCSS( $parser );
			return;
		}
		global $sfgScriptPath, $smwgScriptPath, $wgScriptPath, $wgJsMimeType, $sfgUseFormEditPage;
		global $smwgJQueryIncluded, $smwgJQUIAutoIncluded;
		// jQuery and jQuery UI are used so often in forms, we might as
		// well assume they'll always be used, and include them in
		// every form
		$smwgJQueryIncluded = true;
		$smwgJQUIAutoIncluded = true;

		$css_files = array(
			"$smwgScriptPath/skins/SMW_custom.css",
			"$sfgScriptPath/skins/jquery-ui/base/jquery.ui.all.css",
			"$sfgScriptPath/skins/SemanticForms.css",
			"$sfgScriptPath/skins/SF_submit.css",
			"$sfgScriptPath/skins/jquery.fancybox.css"
		);
		foreach ( $css_files as $css_file ) {
			$link = array(
				'rel' => 'stylesheet',
				'type' => 'text/css',
				'media' => "screen",
				'href' => $css_file
			);
			if ( !is_null( $parser ) ) {
				$parser->getOutput()->addHeadItem( Xml::element( 'link', $link ) );
			} else {
				$wgOut->addLink( $link );
			}
		}
		
		$scripts = array();
		if ( !$sfgUseFormEditPage )
			$scripts[] = "$sfgScriptPath/libs/SF_ajax_form_preview.js";
		$realFunction = array( 'SMWOutputs', 'requireHeadItem' );
		if ( is_callable( $realFunction ) ) {
			SMWOutputs::requireHeadItem( SMW_HEADER_TOOLTIP );
			SMWOutputs::requireHeadItem( SMW_HEADER_SORTTABLE );
			// TODO - should this be called directly here, or is
			// there a "smarter" (in some way) place to put it?
			SMWOutputs::commitToOutputPage( $wgOut );
		} else {
			$scripts[] = "$smwgScriptPath/skins/SMW_tooltip.js";
			$scripts[] = "$smwgScriptPath/skins/SMW_sorttable.js";
		}
		$realFunction = array( 'OutputPage', 'includeJQuery' );
		if ( is_callable( $realFunction ) ) {
			$wgOut->includeJQuery();
		} else {
			$scripts[] = "$sfgScriptPath/libs/jquery-1.4.2.min.js";
		}
		$scripts[] = "$sfgScriptPath/libs/jquery-ui/jquery.ui.core.min.js";
		$scripts[] = "$sfgScriptPath/libs/jquery-ui/jquery.ui.widget.min.js";
		$scripts[] = "$sfgScriptPath/libs/jquery-ui/jquery.ui.button.min.js";
		$scripts[] = "$sfgScriptPath/libs/jquery-ui/jquery.ui.position.min.js";
		$scripts[] = "$sfgScriptPath/libs/jquery-ui/jquery.ui.autocomplete.min.js";
		$scripts[] = "$sfgScriptPath/libs/jquery-ui/jquery.ui.mouse.min.js";
		$scripts[] = "$sfgScriptPath/libs/jquery-ui/jquery.ui.sortable.min.js";
		$scripts[] = "$sfgScriptPath/libs/jquery.fancybox.js";
		$scripts[] = "$sfgScriptPath/libs/SF_autogrow.js";
		$scripts[] = "$sfgScriptPath/libs/SF_submit.js";
		$scripts[] = "$sfgScriptPath/libs/SemanticForms.js";

		global $wgOut;
		foreach ( $scripts as $js ) {
			if ( $parser ) {
				$script = "<script type=\"$wgJsMimeType\" src=\"$js\"></script>\n";
				$parser->getOutput()->addHeadItem( $script );
			} else {
				$wgOut->addScriptFile( $js );
			}
		}
	}

	/**
	 * Return an array of all form names on this wiki
 	*/
	public static function getAllForms() {
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'page',
			'page_title',
			array( 'page_namespace' => SF_NS_FORM,
				'page_is_redirect' => false ),
			__METHOD__,
			array( 'ORDER BY' => 'page_title' ) );
		$form_names = array();
		while ( $row = $dbr->fetchRow( $res ) ) {
			$form_names[] = str_replace( '_', ' ', $row[0] );
		}
		$dbr->freeResult( $res );
		return $form_names;
	}

	public static function formDropdownHTML() {
		// create a dropdown of possible form names
		global $sfgContLang;
		$namespace_labels = $sfgContLang->getNamespaces();
		$form_label = $namespace_labels[SF_NS_FORM];
		$form_names = SFUtils::getAllForms();
		$select_body = "";
		foreach ( $form_names as $form_name ) {
			$select_body .= "\t" . Xml::element( 'option', null, $form_name ) . "\n";
		}
		return "\t$form_label:" . Xml::tags( 'select', array( 'name' => 'form' ), $select_body ) . "\n";
	}

	/*
	 * This function, unlike the others, doesn't take in a substring
	 * because it uses the SMW data store, which can't perform
	 * case-insensitive queries; for queries with a substring, the
	 * function SFAutocompleteAPI::getAllValuesForProperty() exists.
	 */
	public static function getAllValuesForProperty( $property_name ) {
		global $sfgMaxAutocompleteValues;

		$store = smwfGetStore();
		$requestoptions = new SMWRequestOptions();
		$requestoptions->limit = $sfgMaxAutocompleteValues;
		$values = self::getSMWPropertyValues( $store, null, null, $property_name, $requestoptions );
		sort( $values );
		return $values;
	}

	/*
	 * Get all the pages that belong to a category and all its
	 * subcategories, down a certain number of levels - heavily based on
	 * SMW's SMWInlineQuery::includeSubcategories()
	 */
	public static function getAllPagesForCategory( $top_category, $num_levels, $substring = null ) {
		if ( 0 == $num_levels ) return $top_category;
		global $sfgMaxAutocompleteValues;

		$db = wfGetDB( DB_SLAVE );
		$top_category = str_replace( ' ', '_', $top_category );
		$categories = array( $top_category );
		$checkcategories = array( $top_category );
		$pages = array();
		for ( $level = $num_levels; $level > 0; $level-- ) {
			$newcategories = array();
			foreach ( $checkcategories as $category ) {
				if ( $substring != null ) {
					$substring = str_replace( ' ', '_', strtolower( $substring ) );
					$substring = str_replace( '_', '\_', $substring );
					$substring = str_replace( "'", "\'", $substring );
					$conditions = 'cl_to = ' . $db->addQuotes( $category ) . " AND (LOWER(CONVERT(`page_title` USING utf8)) LIKE '" . $substring . "%' OR LOWER(CONVERT(`page_title` USING utf8)) LIKE '%\_" . $substring . "%' OR page_namespace = " . NS_CATEGORY . ")";
				} else {
					$conditions = 'cl_to = ' . $db->addQuotes( $category );
				}
				$res = $db->select( // make the query
					array( 'categorylinks', 'page' ),
					array( 'page_title', 'page_namespace' ),
					array( 'cl_from = page_id', $conditions ),
					__METHOD__,
					'SORT BY cl_sortkey' );
				if ( $res ) {
					while ( $res && $row = $db->fetchRow( $res ) ) {
						if ( array_key_exists( 'page_title', $row ) ) {
							$page_namespace = $row['page_namespace'];
							if ( $page_namespace == NS_CATEGORY ) {
								$new_category = $row[ 'page_title' ];
								if ( !in_array( $new_category, $categories ) ) {
									$newcategories[] = $new_category;
								}
							} else {
								$cur_title = Title::makeTitleSafe( $row['page_namespace'], $row['page_title'] );
								$cur_value = self::titleString( $cur_title );
								if ( ! in_array( $cur_value, $pages ) ) {
									if ( $substring == null )
										$pages[] = $cur_value;
									else
										$pages[] = array( 'title' => $cur_value );
								}
								// return if we've reached the maximum number of allowed values
								if ( count( $pages ) > $sfgMaxAutocompleteValues ) {
									// Remove duplicates, and put in alphabetical order.
									$pages = array_unique( $pages );
									sort( $pages );
									return $pages;
								}
							}
						}
					}
					$db->freeResult( $res );
				}
			}
			if ( count( $newcategories ) == 0 ) {
				// Remove duplicates, and put in alphabetical order.
				$pages = array_unique( $pages );
				sort( $pages );
				return $pages;
			} else {
				$categories = array_merge( $categories, $newcategories );
			}
			$checkcategories = array_diff( $newcategories, array() );
		}
		// Remove duplicates, and put in alphabetical order.
		$pages = array_unique( $pages );
		sort( $pages );
		return $pages;
	}

	public static function getAllPagesForConcept( $concept_name, $substring = null ) {
		global $sfgMaxAutocompleteValues;

		$store = smwfGetStore();

		$concept = Title::makeTitleSafe( SMW_NS_CONCEPT, $concept_name );
		if ( !is_null( $substring ) ) {
			$substring = strtolower( $substring );
		}

		// Escape if there's a problem.
		if ( $concept == null ) {
			return array();
		}

		$desc = new SMWConceptDescription( $concept );
		$printout = new SMWPrintRequest( SMWPrintRequest::PRINT_THIS, "" );
		$desc->addPrintRequest( $printout );
		$query = new SMWQuery( $desc );
		$query->setLimit( $sfgMaxAutocompleteValues );
		$query_result = $store->getQueryResult( $query );
		$pages = array();
		while ( $res = $query_result->getNext() ) {
			$pageName = $res[0]->getNextText( SMW_OUTPUT_WIKI );
			if ( is_null( $substring ) ) {
				$pages[] = $pageName;
			} else {
				// Filter on the substring manually. It would
				// be better to do this filtering in the
				// original SMW query, but that doesn't seem
				// possible yet.
				$lowercasePageName = strtolower( $pageName );
				if ( strpos( $lowercasePageName, $substring ) === 0 ||
					strpos( $lowercasePageName, ' ' . $substring ) > 0 ) {
						$pages[] = array( 'title' => $pageName );
					}
			}
		}
		sort( $pages );
		return $pages;
	}

	public static function getAllPagesForNamespace( $namespace_name, $substring = null ) {
		// cycle through all the namespace names for this language, and
		// if one matches the namespace specified in the form, add the
		// names of all the pages in that namespace to $names_array
		global $wgContLang;
		$namespaces = $wgContLang->getNamespaces();
		$db = wfGetDB( DB_SLAVE );
		$pages = array();
		foreach ( $namespaces as $ns_code => $ns_name ) {
			if ( $ns_name == $namespace_name ) {
				$conditions = "page_namespace = $ns_code";
				if ( $substring != null ) {
					$substring = str_replace( ' ', '_', strtolower( $substring ) );
					$substring = str_replace( '_', '\_', $substring );
					$substring = str_replace( "'", "\'", $substring );
					$conditions .= " AND (LOWER(CONVERT(`page_title` USING utf8)) LIKE '$substring%' OR LOWER(CONVERT(`page_title` USING utf8)) LIKE '%\_$substring%')";
				}
				$res = $db->select( 'page',
					'page_title',
					$conditions, __METHOD__,
					array( 'ORDER BY' => 'page_title' ) );
				while ( $row = $db->fetchRow( $res ) ) {
					$cur_value = str_replace( '_', ' ', $row[0] );
					if ( $substring == null ) {
						$pages[] = $cur_value;
					} else {
						$pages[] = array( 'title' => $cur_value );
					}
				}
				$db->freeResult( $res );
			}
		}
		return $pages;
	}

	/**
	 * Creates an array of values that match the specified source name and type,
	 * for use by both Javascript autocompletion and comboboxes.
	 */
	public static function getAutocompleteValues( $source_name, $source_type ) {
		$names_array = array();
		// the query depends on whether this is a property, category, concept
		// or namespace
		if ( $source_type == 'property' || $source_type == 'attribute' || $source_type == 'relation' ) {
			$names_array = self::getAllValuesForProperty( $source_name );
		} elseif ( $source_type == 'category' ) {
			$names_array = self::getAllPagesForCategory( $source_name, 10 );
		} elseif ( $source_type == 'concept' ) {
			$names_array = self::getAllPagesForConcept( $source_name );
		} else { // i.e., $source_type == 'namespace'
			// switch back to blank for main namespace
			if ( $source_name == "Main" )
				$source_name = "";
			$names_array = self::getAllPagesForNamespace( $source_name );
		}
		return $names_array;
	}

	/**
	 * Helper function to get an array of values out of what may be either
	 * an array or a delimited string
	 */
	public static function getValuesArray( $value, $delimiter ) {
		if ( is_array( $value ) ) {
			return $value;
		} else {
			// remove extra spaces
			return array_map( 'trim', explode( $delimiter, $value ) );
		}
	}

	public static function getValuesFromExternalURL( $external_url_alias, $substring ) {
		global $sfgAutocompletionURLs;
		if ( empty( $sfgAutocompletionURLs ) ) return array();
		$url = $sfgAutocompletionURLs[$external_url_alias];
		if ( empty( $url ) ) return array();
		$url = str_replace( '<substr>', $substring, $url );
		$page_contents = Http::get( $url );
		if ( empty( $page_contents ) ) return array();
		$data = json_decode( $page_contents );
		if ( empty( $data ) ) return array();
		$return_values = array();
		foreach ( $data->sfautocomplete as $val ) {
			$return_values[] = (array)$val;
		}
		return $return_values;
	}

	/**
	 * A helper function, used by getFormTagComponents().
	 */
	public static function convertBackToPipes( $s ) {
		return str_replace( "\1", '|', $s );
	}

	/**
	 * This function is basically equivalent to calling
	 * explode( '|', $str ), except that it doesn't split on pipes
	 * that are within parser function calls - i.e., pipes within
	 * double curly brackets.
	 */
	public static function getFormTagComponents( $str ) {
		// Turn each pipe within double curly brackets into another,
		// unused character (here, "\1"), then do the explode, then
		// convert them back.
		$pattern = '/({{.*)\|(.*}})/';
		while ( preg_match($pattern, $str, $matches) ) {
			$str = preg_replace($pattern, "$1" . "\1" . "$2", $str);
		}
		return array_map( array('SFUtils', 'convertBackToPipes'), explode('|', $str) );
	}

	/**
	 * Parse the form definition and store the resulting HTML in the
	 * page_props table, if caching has been specified in LocalSettings.php
	 */
	public static function cacheFormDefinition( $parser, $text ) {
		global $sfgCacheFormDefinitions;
		if ( ! $sfgCacheFormDefinitions )
			return true;

		$title = $parser->getTitle();
		if ( empty( $title ) ) return true;
		if ( $title->getNamespace() != SF_NS_FORM ) return true;
		// Remove <noinclude> sections and <includeonly> tags from form definition
		$form_def = StringUtils::delimiterReplace( '<noinclude>', '</noinclude>', '', $text );
		$form_def = strtr( $form_def, array( '<includeonly>' => '', '</includeonly>' => '' ) );

		// parse wiki-text
		// add '<nowiki>' tags around every triple-bracketed form
		// definition element, so that the wiki parser won't touch
		// it - the parser will remove the '<nowiki>' tags, leaving
		// us with what we need
		$form_def = "__NOEDITSECTION__" . strtr( $form_def, array( '{{{' => '<nowiki>{{{', '}}}' => '}}}</nowiki>' ) );
		$dummy_title = Title::newFromText( 'Form definition title for caching purposes' );
		$form_def = $parser->parse( $form_def, $dummy_title, $parser->mOptions )->getText();

		$parser->mOutput->setProperty( 'formdefinition', $form_def );
		return true;
	}

	/*
	 * Loads messages only for MediaWiki versions that need it (< 1.16)
	 */
	public static function loadMessages() {
		global $wgVersion;
		if ( version_compare( $wgVersion, '1.16', '<' ) ) {
			wfLoadExtensionMessages( 'SemanticForms' );
		}
	}

	/**
	 * Translates an EditPage error code into a corresponding message ID
	 * @param $error The error code
	 * @return String
	 */
	public static function processEditErrors ( $error ) {

		switch ( $error ) {
			case EditPage::AS_SUCCESS_NEW_ARTICLE:
			case EditPage::AS_SUCCESS_UPDATE:
				return null;

			case EditPage::AS_SPAM_ERROR:
				return 'spamprotectiontext';

			case EditPage::AS_BLOCKED_PAGE_FOR_USER:
				return 'blockedtitle';

			case EditPage::AS_IMAGE_REDIRECT_ANON:
				return 'uploadnologin';

			case EditPage::AS_READ_ONLY_PAGE_ANON:
				return 'loginreqtitle';

			case EditPage::AS_READ_ONLY_PAGE_LOGGED:
			case EditPage::AS_READ_ONLY_PAGE:
				return array( 'readonlytext', array ( wfReadOnlyReason() ) );

			case EditPage::AS_RATE_LIMITED:
				return 'actionthrottledtext';

			case EditPage::AS_NO_CREATE_PERMISSION:
				return 'nocreatetext';

			case EditPage::AS_BLANK_ARTICLE:
				return 'autoedit-blankpage';

			case EditPage::AS_IMAGE_REDIRECT_LOGGED:
				return 'badaccess';

			case EditPage::AS_HOOK_ERROR_EXPECTED:
			case EditPage::AS_HOOK_ERROR:
				return 'sf_formedit_hookerror';

			case EditPage::AS_CONFLICT_DETECTED:
				return 'editconflict';

			case EditPage::AS_CONTENT_TOO_BIG:
			case EditPage::AS_ARTICLE_WAS_DELETED:
			case EditPage::AS_SUMMARY_NEEDED:
			case EditPage::AS_TEXTBOX_EMPTY:
			case EditPage::AS_MAX_ARTICLE_SIZE_EXCEEDED:
			case EditPage::AS_END:
			case EditPage::AS_FILTERING:
			default:
				return array( 'internalerror_text', array ( $error ) );
		}
	}

	public static function addToAdminLinks( &$admin_links_tree ) {
		$data_structure_label = wfMsg( 'smw_adminlinks_datastructure' );
		$data_structure_section = $admin_links_tree->getSection( $data_structure_label );
		if ( is_null( $data_structure_section ) ) {
			return true;
		}
		$smw_row = $data_structure_section->getRow( 'smw' );
		$smw_row->addItem( ALItem::newFromSpecialPage( 'Templates' ), 'Properties' );
		$smw_row->addItem( ALItem::newFromSpecialPage( 'Forms' ), 'SemanticStatistics' );
		$smw_admin_row = $data_structure_section->getRow( 'smw_admin' );
		$smw_admin_row->addItem( ALItem::newFromSpecialPage( 'CreateClass' ), 'SMWAdmin' );
		$smw_admin_row->addItem( ALItem::newFromSpecialPage( 'CreateProperty' ), 'SMWAdmin' );
		$smw_admin_row->addItem( ALItem::newFromSpecialPage( 'CreateTemplate' ), 'SMWAdmin' );
		$smw_admin_row->addItem( ALItem::newFromSpecialPage( 'CreateForm' ), 'SMWAdmin' );
		$smw_admin_row->addItem( ALItem::newFromSpecialPage( 'CreateCategory' ), 'SMWAdmin' );
		$smw_docu_row = $data_structure_section->getRow( 'smw_docu' );
		$sf_name = wfMsg( 'specialpages-group-sf_group' );
		$sf_docu_label = wfMsg( 'adminlinks_documentation', $sf_name );
		$smw_docu_row->addItem( ALItem::newFromExternalLink( "http://www.mediawiki.org/wiki/Extension:Semantic_Forms", $sf_docu_label ) );

		return true;
	}
}

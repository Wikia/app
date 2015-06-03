<?php
/**
 * A class for static helper functions for Semantic Drilldown
 *
 * @author Yaron Koren
 */

class SDUtils {

	/**
	 * Helper function to handle getPropertyValues() in both SMW 1.6
	 * and earlier versions.
	 * 
	 * @param SMWStore $store
	 * @param string $pageName
	 * @param integer $pageNamespace
	 * @param string $propID
	 * @param null|SMWRequestOptions $requestOptions
	 * 
	 * @return array of SMWDataItem
	 */
	public static function getSMWPropertyValues( SMWStore $store, $pageName, $pageNamespace, $propID, $requestOptions = null ) {
		// SMWDIProperty was added in SMW 1.6
		if ( class_exists( 'SMWDIProperty' ) ) {
			$pageName = str_replace( ' ', '_', $pageName );
			$page = new SMWDIWikiPage( $pageName, $pageNamespace, null );
			$property = new SMWDIProperty( $propID );
			return $store->getPropertyValues( $page, $property, $requestOptions );
		} else {
			$title = Title::makeTitleSafe( $pageNamespace, $pageName );
			$property = SMWPropertyValue::makeProperty( $propID );
			return $store->getPropertyValues( $title, $property, $requestOptions );
		}
	}

	/**
	 * Gets a list of the names of all categories in the wiki that aren't
	 * children of some other category - this list additionally includes,
	 * and excludes, categories that are manually set with
	 * 'SHOWINDRILLDOWN' and 'HIDEFROMDRILLDOWN', respectively.
	 */
	static function getTopLevelCategories() {
		$categories = array();
		$dbr = wfGetDB( DB_SLAVE );
		extract( $dbr->tableNames( 'page', 'categorylinks', 'page_props' ) );
		$cat_ns = NS_CATEGORY;
		$sql = "SELECT page_title FROM $page p LEFT OUTER JOIN $categorylinks cl ON p.page_id = cl.cl_from WHERE p.page_namespace = $cat_ns AND cl.cl_to IS NULL";
		$res = $dbr->query( $sql );
		if ( $dbr->numRows( $res ) > 0 ) {
			while ( $row = $dbr->fetchRow( $res ) ) {
				$categories[] = str_replace( '_', ' ', $row[0] );
			}
		}
		$dbr->freeResult( $res );

		// get 'hide' and 'show' categories
		$hidden_cats = $shown_cats = array();
		$sql2 = "SELECT p.page_title, pp.pp_propname FROM $page p JOIN $page_props pp ON p.page_id = pp.pp_page WHERE p.page_namespace = $cat_ns AND (pp.pp_propname = 'hidefromdrilldown' OR pp.pp_propname = 'showindrilldown') AND pp.pp_value = 'y'";
		$res2 = $dbr->query( $sql2 );
		if ( $dbr->numRows( $res2 ) > 0 ) {
			while ( $row = $dbr->fetchRow( $res2 ) ) {
				if ( $row[1] == 'hidefromdrilldown' )
					$hidden_cats[] = str_replace( '_', ' ', $row[0] );
				else
					$shown_cats[] = str_replace( '_', ' ', $row[0] );
			}
		}
		$dbr->freeResult( $res2 );
		$categories = array_merge( $categories, $shown_cats );
		foreach ( $hidden_cats as $hidden_cat ) {
			foreach ( $categories as $i => $cat ) {
				if ( $cat == $hidden_cat ) {
					unset( $categories[$i] );
				}
			}
		}
		sort( $categories );
		return $categories;
	}

	/**
	 * Gets the list of names of only those categories in the wiki
	 * that have a __SHOWINDRILLDOWN__ declaration on their page.
	 */
	static function getOnlyExplicitlyShownCategories() {
		$shown_cats = array();

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			array( 'p' => 'page', 'pp' => 'page_props' ),
			'p.page_title',
			array(
				'p.page_namespace' => NS_CATEGORY,
				'pp.pp_propname' => 'showindrilldown',
				'pp.pp_value' => 'y'
			),
			'SDUtils::getOnlyExplicitlyShownCategories',
			array( 'ORDER BY' => 'p.page_title' ),
			array( 'pp' => array( 'JOIN', 'p.page_id = pp.pp_page' ) )
		);

		while ( $row = $dbr->fetchRow( $res ) ) {
			$shown_cats[] = str_replace( '_', ' ', $row[0] );
		}
		$dbr->freeResult( $res );

		return $shown_cats;
	}

	/**
	 * Returns the list of categories that will show up in the
	 * header/sidebar of the 'BrowseData' special page.
	 */
	public static function getCategoriesForBrowsing() {
		global $sdgHideCategoriesByDefault;

		if ( $sdgHideCategoriesByDefault ) {
			return self::getOnlyExplicitlyShownCategories();
		} else {
			return self::getTopLevelCategories();
		}
	}

	/**
	 * Gets a list of the names of all properties in the wiki
	 */
	static function getSemanticProperties() {
		global $smwgContLang;
		$smw_namespace_labels = $smwgContLang->getNamespaces();
		$all_properties = array();

		$options = new SMWRequestOptions();
		$options->limit = 10000;
		$used_properties = smwfGetStore()->getPropertiesSpecial( $options );
		foreach ( $used_properties as $property ) {
			if ( $property[0] instanceof SMWDIProperty ) {
				// SMW 1.6+
				$propName = $property[0]->getKey();
				if ( $propName{0} != '_' ) {
					$all_properties[] = str_replace( '_', ' ', $propName );
				}
			} else {
				$all_properties[] = $property[0]->getWikiValue();
			}
		}
		$unused_properties = smwfGetStore()->getUnusedPropertiesSpecial( $options );
		foreach ( $unused_properties as $property ) {
			if ( $property instanceof SMWDIProperty ) {
				// SMW 1.6+
				$all_properties[] = str_replace( '_', ' ', $property->getKey() );
			} else {
				$all_properties[] = $property->getWikiValue();
			}
		}
		// remove the special properties of Semantic Drilldown from this list...
		global $sdgContLang;
		$sd_props = $sdgContLang->getPropertyLabels();
		$sd_prop_aliases = $sdgContLang->getPropertyAliases();
		foreach ( $all_properties as $i => $prop_name ) {
			foreach ( $sd_props as $prop => $label ) {
				if ( $prop_name == $label ) {
					unset( $all_properties[$i] );
				}
			}
			foreach ( $sd_prop_aliases as $alias => $cur_prop ) {
				if ( $prop_name == $alias ) {
					unset( $all_properties[$i] );
				}
			}
		}
		sort( $all_properties );
		return $all_properties;
	}

	/**
	 * Gets the names of all the filter pages, i.e. pages in the Filter
	 * namespace
	 */
	static function getFilters() {
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'page', 'page_title', array( 'page_namespace' => SD_NS_FILTER ) );
		$filters = array();
		while ( $row = $dbr->fetchRow( $res ) ) {
			$filters[] = $row[0];
		}
		$dbr->freeResult( $res );
		return $filters;
	}

	/**
	 * Generic static function - gets all the values that a specific page
	 * points to with a specific property
	 */
	static function getValuesForProperty( $subject, $subject_namespace, $special_prop ) {
		$store = smwfGetStore();
		$res = self::getSMWPropertyValues( $store, $subject, $subject_namespace, $special_prop );
		$values = array();
		foreach ( $res as $prop_val ) {
			// depends on version of SMW
			if ( $prop_val instanceof SMWDIWikiPage ) {
				$actual_val = $prop_val->getDBkey();
			} elseif ( $prop_val instanceof SMWDIString ) {
				$actual_val = $prop_val->getString();
			} elseif ( method_exists( $prop_val, 'getValueKey' ) ) {
				$actual_val = $prop_val->getValueKey();
			} else {
				$actual_val = $prop_val->getXSDValue();
			}
			$values[] = html_entity_decode( str_replace( '_', ' ', $actual_val ) );
		}
		return $values;
	}

	/**
	 * Gets all the filters specified for a category.
	 */
	static function loadFiltersForCategory( $category ) {
		$filters = array();
		$filters_ps = array();
		$filter_names = SDUtils::getValuesForProperty( str_replace( ' ', '_', $category ), NS_CATEGORY, '_SD_F' );
		foreach ( $filter_names as $filter_name ) {
			$filters[] = SDFilter::load( $filter_name );
		}
		// Read from the Page Schemas schema for this category, if
		// it exists, and add any filters defined there.
		if ( class_exists( 'PSSchema' ) ) {
			$pageSchemaObj = new PSSchema( $category );
			if ( $pageSchemaObj->isPSDefined() ) {
				$filters_ps = SDFilter::loadAllFromPageSchema( $pageSchemaObj );
				$result_filters = array_merge( $filters, $filters_ps );
				return $result_filters;
			}
		}
		return $filters;
	}

	/**
	 * Gets all the display parameters defined for a category
	 */
	static function getDisplayParamsForCategory( $category ) {
		$all_display_params = SDUtils::getValuesForProperty( str_replace( ' ', '_', $category ), NS_CATEGORY, '_SD_DP' );

		$return_display_params = array();
		foreach ( $all_display_params as $display_params ) {
			$return_display_params[] = explode( ';', $display_params );
		}
		return $return_display_params;
	}

	static function getCategoryChildren( $category_name, $get_categories, $levels ) {
		if ( $levels == 0 ) {
			return array();
		}
		$pages = array();
		$subcategories = array();
		$dbr = wfGetDB( DB_SLAVE );
		extract( $dbr->tableNames( 'page', 'categorylinks' ) );
		$cat_ns = NS_CATEGORY;
		$query_category = str_replace( ' ', '_', $category_name );
		$query_category = str_replace( "'", "\'", $query_category );
		$sql = "SELECT p.page_title, p.page_namespace FROM $categorylinks cl
	JOIN $page p on cl.cl_from = p.page_id
	WHERE cl.cl_to = '$query_category'\n";
		if ( $get_categories )
			$sql .= "AND p.page_namespace = $cat_ns\n";
		$sql .= "ORDER BY cl.cl_sortkey";
		$res = $dbr->query( $sql );
		while ( $row = $dbr->fetchRow( $res ) ) {
			if ( $get_categories ) {
				$subcategories[] = $row[0];
				$pages[] = $row[0];
			} else {
				if ( $row[1] == $cat_ns )
					$subcategories[] = $row[0];
				else
					$pages[] = $row[0];
			}
		}
		$dbr->freeResult( $res );
		foreach ( $subcategories as $subcategory ) {
			$pages = array_merge( $pages, SDUtils::getCategoryChildren( $subcategory, $get_categories, $levels - 1 ) );
		}
		return $pages;
	}

	static function monthToString( $month ) {
		if ( $month == 1 ) {
			return wfMsg( 'january' );
		} elseif ( $month == 2 ) {
			return wfMsg( 'february' );
		} elseif ( $month == 3 ) {
			return wfMsg( 'march' );
		} elseif ( $month == 4 ) {
			return wfMsg( 'april' );
		} elseif ( $month == 5 ) {
			// Needed to avoid using 3-letter abbreviation
			return wfMsg( 'may_long' );
		} elseif ( $month == 6 ) {
			return wfMsg( 'june' );
		} elseif ( $month == 7 ) {
			return wfMsg( 'july' );
		} elseif ( $month == 8 ) {
			return wfMsg( 'august' );
		} elseif ( $month == 9 ) {
			return wfMsg( 'september' );
		} elseif ( $month == 10 ) {
			return wfMsg( 'october' );
		} elseif ( $month == 11 ) {
			return wfMsg( 'november' );
		} else { // if ($month == 12) {
			return wfMsg( 'december' );
		}
	}

	static function stringToMonth( $str ) {
		if ( $str == wfMsg( 'january' ) ) {
			return 1;
		} elseif ( $str == wfMsg( 'february' ) ) {
			return 2;
		} elseif ( $str == wfMsg( 'march' ) ) {
			return 3;
		} elseif ( $str == wfMsg( 'april' ) ) {
			return 4;
		} elseif ( $str == wfMsg( 'may_long' ) ) {
			return 5;
		} elseif ( $str == wfMsg( 'june' ) ) {
			return 6;
		} elseif ( $str == wfMsg( 'july' ) ) {
			return 7;
		} elseif ( $str == wfMsg( 'august' ) ) {
			return 8;
		} elseif ( $str == wfMsg( 'september' ) ) {
			return 9;
		} elseif ( $str == wfMsg( 'october' ) ) {
			return 10;
		} elseif ( $str == wfMsg( 'november' ) ) {
			return 11;
		} else { // if ($strmonth == wfMsg('december')) {
			return 12;
		}
	}

	static function booleanToString( $bool_value ) {
		if ( function_exists( 'wfLoadExtensionMessages' ) ) {
			wfLoadExtensionMessages( 'SemanticMediaWiki' );
		}
		$words_field_name = ( $bool_value == true ) ? 'smw_true_words' : 'smw_false_words';
		$words_array = explode( ',', wfMsgForContent( $words_field_name ) );
		// go with the value in the array that tends to be "yes" or
		// "no", which is the 3rd
		$index_of_word = 2;
		// capitalize first letter of word
		if ( count( $words_array ) > $index_of_word ) {
			$string_value = ucwords( $words_array[$index_of_word] );
		} elseif ( count( $words_array ) == 0 ) {
			$string_value = $bool_value; // a safe value if no words are found
		} else {
			$string_value = ucwords( $words_array[0] );
		}
		return $string_value;
	}

	/**
	 * Prints the mini-form contained at the bottom of various pages, that
	 * allows pages to spoof a normal edit page, that can preview, save,
	 * etc.
	 */
	static function printRedirectForm( $title, $page_contents, $edit_summary, $is_save, $is_preview, $is_diff, $is_minor_edit, $watch_this ) {
		$article = new Article( $title );
		$new_url = $title->getLocalURL( 'action=submit' );
		$starttime = wfTimestampNow();
		$edittime = $article->getTimestamp();
		global $wgUser;
		if ( $wgUser->isLoggedIn() )
			$token = htmlspecialchars( $wgUser->editToken() );
		else
			$token = EDIT_TOKEN_SUFFIX;

		if ( $is_save )
			$action = "wpSave";
		elseif ( $is_preview )
			$action = "wpPreview";
		else // $is_diff
			$action = "wpDiff";

		$text = <<<END
	<form id="editform" name="editform" method="post" action="$new_url">
	<input type="hidden" name="wpTextbox1" id="wpTextbox1" value="$page_contents" />
	<input type="hidden" name="wpSummary" value="$edit_summary" />
	<input type="hidden" name="wpStarttime" value="$starttime" />
	<input type="hidden" name="wpEdittime" value="$edittime" />
	<input type="hidden" name="wpEditToken" value="$token" />
	<input type="hidden" name="$action" />

END;
		if ( $is_minor_edit )
			$text .= '    <input type="hidden" name="wpMinoredit">' . "\n";
		if ( $watch_this )
			$text .= '    <input type="hidden" name="wpWatchthis">' . "\n";
		$text .= <<<END
	</form>
	<script type="text/javascript">
	document.editform.submit();
	</script>

END;
		return $text;
	}

	/**
	 * Register magic-word variable IDs
	 */
	static function addMagicWordVariableIDs( &$magicWordVariableIDs ) {
		$magicWordVariableIDs[] = 'MAG_HIDEFROMDRILLDOWN';
		$magicWordVariableIDs[] = 'MAG_SHOWINDRILLDOWN';
		return true;
	}

	/**
	 * Set the actual value of the magic words
	 */
	static function addMagicWordLanguage( &$magicWords, $langCode ) {
		switch( $langCode ) {
		default:
			$magicWords['MAG_HIDEFROMDRILLDOWN'] = array( 0, '__HIDEFROMDRILLDOWN__' );
			$magicWords['MAG_SHOWINDRILLDOWN'] = array( 0, '__SHOWINDRILLDOWN__' );
		}
		return true;
	}

	/**
	 * Set values in the page_props table based on the presence of the
	 * 'HIDEFROMDRILLDOWN' and 'SHOWINDRILLDOWN' magic words in a page
	 */
	static function handleShowAndHide( &$parser, &$text ) {
		global $wgOut, $wgAction;
		$mw_hide = MagicWord::get( 'MAG_HIDEFROMDRILLDOWN' );
		if ( $mw_hide->matchAndRemove( $text ) ) {
			$parser->mOutput->setProperty( 'hidefromdrilldown', 'y' );
		}
		$mw_show = MagicWord::get( 'MAG_SHOWINDRILLDOWN' );
		if ( $mw_show->matchAndRemove( $text ) ) {
			$parser->mOutput->setProperty( 'showindrilldown', 'y' );
		}
		return true;
	}

	public static function addToAdminLinks( &$admin_links_tree ) {
		$browse_search_section = $admin_links_tree->getSection( wfMsg( 'adminlinks_browsesearch' ) );
		$sd_row = new ALRow( 'sd' );
		$sd_row->addItem( ALItem::newFromSpecialPage( 'BrowseData' ) );
		$sd_row->addItem( ALItem::newFromSpecialPage( 'Filters' ) );
		$sd_row->addItem( ALItem::newFromSpecialPage( 'CreateFilter' ) );
		$sd_name = wfMsg( 'specialpages-group-sd_group' );
		$sd_docu_label = wfMsg( 'adminlinks_documentation', $sd_name );
		$sd_row->addItem( AlItem::newFromExternalLink( "http://www.mediawiki.org/wiki/Extension:Semantic_Drilldown", $sd_docu_label ) );

		$browse_search_section->addRow( $sd_row );

		return true;
	}
}

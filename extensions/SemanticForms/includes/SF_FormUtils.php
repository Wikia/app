<?php
/**
 * Javascript- and HTML-creation utilities for the display of a form
 *
 * @author Yaron Koren
 * @author Jeffrey Stuckman
 * @author Harold Solbrig
 * @author Eugene Mednikov
 * @file
 * @ingroup SF
 */

class SFFormUtils {
	static function setGlobalJSVariables( &$vars ) {
		global $sfgAutocompleteValues, $sfgAutocompleteOnAllChars;
		global $sfgFieldProperties, $sfgCargoFields, $sfgDependentFields;
		global $sfgShowOnSelect, $sfgScriptPath;
		global $edgValues, $sfgEDSettings;
//		global $sfgInitJSFunctions, $sfgValidationJSFunctions;

		$vars['sfgAutocompleteValues'] = $sfgAutocompleteValues;
		$vars['sfgAutocompleteOnAllChars'] = $sfgAutocompleteOnAllChars;
		$vars['sfgFieldProperties'] = $sfgFieldProperties;
		$vars['sfgCargoFields'] = $sfgCargoFields;
		$vars['sfgDependentFields'] = $sfgDependentFields;
		$vars['sfgShowOnSelect'] = $sfgShowOnSelect;
		$vars['sfgScriptPath'] = $sfgScriptPath;
		$vars['edgValues'] = $edgValues;
		$vars['sfgEDSettings'] = $sfgEDSettings;
//		$vars['sfgInitJSFunctions'] = $sfgInitJSFunctions;
//		$vars['sfgValidationJSFunctions'] = $sfgValidationJSFunctions;

		return true;
	}

	/**
	 * Add a hidden input for each field in the template call that's
	 * not handled by the form itself
	 */
	static function unhandledFieldsHTML( $templateName, $templateContents ) {
		// HTML element names shouldn't contain spaces
		$templateName = str_replace( ' ', '_', $templateName );
		$text = "";
		foreach ( $templateContents as $key => $value ) {
			if ( !is_null( $key ) && !is_numeric( $key ) ) {
				$key = urlencode( $key );
				$text .= Html::hidden( '_unhandled_' . $templateName . '_' . $key, $value );
			}
		}
		return $text;
	}

	/**
	 * Add unhandled fields back into the template call that the form
	 * generates, so that editing with a form will have no effect on them
	 */
	static function addUnhandledFields( $templateName ) {
		global $wgRequest;

		$templateName = str_replace( ' ', '_', $templateName );
		$prefix = '_unhandled_' . $templateName . '_';
		$prefixSize = strlen( $prefix );
		$additional_template_text = "";
		foreach ( $wgRequest->getValues() as $key => $value ) {
			if ( strpos( $key, $prefix ) === 0 ) {
				$field_name = urldecode( substr( $key, $prefixSize ) );
				$additional_template_text .= "|$field_name=$value\n";
			}
		}
		return $additional_template_text;
	}

	static function summaryInputHTML( $is_disabled, $label = null, $attr = array(), $value = '' ) {
		global $sfgTabIndex;

		if ( $label == null ) {
			$label = wfMessage( 'summary' )->text();
		}
		$text = Html::rawElement( 'span', array( 'id' => 'wpSummaryLabel' ),
			Html::element( 'label', array( 'for' => 'wpSummary' ), $label ) );

		$sfgTabIndex++;
		$attr['tabindex'] = $sfgTabIndex;
		$attr['type'] = 'text';
		$attr['value'] = $value;
		$attr['name'] = 'wpSummary';
		$attr['id'] = 'wpSummary';
		$attr['maxlength'] = 200;
		$attr['size'] = 60;
		if ( $is_disabled ) {
			$attr['disabled'] = true;
		}
		$text .= ' ' . Html::element( 'input', $attr );

		return $text;
	}

	static function minorEditInputHTML( $form_submitted, $is_disabled, $is_checked, $label = null, $attrs = array() ) {
		global $sfgTabIndex, $wgUser, $wgParser;

		$sfgTabIndex++;
		if ( !$form_submitted ) {
			$is_checked = $wgUser->getOption( 'minordefault' );
		}

		if ( $label == null ) {
			$label = $wgParser->recursiveTagParse( wfMessage( 'minoredit' )->text() );
		}

		$tooltip = wfMessage( 'tooltip-minoredit' )->text();
		$attrs += array(
			'id' => 'wpMinoredit',
			'accesskey' => wfMessage( 'accesskey-minoredit' )->text(),
			'tabindex' => $sfgTabIndex,
		);
		if ( $is_disabled ) {
			$attrs['disabled'] = true;
		}
		$text = "\t" . Xml::check( 'wpMinoredit', $is_checked, $attrs ) . "\n";
		$text .= "\t" . Html::rawElement( 'label', array(
			'for' => 'wpMinoredit',
			'title' => $tooltip
		), $label ) . "\n";

		return $text;
	}

	static function watchInputHTML( $form_submitted, $is_disabled, $is_checked = false, $label = null, $attrs = array() ) {
		global $sfgTabIndex, $wgUser, $wgTitle, $wgParser;

		$sfgTabIndex++;
		// figure out if the checkbox should be checked -
		// this code borrowed from /includes/EditPage.php
		if ( !$form_submitted ) {
			if ( $wgUser->getOption( 'watchdefault' ) ) {
				# Watch all edits
				$is_checked = true;
			} elseif ( $wgUser->getOption( 'watchcreations' ) && !$wgTitle->exists() ) {
				# Watch creations
				$is_checked = true;
			} elseif ( $wgTitle->userIsWatching() ) {
				# Already watched
				$is_checked = true;
			}
		}
		if ( $label == null )
			$label = $wgParser->recursiveTagParse( wfMessage( 'watchthis' )->text() );
		$attrs += array(
			'id' => 'wpWatchthis',
			'accesskey' => wfMessage( 'accesskey-watch' )->text(),
			'tabindex' => $sfgTabIndex,
		);
		if ( $is_disabled ) {
			$attrs['disabled'] = true;
		}
		$text = "\t" . Xml::check( 'wpWatchthis', $is_checked, $attrs ) . "\n";
		$tooltip = wfMessage( 'tooltip-watch' )->text();
		$text .= "\t" . Html::rawElement( 'label', array(
			'for' => 'wpWatchthis',
			'title' => $tooltip
		), $label ) . "\n";

		return $text;
	}

	/**
	 * Helper function to display a simple button
	 */
	static function buttonHTML( $name, $value, $type, $attrs ) {
		return "\t\t" . Html::input( $name, $value, $type, $attrs ) . "\n";
	}

	static function saveButtonHTML( $is_disabled, $label = null, $attr = array() ) {
		global $sfgTabIndex;

		$sfgTabIndex++;
		if ( $label == null ) {
			$label = wfMessage( 'savearticle' )->text();
		}
		$temp = $attr + array(
			'id'        => 'wpSave',
			'tabindex'  => $sfgTabIndex,
			'accesskey' => wfMessage( 'accesskey-save' )->text(),
			'title'     => wfMessage( 'tooltip-save' )->text(),
		);
		if ( $is_disabled ) {
			$temp['disabled'] = true;
		}
		return self::buttonHTML( 'wpSave', $label, 'submit', $temp );
	}

	static function saveAndContinueButtonHTML( $is_disabled, $label = null, $attr = array() ) {
		global $sfgTabIndex;

		$sfgTabIndex++;

		if ( $label == null ) {
			$label = wfMessage( 'sf_formedit_saveandcontinueediting' )->text();
		}

		$temp = $attr + array(
			'id'        => 'wpSaveAndContinue',
			'tabindex'  => $sfgTabIndex,
			'disabled'  => true,
			'accesskey' => wfMessage( 'sf_formedit_accesskey_saveandcontinueediting' )->text(),
			'title'     => wfMessage( 'sf_formedit_tooltip_saveandcontinueediting' )->text(),
		);

		if ( $is_disabled ) {
			$temp['class'] = 'sf-save_and_continue disabled';
		} else {
			$temp['class'] = 'sf-save_and_continue';
		}

		return self::buttonHTML( 'wpSaveAndContinue', $label, 'button', $temp );
	}

	static function showPreviewButtonHTML( $is_disabled, $label = null, $attr = array() ) {
		global $sfgTabIndex;

		$sfgTabIndex++;
		if ( $label == null ) {
			$label = wfMessage( 'showpreview' )->text();
		}
		$temp = $attr + array(
			'id'        => 'wpPreview',
			'tabindex'  => $sfgTabIndex,
			'accesskey' => wfMessage( 'accesskey-preview' )->text(),
			'title'     => wfMessage( 'tooltip-preview' )->text(),
		);
		if ( $is_disabled ) {
			$temp['disabled'] = true;
		}
		return self::buttonHTML( 'wpPreview', $label, 'submit', $temp );
	}

	static function showChangesButtonHTML( $is_disabled, $label = null, $attr = array() ) {
		global $sfgTabIndex;

		$sfgTabIndex++;
		if ( $label == null ) {
			$label = wfMessage( 'showdiff' )->text();
		}
		$temp = $attr + array(
			'id'        => 'wpDiff',
			'tabindex'  => $sfgTabIndex,
			'accesskey' => wfMessage( 'accesskey-diff' )->text(),
			'title'     => wfMessage( 'tooltip-diff' )->text(),
		);
		if ( $is_disabled ) {
			$temp['disabled'] = true;
		}
		return self::buttonHTML( 'wpDiff', $label, 'submit', $temp );
	}

	static function cancelLinkHTML( $is_disabled, $label = null, $attr = array() ) {
		global $wgTitle, $wgParser;

		if ( $label == null ) {
			$label = $wgParser->recursiveTagParse( wfMessage( 'cancel' )->text() );
		}
		if ( $wgTitle == null ) {
			$cancel = '';
		}
		// if we're on the special 'FormEdit' page, just send the user
		// back to the previous page they were on
		elseif ( $wgTitle->isSpecial( 'FormEdit' ) ) {
			$stepsBack = 1;
			// For IE, we need to go back twice, past the redirect.
			if ( array_key_exists( 'HTTP_USER_AGENT', $_SERVER ) &&
				stristr( $_SERVER['HTTP_USER_AGENT'], "msie" ) ) {
				$stepsBack = 2;
			}
			$cancel = "<a href=\"javascript:history.go(-$stepsBack);\">$label</a>";
		} else {
			$cancel = Linker::link( $wgTitle, $label, array(), array(), 'known' );
		}
		return "\t\t" . Html::rawElement( 'span', array( 'class' => 'editHelp' ), $cancel ) . "\n";
	}

	static function runQueryButtonHTML( $is_disabled = false, $label = null, $attr = array() ) {
		// is_disabled is currently ignored
		global $sfgTabIndex;

		$sfgTabIndex++;
		if ( $label == null ) {
			$label = wfMessage( 'runquery' )->text();
		}
		return self::buttonHTML( 'wpRunQuery', $label, 'submit',
			$attr + array(
			'id'        => 'wpRunQuery',
			'tabindex'  => $sfgTabIndex,
			'title'     => $label,
		) );
	}

	// Much of this function is based on MediaWiki's EditPage::showEditForm()
	static function formBottom( $form_submitted, $is_disabled ) {
		global $wgUser;

		$summary_text = SFFormUtils::summaryInputHTML( $is_disabled );
		$text = <<<END
	<br /><br />
	<div class='editOptions'>
$summary_text	<br />

END;
		if ( $wgUser->isAllowed( 'minoredit' ) ) {
			$text .= SFFormUtils::minorEditInputHTML( $form_submitted, $is_disabled, false );
		}

		if ( $wgUser->isLoggedIn() ) {
			$text .= SFFormUtils::watchInputHTML( $form_submitted, $is_disabled );
		}

		$text .= <<<END
	<br />
	<div class='editButtons'>

END;
		$text .= SFFormUtils::saveButtonHTML( $is_disabled );
		$text .= SFFormUtils::showPreviewButtonHTML( $is_disabled );
		$text .= SFFormUtils::showChangesButtonHTML( $is_disabled );
		$text .= SFFormUtils::cancelLinkHTML( $is_disabled );
		$text .= <<<END
	</div><!-- editButtons -->
	</div><!-- editOptions -->

END;
		return $text;
	}

	// based on MediaWiki's EditPage::getPreloadedText()
	static function getPreloadedText( $preload ) {
		if ( $preload === '' ) {
			return '';
		} else {
			$preloadTitle = Title::newFromText( $preload );
			if ( isset( $preloadTitle ) && $preloadTitle->userCan( 'read' ) ) {
				$rev = Revision::newFromTitle( $preloadTitle );
				if ( is_object( $rev ) ) {
					$text = $rev->getText();
					// Remove <noinclude> sections and <includeonly> tags from text
					$text = StringUtils::delimiterReplace( '<noinclude>', '</noinclude>', '', $text );
					$text = strtr( $text, array( '<includeonly>' => '', '</includeonly>' => '' ) );
					return $text;
				}
			}
			return '';
		}
	}

	/**
	 * Used by 'RunQuery' page
	 */
	static function queryFormBottom() {
		return self::runQueryButtonHTML( false );
	}

	static function getMonthNames() {
		return array(
			wfMessage( 'january' )->inContentLanguage()->text(),
			wfMessage( 'february' )->inContentLanguage()->text(),
			wfMessage( 'march' )->inContentLanguage()->text(),
			wfMessage( 'april' )->inContentLanguage()->text(),
			// Needed to avoid using 3-letter abbreviation
			wfMessage( 'may_long' )->inContentLanguage()->text(),
			wfMessage( 'june' )->inContentLanguage()->text(),
			wfMessage( 'july' )->inContentLanguage()->text(),
			wfMessage( 'august' )->inContentLanguage()->text(),
			wfMessage( 'september' )->inContentLanguage()->text(),
			wfMessage( 'october' )->inContentLanguage()->text(),
			wfMessage( 'november' )->inContentLanguage()->text(),
			wfMessage( 'december' )->inContentLanguage()->text()
		);
	}

	/**
	 * Parse the form definition and return it
	 */
	public static function getFormDefinition( Parser $parser, $form_def = null, $form_id = null ) {
		if ( $form_id !== null ) {
			$cachedDef = self::getFormDefinitionFromCache( $form_id, $parser );

			if ( $cachedDef !== null ) {
				return $cachedDef;
			}
		}

		if ( $form_id !== null ) {
			$form_title = Title::newFromID( $form_id );
			$form_def = SFUtils::getPageText( $form_title );
		} elseif ( $form_def == null ) {
			// No id, no text -> nothing to do

			return '';
		}

		// Remove <noinclude> sections and <includeonly> tags from form definition
		$form_def = StringUtils::delimiterReplace( '<noinclude>', '</noinclude>', '', $form_def );
		$form_def = strtr( $form_def, array( '<includeonly>' => '', '</includeonly>' => '' ) );

		// We need to replace all SF tags in the form definition by strip items. But we can not just use
		// the Parser strip state because the Parser would during parsing replace all strip items and then
		// mangle them into HTML code. So we have to use our own. Which means we also can not just use
		// Parser::insertStripItem() (see below).
		$rnd = wfRandomString( 32 );

		// This regexp will find any SF triple braced tags (including correct handling of contained braces), i.e.
		// {{{field|foo|default={{Bar}}}}} is not a problem. When used with preg_match and friends, $matches[0] will
		// contain the whole SF tag, $matches[1] will contain the tag without the enclosing triple braces.
		$regexp = '#\{\{\{((?>[^\{\}]+)|(\{((?>[^\{\}]+)|(?-2))*\}))*\}\}\}#';

		$items = array();

		// replace all SF tags by strip markers
		$form_def = preg_replace_callback(
			$regexp,

			// This is essentially a copy of Parser::insertStripItem().
			// The 'use' keyword will bump the minimum PHP version to 5.3
			function ( array $matches ) use ( &$items, $rnd ) {
				$markerIndex = count( $items );
				$items[] = $matches[0];
				return "$rnd-item-$markerIndex-$rnd";

			},

			$form_def
		);


		// parse wiki-text
		if ( isset( $parser->mInParse ) && $parser->mInParse === true ) {
			$form_def = $parser->recursiveTagParse( $form_def );
			$output = $parser->getOutput();
		} else {
			$title = is_object( $parser->getTitle() ) ? $parser->getTitle() : new Title();
			$output = $parser->parse( $form_def, $title, $parser->getOptions() );
			$form_def = $output->getText();
		}
		$form_def = preg_replace_callback(
			"/{$rnd}-item-(\d+)-{$rnd}/",
			function ( array $matches ) use ( $items ) {
				$markerIndex = (int) $matches[1];
				return $items[$markerIndex];
			},
			$form_def
		);

		if ( $output->getCacheTime() == -1 ) {
			$form_article = Article::newFromID( $form_id );
			self::purgeCache( $form_article );
			wfDebug( "Caching disabled for form definition $form_id\n" );
		} elseif ( $form_id !== null ) {
			self::cacheFormDefinition( $form_id, $form_def, $parser );
		}

		return $form_def;
	}

	/**
	 * Get a form definition from cache
	 */
	protected static function getFormDefinitionFromCache( $form_id, Parser $parser ) {
		global $sfgCacheFormDefinitions;

		// use cache if allowed
		if ( !$sfgCacheFormDefinitions ) {
			return null;
		}

		$cache = self::getFormCache();

		// create a cache key consisting of owner name, article id and user options
		$cacheKeyForForm = self::getCacheKey( $form_id, $parser );

		$cached_def = $cache->get( $cacheKeyForForm );

		// Cache hit?
		if ( is_string( $cached_def ) ) {
			wfDebug( "Cache hit: Got form definition $cacheKeyForForm from cache\n" );

			return $cached_def;
		}

		wfDebug( "Cache miss: Form definition $cacheKeyForForm not found in cache\n" );

		return null;
	}

	/**
	 * Store a form definition in cache
	 */
	protected static function cacheFormDefinition( $form_id, $form_def, Parser $parser ) {
		global $sfgCacheFormDefinitions;

		// Store in cache if requested
		if ( !$sfgCacheFormDefinitions ) {
			return;
		}

		$cache = self::getFormCache();
		$cacheKeyForForm = self::getCacheKey( $form_id, $parser );
		$cacheKeyForList = self::getCacheKey( $form_id );

		// Update list of form definitions
		$listOfFormKeys = $cache->get( $cacheKeyForList );
		// The list of values is used by self::purge, keys are ignored.
		// This way we automatically override duplicates.
		$listOfFormKeys[$cacheKeyForForm] = $cacheKeyForForm;

		// We cache indefinitely ignoring $wgParserCacheExpireTime.
		// The reasoning is that there really is not point in expiring
		// rarely changed forms automatically (after one day per
		// default). Instead the cache is purged on storing/purging a
		// form definition.

		// Store form definition with current user options
		$cache->set( $cacheKeyForForm, $form_def );

		// Store updated list of form definitions
		$cache->set( $cacheKeyForList, $listOfFormKeys );
		wfDebug( "Cached form definition $cacheKeyForForm\n" );
	}

	/**
	 * Deletes the form definition associated with the given wiki page
	 * from the main cache.
	 *
	 * Hooks: ArticlePurge, ArticleSave
	 *
	 * @param Page $wikipage
	 * @return bool
	 */
	public static function purgeCache( Page $wikipage ) {
		if ( !$wikipage->getTitle()->inNamespace( SF_NS_FORM ) ) {
			return true;
		}

		$cache = self::getFormCache();
		$cacheKeyForList = self::getCacheKey( $wikipage->getId() );

		// get references to stored datasets
		$listOfFormKeys = $cache->get( $cacheKeyForList );

		if ( !is_array( $listOfFormKeys ) ) {
			return true;
		}

		// delete stored datasets
		foreach ( $listOfFormKeys as $key ) {
			$cache->delete( $key );
			wfDebug( "Deleted cached form definition $key.\n" );
		}

		// delete references to datasets
		$cache->delete( $cacheKeyForList );
		wfDebug( "Deleted cached form definition references $cacheKeyForList.\n" );

		return true;
	}

	/**
	 *  Get the cache object used by the form cache
	 */
	public static function getFormCache() {
		global $sfgFormCacheType, $wgParserCacheType;
		$ret = wfGetCache( ( $sfgFormCacheType !== null ) ? $sfgFormCacheType : $wgParserCacheType  );
		return $ret;
	}


	/**
	 * Get a cache key.
	 *
	 * @param string $formId
	 * @param Parser $parser Provide parser to get unique cache key
	 * @return string
	 */
	public static function getCacheKey( $formId, $parser = null ) {
		if ( is_null( $parser ) ) {
			return wfMemcKey( 'ext.SemanticForms.formdefinition', $formId );
		} else {
			$optionsHash = $parser->getOptions()->optionsHash( ParserOptions::legacyOptions() );
			return wfMemcKey( 'ext.SemanticForms.formdefinition', $formId, $optionsHash );
		}
	}

	/*
	 * Get section header HTML
	 */
	static function headerHTML( $header_name , $header_level = 2 ) {

		global $sfgTabIndex;

		$sfgTabIndex++;
		$text = "";

		if ( !is_numeric( $header_level ) ) {
			// The default header level is set to 2
			$header_level = 2;
		}

		$header_level = min( $header_level, 6 );
		$elementName = 'h'. $header_level;
		$text = Html::rawElement( $elementName, array(), $header_name );
		return $text;
	}

	/**
	 * Get the changed index if a new template or section was
	 * inserted before the end, or one was deleted in the form
	 */
	static function getChangedIndex( $i, $new_item_loc, $deleted_item_loc ) {
		$old_i = $i;
		if ( $new_item_loc != null ) {
			if ( $i > $new_item_loc ) {
				$old_i = $i - 1;
			} elseif ( $i == $new_item_loc ) {
				// it's the new template; it shouldn't
				// get any query-string data
				$old_i = - 1;
			}
		} elseif ( $deleted_item_loc != null ) {
			if ( $i >= $deleted_item_loc ) {
				$old_i = $i + 1;
			}
		}
		return $old_i;
	}
}

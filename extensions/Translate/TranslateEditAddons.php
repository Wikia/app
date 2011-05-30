<?php
/**
 * Tools for edit page view to aid translators. This implements the so called
 * old style editing, which extends the normal edit page.
 *
 * @file
 * @author Niklas Laxström
 * @author Siebrand Mazeland
 * @copyright Copyright © 2007-2010 Niklas Laxström, Siebrand Mazeland
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Various editing enhancements to the edit page interface.
 * Partly succeeded by the new ajax-enhanced editor but kept for compatibility.
 * Also has code that is still relevant, like the hooks on save.
 */
class TranslateEditAddons {

	/**
	 * Add some tabs for navigation for users who do not use Ajax interface.
	 * @param $skin Skin
	 * @param $tabs Array
	 */
	static function addNavigationTabs( $skin, &$tabs ) {
		global $wgRequest;

		$title = $skin->getTitle();

		if ( !self::isMessageNamespace( $title ) ) {
			return true;
		}

		list( $key, $code, $group ) = self::getKeyCodeGroup( $title );
		if ( !$group || !$code ) {
			return true;
		}

		$collection = $group->initCollection( 'en' );
		$collection->filter( 'optional' );
		$keys = array_keys( $collection->keys() );
		$count = count( $keys );

		$key = strtolower( strtr( $key, ' ', '_' ) );

		$next = $prev = null;

		foreach ( $keys as $index => $tkey ) {
			if ( $key === strtolower( strtr( $tkey, ' ', '_' ) ) ) {
				break;
			}
			if ( $index === $count -1 ) {
				$index = -666;
			}
		}

		if ( isset( $keys[$index -1] ) ) {
			$prev = $keys[$index -1];
		}
		if ( isset( $keys[$index + 1] ) ) {
			$next = $keys[$index + 1];
		}

		$id = $group->getId();
		$ns = $title->getNamespace();

		$translate = SpecialPage::getTitleFor( 'Translate' );
		$fragment = htmlspecialchars( "#msg_$key" );

		$nav_params = array();
		$nav_params['loadgroup'] = $id;
		$nav_params['action'] = $wgRequest->getText( 'action', 'edit' );

		$tabindex = 2;

		if ( $prev !== null ) {
			$linktitle = Title::makeTitleSafe( $ns, "$prev/$code" );
			$data = array(
				'text' => wfMsg( 'translate-edit-tab-prev' ),
				'href' => $linktitle->getLocalUrl( $nav_params ),
			);
			self::addTab( $skin, $tabs, 'prev', $data, $tabindex );
		}

		$params = array(
			'group' => $id,
			'language' => $code,
			'task' => 'view',
			'offset' => max( 0, $index - 250 ),
			'limit' => 500,
		);
		$data = array(
			'text' => wfMsg( 'translate-edit-tab-list' ),
			'href' => $translate->getLocalUrl( $params ) . $fragment,
		);
		self::addTab( $skin, $tabs, 'list', $data, $tabindex );

		if ( $next !== null && $next !== true ) {
			$linktitle = Title::makeTitleSafe( $ns, "$next/$code" );
			$data = array(
				'text' => wfMsg( 'translate-edit-tab-next' ),
				'href' => $linktitle->getLocalUrl( $nav_params ),
			);
			self::addTab( $skin, $tabs, 'next', $data, $tabindex );
		}

		return true;
	}

	protected static function addTab( $skin, &$tabs, $name, $data, &$index ) {
		if ( $skin instanceof SkinVector ) {
			$data['class'] = false; // Vector needs it for some reason
			$tabs['namespaces'][$name] = $data;
		} else {
			array_splice( $tabs, $index++, 0, array( $name => $data ) );
		}
	}

	/**
	 * Keep the usual diiba daaba hidden from translators.
	 */
	static function intro( $object ) {
		$object->suppressIntro = true;

		return true;
	}

	/**
	 * Adds the translation aids and navigation to the normal edit page.
	 */
	static function addTools( $object ) {
		if ( !self::isMessageNamespace( $object->mTitle ) ) {
			return true;
		}

		$object->editFormTextTop .= self::editBoxes( $object );

		return true;
	}

	/**
	 * Replace the normal save button with one that says if you are editing
	 * message documentation to try to avoid accidents.
	 */
	static function buttonHack( $editpage, &$buttons, $tabindex ) {
		global $wgTranslateDocumentationLanguageCode, $wgLang;

		$handle = new MessageHandle( $editpage->mTitle );
		if ( !$handle->isValid() ) {
			return true;
		}

		$code = $handle->getCode();

		if ( $code === $wgTranslateDocumentationLanguageCode ) {
			$name = TranslateUtils::getLanguageName( $code, false, $wgLang->getCode() );
			$temp = array(
				'id'        => 'wpSave',
				'name'      => 'wpSave',
				'type'      => 'submit',
				'tabindex'  => ++$tabindex,
				'value'     => wfMsg( 'translate-save', $name ),
				'accesskey' => wfMsg( 'accesskey-save' ),
				'title'     => wfMsg( 'tooltip-save' ) . ' [' . wfMsg( 'accesskey-save' ) . ']',
			);
			$buttons['save'] = Xml::element( 'input', $temp, '' );
		}

		global $wgTranslateSupportUrl;
		if ( !$wgTranslateSupportUrl ) return true;

		$supportTitle = Title::newFromText( $wgTranslateSupportUrl['page'] );
		if ( !$supportTitle ) return true;

		$supportParams = $wgTranslateSupportUrl['params'];
		foreach ( $supportParams as &$value ) {
			$value = str_replace( '%MESSAGE%', $handle->getTitle()->getPrefixedText(), $value );
		}

		$temp = array(
			'id'        => 'wpSupport',
			'name'      => 'wpSupport',
			'type'      => 'button',
			'tabindex'  => ++$tabindex,
			'value'     => wfMsg( 'translate-js-support' ),
			'title'     => wfMsg( 'translate-js-support-title' ),
			'data-load-url' => $supportTitle->getLocalUrl( $supportParams ),
			'onclick'   => "window.open( jQuery(this).attr('data-load-url') );",
		);
		$buttons['ask'] = Html::element( 'input', $temp, '' );

		return true;
	}

	/**
	* @return Array of the message and the language
	*/
	public static function figureMessage( Title $title ) {
		$text = $title->getDBkey();
		$pos = strrpos( $text, '/' );

		if ( $pos === false ) {
			$code = '';
			$key = $text;
		} else {
			$code = substr( $text, $pos + 1 );
			$key = substr( $text, 0, $pos );
		}

		return array( $key, $code );
	}

	public static function getKeyCodeGroup( Title $title ) {
		list( $key, $code ) = self::figureMessage( $title );
		$group = self::getMessageGroup( $title->getNamespace(), $key );

		return array( $key, $code, $group );
	}

	/**
	 * Tries to determine to which group this message belongs. It tries to get
	 * group id from loadgroup GET-paramater, but fallbacks to messageIndex file
	 * if no valid group was provided, or the group provided is a meta group.
	 *
	 * @param $namespace \int The namespace number for the key we are interested in.
	 * @param $key \string The message key we are interested in.
	 * @return MessageGroup which the key belongs to, or null.
	 */
	private static function getMessageGroup( $namespace, $key ) {
		global $wgRequest;

		$group = $wgRequest->getText( 'loadgroup', '' );
		$mg = MessageGroups::getGroup( $group );

		if ( $mg === null ) {
			$group = TranslateUtils::messageKeyToGroup( $namespace, $key );
			if ( $group ) {
				$mg = MessageGroups::getGroup( $group );
			}
		}

		return $mg;
	}

	private static function editBoxes( $object ) {
		global $wgOut, $wgRequest;

		$th = new TranslationHelpers( $object->mTitle );
		if ( $object->firsttime && !$wgRequest->getCheck( 'oldid' ) && !$wgRequest->getCheck( 'undo' ) ) {
			$object->textbox1 = $th->getTranslation();
		} else {
			$th->setTranslation( $object->textbox1 );
		}

		TranslationHelpers::addModules( $wgOut );

		return $th->getBoxes();
	}

	/**
	 * Check if a string contains the fuzzy string.
	 *
	 * @param $text \string Arbitrary text
	 * @return \bool If string contains fuzzy string.
	 */
	public static function hasFuzzyString( $text ) {
		return strpos( $text, TRANSLATE_FUZZY ) !== false;
	}

	/** Check if a title is marked as fuzzy.
	 *
	 * @param $title Title
	 * @return \bool If title is marked fuzzy.
	 */
	public static function isFuzzy( Title $title ) {
		$dbr = wfGetDB( DB_SLAVE );
		$id = $dbr->selectField( 'revtag_type', 'rtt_id', array( 'rtt_name' => 'fuzzy' ), __METHOD__ );

		$tables = array( 'page', 'revtag' );
		$fields = array( 'rt_type' );
		$conds  = array(
			'page_namespace' => $title->getNamespace(),
			'page_title' => $title->getDBkey(),
			'rt_type' => $id,
			'page_id=rt_page',
			'page_latest=rt_revision'
		);

		$res = $dbr->selectField( $tables, $fields, $conds, __METHOD__ );

		return $res === $id;
	}


	/** Check if a title is in a message namespace.
	 *
	 * @param $title Title
	 * @return \bool If title is in a message namespace.
	 */
	public static function isMessageNamespace( Title $title ) {
		global $wgTranslateMessageNamespaces;

		$namespace = $title->getNamespace();

		return in_array( $namespace, $wgTranslateMessageNamespaces, true );
	}

	/**
	 * @static
	 * @param $skin Skin
	 * @param $tabs
	 * @return bool
	 */
	public static function tabs( $skin, &$tabs ) {
		if ( !self::isMessageNamespace( $skin->getTitle() ) ) {
			return true;
		}

		unset( $tabs['protect'] );

		return true;
	}

	public static function keepFields( $edit, $out ) {
		global $wgRequest;

		$out->addHTML( "\n" .
			Html::hidden( 'loadgroup', $wgRequest->getText( 'loadgroup' ) ) .
			Html::hidden( 'loadtask', $wgRequest->getText( 'loadtask' ) ) .
			"\n"
		);

		return true;
	}

	public static function onSave( $article, $user, $text, $summary,
			$minor, $_, $_, $flags, $revision
	) {
		$title = $article->getTitle();

		if ( !self::isMessageNamespace( $title ) ) {
			return true;
		}

		list( $key, $code, $group ) = self::getKeyCodeGroup( $title );

		// Unknown message, do not handle.
		if ( !$group || !$code ) {
			return true;
		}

		$groups = TranslateUtils::messageKeyToGroups( $title->getNamespace(), $key );
		$cache = new ArrayMemoryCache( 'groupstats' );

		foreach ( $groups as $g ) {
			$cache->clear( $g, $code );
		}

		// Check for explicit tag.
		$fuzzy = self::hasFuzzyString( $text );

		// Check for problems, but only if not fuzzy already.
		global $wgTranslateDocumentationLanguageCode;
		if ( $code !== $wgTranslateDocumentationLanguageCode ) {
			$checker = $group->getChecker();

			if ( $checker ) {
				$en = $group->getMessage( $key, 'en' );
				$message = new FatMessage( $key, $en );
				/**
				 * Take the contents from edit field as a translation.
				 */
				$message->setTranslation( $text );

				$checks = $checker->checkMessage( $message, $code );
				if ( count( $checks ) ) {
					$fuzzy = true;
				}
			}
		}

		// Update it.
		if ( $revision === null ) {
			$rev = $article->getTitle()->getLatestRevId();
		} else {
			$rev = $revision->getID();
		}

		// begin fuzzy tag.
		$dbw = wfGetDB( DB_MASTER );

		$id = $dbw->selectField( 'revtag_type', 'rtt_id', array( 'rtt_name' => 'fuzzy' ), __METHOD__ );

		$conds = array(
			'rt_page' => $article->getTitle()->getArticleId(),
			'rt_type' => $id,
			'rt_revision' => $rev
		);
		// Remove any existing fuzzy tags for this revision
		$dbw->delete( 'revtag', $conds, __METHOD__ );

		// Add the fuzzy tag if needed.
		if ( $fuzzy !== false ) {
			$dbw->insert( 'revtag', $conds, __METHOD__ );
		}

		// Diffs for changed messages.
		if ( $fuzzy !== false ) {
			return true;
		}

		if ( $group instanceof WikiPageMessageGroup ) {
			return true;
		}

		$definitionTitle = Title::makeTitleSafe( $title->getNamespace(), "$key/en" );
		if ( $definitionTitle && $definitionTitle->exists() ) {
			$definitionRevision = $definitionTitle->getLatestRevID();

			$id = $dbw->selectField( 'revtag_type', 'rtt_id',
				array( 'rtt_name' => 'tp:transver' ), __METHOD__ );

			$conds = array(
				'rt_page' => $title->getArticleId(),
				'rt_type' => $id,
				'rt_revision' => $rev,
				'rt_value' => $definitionRevision,
			);
			$index = array( 'rt_type', 'rt_page', 'rt_revision' );
			$dbw->replace( 'revtag', array( $index ), $conds, __METHOD__ );
		}

		return true;
	}

	public static function preserveWhitespaces( $text ) {
		$text = wfEscapeWikiText( $text );
		$text = preg_replace( '/^ /m', '&#160;', $text );
		$text = preg_replace( '/ $/m', '&#160;', $text );
		$text = preg_replace( '/  /', '&#160; ', $text );
		$text = str_replace( "\n", '<br />', $text );
		return $text;
	}

	public static function translateMessageDocumentationLanguage( &$names, $code ) {
		global $wgTranslateDocumentationLanguageCode;
		if ( $wgTranslateDocumentationLanguageCode ) {
			$names[$wgTranslateDocumentationLanguageCode] =
				wfMessage( 'translate-documentation-language' )->inLanguage( $code )->plain();
		}
		return true;
	}

	public static function disablePreSaveTransform( $article, $popts ) {
		global $wgTranslateDocumentationLanguageCode;
		$keycodegroup = self::getKeyCodeGroup( $article->getTitle() );
		if ( self::isMessageNamespace( $article->getTitle() )
			&& $keycodegroup[1] !== $wgTranslateDocumentationLanguageCode ) {
			$popts->setPreSaveTransform( false );
		}
		return true;
	}

	public static function displayOnDiff( $de, $out ) {
		$title = $de->getTitle();
		$handle = new MessageHandle( $title );

		if ( !$handle->isValid() ) {
			return true;
		}

		$de->loadNewText();
		$out->setRevisionId( $de->mNewRev->getId() );

		$th = new TranslationHelpers( $title );
		$th->setEditMode( false );
		$th->setTranslation( $de->mNewtext );
		TranslationHelpers::addModules( $out );

		$boxes = array();
		$boxes[] = $th->getDocumentationBox();
		$boxes[] = $th->getDefinitionBox();
		$boxes[] = $th->getTranslationDisplayBox();
		$output = Html::rawElement( 'div', array( 'class' => 'mw-sp-translate-edit-fields' ), implode( "\n\n", $boxes ) );
		$out->addHtml( $output );
		return false;
	}

	public static function searchProfile( &$profiles ) {
		global $wgTranslateMessageNamespaces;
		$insert = array();
		$insert['translation'] = array(
			'message' => 'translate-searchprofile',
			'tooltip' => 'translate-searchprofile-tooltip',
			'namespaces' => $wgTranslateMessageNamespaces,
		);
		
		$profiles = wfArrayInsertAfter( $profiles, $insert, 'help' );
		return true;
	}

	public static function searchProfileForm( $search, &$form, $profile, $term, $opts ) {
		if ( $profile !== 'translation' ) {
			return true;
		}

		if( !$search->getSearchEngine()->supports( 'title-suffix-filter' ) ) {
			return false;
		}

		$hidden = '';
		foreach( $opts as $key => $value ) {
			$hidden .= Html::hidden( $key, $value );
		}

		$context = $search->getContext();
		$code = $context->getLang()->getCode();
		$selected = $context->getRequest()->getVal( 'languagefilter' );

		if ( is_callable( array( 'LanguageNames', 'getNames' ) ) ) {
			$languages = LanguageNames::getNames( $code,
				LanguageNames::FALLBACK_NORMAL,
				LanguageNames::LIST_MW
			);
		} else {
			$languages = Language::getLanguageNames( false );
		}

		ksort( $languages );

		$selector = new HTMLSelector( 'languagefilter', 'languagefilter', $selected );
		$selector->addOption( wfMessage( 'translate-search-nofilter' ), '-' );
		foreach ( $languages as $code => $name ) {
			$selector->addOption( "$code - $name", $code );
		}

		$selector = $selector->getHTML();

		$label = Xml::label( wfMessage( 'translate-search-languagefilter' ), 'languagefilter' ) . '&#160;';
		$params = array( 'id' => 'mw-searchoptions' );

		$form = Xml::fieldset( false, false, $params ) .
			$hidden . $label . $selector .
			Html::closeElement( 'fieldset' );
		return false;
	}

	public static function searchProfileSetupEngine( $search, $profile, $engine ) {
		if ( $profile !== 'translation' ) {
			return true;
		}

		$context = $search->getContext();
		$selected = $context->getRequest()->getVal( 'languagefilter' );
		if ( $selected !== '-' && $selected ) {
			$engine->setFeatureData( 'title-suffix-filter', "/$selected" );
			$search->setExtraParam( 'languagefilter', $selected );
		}
		return true;
	}

}

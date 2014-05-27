<?php
/**
 * Tools for edit page view to aid translators. This implements the so called
 * old style editing, which extends the normal edit page.
 *
 * @file
 * @author Niklas Laxström
 * @author Siebrand Mazeland
 * @copyright Copyright © 2007-2011 Niklas Laxström, Siebrand Mazeland
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
	 * Hooks: SkinTemplateNavigation, SkinTemplateTabs
	 */
	static function addNavigationTabs( Skin $skin, array &$tabs ) {
		global $wgRequest;

		$title = $skin->getTitle();
		$handle = new MessageHandle( $title );

		if ( !$handle->isValid() ) {
			return true;
		}

		$group = $handle->getGroup();
		// Happens when translation page move is in progress
		if ( !$group ) {
			return true;
		}

		$key = $handle->getKey();
		$code = $handle->getCode();
		$collection = $group->initCollection( $group->getSourceLanguage() );
		$collection->filter( 'optional' );
		$keys = $collection->getMessageKeys();
		$count = count( $keys );

		$key = strtolower( strtr( $key, ' ', '_' ) );

		$next = $prev = null;

		$match = -100;

		foreach ( $keys as $index => $tkey ) {
			if ( $key === strtolower( strtr( $tkey, ' ', '_' ) ) ) {
				$match = $index;
				break;
			}
		}

		if ( isset( $keys[$match -1] ) ) {
			$prev = $keys[$match -1];
		}
		if ( isset( $keys[$match + 1] ) ) {
			$next = $keys[$match + 1];
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

		if ( $next !== null ) {
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
		// SkinChihuahua is an exception for userbase.kde.org.
		if ( $skin instanceof SkinVector || $skin instanceof SkinChihuahua ) {
			$data['class'] = false; // These skins need it for some reason
			$tabs['namespaces'][$name] = $data;
		} else {
			array_splice( $tabs, $index++, 0, array( $name => $data ) );
		}
	}

	/**
	 * Keep the usual diiba daaba hidden from translators.
	 * Hook: AlternateEdit
	 */
	public static function intro( EditPage $editpage ) {
		$handle = new MessageHandle( $editpage->mTitle );
		if ( $handle->isValid() ) {
			$editpage->suppressIntro = true;
			return true;
		}

		$msg = wfMsgForContent( 'translate-edit-tag-warning' );

		if ( $msg !== '' && $msg !== '-' && TranslatablePage::isSourcePage( $editpage->mTitle ) ) {
			global $wgOut;
			$editpage->editFormTextTop .= $wgOut->parse( $msg );
		}

		return true;
	}

	/**
	 * Adds the translation aids and navigation to the normal edit page.
	 * Hook: EditPage::showEditForm:initial
	 */
	static function addTools( EditPage $object ) {
		$handle = new MessageHandle( $object->mTitle );
		if ( !$handle->isValid() ) {
			return true;
		}

		$object->editFormTextTop .= self::editBoxes( $object );
		return true;
	}

	/**
	 * Replace the normal save button with one that says if you are editing
	 * message documentation to try to avoid accidents.
	 * Hook: EditPageBeforeEditButtons
	 */
	static function buttonHack( EditPage $editpage, &$buttons, $tabindex ) {
		global $wgLang;

		$handle = new MessageHandle( $editpage->mTitle );
		if ( !$handle->isValid() ) {
			return true;
		}

		if ( $handle->isDoc() ) {
			$name = TranslateUtils::getLanguageName( $handle->getCode(), false, $wgLang->getCode() );
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
		if ( !$wgTranslateSupportUrl ) {
			return true;
		}

		$supportTitle = Title::newFromText( $wgTranslateSupportUrl['page'] );
		if ( !$supportTitle ) {
			return true;
		}

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
	 * @param $title Title
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

	/**
	 * @param $object
	 * @return String
	 */
	private static function editBoxes( EditPage $object ) {
		global $wgOut, $wgRequest;

		$groupId = $wgRequest->getText( 'loadgroup', '' );
		$th = new TranslationHelpers( $object->mTitle, $groupId );
		if ( $object->firsttime && !$wgRequest->getCheck( 'oldid' ) && !$wgRequest->getCheck( 'undo' ) ) {
			$object->textbox1 = (string) $th->getTranslation();
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
		# wfDeprecated( __METHOD__, '1.19' );
		return MessageHandle::hasFuzzyString( $text );
	}

	/**
	 * Check if a title is marked as fuzzy.
	 * @param $title Title
	 * @return \bool If title is marked fuzzy.
	 */
	public static function isFuzzy( Title $title ) {
		# wfDeprecated( __METHOD__, '1.19' );
		$handle = new MessageHandle( $title );
		return $handle->isFuzzy();
	}

	/**
	 * Removes protection tab for message namespaces - not useful.
	 * Hook: SkinTemplateTabs
	 */
	public static function tabs( Skin $skin, &$tabs ) {
		$handle = new MessageHandle( $skin->getTitle() );
		if ( $handle->isMessageNamespace() ) {
			unset( $tabs['protect'] );
		}

		return true;
	}

	/**
	 * Hook: EditPage::showEditForm:fields
	 */
	public static function keepFields( EditPage $edit, OutputPage $out ) {
		global $wgRequest;

		$out->addHTML( "\n" .
			Html::hidden( 'loadgroup', $wgRequest->getText( 'loadgroup' ) ) .
			Html::hidden( 'loadtask', $wgRequest->getText( 'loadtask' ) ) .
			"\n"
		);

		return true;
	}

	/**
	 * Runs message checks, adds tp:transver tags and updates statistics.
	 * Hook: ArticleSaveComplete
	 */
	public static function onSave( $article, $user, $text, $summary,
			$minor, $_, $_, $flags, $revision
	) {
		$title = $article->getTitle();
		$handle = new MessageHandle( $title );

		if ( !$handle->isValid() ) {
			return true;
		}

		// Update it.
		if ( $revision === null ) {
			$rev = $article->getTitle()->getLatestRevId();
		} else {
			$rev = $revision->getID();
		}

		$fuzzy = self::checkNeedsFuzzy( $handle, $text );
		self::updateFuzzyTag( $title, $rev, $fuzzy );
		MessageGroupStats::clear( $handle );

		if ( $fuzzy === false ) {
			wfRunHooks( 'Translate:newTranslation', array( $handle, $rev, $text, $user ) );
		}

		return true;
	}

	/**
	 * @return bool
	 */
	protected static function checkNeedsFuzzy( MessageHandle $handle, /*string*/$text ) {
		// Check for explicit tag.
		$fuzzy = self::hasFuzzyString( $text );

		// Docs are exempt for checks
		if ( $handle->isDoc() ) {
			return $fuzzy;
		}

		// Not all groups have checkers
		$group = $handle->getGroup();
		$checker = $group->getChecker();
		if ( !$checker ) {
			return $fuzzy;
		}

		$code = $handle->getCode();
		$key = $handle->getKey();
		$en = $group->getMessage( $key, $group->getSourceLanguage() );
		$message = new FatMessage( $key, $en );
		// Take the contents from edit field as a translation.
		$message->setTranslation( $text );

		$checks = $checker->checkMessage( $message, $code );
		if ( count( $checks ) ) {
			$fuzzy = true;
		}

		return $fuzzy;
	}

	/**
	 * @param $title Title
	 * @param $revision int
	 * @param $fuzzy bool
	 */
	protected static function updateFuzzyTag( Title $title, $revision, $fuzzy ) {
		$dbw = wfGetDB( DB_MASTER );

		$conds = array(
			'rt_page' => $title->getArticleId(),
			'rt_type' => RevTag::getType( 'fuzzy' ),
			'rt_revision' => $revision
		);

		// Replace the existing fuzzy tag, if any
		if ( $fuzzy !== false ) {
			$index = array_keys( $conds );
			$dbw->replace( 'revtag', array( $index ), $conds, __METHOD__ );
		} else {
			$dbw->delete( 'revtag', $conds, __METHOD__ );
		}
	}


	/**
	 * Adds tag which identifies the revision of source message at that time.
	 * This is used to show diff against current version of source message
	 * when updating a translation.
	 * Hook: Translate:newTranslation
	 * @param $handle MessageHandle
	 * @param $revision int
	 * @param $text string
	 * @param $user User
	 * @return bool
	 */
	public static function updateTransverTag( MessageHandle $handle, $revision, $text, User $user ) {
		if ( $user->isAllowed( 'bot' ) ) {
			return false;
		}

		$group = $handle->getGroup();
		if ( $group instanceof WikiPageMessageGroup ) {
			// WikiPageMessageGroup has different method
			return true;
		}

		$title = $handle->getTitle();
		$name = $handle->getKey() . '/' . $group->getSourceLanguage();
		$definitionTitle = Title::makeTitleSafe( $title->getNamespace(), $name );
		if ( !$definitionTitle || !$definitionTitle->exists() ) {
			return true;
		}

		$definitionRevision = $definitionTitle->getLatestRevID();

		$dbw = wfGetDB( DB_MASTER );

		$conds = array(
			'rt_page' => $title->getArticleId(),
			'rt_type' => RevTag::getType( 'tp:transver' ),
			'rt_revision' => $revision,
			'rt_value' => $definitionRevision,
		);
		$index = array( 'rt_type', 'rt_page', 'rt_revision' );
		$dbw->replace( 'revtag', array( $index ), $conds, __METHOD__ );
		return true;
	}

	/**
	 * Hook: ArticlePrepareTextForEdit
	 */
	public static function disablePreSaveTransform( $article, ParserOptions $popts ) {
		$handle = new MessageHandle( $article->getTitle() );
		if ( $handle->isMessageNamespace() && !$handle->isDoc() ) {
			$popts->setPreSaveTransform( false );
		}
		return true;
	}

	/**
	 * Hook: ArticleContentOnDiff
	 */
	public static function displayOnDiff( DifferenceEngine $de, OutputPage $out ) {
		$title = $de->getTitle();
		$handle = new MessageHandle( $title );

		if ( !$handle->isValid() ) {
			return true;
		}

		$de->loadNewText();
		$out->setRevisionId( $de->mNewRev->getId() );

		$th = new TranslationHelpers( $title, /*group*/false );
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
}

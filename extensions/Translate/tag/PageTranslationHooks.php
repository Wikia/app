<?php
/**
 * Contains class with page translation feature hooks.
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2008-2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Hooks for page translation.
 *
 * @todo Methods need documentation.
 * @ingroup PageTranslation
 */
class PageTranslationHooks {
	// Uuugly hack
	static $allowTargetEdit = false;

	/**
	 * @static
	 * @param  $parser Parser
	 * @param  $text String
	 * @param  $state
	 * @return bool
	 */
	public static function renderTagPage( $parser, &$text, $state ) {
		$title = $parser->getTitle();

		if ( strpos( $text, '<translate>' ) !== false ) {
			try {
				$parse = TranslatablePage::newFromText( $parser->getTitle(), $text )->getParse();
				$text = $parse->getTranslationPageText( null );
			} catch ( TPException $e ) {
				// Show ugly preview without processed <translate> tags
			}
		}

		// For translation pages, parse plural, grammar etc with correct language
		$page = TranslatablePage::isTranslationPage( $title );
		if ( $page ) {
			list( , $code ) = TranslateUtils::figureMessage( $title->getText() );
			$parser->getOptions()->setTargetLanguage( Language::factory( $code ) );
			$name = $page->getPageDisplayTitle( $code );
			if ( $name ) {
				$realFunction = array( 'MessageCache', 'singleton' );
				if ( is_callable( $realFunction ) ) {
					$cache = MessageCache::singleton();
				} else {
					global $wgMessageCache;
					$cache = $wgMessageCache;
				}
				$name = $cache->transform( $name, false, Language::factory( $code ) );
				$parser->getOutput()->setDisplayTitle( $name );
			}
		}

		return true;
	}

	// Only called form hook
	public static function injectCss( $outputpage, $text ) {
		TranslateUtils::injectCSS();

		return true;
	}

	public static function titleToGroup( Title $title ) {
		$namespace = $title->getNamespace();
		$text = $title->getDBkey();
		list( $key, ) = TranslateUtils::figureMessage( $text );

		return TranslateUtils::messageKeyToGroup( $namespace, $key );
	}

	/**
	 * @static
	 * @param $article Article
	 * @param $user User
	 * @param  $text
	 * @param  $summary
	 * @param  $minor
	 * @param  $_
	 * @param  $_
	 * @param  $flags
	 * @param  $revision
	 * @return bool
	 */
	public static function onSectionSave( $article, $user, $text, $summary, $minor,
		$_, $_, $flags, $revision ) {
		$title = $article->getTitle();

		// Some checks

		// We are only interested in the translations namespace
		if ( $title->getNamespace() != NS_TRANSLATIONS ) {
			return true;
		}

		// Do not trigger renders for fuzzy
		if ( strpos( $text, TRANSLATE_FUZZY ) !== false ) {
			return true;
		}

		// Figure out the group
		$groupKey = self::titleToGroup( $title );
		$group = MessageGroups::getGroup( $groupKey );
		if ( !$group instanceof WikiPageMessageGroup ) {
			SpecialPageTranslation::superDebug( __METHOD__, 'not wp-group', $title, $user, $groupKey );
			return;
		}

		// Finally we know the title and can construct a Translatable page
		$page = TranslatablePage::newFromTitle( $group->getTitle() );

		// Add a tracking mark
		if ( $revision !== null ) {
			self::addSectionTag( $title, $revision->getId(), $page->getMarkedTag() );
		}

		// Update the target translation page
		list( , $code ) = TranslateUtils::figureMessage( $title->getDBkey() );
		global $wgTranslateDocumentationLanguageCode;
		if ( $code !== $wgTranslateDocumentationLanguageCode ) {
			SpecialPageTranslation::superDebug( __METHOD__, 'ok', $title, $user );
			self::updateTranslationPage( $page, $code, $user, $flags, $summary );
		}

		return true;
	}

	protected static function addSectionTag( Title $title, $revision, $pageRevision ) {
		if ( $pageRevision === null ) {
			throw new MWException( 'Page revision is null' );
		}

		$dbw = wfGetDB( DB_MASTER );

		// Can this be done in one query?
		$id = $dbw->selectField( 'revtag_type', 'rtt_id',
			array( 'rtt_name' => 'tp:transver' ), __METHOD__ );

		$conds = array(
			'rt_page' => $title->getArticleId(),
			'rt_type' => $id,
			'rt_revision' => $revision
		);
		$dbw->delete( 'revtag', $conds, __METHOD__ );

		$conds['rt_value'] = $pageRevision;

		$dbw->insert( 'revtag', $conds, __METHOD__ );
	}

	public static function updateTranslationPage( TranslatablePage $page,
		$code, $user, $flags, $summary ) {

		$source = $page->getTitle();
		$target = Title::makeTitle( $source->getNamespace(), $source->getDBkey() . "/$code" );

		// We don't know and don't care
		$flags &= ~EDIT_NEW & ~EDIT_UPDATE;

		// Update the target page
		$job = RenderJob::newJob( $target );
		$job->setUser( $user );
		$job->setSummary( $summary );
		$job->setFlags( $flags );
		$job->run();

		// Regenerate translation caches
		$page->getTranslationPercentages( 'force' );

		// Invalidate caches
		$pages = $page->getTranslationPages();
		foreach ( $pages as $title ) {
			$article = new Article( $title, 0 );
			$article->doPurge();
		}

		// And the source page itself too
		$article = new Article( $page->getTitle(), 0 );
		$article->doPurge();
	}

	public static function languages( $data, $params, $parser ) {
		$title = $parser->getTitle();

		// Check if this is a source page or a translation page
		$page = TranslatablePage::newFromTitle( $title );
		if ( $page->getMarkedTag() === false ) {
			$page = TranslatablePage::isTranslationPage( $title );
		}

		if ( $page === false || $page->getMarkedTag() === false ) {
			return '';
		}

		$status = $page->getTranslationPercentages();
		if ( !$status ) {
			return '';
		}

		// Fix title
		$title = $page->getTitle();

		// Sort by language code, which seems to be the only sane method
		ksort( $status );

		$options = $parser->getOptions();

		if ( method_exists( $options, 'getUserLang' ) ) {
			$userLangCode = $options->getUserLang();
			$sk = false;
		} else { // Backward compat for MediaWiki 1.17
			global $wgLang;
			$userLangCode = $wgLang->getCode();
			$sk = $options->getSkin();
		}

		$languages = array();
		foreach ( $status as $code => $percent ) {
			$name = TranslateUtils::getLanguageName( $code, false, $userLangCode );
			$name = htmlspecialchars( $name ); // Unlikely, but better safe

			/* Percentages are too accurate and take more
			 * space than simple images */
			$percent *= 100;
			if     ( $percent < 20 ) $image = 1;
			elseif ( $percent < 40 ) $image = 2;
			elseif ( $percent < 60 ) $image = 3;
			elseif ( $percent < 80 ) $image = 4;
			else                     $image = 5;

			$percent = Xml::element( 'img', array(
				'src'   => TranslateUtils::assetPath( "images/prog-$image.png" ),
				'alt'   => "$percent%", // @todo i18n missing.
				'title' => "$percent%", // @todo i18n missing.
				'width' => '9',
				'height' => '9',
			) );

			// Add links to other languages
			$suffix = ( $code === 'en' ) ? '' : "/$code";
			$_title = Title::makeTitle( $title->getNamespace(), $title->getDBkey() . $suffix );

			if ( $parser->getTitle()->getText() === $_title->getText() ) {
				$languages[] = Html::rawElement( 'b', null, "*$name* $percent" );
			} elseif ( $code === $userLangCode ) {
				// Backward compat for MediaWiki 1.17
				if( $sk ) {
					$languages[] = $sk->linkKnown( $_title, Html::rawElement( 'b', null, "$name $percent" ) );
				} else {
					$languages[] = Linker::linkKnown( $_title, Html::rawElement( 'b', null, "$name $percent" ) );
				}
			} else {
				// Backward compat for MediaWiki 1.17
				if( $sk ) {
					$languages[] = $sk->linkKnown( $_title, "$name $percent" );
				} else {
					$languages[] = Linker::linkKnown( $_title, "$name $percent" );
				}
			}
		}

		$legend = wfMsg( 'tpt-languages-legend' );
		$languages = implode( wfMsg( 'tpt-languages-separator' ), $languages );

		return <<<FOO
<div class="mw-pt-languages">
<table><tbody>

<tr valign="top">
<td class="mw-pt-languages-label"><b>$legend</b></td>
<td class="mw-pt-languages-list">$languages</td></tr>

</tbody></table>
</div>
FOO;
	}

	// To display nice error for editpage
	public static function tpSyntaxCheckForEditPage( $editpage, $text, &$error, $summary ) {
		if ( strpos( $text, '<translate>' ) === false ) {
			return true;
		}

		$page = TranslatablePage::newFromText( $editpage->mTitle, $text );
		try {
			$page->getParse();
		} catch ( TPException $e ) {
			$error .= Html::rawElement( 'div', array( 'class' => 'error' ), $e->getMessage() );
		}

		return true;
	}

	/**
	 * When attempting to save, last resort. Edit page would only display
	 * edit conflict if there wasn't tpSyntaxCheckForEditPage
	 */
	public static function tpSyntaxCheck( $article, $user, $text, $summary,
			$minor, $_, $_, $flags, $status ) {
		// Quick escape on normal pages
		if ( strpos( $text, '<translate>' ) === false ) {
			return true;
		}

		$page = TranslatablePage::newFromText( $article->getTitle(), $text );
		try {
			$page->getParse();
		} catch ( TPException $e ) {
			call_user_func_array( array( $status, 'fatal' ), $e->getMsg() );
			return false;
		}

		return true;
	}

	public static function addTranstag( $article, $user, $text, $summary,
			$minor, $_, $_, $flags, $revision ) {
		// We are not interested in null revisions
		if ( $revision === null ) {
			return true;
		}

		// Quick escape on normal pages
		if ( strpos( $text, '</translate>' ) === false ) {
			return true;
		}

		// Add the ready tag
		$page = TranslatablePage::newFromTitle( $article->getTitle() );
		if ( $page->getParse()->countSections() > 0 ) {
			$page->addReadyTag( $revision->getId() );
		}

		return true;
	}

	/// Prevent editing of unknown pages in Translations namespace
	public static function preventUnknownTranslations( $title, $user, $action, &$result ) {
		if ( $title->getNamespace() == NS_TRANSLATIONS && $action === 'edit' ) {
			$group = self::titleToGroup( $title );
			if ( $group === null ) {
				// No group means that the page is currently not
				// registered to any page translation message groups
				$result = array( 'tpt-unknown-page' );
				return false;
			}
		}

		return true;
	}

	/// Prevent editing of translation pages directly
	public static function preventDirectEditing( $title, $user, $action, &$result ) {
		$page = TranslatablePage::isTranslationPage( $title );
		if ( $page !== false ) {
			if ( self::$allowTargetEdit ) {
				return true;
			}

			if ( $page->getMarkedTag() ) {
				list( , $code ) = TranslateUtils::figureMessage( $title->getText() );
				$result = array(
					'tpt-target-page',
					$page->getTitle()->getPrefixedText(),
					$page->getTranslationUrl( $code )
				);

				return false;
			}
		} elseif ( $action === 'delete' ) {
			$page = TranslatablePage::newFromTitle( $title );
			if ( $page->getMarkedTag() ) {
				$result = array( 'tpt-delete-impossible' );
				return false;
			}
		}

		return true;
	}

	public static function schemaUpdates( $updater = null ) {
		$dir = dirname( __FILE__ ) . '/..';

		if ( $updater === null ) {
			global $wgExtNewTables, $wgExtNewFields;

			$wgExtNewTables[] = array( 'translate_sections', "$dir/translate.sql" );
			$wgExtNewFields[] = array( 'translate_sections', 'trs_order', "$dir/translate-add-trs_order.patch.sql" );
			$wgExtNewTables[] = array( 'revtag_type', "$dir/revtags.sql" );
		} else {
			$updater->addExtensionUpdate( array( 'addTable', 'translate_sections', "$dir/translate.sql", true ) );
			$updater->addExtensionUpdate( array( 'addField', 'translate_sections', 'trs_order', "$dir/translate-add-trs_order.patch.sql", true ) );
			$updater->addExtensionUpdate( array( 'addTable', 'revtag_type', "$dir/revtags.sql", true ) );
		}
		return true;
	}

	/// @todo: fix method name.
	public static function test( &$article, &$outputDone, &$pcache ) {
		if ( !$article->getOldID() ) {
			self::header( $article->getTitle() );
		}

		return true;
	}

	public static function header( Title $title ) {
		if ( TranslatablePage::isSourcePage( $title ) ) {
			self::sourcePageHeader( $title );
		} elseif ( TranslatablePage::isTranslationPage( $title ) )  {
			self::translationPageHeader( $title );
		}
	}

	protected static function sourcePageHeader( Title $title ) {
		global $wgUser, $wgLang;

		$page = TranslatablePage::newFromTitle( $title );

		$marked = $page->getMarkedTag();
		$ready = $page->getReadyTag();

		$title = $page->getTitle();
		$sk = $wgUser->getSkin();

		$latest = $title->getLatestRevId();
		$canmark = $ready === $latest && $marked !== $latest;

		$actions = array();

		if ( $marked && $wgUser->isAllowed( 'translate' ) ) {
			$par = array(
				'group' => $page->getMessageGroupId(),
				'language' => $wgLang->getCode(),
				'task' => 'view'
			);

			$translate = SpecialPage::getTitleFor( 'Translate' );
			$linkDesc  = wfMsgHtml( 'translate-tag-translate-link-desc' );
			$actions[] = $sk->link( $translate, $linkDesc, array(), $par );
		}

		if ( $canmark ) {
			$diffUrl = $title->getFullUrl( array( 'oldid' => $marked, 'diff' => $latest ) );
			$par = array( 'target' => $title->getPrefixedText() );
			$translate = SpecialPage::getTitleFor( 'PageTranslation' );

			if ( $wgUser->isAllowed( 'pagetranslation' ) ) {
				// This page has never been marked
				if ( $marked === false ) {
					$linkDesc  = wfMsgHtml( 'translate-tag-markthis' );
					$actions[] = $sk->link( $translate, $linkDesc, array(), $par );
				} else {
					$markUrl = $translate->getFullUrl( $par );
					$actions[] = wfMsgExt( 'translate-tag-markthisagain', 'parseinline', $diffUrl, $markUrl );
				}
			} else {
				$actions[] = wfMsgExt( 'translate-tag-hasnew', 'parseinline', $diffUrl );
			}
		}

		if ( !count( $actions ) ) {
			return;
		}

		$legend  = Html::rawElement(
			'div',
			array( 'style' => 'font-size: x-small; text-align: center;' ),
			$wgLang->semicolonList( $actions )
		) . Html::element( 'hr' );

		global $wgOut;

		$wgOut->addHTML( $legend );
	}

	protected static function translationPageHeader( Title $title ) {
		global $wgOut;

		// Check if applicable
		$page = TranslatablePage::isTranslationPage( $title );
		if ( $page === false ) {
			return;
		}

		list( , $code ) = TranslateUtils::figureMessage( $title->getText() );

		// Get the translation percentage
		$pers = $page->getTranslationPercentages();
		$per = 0;
		if ( isset( $pers[$code] ) ) {
			$per = $pers[$code] * 100;
		}
		$titleText = $page->getTitle()->getPrefixedText();
		$url = $page->getTranslationUrl( $code );

		// Output
		$wrap = '<div style="font-size: x-small; text-align: center">$1</div>';
		$wgOut->wrapWikiMsg( $wrap, array( 'tpt-translation-intro', $url, $titleText, $per ) );

		if ( floor( $per ) < 100 ) {
			$group = $page->getMessageGroup();
			$collection = $group->initCollection( $code );
			$collection->filter( 'fuzzy', false );
			if ( count( $collection ) ) {
				$wrap = '<div style="font-size: x-small; text-align: center" class="mw-translate-fuzzy">$1</div>';
				$wgOut->wrapWikiMsg( $wrap, array( 'tpt-translation-intro-fuzzy' ) );
			}
		}

		$wgOut->addHTML( '<hr />' );
	}

	public static function parserTestTables( &$tables ) {
		$tables[] = 'revtag_type';
		$tables[] = 'revtag';

		return true;
	}

	public static function preventCategorization( $updater ) {
		global $wgTranslateDocumentationLanguageCode;
		$title = $updater->getTitle();
		list( , $code ) = TranslateUtils::figureMessage( $title );
		if ( $title->getNamespace() == NS_TRANSLATIONS && $code !== $wgTranslateDocumentationLanguageCode ) {
			$updater->mCategories = array();
		}
		return true;
	}

	public static function formatLogEntry( $type, $action, $title, $forUI, $params ) {
		global $wgLang, $wgContLang;

		$language = $forUI === null ? $wgContLang : $wgLang;
		$opts = array( 'parseinline', 'language' => $language );

		$_ = unserialize( $params[0] );
		$user =  $_['user'];

		if ( $action === 'mark' ) {
			return wfMsgExt( 'pt-log-mark', $opts, $title->getPrefixedText(), $user, $_['revision'] );
		} elseif ( $action === 'unmark' ) {
			return wfMsgExt( 'pt-log-unmark', $opts, $title->getPrefixedText(), $user );
		} elseif ( $action === 'moveok' ) {
			return wfMsgExt( 'pt-log-moveok', $opts, $title->getPrefixedText(), $user );
		} elseif ( $action === 'movenok' ) {
			return wfMsgExt( 'pt-log-movenok', $opts, $title->getPrefixedText(), $user, $_['target'] );
		}
	}

	public static function replaceMovePage( &$list ) {
		$old = is_array( $list['Movepage'] );
		$list['Movepage'] = array( 'SpecialPageTranslationMovePage', $old );
		return true;
	}

	public static function lockedPagesCheck( $title, $user, $action, &$result ) {
		global $wgMemc;
		$key = wfMemcKey( 'pt-lock', $title->getPrefixedText() );
		if ( $wgMemc->get( $key ) === true ) {
			$result = array( 'pt-locked-page' );
			return false;
		}

		return true;
	}
}

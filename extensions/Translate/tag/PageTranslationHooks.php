<?php

class PageTranslationHooks {

	// Uuugly hack
	static $allowTargetEdit = false;

	public static function renderTagPage( $parser, &$text, $state ) {
		$title = $parser->getTitle();
		if ( strpos( $text, '</translate>' ) !== false ) {
			$cb = array( __CLASS__, 'replaceTagCb' );
			# Remove the tags nicely, trying to not leave excess whitespace lying around
			$text = preg_replace_callback( '~(\n?<translate>\s*?)(.*?)(\s*?</translate>)~s', $cb, $text );
			# Replace variable markers
			$text = preg_replace_callback( '~(<tvar[^<>]+>)(.*)(</>)~s', $cb, $text );
		}

		// For translation pages, parse plural, grammar etc with correct language
		if ( $page = TranslatablePage::isTranslationPage( $title ) ) {
			list( , $code ) = TranslateUtils::figureMessage( $title->getText() );
			$parser->mOptions->setTargetLanguage( Language::factory( $code ) );
		}
		return true;
	}

	public static function replaceTagCb( $matches ) {
		return $matches[2];
	}

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

	public static function onSectionSave( $article, $user, $text, $summary, $minor,
		$_, $_, $flags, $revision ) {
		$title = $article->getTitle();

		// Some checks

		// We are only interested in the translations namespace
		if ( $title->getNamespace() != NS_TRANSLATIONS ) return true;
		// Do not trigger renders for fuzzy
		if ( strpos( $text, TRANSLATE_FUZZY ) !== false ) return true;

		// Figure out the group
		$groupKey = self::titleToGroup( $title );
		$group = MessageGroups::getGroup( $groupKey );
		if ( !$group instanceof WikiPageMessageGroup ) return;

		// Finally we know the title and can construct a Translatable page
		$page = TranslatablePage::newFromTitle( $group->title );

		// Add a tracking mark
		if ( $revision !== null ) {
			self::addSectionTag( $title, $revision->getId(), $page->getMarkedTag() );
		}

		// Update the target translation page
		list( , $code ) = TranslateUtils::figureMessage( $title->getDBkey() );
		self::updateTranslationPage( $page, $code, $user, $flags, $summary );

		return true;
	}

	protected static function addSectionTag( Title $title, $revision, $pageRevision ) {
		if ( $pageRevision === null ) throw new MWException( 'Page revision is null' );

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
			$article = new Article( $title );
			$article->doPurge();
		}

		// And the source page itself too
		$article = new Article( $page->getTitle() );
		$article->doPurge();
	}

	public static function addSidebar( $out, $tpl ) {
		// TODO: fixme
		return true;
		global $wgLang;

		// Sort by translation percentage
		arsort( $status, SORT_NUMERIC );

		foreach ( $status as $code => $percent ) {
			$name = TranslateUtils::getLanguageName( $code, false, $wgLang->getCode() );
			$percent = $wgLang->formatNum( round( 100 * $percent ) );
			$label = "$name ($percent%)";

			$_title = TranslateTagUtils::codefyTitle( $title, $code );

			$items[] = array(
				'text' => $label,
				'href' => $_title->getFullURL(),
				'id' => 'foo',
			);
		}

		$sidebar = $out->buildSidebar();
		$sidebar['TRANSLATIONS'] = $items;

		$tpl->set( 'sidebar', $sidebar );

		return true;
	}

		

	public static function languages( $data, $params, $parser ) {
		$title = $parser->getTitle();

		// Check if this is a source page or a translation page
		$page = TranslatablePage::newFromTitle( $title );
		if ( $page->getMarkedTag() === false ) {
			$page = TranslatablePage::isTranslationPage( $title );
		}
		if ( $page === false || $page->getMarkedTag() === false )  return '';

		$status = $page->getTranslationPercentages();
		if ( !$status ) return '';

		// Fix title
		$title = $page->getTitle();

		// Sort by language code, which seems to be the only sane method
		ksort( $status );

		$sk = $parser->mOptions->getSkin();

		/* We rely on $wgLang, which should not matter as
		 * languages are cached per language. However it
		 * would be nicer to use $parser->getFunctionLang();
		 * but that needs to be set correct first. */
		// $lobj = $parser->getFunctionLang();
		global $wgTranslateCssLocation, $wgLang;

		$languages = array();
		foreach ( $status as $code => $percent ) {
			$name = TranslateUtils::getLanguageName( $code, false, $wgLang->getCode() );

			/* Percentages are too accurate and take more
			 * space than plain images */
			$percent *= 100;
			if     ( $percent < 20 ) $image = 1;
			elseif ( $percent < 40 ) $image = 2;
			elseif ( $percent < 60 ) $image = 3;
			elseif ( $percent < 80 ) $image = 4;
			else                     $image = 5;

			$percent = Xml::element( 'img', array(
				'src'   => "$wgTranslateCssLocation/images/prog-$image.png",
				'alt'   => "$percent%",
				'title' => "$percent%",
				'width' => '9',
				'height' => '9',
			) );
			$label = "$name $percent";

			// Add links to other languages
			$suffix = ( $code === 'en' ) ? '' : "/$code";
			$_title = Title::makeTitle( $title->getNamespace(), $title->getDBkey() . $suffix );

			// For some reason self-links are not done automatically
			if ( $parser->getTitle()->getText() === $_title->getText() ) {
				$languages[] = "<b>$label</b>";
			} else {
				$languages[] = $sk->link( $_title, $label );
			}
		}

		wfLoadExtensionMessages( 'PageTranslation' );
		$legend = wfMsg( 'tpt-languages-legend' );
		$languages = implode( '&nbsp;• ', $languages );

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

	// When attempting to save
	public static function tpSyntaxCheck( $article, $user, $text, $summary,
			$minor, $_, $_, $flags, $status ) {
		// Quick escape on normal pages
		if ( strpos( $text, '</translate>' ) === false ) return true;

		$page = TranslatablePage::newFromText( $article->getTitle(), $text );
		try {
			/* This does not catch all problems yet,
			 * like markup spanning between sections. */
			$page->getParse();
		} catch ( TPException $e ) {
			// FIXME: throws "PHP Notice:  Undefined variable: ret" when <translate>/</translate> is uneven
			// and an 'edit conflict'.
			call_user_func_array( array( $status, 'fatal' ), $ret );
			return false;
		}

		return true;
	}

	public static function addTranstag( $article, $user, $text, $summary,
			$minor, $_, $_, $flags, $revision ) {
		// We are not interested in null revisions
		if ( $revision === null ) return true;

		// Quick escape on normal pages
		if ( strpos( $text, '</translate>' ) === false ) return true;

		// Add the ready tag
		$page = TranslatablePage::newFromTitle( $article->getTitle() );
		$page->addReadyTag( $revision->getId() );

		return true;
	}

	// Here we disable editing of some existing or unknown pages
	public static function translationsCheck( $title, $user, $action, &$result ) {
		// Case 1: Unknown section translations
		if ( $title->getNamespace() == NS_TRANSLATIONS && $action === 'edit' ) {
			$group = self::titleToGroup( $title );
			if ( $group === null ) {
				// No group means that the page is currently not 
				// registered to any page translation message groups
				wfLoadExtensionMessages( 'PageTranslation' );
				$result = array( 'tpt-unknown-page' );
				return false;
			}

			return true;
		}


		// Case 2: Target pages
		$page = TranslatablePage::isTranslationPage( $title );
		if ( $page !== false ) {
			if ( self::$allowTargetEdit ) return true;

			if ( $page->getMarkedTag() ) {
				list( , $code ) = TranslateUtils::figureMessage( $title->getText() );
				wfLoadExtensionMessages( 'PageTranslation' );
				$result = array(
					'tpt-target-page',
					$page->getTitle()->getPrefixedText(),
					$page->getTranslationUrl( $code )
				);
				return false;
			}
		}

		return true;
	}

	public static function schemaUpdates() {
		global $wgExtNewTables;
		$dir = dirname( __FILE__ ) . '/..';
		$wgExtNewTables[] = array( 'translate_sections', "$dir/translate.sql" );
		$wgExtNewTables[] = array( 'revtag_type', "$dir/revtags.sql" );

		return true;
	}

	// TODO: fix the name
	public static function test( &$article, &$outputDone, &$pcache ) {
		global $wgOut;
		if ( !$article->getOldID() ) {
			self::header( $article->getTitle() );
		}
		return true;
	}

	public static function header( Title $title ) {
		global $wgLang, $wgUser;

		$page = TranslatablePage::newFromTitle( $title );
		$marked = $page->getMarkedTag();
		$ready = $page->getReadyTag();

		if ( $marked || $ready ) {
			self::sourcePageHeader( $page, $marked, $ready );
		} else  {
			self::translationPageHeader( $title );
		}
	}

	protected static function sourcePageHeader( TranslatablePage $page,
		$marked, $ready ) {

		global $wgUser, $wgLang;
		wfLoadExtensionMessages( 'PageTranslation' );

		$title = $page->getTitle();
		$sk = $wgUser->getSkin();

		$latest = $title->getLatestRevId();
		$canmark = $ready === $latest && $marked !== $latest;

		$actions = array();

		if ( $marked && $wgUser->isAllowed( 'translate' ) ) {
			$par = array(
				'group' => 'page|' . $title->getPrefixedText(),
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

		if ( !count( $actions ) ) return;
		$legend  = "<div style=\"font-size: x-small; text-align: center\">";
		if ( method_exists( $wgLang, 'semicolonList' ) ) {
			// BC for <1.15
			$legend .= $wgLang->semicolonList( $actions );
		} else {
			$legend .= implode( '; ', $actions );
		}
		$legend .= '</div><hr />';
		
		global $wgOut;
		$wgOut->addHTML( $legend );

	}

	protected static function translationPageHeader( Title $title ) {
		global $wgOut;

		// Check if applicable
		$page = TranslatablePage::isTranslationPage( $title );
		if ( $page === false ) return;

		list( , $code ) = TranslateUtils::figureMessage( $title->getText() );

		// Get the translation percentage
		$pers = $page->getTranslationPercentages();
		$per = @$pers[$code];
		$per = ( $per === null ) ? 0 : $per * 100;
		$titleText = $page->getTitle()->getPrefixedText();
		$url = $page->getTranslationUrl( $code );

		// Output
		wfLoadExtensionMessages( 'PageTranslation' );
		$wrap = '<div style="font-size: x-small; text-align: center">$1</div>';
		
		$wgOut->wrapWikiMsg( $wrap, array( 'tpt-translation-intro', $url, $titleText, $per ) );

		if ( ( (int) $per ) < 100 ) {
			$wrap = '<div style="font-size: x-small; text-align: center" class="mw-translate-fuzzy">$1</div>';
			$wgOut->wrapWikiMsg( $wrap, array( 'tpt-translation-intro-fuzzy' ) );
		}
		$wgOut->addHTML( '<hr />' );

	}

	public static function parserTestTables( &$tables ) {
		$tables[] = 'revtag_type';
		$tables[] = 'revtag';

		return true;
	}

	public static function exportToolbox( $skin ) {
		$title = $skin->skin->mTitle;

		// Check if this is a source page or a translation page
		$page = TranslatablePage::newFromTitle( $title );
		if ( $page->getMarkedTag() === false ) {
			$page = TranslatablePage::isTranslationPage( $title );
		}
		if ( $page === false || $page->getMarkedTag() === false )  return true;

		$export = array( $page->getTitle()->getPrefixedText() ); // Source page
		$titles = $page->getTranslationPages();
		foreach ( $titles as $title ) {
			$export[] = $title->getPrefixedText();
		}

		$params = array( 'pages' => implode( "\n", $export ) );

		$href = SpecialPage::getTitleFor( 'Export' )->getLocalUrl( $params );
		$linkText = wfMsgHtml( 'tpt-download-page' );

		print "<li id=\"t-download-as-pdf\"><a href=\"$href\" rel=\"nofollow\">$linkText</a></li>";
		return true;
	}

}
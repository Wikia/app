<?php

class TranslateTagHooks {

	public static function disableEdit( $title, $user, $action, &$errors ) {
		if ( $action !== 'edit' ) return true;

		$type = TranslateTagUtils::T_TRANSLATION;
		if ( TranslateTagUtils::isTagPage( $title, $type ) ) {
			wfLoadExtensionMessages( 'Translate' );

			$sourceTitle = Title::makeTitle(
				$title->getNamespace(),
				// TODO: breaks if the page being translated is a subpage
				$title->getBaseText()
			);

			list( , $code ) = TranslateTagUtils::keyAndcode( $title );
			$par = array(
				'group' => 'page|' . $sourceTitle->getPrefixedText(),
				'language' => $code,
				'task' => 'view',
			);
			$translate = SpecialPage::getTitleFor( 'Translate' );

			$errors[] = array( 'translate-tag-noedit',
				$sourceTitle->getFullURL( 'action=edit' ),
				$translate->getFullUrl( wfArrayToCgi( $par ) )
			);
			return false;
		}

		return true;
	}

	public static function renderTagPage( $parser, &$text, $state ) {
		$title = $parser->getTitle();
		list( , $code ) = TranslateTagUtils::keyAndcode( $title );

		if ( strpos( $text, '</translate>' ) !== false ) {
			$tag = TranslateTag::getInstance();
			$text = $tag->renderPage( $text, $title );

			wfLoadExtensionMessages( 'Translate' );
			$cat = wfMsgForContent( 'translate-tag-category' );
			$text .= " [[Category:$cat]]";
			$text = $tag->getHeader( $title ) . $text;
		} elseif ( strpos( $text, '<translate />' ) !== false ) {
			$text = str_replace( '<translate />', '', $text );

			list( , $code ) = TranslateTagUtils::keyAndCode( $title );
			$title = TranslateTagUtils::deCodefy( $title );

			$tag = TranslateTag::getInstance();
			$text = $tag->renderPage( $text, $title );
			$text = $tag->getHeader( $title, $code ) . $text;

			$lobj = Language::factory( $code );
			$parser->mOptions->setTargetLanguage( $lobj );
		}

		return true;
	}

	public static function injectCss( $outputpage, $text ) {
		TranslateUtils::injectCSS();
		return true;
	}

	public static function onSave( $article, $user, $text, $summary, $minor,
		$_, $_, $flags, $revision ) {
		global $wgTranslateFuzzyBotName;

		// Do not trigger renders for bots
		// It is more efficient to update 
		if ( $user->getName() === $wgTranslateFuzzyBotName ) return true;

		$flags |= EDIT_SUPPRESS_RC; // No point listing them twice
		$flags &= ~EDIT_NEW & ~EDIT_UPDATE; // We don't know

		$title = $article->getTitle();
		self::updateTranslationChange( $title, $flags, $summary );
		self::updateSourceChange( $title, $flags, $summary );

		return true;

	}

	public static function updateTranslationChange( Title $translation, $flags, $summary ) {
		list( $key, $code ) = TranslateTagUtils::keyAndcode( $translation );

		// Figure out group
		$namespace = $translation->getNamespace();
		$groupKey = TranslateUtils::messageKeyToGroup( $namespace, $key );
		$group = MessageGroups::getGroup( $groupKey );
		if ( !$group instanceof WikiPageMessageGroup ) return;

		$source = $group->title;
		$target = TranslateTagUtils::codefyTitle( $group->title, $code );

		global $wgUser;
		$user = $wgUser->getName();
		RenderJob::renderPage( $source, $target, $user, $summary, $flags, true );
	}

	public static function updateSourceChange( Title $source, $flags, $summary ) {
		global $wgUser;
		$user = $wgUser->getName();

		$type = TranslateTagUtils::T_SOURCE;

		if ( !TranslateTagUtils::isTagPage( $source, $type ) ) return true;

		$dbr = wfGetDB( DB_SLAVE );
		$likePattern = $dbr->escapeLike( $source->getDBkey() ) . '/%%';
		$res = $dbr->select(
			'page',
			array( 'page_namespace', 'page_title' ),
			array(
				'page_namespace' => $source->getNamespace(),
				"page_title LIKE '$likePattern'"
			), __METHOD__ );

		$titles = TitleArray::newFromResult( $res );
		$type = TranslateTagUtils::T_TRANSLATION;
		foreach ( $titles as $target ) {
			if ( !TranslateTagUtils::isTagPage( $target, $type ) ) continue;
			RenderJob::renderPage( $source, $target, $user, $summary, $flags );
		}
	}

	public static function addSidebar( $out, $tpl ) {
		$title = TranslateTagUtils::deCodefy( $out->mTitle );
		$status = TranslateTagUtils::getPercentages( $title );
		if ( !$status ) return true;

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
		$title = TranslateTagUtils::deCodefy( $parser->getTitle() );
		$status = TranslateTagUtils::getPercentages( $title );
		if ( !$status ) return '';

		global $wgLang;

		// Sort by language code
		ksort( $status );

		// $lobj = $parser->getFunctionLang();
		$sk = $parser->mOptions->getSkin();
		$legend = wfMsg( 'otherlanguages' );

		global $wgTranslateCssLocation;

		$languages = array();
		foreach ( $status as $code => $percent ) {
			$name = TranslateUtils::getLanguageName( $code, false, $wgLang->getCode() );

			$percent *= 100;
			if     ( $percent < 20 ) $image = 1;
			elseif ( $percent < 40 ) $image = 2;
			elseif ( $percent < 60 ) $image = 3;
			elseif ( $percent < 80 ) $image = 4;
			else                     $image = 5;

			$percent = Xml::element( 'img', array(
				'src' => "$wgTranslateCssLocation/images/prog-$image.png"
			) );
			$label = "$name $percent";

			$_title = TranslateTagUtils::codefyTitle( $title, $code );
			$languages[] = $sk->link( $_title, $label );
		}

		$languages = implode( '&nbsp;• ', $languages );

		return <<<FOO
<div class="LanguageLinks">
<table style="border: 1px solid rgb(170, 170, 170); background: rgb(246, 249, 237) none repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; border-collapse: collapse; line-height: 1.2;" border="0" cellpadding="2" cellspacing="0" rules="all" width="100%">

<tbody><tr valign="top">
<td style="border-right: 1px solid rgb(170, 170, 170); padding: 0.5em; background: rgb(238, 243, 226) none repeat scroll 0% 0%; width: 200px; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;"><b>$legend:</b>

</td><td style="padding: 0.5em;">$languages</td></tr></tbody></table>
</div>
FOO;
	}

	public static function onTemplate( $parser, &$title, &$skip, &$id  ) {
		global $wgLang;
		$type = TranslateTagUtils::T_SOURCE;
		if ( TranslateTagUtils::isTagPage( $title, $type ) ) {
			$newtitle = TranslateTagUtils::codefyTitle( $title, $wgLang->getCode() );
			if ( $newtitle->exists() ) $title = $newtitle;
		}
		return true;
	}

}
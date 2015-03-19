<?php

/**
 * Service providing interface for generating previews and diffs
 */

class EditPageService extends Service {

	private $app;

	private $mTitle;

	function __construct(Title $title) {
		$this->app = F::app();
		$this->mTitle = $title;
	}

	static public function newFromArticle(Article $article) {
		return new self($article->getTitle());
	}

	# Disgustingly copied from SkinTemplate
	static public function wrapBodyText($title, $request, $html) {
		global $wgContLang, $wgEnableVenusArticle;

		# An ID that includes the actual body text; without categories, contentSub, ...
		$realBodyAttribs = array( 'id' => 'mw-content-text' );

		# Add a mw-content-ltr/rtl class to be able to style based on text direction
		# when the content is different from the UI language, i.e.:
		# not for special pages or file pages AND only when viewing AND if the page exists
		# (or is in MW namespace, because that has default content)
		if( !in_array( $title->getNamespace(), array( NS_SPECIAL, NS_FILE ) ) ) {
			$lang = ( $title->exists() ) ? $title->getPageLanguage() : $wgContLang;

			$realBodyAttribs['lang'] = $lang->getHtmlCode();
			$realBodyAttribs['dir'] = $lang->getDir();
		   	$realBodyAttribs['class'] = 'mw-content-'.$lang->getDir();

			if ( !empty( $wgEnableVenusArticle ) ) {
				$realBodyAttribs['class'] .= ' mw-content-text mw-content-preview';
			}
		}

		return Html::rawElement( 'div', $realBodyAttribs, $html );
	}

	public function getPreview($wikitext, $asJson = false) {

		// TODO: use wgParser here because some parser hooks initialize themselves on wgParser (should on provided parser instance)
		global $wgParser, $wgUser, $wgRequest;
		wfProfileIn(__METHOD__);

		$wg = $this->app->wg;

		$parserOptions = new ParserOptions($wgUser);

		$originalWikitext = $wikitext;

		if ( !empty( $wg->EnableCategorySelectExt ) ) {
		// if CategorySelect is enabled, add categories to wikitext
			$categories = $wg->Request->getVal( 'categories', '' );
			$wikitext .= CategoryHelper::changeFormat( $categories, 'json', 'wikitext' );
		}

		// call preSaveTransform so signatures, {{subst:foo}}, etc. will work
		$wikitext = $wgParser->preSaveTransform($wikitext, $this->mTitle, $this->app->getGlobal('wgUser'), $parserOptions);

		$title = $this->mTitle;
		$wrapper = new GlobalStateWrapper( ['wgArticleAsJson' => $asJson] );
		$wrapper->wrap( function () use ( &$out, $wgParser, $wikitext, $title, $parserOptions ) {
			$out = $wgParser->parse( $wikitext, $title, $parserOptions )->getText();
		});

		if ( !$asJson ) {
			$out = EditPageService::wrapBodyText($this->mTitle, $wgRequest, $out);
		}

		// we should also render categories and interlanguage links
		$parserOutput = $wgParser->getOutput();
		$catbox = $this->renderCategoryBoxFromParserOutput($parserOutput);
		$interlanglinks = $this->renderInterlangBoxFromParserOutput($parserOutput);

		/**
		 * bugid: 47995 -- Treat JavaScript and CSS as raw text wrapped in <pre> tags
		 * We still rely on the parser for other stuff
		 */
		if ( $this->mTitle->isCssOrJsPage() ) {
			$out = '<pre>' . htmlspecialchars( $originalWikitext ) . '</pre>';
		}

		wfProfileOut(__METHOD__);

		return array( $out, $catbox, $interlanglinks );
	}

	public function getDiff($wikitext, $section = '') {
		wfProfileIn(__METHOD__);

		$section = intval($section);

		$article = new Article($this->mTitle);

		// create "fake" EditPage
		$editPage = new EditPage($article);

		// rtrim is a fix for https://wikia-inc.atlassian.net/browse/MAIN-152
		// To understand better look at "$this->textbox1 = $this->safeUnicodeInput( $request, 'wpTextbox1' );" in EditPage.php
		$editPage->textbox1 = rtrim( $wikitext );
		$editPage->edittime = null;
		$editPage->section = $section > 0 ? $section : '';

		// render diff HTML to $wgOut
		$out = $this->app->getGlobal('wgOut');

		$oldHtml = $out->getHTML();

		$out->clearHTML();
		$editPage->showDiff();
		$diff = $out->getHTML();

		// restore state of output
		$out->clearHTML();
		$out->addHTML($oldHtml);

		wfProfileOut(__METHOD__);
		return $diff;
	}

	protected function renderCategoryBoxFromParserOutput($parserOutput) {
		wfProfileIn(__METHOD__);

		$wg = $this->app->wg;

		$catbox = '';

		$wg->Out->addParserOutput($parserOutput);

		if ( !empty( $wg->EnableCategorySelectExt ) ) {
			$catbox = $this->app->renderView( 'CategorySelectController', 'articlePage', array(
				'userCanEdit' => false
			));

		} else {
			$skin = RequestContext::getMain()->getSkin();
			$categories = $wg->Out->getCategories();

			if (!empty($categories) && ($skin instanceof SkinOasis)) {
				$categoryLinks = $skin->getCategories();
				$catbox = F::app()->sendRequest('ArticleCategories','Index',array(
					'categoryLinks' => $categoryLinks
				))->toString();
			}
		}

		wfProfileOut(__METHOD__);
		return $catbox;
	}

	protected function renderInterlangBoxFromParserOutput($parserOutput) {
		global $wgOut, $wgContLang, $wgHideInterlanguageLinks;

		wfProfileIn(__METHOD__);

		$wgOut->addParserOutput($parserOutput);
		$skin = RequestContext::getMain()->getSkin();
		$languagelinks= $wgOut->getLanguageLinks();

		$language_urls = array();

		if ( !$wgHideInterlanguageLinks ) {
			foreach( $languagelinks as $l ) {
				$tmp = explode( ':', $l, 2 );
				$class = 'interwiki-' . $tmp[0];
				unset( $tmp );
				$nt = Title::newFromText( $l );
				if ( $nt ) {
					$language_urls[] = array(
						'href' => $nt->getFullURL(),
						'text' => ( $wgContLang->getLanguageName( $nt->getInterwiki() ) != '' ?
							$wgContLang->getLanguageName( $nt->getInterwiki() ) : $l ),
						'class' => $class
					);
				}
			}
		}

		$langbox = '';
		if(!empty($language_urls) && ($skin instanceof SkinOasis)) {
			$langbox = F::app()->sendRequest('ArticleInterlang','Index',array('request_language_urls' => $language_urls))->toString();
		}

		wfProfileOut(__METHOD__);
		return $langbox;
	}

	public function getTemplatesList() {
		wfProfileIn(__METHOD__);

		$templates = $this->mTitle->getTemplateLinksFrom();
		$html = Linker::formatTemplates( $templates );

		wfProfileOut(__METHOD__);
		return $html;
	}
}

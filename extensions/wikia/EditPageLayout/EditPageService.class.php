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
		global $wgContLang;

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
                }

                return Html::rawElement( 'div', $realBodyAttribs, $html );
	}

	public function getPreview($wikitext) {
		// TODO: use wgParser here because some parser hooks initialize themselves on wgParser (should on provided parser instance)
		global $wgParser, $wgUser, $wgRequest;
		wfProfileIn(__METHOD__);

		$parserOptions = new ParserOptions($wgUser);

		// call preSaveTransform so signatures, {{subst:foo}}, etc. will work
		$wikitext = $wgParser->preSaveTransform($wikitext, $this->mTitle, $this->app->getGlobal('wgUser'), $parserOptions);

		// parse wikitext using MW parser
		$html = $wgParser->parse($wikitext, $this->mTitle, $parserOptions)->getText();

		$html = EditPageService::wrapBodyText($this->mTitle, $wgRequest, $html);

		// we should also render categories and interlanguage links
		$parserOutput = $wgParser->getOutput();
		$catbox = $this->renderCategoryBoxFromParserOutput($parserOutput);
		$interlanglinks = $this->renderInterlangBoxFromParserOutput($parserOutput);

		wfProfileOut(__METHOD__);
		return array( $html, $catbox, $interlanglinks);
	}

	public function getDiff($wikitext, $section = '') {
		wfProfileIn(__METHOD__);

		$section = intval($section);

		// create "fake" EditPage
		if( function_exists('CategorySelectInitializeHooks') ) {
			CategorySelectInitializeHooks(null, null, $this->mTitle, null, null, null, true);
		}
		$article = new Article($this->mTitle);

		$editPage = new EditPage($article);
		$editPage->textbox1 = $wikitext;
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
		global $wgOut;

		wfProfileIn(__METHOD__);

		$wgOut->addParserOutput($parserOutput);
		$skin = RequestContext::getMain()->getSkin();
		$categories = $wgOut->getCategories();

		$catbox = '';
		if(!empty($categories ) && ($skin instanceof SkinOasis)) {
			$catlinks = $skin->getCategories();
			$catbox = F::app()->sendRequest('ArticleCategories','Index',array('catlinks' => $catlinks))->toString();
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

		$langbox = null;
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

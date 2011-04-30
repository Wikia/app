<?php

/**
 * Service providing interface for generating previews and diffs
 */

class EditPageService extends Service {

	private $app;

	private $mTitle;

	function __construct(Title $title) {
		$this->app = WF::build('App');
		$this->mTitle = $title;
	}

	static public function newFromArticle(Article $article) {
		return new self($article->getTitle());
	}

	public function getPreview($wikitext) {
		// TODO: use wgParser here because some parser hooks initialize themselves on wgParser (should on provided parser instance)
		global $wgParser, $wgUser;
		wfProfileIn(__METHOD__);

		$parserOptions = new ParserOptions($wgUser);

		// call preSaveTransform so signatures, {{subst:foo}}, etc. will work
		$wikitext = $wgParser->preSaveTransform($wikitext, $this->mTitle, $this->app->getGlobal('wgUser'), $parserOptions);

		// parse wikitext using MW parser
		$html = $wgParser->parse($wikitext, $this->mTitle, $parserOptions)->getText();

		wfProfileOut(__METHOD__);
		return $html;
	}

	public function getDiff($wikitext, $section = '') {
		wfProfileIn(__METHOD__);

		$section = intval($section);

		// create "fake" EditPage
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
}

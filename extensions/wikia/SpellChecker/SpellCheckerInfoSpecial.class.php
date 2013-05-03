<?php

class SpellCheckerInfoSpecial extends SpecialPage {

	protected $app = null;

	private $out;
	private $request;
	private $title;

	function __construct() {
		parent::__construct('SpellCheckerInfo');

		$this->app = F::app();

		$this->out = $this->app->getGlobal('wgOut');
		$this->request = $this->app->getGlobal('wgRequest');
		$this->title = $this->app->getGlobal('wgTitle');
	}

	function execute() {
		$this->out->setPageTitle( wfMsg('spellchecker-info') );

		// get information about enchant
		$dict = new SpellCheckerDictionary();

		// show list of all supported lanuages
		$languages = $dict->getLanguages();
		$rows = array();

		foreach($languages as $lang) {
			$rows[] = array($lang);
		}

		$this->out->addHtml( Xml::buildTable($rows, array('class' => 'wikitable'), array(
			wfMsg('spellchecker-info-languages', count($languages)),
		)) );

		// list providers
		$providers = $dict->getProviders();
		$rows = array();
		foreach ($providers as $provider => $dictionaries) {
			sort($dictionaries);
			$count = count($dictionaries);

			$rows[] = array(
				$provider,
				implode(', ', $dictionaries) . " ({$count})"
			);
		}

		$this->out->addHtml( Xml::buildTable($rows, array('class' => 'wikitable'), array(
			wfMsg('spellchecker-info-provider'),
			wfMsg('spellchecker-info-dictionaries'),
		)) );

		// spell checking demo
		$this->out->addHtml( Xml::element('hr') );

		$this->spellCheckingForm($languages);
	}

	/**
	 * Display form for testing spell checking feature
	 */
	function spellCheckingForm($languages) {
		$fields = array(
			'text' => array(
				'class' => 'HTMLTextField',
				'label-message' => 'spellchecker-info-spellcheck-text',
			),
			'lang' => array(
				'class' => 'HTMLSelectField',
				'label-message' => 'spellchecker-info-spellcheck-languages',
				'options' => array_combine($languages, $languages),
			),
		);

		$form = new HTMLForm($fields);
		$form->setTitle($this->title);
		$form->setSubmitText(wfMsg('spellchecker-info-spellcheck-submit'));
		$form->loadData();
		$form->displayForm('');

		// page was POSTed, perform spell cheking
		if ($this->request->wasPosted()) {
			$text = $this->request->getText('wptext');
			$langCode = $this->request->getText('wplang');

			// create spell checking service
			$service = new SpellCheckerService($langCode);
			$info = $service->getInfo();

			// check the spelling (returns true or array of spelling suggestions)
			$data = $service->checkWord($text);

			// print out results
			if ($data === true) {
				$result =wfMsg('spellchecker-info-spellcheck-is-correct', $text);
			}
			else {
				$result = wfMsg('spellchecker-info-spellcheck-suggestions', $text, implode(', ', $data));
			}

			$this->out->addHtml("<p>{$result}</p>");
			$this->out->addHtml("<p><small>{$info['desc']} / {$info['lang']}</small></p>");
		}
	}
}

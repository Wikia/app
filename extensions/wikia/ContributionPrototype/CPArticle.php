<?php

namespace ContributionPrototype;

use OutputPage;

class CPArticle {

	const CP_HOST = 'http://localhost:8082';

	/** @var int */
	private $wikiId;

	/** @var string */
	private $dbName;

	/** @var string */
	private $articleTitle;

	/** @var OutputPage */
	private $output;

	/**
	 * CPArticle constructor.
	 * @param int $wikiId
	 * @param string $dbName
	 * @param string $articleTitle
	 * @param OutputPage $output
	 */
	public function __construct($wikiId, $dbName, $articleTitle, OutputPage $output) {
		$this->wikiId = $wikiId;
		$this->dbName = $dbName;
		$this->articleTitle = $articleTitle;
		$this->output = $output;
	}

	public function view() {
		$this->output->addLink([
			'rel' => 'stylesheet',
			'href'=> self::CP_HOST.'/public/assets/styles/main.css',
		]);
		$html = file_get_contents(self::CP_HOST."/wiki/lol/wiki/Home");
		preg_match('/<body>(.*?)<\/body>/is', $html, $matches);
		$body = preg_replace(
				'/<script src=("|\')\/(.*?)(\1)>/',
				'<script src=$1'.self::CP_HOST.'/$2$1>',
				$matches[1]);
		$this->output->addHTML($body);
	}
}

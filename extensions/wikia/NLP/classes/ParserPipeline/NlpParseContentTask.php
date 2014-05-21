<?php

namespace \Wikia\NLP\ParsingPipeline;
use Wikia\Tasks\Tasks\BaseTask;

class NlpParseContentTask extends BaseTask
{
	/**
	 * Uniquely identifying ID for article
	 * @var str
	 */
	public $document_id;

	public function __construct() {
		global $wgArticleId, $wgCityId;
		parent::__construct();
		$this->document_id = sprintf( '%d_%d', $wgArticleId, $wgCityId );
	}

	public function title( \Title $title ) {
		global $wgCityId;
		parent::title( $title );
		$this->document_id = sprintf( '%d_%d', $title->getArticleId(), $wgCityId );
	}

}
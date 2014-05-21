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

	/**
	 * set this task to call a method in this class. the first argument to this method should be the method to execute,
	 * and subsequent arguments are arguments passed to that method. Example: call('add', 2, 3) would call the method
	 * add with 2 and 3 as parameters. we're adding this to the current class to override the method existing herein.
	 *
	 * @return array [$this, order in which this call should be made]
	 */
	public function call(/** method, arg1, arg2, ...argN */) {
		$args = func_get_args();
		$method = array_shift($args);

		$this->calls []= [$method, $args];

		return [$this, count($this->calls) - 1];
	}

}
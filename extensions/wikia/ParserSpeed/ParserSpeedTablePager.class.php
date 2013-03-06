<?php

/**
 * Pager that shows ParserSpeed stats in ParserSpeed special page
 * @author wladek
 */
class ParserSpeedTablePager extends TablePager {

	public function __construct( IContextSource $context = null ) {
		parent::__construct($context);
		$this->mDb = wfGetDB(DB_SLAVE,array(),F::app()->wg->ExternalDatawareDB);
	}

	function isFieldSortable( $field ) {
		return in_array( $field, array( 'average_time', 'wikitext_size', 'html_size' ) );
	}

	function formatValue( $name, $value ) {
		switch ($name) {
			case 'article_title':
				$articleId = $this->mCurrentRow->article_id;
				$title = Title::newFromID($articleId);
				return $title ? Linker::link($title) : '(unknown, id: '.$articleId.')';
				break;
			case 'wikitext_size':
			case 'html_size':
				return sprintf("%.1f kb",$value / 1000);
				break;
			default:
				return $value;

		}
	}

	function getDefaultSort() {
		return 'average_time';
	}

	function getDefaultDirections() {
		return true;
	}

	function getFieldNames() {
		return array(
			'article_title' => 'Article',
			'average_time' => 'Avg. parsing time',
			'wikitext_size' => 'Wikitext size',
			'html_size' => 'HTML size',
		);
	}

	function getQueryInfo() {
		$queryInfo = array(
			'tables' => 'parser_speed_article',
			'fields' => 'article_id, average_time, wikitext_size, html_size',
			'conds' => array(
				'wiki_id' => F::app()->wg->CityId,
			)
		);
		return $queryInfo;
	}

}
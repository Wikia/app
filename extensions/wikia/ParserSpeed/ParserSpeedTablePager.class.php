<?php

/**
 * Pager that shows ParserSpeed stats in ParserSpeed special page
 * @author wladek
 */
class ParserSpeedTablePager extends TablePager {

	protected $mainNamespaceText;

	public function __construct( IContextSource $context = null ) {
		parent::__construct($context);
		$this->mDb = wfGetDB(DB_SLAVE,array(),F::app()->wg->ExternalDatawareDB);
		$this->mainNamespaceText = $this->msg( 'blanknamespace' )->inContentLanguage()->plain();
	}

	function isFieldSortable( $field ) {
		return in_array( $field, array( 'page_ns', 'average_time', 'minimum_time', 'maximum_time', 'wikitext_size', 'html_size', 'exp_func_count', 'node_count', 'post_expand_size', 'temp_arg_size' ) );
	}

	function formatValue( $name, $value ) {
		global $wgContLang;
		switch ($name) {
			case 'article_title':
				$articleId = $this->mCurrentRow->article_id;
				$title = Title::newFromID($articleId);
				return $title ? Linker::link($title) : '(unknown, id: '.$articleId.')';
				break;
			case 'page_ns':
				return ($value != 0 ? $wgContLang->getNsText( $value ) : $this->mainNamespaceText) . " [$value]";
				break;
			case 'average_time':
			case 'minimum_time':
			case 'maximum_time':
				return $value . " s";
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
			'page_ns' => $this->msg( 'parserspeed-namespace' )->plain(),
			'article_title' => $this->msg( 'parserspeed-title' )->plain(),
			'average_time' => $this->msg( 'parserspeed-average' )->plain(),
			'minimum_time' => $this->msg( 'parserspeed-minimum' )->plain(),
			'maximum_time' => $this->msg( 'parserspeed-maximum' )->plain(),
			'wikitext_size' => $this->msg( 'parserspeed-wikitext' )->plain(),
			'html_size' => $this->msg( 'parserspeed-html' )->plain(),
			'exp_func_count' => $this->msg( 'parserspeed-expensive-functions' )->plain(),
			'node_count' => $this->msg( 'parserspeed-nodes' )->plain(),
			'post_expand_size' => $this->msg( 'parserspeed-expand-size' )->plain(),
			'temp_arg_size' => $this->msg( 'parserspeed-arg-size' )->plain(),
		);
	}

	function getQueryInfo() {
		$queryInfo = array(
			'tables' => 'parser_speed_article',
			'fields' => 'article_id, page_ns, average_time, minimum_time, maximum_time, wikitext_size, html_size, exp_func_count, node_count, post_expand_size, temp_arg_size',
			'conds' => array(
				'wiki_id' => F::app()->wg->CityId,
			)
		);
		return $queryInfo;
	}

}

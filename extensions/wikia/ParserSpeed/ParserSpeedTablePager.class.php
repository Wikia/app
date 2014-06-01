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
		$this->mainNamespaceText = wfMessage('blanknamespace')->inContentLanguage()->plain();
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
		// todo: transfer to i18n files
		return array(
			'page_ns' => 'Namespace',
			'article_title' => 'Article',
			'average_time' => 'Avg. parsing time',
			'minimum_time' => 'Min. parsing time',
			'maximum_time' => 'Max. parsing time',
			'wikitext_size' => 'Wikitext size',
			'html_size' => 'HTML size',
			'exp_func_count' => 'Exp. functions',
			'node_count' => 'Node count',
			'post_expand_size' => 'Post expand size',
			'temp_arg_size' => 'Temp arg. size'
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
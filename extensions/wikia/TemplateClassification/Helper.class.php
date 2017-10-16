<?php

namespace Wikia\TemplateClassification;


class Helper {

	/**
	 * Get all template pages with given category
	 *
	 * @param string $category
	 * @return bool|mixed
	 * @throws \FluentSql\Exception\SqlException
	 */
	public function getTemplatesByCategory( $category ) {
		$db = wfGetDB( DB_SLAVE );

		$templates = ( new \WikiaSQL() )
			->SELECT( 'page_id', 'page_title' )
			->FROM( 'categorylinks' )
			->LEFT_JOIN( 'page' )
			->ON( 'cl_from', 'page_id' )
			->WHERE( 'cl_to' )->EQUAL_TO( $category )
			->AND_( 'page_namespace' )->EQUAL_TO( NS_TEMPLATE )
			->runLoop( $db, function( &$templates, $row ) {
				$templates[$row->page_id] = $row->page_title;
			}, [] );

		return $templates;
	}

	/**
	 * Count template pages with given category
	 *
	 * @param $category
	 * @return bool|mixed
	 * @throws \Exception
	 * @throws \FluentSql\Exception\SqlException
	 */
	public function countTemplatesInCategory( $category ) {
		$db = wfGetDB( DB_SLAVE );

		$count = ( new \WikiaSQL() )
			->SELECT()
			->COUNT( 1 )->AS_( 'count' )
			->FROM( 'categorylinks' )
			->LEFT_JOIN( 'page' )
			->ON( 'cl_from', 'page_id' )
			->WHERE( 'cl_to' )->EQUAL_TO( $category )
			->AND_( 'page_namespace' )->EQUAL_TO( NS_TEMPLATE )

			->runLoop( $db, function( &$count, $row ) {
				$count = (int)$row->count;
			}, 0 );

		return $count;
	}
}

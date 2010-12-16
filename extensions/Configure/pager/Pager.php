<?php

/**
 * Interface for pagers used to list versions at Special:ViewConfig
 *
 * @ingroup Extensions
 * @author Alexandre Emsenhuber
 */
interface ConfigurationPager extends Pager {

	/**
	 * Set the wiki to get versions or false for all wikis
	 *
	 * @param $wiki String or false
	 */
	public function setWiki( $wiki );

	/**
	 * Get the number of rows in the pager
	 *
	 * @return Integer
	 */
	public function getNumRows();

	/**
	 * Used to set a callback function to format the rows, this is generally
	 * SpecialViewConfig::formatVersionRow(). The callback needs as first param
	 * an array with the following keys set:
	 * - timestamp: version's timestamp
	 * - wikis: array of wikis in the version
	 * - count: a counter, starting at 1 for the top (newer) row
	 * - user_name: Name of the user who made the version
	 * - user_wiki: Wiki in which the user made the version
	 * - reason: revision's comment
	 */
	public function setFormatCallback( $callback );
}

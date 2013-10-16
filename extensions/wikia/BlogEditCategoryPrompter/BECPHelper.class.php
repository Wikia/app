<?php
/**
 * BECPHelper
 *
 * Prompts users to add categories to blog posts
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

class BECPHelper {
	const PERM_NAME = 'becp_user';

	public static function onBlogArticleInitialized( CreateBlogPage $blogPage, $mode ) {
		if ( $mode == SpecialCustomEditPage::MODE_EDIT || !$blogPage->user->isAllowed( self::PERM_NAME ) ) {
			return true;
		}

		Wikia::addAssetsToOutput( 'extensions/wikia/BlogEditCategoryPrompter/becp.js' );
		JSMessages::enqueuePackage( 'BECP', JSMessages::INLINE );

		return true;
	}
}
<?php

/**
 * Static class for hooks handled by the SubPageList extension.
 * 
 * @since 0.3
 * 
 * @file SubPageList.hooks.php
 * @ingroup SubPageList
 * 
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class SPLHooks {
	
	/**
	 * Occurs after a new article has been created.
	 * https://secure.wikimedia.org/wikipedia/mediawiki/wiki/Manual:Hooks/ArticleInsertComplete
	 * 
	 * @since 0.3
	 * 
	 * @param Article|WikiPage &$article WikiPage object since MW 1.18
	 * 
	 * @return true
	 */
	public static function onArticleInsertComplete(
		&$article, User &$user, $text, $summary, $minoredit, 
		$watchthis, $sectionanchor, &$flags, Revision $revision ) {
			
		self::invalidateBasePages( $article->getTitle() );
	    
	    return true;
	}
	
	/**
	 * Occurs after the delete article request has been processed.
	 * https://secure.wikimedia.org/wikipedia/mediawiki/wiki/Manual:Hooks/ArticleDeleteComplete
	 * 
	 * @since 0.3
	 * 
	 * @param Article|WikiPage &$article WikiPage object since MW 1.18
	 * 
	 * @return true
	 */
	public static function onArticleDeleteComplete( &$article, User &$user, $reason, $id ) {
		self::invalidateBasePages( $article->getTitle() );
	    
	    return true;
	}	

	/**
	 * Occurs whenever a request to move an article is completed.
	 * https://secure.wikimedia.org/wikipedia/mediawiki/wiki/Manual:Hooks/TitleMoveComplete
	 * 
	 * @since 0.3
	 * 
	 * @return true
	 */
	public static function onTitleMoveComplete( Title &$title, Title &$newtitle, User &$user, $oldid, $newid ) {
		self::invalidateBasePages( $title );
		self::invalidateBasePages( $newtitle );
	    
	    return true;
	}
	
	/**
	 * Invalidate the base pages for this title, so that any SubPageList
	 * there gets refreshed after doing a subpage delete, move or creation.
	 * 
	 * @since 0.3
	 * 
	 * @param Title $title
	 */
	protected static function invalidateBasePages( Title $title ) {
		global $egSPLAutorefresh;
		
		if ( !$egSPLAutorefresh ) {
			return;
		}
		
		$slashPosition = strpos( $title->getDBkey(), '/' );

		if ( $slashPosition !== false ) {
			$baseTitleText = substr( $title->getDBkey(), 0, $slashPosition );
			
			$titleArray = self::getBaseSubPages(
				$baseTitleText,
				$title->getNamespace()
			);
			
			foreach ( $titleArray as $parentTitle ) {
				// No point in invalidating the page itself
				if ( $parentTitle->getArticleID() != $title->getArticleID() ) {
					$parentTitle->invalidateCache();
				}
			}
			
			$baseTitle = Title::newFromText( $baseTitleText, $title->getNamespace() );
			if ( $baseTitle->getArticleID() != $title->getArticleID() ) {
				$baseTitle->invalidateCache();
			}					
		}
	}
	
	/**
	 * Returns a title iterator with all the subpages of the base page
	 * for the provided title. This will include the provided title itself,
	 * unless the provided title is a base page.
	 * 
	 * @since 0.3
	 * 
	 * @param string $baseTitle
	 * @param integer $ns
	 * 
	 * @return TitleArray
	 */
	protected static function getBaseSubPages( $baseTitle, $ns ) {
		$dbr = wfGetDB( DB_SLAVE );
		
		$titleArray = TitleArray::newFromResult(
			$dbr->select( 'page',
				array( 'page_id', 'page_namespace', 'page_title', 'page_is_redirect' ),
				array(
					'page_namespace' => $ns, 
					'page_title' => $dbr->buildLike( $baseTitle . '/', $dbr->anyString() )
				),
				__METHOD__,
				array( 'LIMIT' => 500 )
			)
		);
		
		return $titleArray;
	}
	
}
<?php

use Wikia\PageHeader\Button;

/**
 * Created by JetBrains PhpStorm.
 * User: mech
 * Date: 8/22/12
 * Time: 2:55 PM
 */

class BlogsHelper {

	/**
	 * add a tab to special search page
	 */
	public static function OnSpecialSearchProfiles( &$profiles ) {

		$blogSearchProfile = array(
			'message' => 'blogs-searchprofile',
			'tooltip' => 'blogs-searchprofile-tooltip',
			'namespaces' => array( NS_BLOG_ARTICLE, NS_BLOG_LISTING )
		);

		if ( !array_key_exists( 'users', $profiles ) ) {
			$profiles['blogs'] = $blogSearchProfile;
		} else {
			$newProfiles = array();
			foreach ( $profiles as $k => $value ) {
				if ( $k === 'users' ) {
					$newProfiles['blogs'] = $blogSearchProfile;
				}
				$newProfiles[$k] = $value;
			}
			$profiles = $newProfiles;

		}

		return true;
	}

	/**
	 * BugId:25123 - Fixes the caching issues related to the bloglist tag.
	 *
	 * The method checks for usage of the bloglist tag and sets the page_props
	 * accordingly.
	 *
	 * @param $oParser Object The Parser instance being used.
	 * @param $sText String The new content.
	 * @param $oStringState Object The StripState instance being used.
	 *
	 * @return Boolean True so the calling function would continue.
	 *
	 * @author Michał Roszka (Mix) <mix@wikia-inc.com>
	 * @since October 24, 2012
	 *
	 * @see grep -r 'BugId:25123' *
	 * @see doc/hooks.txt
	 */
	public static function OnParserBeforeInternalParse(
		Parser $oParser, &$sText, &$oStripState
	): bool {
		wfProfileIn( __METHOD__ );
		// The name of the bloglist tag is defined in a constant.
		$sRegExp = sprintf( '/<%s[^>]*>(.*)<\/%s>/siU', BLOGTPL_TAG, BLOGTPL_TAG );

		// Set the bloglist property if there is a bloglist tag in the text of the revision.
		if ( preg_match( $sRegExp, $sText ) ) {
			$oParser->getOutput()->setProperty( BLOGTPL_TAG, 1 );
		}
		wfProfileOut( __METHOD__ );
		// Always ...
		return true; // ... to the single purpose of the moment.
	}

	/**
	 * BugId:25123 - Fixes the caching issues related to the bloglist tag.
	 *
	 * The method schedules a job of class BloglistDeferredPurge
	 * whenever a blog article is saved.
	 *
	 * @param $oArticle WikiPage The article being saved.
	 *
	 * @return Boolean True so the calling function would continue.
	 *
	 * @author Michał Roszka (Mix) <mix@wikia-inc.com>
	 * @since October 24, 2012
	 *
	 * @see grep -r 'BugId:25123' *
	 * @see doc/hooks.txt
	 */
	public static function OnArticleInsertComplete( WikiPage $oArticle ): bool {
		wfProfileIn( __METHOD__ );
		// schedule a BloglistDeferredPurge job if the article is a blog article.
		if ( NS_BLOG_ARTICLE == $oArticle->getTitle()->getNamespace() ) {
			global $wgCityId;

			$task = ( new \Wikia\Blogs\BlogTask() )->wikiId( $wgCityId );
			$task->call( 'deferredPurge' );
			$task->queue();
		}
		wfProfileOut( __METHOD__ );
		// Always...
		return true; // ... to the single purpose of the moment.
	}

	public static function onFilePageImageUsageSingleLink( &$link, &$element ) {
		wfProfileIn( __METHOD__ );
		$ns = $element->page_namespace;

		if ( $ns == NS_BLOG_ARTICLE ) {
			$title = Title::newFromText( $element->page_title, $ns );
			$userBlog = Title::newFromText( $title->getBaseText(), $ns );

			$link = wfMsgExt(
				'blog-file-page',
				array ( 'parsemag' ),
				$title->getLocalURL(),
				$title->getSubpageText(),
				$userBlog->getLocalURL(),
				$userBlog->getText()
			);
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Enables commenting for a blog post that has been moved from another namespace
	 * @param Title $oOldTitle An object for the old article's name
	 * @param Title $oNewTitle An object for the new article's name
	 * @param User $oUser
	 * @param integer $iOldId
	 * @param integer $iNewId
	 * @return bool
	 */
	public static function onTitleMoveComplete( Title $oOldTitle, Title $oNewTitle, User $oUser, $iOldId, $iNewId ) {
		global $wgArticleCommentsNamespaces;
		wfProfileIn( __METHOD__ );

		// Enables comments if an article has been moved to
		// a Blog namespace from a non-blog one
		// and if the new namespace has comments enabled.
		if ( ArticleComment::isBlog( $oNewTitle ) &&
			in_array( $oNewTitle->getNamespace(), $wgArticleCommentsNamespaces ) &&
			$oOldTitle->getNamespace() !== $oNewTitle->getNamespace()
		) {
			BlogArticle::setProps( $oNewTitle->getArticleID(), [ 'commenting' => '1' ] );
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * SUS-260: Prevent moving pages into User blog comment namespace, or moving comments out of this namespace
	 * @param Title $sourceTitle
	 * @param Title $targetTitle
	 * @param User $user
	 * @param null|array $err
	 * @param string $reason
	 * @return bool false if we're trying to move out of or into blog comment namespace, true otherwise
	 */
	public static function onAbortMove( Title $sourceTitle, Title $targetTitle, User $user, &$err, string $reason ): bool {
		$blogsNS = [ NS_BLOG_ARTICLE, NS_BLOG_ARTICLE_TALK ];
		if ( $sourceTitle->inNamespaces( $blogsNS ) && !$targetTitle->inNamespace( $sourceTitle->getNamespace() ) ) {
			$err = wfMessage( 'immobile-source-namespace', $sourceTitle->getNsText() )->escaped();
			return false;
		}

		if ( $targetTitle->inNamespace( NS_BLOG_ARTICLE_TALK ) && !$sourceTitle->inNamespace( $targetTitle->getNamespace() ) ) {
			$err = wfMessage( 'immobile-target-namespace', $targetTitle->getNsText() )->escaped();
			return false;
		}

		return true;
	}

	/**
	 * @param Title $title
	 * @param bool $shouldDisplayActionButton
	 *
	 * @return bool
	 */
	public static function onPageHeaderActionButtonShouldDisplay( \Title $title, bool &$shouldDisplayActionButton ): bool {
		if ( $title->getNamespace() === NS_BLOG_LISTING ) {
			$shouldDisplayActionButton = false;
		} else if ( $title->getNamespace() === NS_BLOG_ARTICLE && !$title->userCan( 'edit' ) ) {
			$shouldDisplayActionButton = false;
		}

		return true;
	}

	/**
	 * @param Title $title
	 * @param array $buttons
	 *
	 * @return bool
	 */
	public static function onAfterPageHeaderButtons( \Title $title, array &$buttons ): bool {
		if ( $title->getNamespace() === NS_BLOG_LISTING ) {
			$label = wfMessage( 'blog-create-post-label' )->escaped();
			array_unshift(
				$buttons,
				new Button(
					$label, 'wds-icons-plus', SpecialPage::getTitleFor( 'CreateBlogPage' )->getLocalUrl()
				)
			);
		}

		return true;
	}
}

<?php

class ArchiveWikiForumHooks {

    /**
     * Show the notification informing the user that wiki forums have been disabled
     * @param Article $article
     * @param $outputDone
     * @param $useParserCache
     * @return bool
     */
	public static function onArticleViewHeader(
		Article $article, bool &$outputDone, bool &$useParserCache
	): bool {
        $title = $article->getTitle();
        if ( static::isForumNS( $title->getNamespace() ) ) {
            $app = F::app();
            $html = $app->renderView(
                ArchiveWikiForumController::class,
                ArchiveWikiForumController::ARCHIVED_FORUM_NOTIFICATION
            );
            $app->wg->Out->addHTML( $html );
        }
        return true;
    }

    /**
     * @param Title $title
     * @param User $user
     * @param $action
     * @param $result
     * @return bool
     */
	public static function onGetUserPermissionsErrors(
		Title $title, User $user, string $action, &$result
	): bool {
        if ( $action == 'read' ) {
            return true;
        }

        if ( static::isForumNS( $title->getNamespace() ) && !static::canEditOldForum( $user ) ) {
            $result = ['protectedpagetext'];
            return false;
        }

        return true;
    }

    /**
     * @param User $user
     * @return bool
     */
    private static function canEditOldForum( User $user ) {
        return $user->isAllowed( 'forumoldedit' );
    }

    private static function isForumNS( $namespace ) {
        return $namespace == NS_FORUM || $namespace == NS_FORUM_TALK;
    }
}

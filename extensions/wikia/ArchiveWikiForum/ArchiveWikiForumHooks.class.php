<?php

class ArchiveWikiForumHooks {

    /**
     * Show the notification informing the user that wiki forums have been disabled
     * @param Article $article
     * @param $outputDone
     * @param $useParserCache
     * @return bool
     */
    public static function onArticleViewHeader( &$article, &$outputDone, &$useParserCache ) {
        $title = $article->getTitle();
        if ( self::isForumNS( $title->getNamespace() ) ) {
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
     * Override button on forum
     * @param WikiaResponse $response
     * @param $ns
     * @param $skin
     * @return bool
     */
    public static function onPageHeaderIndexAfterActionButtonPrepared( $response, $ns, $skin ) {
        $app = F::app();
        $title = $app->wg->Title;

        if ( self::isForumNS( $title->getNamespace() ) ) {
            if ( !static::canEditOldForum( $app->wg->User ) ) {
                $action = [ 'class' => '', 'text' => wfMessage( 'viewsource' )->escaped(), 'href' => $title->getLocalURL( [ 'action' => 'edit' ] ), 'id' => 'ca-viewsource', 'primary' => 1 ];
                $response->setVal( 'actionImage', MenuButtonController::LOCK_ICON );
                $response->setVal( 'action', $action );
                return false;
            }
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
    public static function onGetUserPermissionsErrors( Title &$title, User &$user, $action, &$result ) {
        if ( $action == 'read' ) {
            return true;
        }

        if ( self::isForumNS( $title->getNamespace() ) ) {
            if ( !static::canEditOldForum( $user ) ) {
                $result = [ 'protectedpagetext' ];
                return false;
            }
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

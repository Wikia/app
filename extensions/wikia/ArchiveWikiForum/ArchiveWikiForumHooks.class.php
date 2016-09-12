<?php

class ArchiveWikiForumHooks {

    /**
     * show the info box for old forums
     * @param Article $article
     * @param $outputDone
     * @param $useParserCache
     * @return bool
     */

    static public function onArticleViewHeader( &$article, &$outputDone, &$useParserCache ) {
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

    static public function onPageHeaderIndexAfterActionButtonPrepared( $response, $ns, $skin ) {
        $app = F::app();
        $title = $app->wg->Title;

        if ( self::isForumNS( $title->getNamespace() ) ) {
            if ( !static::canEditOldForum( $app->wg->User ) ) {
                $action = [ 'class' => '', 'text' => wfMessage( 'viewsource' )->escaped(), 'href' => $title->getLocalUrl( [ 'action' => 'edit' ] ), 'id' => 'ca-viewsource', 'primary' => 1 ];
                $response->setVal( 'actionImage', MenuButtonController::LOCK_ICON );
                $response->setVal( 'action', $action );
                return false;
            }
        }
        return true;
    }

    /**
     * helper function for onGetUserPermissionsErrors/onPageHeaderIndexAfterActionButtonPrepared
     * @param User $user
     * @return
     */

    static public function canEditOldForum( $user ) {
        return $user->isAllowed( 'forumoldedit' );
    }

    /**
     * @brief Block any attempts of editing anything in NS_FORUM namespace
     *
     * @return true
     *
     * @author Tomasz Odrobny
     **/

    static function onGetUserPermissionsErrors( Title &$title, User &$user, $action, &$result ) {
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

    private static function isForumNS($namespace ) {
        return $namespace == NS_FORUM || $namespace == NS_FORUM_TALK;
    }
}

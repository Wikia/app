<?php

class HideRevisionHooks {
	/**
	 * Hook for article view, giving us a chance to insert a removal
	 * tab on old version views.
	 */
	public static function onArticleViewHeader( $article ) {
		$oldid = intval( $article->mOldId );
		if( $oldid ) {
			self::installTab( $oldid );
		}
		return true;
	}

	/**
	 * Hook for diff view, giving us a chance to insert a removal
	 * tab on old version views.
	 */
	public static function onDiffViewHeader( $diff, $oldRev, $newRev ) {
		if( !empty( $newRev ) && $newRev->getId() ) {
			self::installTab( $newRev->getId() );
		}
		return true;
	}

	/**
	 * Hook for deletion archive revision view, giving us a chance to
	 * insert a removal tab for a deleted revision.
	 */
	public static function onUndeleteShowRevision( $title, $rev ) {
		self::installArchiveTab( $title, $rev->getTimestamp() );
		return true;
	}

	/**
	 *
	 */
	public static function onContributionsToolLinks( $id, $nt, &$tools ) {
		global $wgUser;
		if( $wgUser->isAllowed( 'oversight' ) ) {
			wfLoadExtensionMessages( 'HideRevision' );
			$title = SpecialPage::getTitleFor( 'Oversight' );
			$tools[] = $wgUser->getSkin()->makeKnownLinkObj( $title, wfMsgHtml( 'hiderevision-link' ), 'author=' . $nt->getPartialUrl() );
		}
		return true;
	}

	/**
	 * If the user is allowed, installs a tab hook on the skin
	 * which links to a handy permanent removal thingy.
	 */
	private static function installTab( $id ) {
		global $wgUser;
		if( $wgUser->isAllowed( 'hiderevision' ) ) {
			global $wgHooks;
			$tab = new HideRevisionTabInstaller( 'revision[]=' . $id );
			$wgHooks['SkinTemplateTabs'][] = array( $tab, 'insertTab' );
		}
	}

	/**
	 * If the user is allowed, installs a tab hook on the skin
	 * which links to a handy permanent removal thingy for
	 * archived (deleted) pages.
	 */
	private static function installArchiveTab( $target, $timestamp ) {
		global $wgUser;
		if( $wgUser->isAllowed( 'hiderevision' ) ) {
			global $wgHooks;
			$tab = new HideRevisionTabInstaller(
				'target=' . $target->getPrefixedUrl() .
				'&timestamp[]=' . $timestamp );
			$wgHooks['SkinTemplateBuildContentActionUrlsAfterSpecialPage'][] =
				array( $tab, 'insertTab' );
		}
	}
}

class HideRevisionTabInstaller {
	function __construct( $linkParam ) {
		$this->mLinkParam = $linkParam;
	}

	function insertTab( $skin, &$content_actions ) {
		wfLoadExtensionMessages( 'HideRevision' );
		$special = SpecialPage::getTitleFor( 'HideRevision' );
		$content_actions['hiderevision'] = array(
			'class' => false,
			'text' => wfMsgHTML( 'hiderevision-tab' ),
			'href' => $special->getLocalUrl( $this->mLinkParam ) );
		return true;
	}
}


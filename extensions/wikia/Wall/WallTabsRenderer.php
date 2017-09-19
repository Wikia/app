<?php
/**
 * Copyright (C) 2017 Wikia, Inc.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * https://www.gnu.org/copyleft/gpl.html
 *
 * @file
 */

class WallTabsRenderer extends ContextSource {
	public function __construct( IContextSource $context ) {
		$this->setContext( $context );
	}

	public function renderUserPageContentActions( array &$contentActions ) {
		if ( empty( $contentActions['namespaces'] ) || empty( $contentActions['namespaces']['user_talk'] ) ) {
			return;
		}

		$userWallTitle = $this->getTitle()->getTalkPage();

		$contentActions['namespaces']['user_talk']['text'] = $this->msg( 'wall-message-wall' )->text();
		$contentActions['namespaces']['user_talk']['href'] = $userWallTitle->getLocalUrl();

		// BugId:23000 Remove the class="new" to prevent the link from being displayed as a redlink in monobook.
		$tabClasses = (array) $contentActions['namespaces']['user_talk']['class'];
		$contentActions['namespaces']['user_talk']['class'] =
			array_filter( $tabClasses, function ( $class ) {
				return $class !== 'new';
			} );
	}

	public function renderWallContentActions( array &$contentActions ) {
		$messageTitle = $this->getMessageTitle();

		if ( empty( $messageTitle ) ) {
			return;
		}

		$wallTitleText = $messageTitle->getBaseText();

		$owningUser = User::newFromName( $wallTitleText, $validateUserName = false );

		$contentActions['namespaces'] = [];

		$contentActions['namespaces']['user-profile'] = [
			'class' => false,
			'href' => $owningUser->getUserPage()->getFullURL(),
			'text' => $this->msg( 'nstab-user' )->text(),
		];

		$contentActions['namespaces']['message-wall'] = [
			'class' => 'selected',
			'href' => $owningUser->getTalkPage()->getFullURL(),
			'text' => $this->msg( 'wall-message-wall' )->text(),
		];
	}

	public function renderUserTalkArchiveContentActions( array &$contentActions ) {
		$messageTitle = $this->getMessageTitle();

		if ( empty( $messageTitle ) ) {
			return;
		}

		$wallTitleText = $messageTitle->getBaseText();

		$userTalkPageTitle = Title::newFromText( $wallTitleText, NS_USER_TALK );

		$contentActions = [];
		$contentActions['namespaces'] = [];

		$contentActions['namespaces']['view-source'] = [
			'class' => false,
			'href' => $userTalkPageTitle->getLocalUrl( [ 'action' => 'edit' ] ),
			'text' => $this->msg( 'user-action-menu-view-source' )->text(),
		];

		$contentActions['namespaces']['history'] = [
			'class' => false,
			'href' => $userTalkPageTitle->getLocalUrl( [ 'action' => 'history' ] ),
			'text' => $this->msg( 'user-action-menu-history' )->text(),
		];
	}

	private function getMessageTitle() {
		$title = $this->getTitle();

		// Message Wall page (Message Wall:John_Doe) or diff page
		// (Thread:TK-999/@comment-SavageOpress1138-20170613235428?diff=prev)
		// In this case we can safely use the context title
		if ( $title->inNamespace( NS_USER_WALL )
		 	|| $this->getRequest()->getCheck( 'diff' )
			|| $this->getRequest()->getCheck( 'oldid' )
		) {
			return $title;
		}

		// Thread page (Thread:123456) - we need to build title from article ID
		$threadId = intval( $title->getText() );

		return Title::newFromID( $threadId );
	}
}

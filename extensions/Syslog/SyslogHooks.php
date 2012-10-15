<?php

/**
 * Hooks for Syslog extension
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

class SyslogHooks {

	/**
	 * Log a message in the syslog
	 *
	 * @param $message string
	 */
	private static function log( $message ) {
		static $init = false;

		if ( !$init ) {
			$init = true;

			global $wgSyslogIdentity, $wgSyslogFacility, $wgHooks;

			openlog( $wgSyslogIdentity ? $wgSyslogIdentity : wfWikiID(), LOG_ODELAY | LOG_PID, $wgSyslogFacility);
		}

		syslog( LOG_NOTICE, $message );
	}

	/**
	 * Hook for article deletion
	 */
	public static function onArticleDeleteComplete( $article, $user, $reason ) {
		$userName = $user->getName();
		$pageName = $article->getTitle()->getPrefixedText();
		self::log( "User '{$userName}' deleted '{$pageName}' for '{$reason}'" );
		return true;
	}

	/**
	 * Hook for article protection
	 */
	public static function onArticleProtectComplete( $article, $user, $protect, $reason ) {
		$userName = $user->getName();
		$pageName = $article->getTitle()->getPrefixedText();
		$action = count( $protect ) ? 'protected' : 'unprotected';
		self::log( "User '{$userName}' {$action} '{$pageName}' for '{$reason}'" );
		return true;
	}

	/**
	 * Hook for article save
	 */
	public static function onArticleSaveComplete( $article, $user, $text, $summary ) {
		$userName = $user->getName();
		$pageName = $article->getTitle()->getPrefixedText();
		self::log( "User '{$userName}' saved '{$pageName}' with comment '{$summary}'" );
		return true;
	}

	/**
	 * Hook for IP & user blocks
	 */
	public static function onBlockIpComplete( $block, $user ) {
		$userName = $user->getName();
		$target = $block->getTarget();
		$target = is_object( $target ) ? $target->getName() : $target;
		self::log( "User '{$userName}' blocked '{$target}' for '{$block->mReason}' until '{$block->mExpiry}'" );
		return true;
	}

	/**
	 * Hook for Special:Emailuser
	 */
	public static function onEmailUserComplete( $to, $from, $subject, $text ) {
		self::log( "Email sent from '$from' to '$to' with subject '$subject'" );
		return true;
	}

	/**
	 * Hook for page unwatching
	 */
	public static function onUnwatchArticleComplete( $user, $article ) {
		$userName = $user->getName();
		$pageName = $article->getTitle()->getPrefixedText();
		self::log( "User '{$userName}' stopped watching '{$pageName}'" );
		return true;
	}

	/**
	 * Hook for login
	 */
	public static function onUserLoginComplete( $user ) {
		self::log( "User '" . $user->getName() . "' logged in" );
		return true;
	}

	/**
	 * Hook for logout
	 */
	public static function onUserLogoutComplete( $user, $inject_html, $oldName ) {
		self::log( "User '" . $oldName . "' logged out" );
		return true;
	}

	/**
	 * Hook for watch
	 */
	public static function onWatchArticleComplete( $user, $article ) {
		$userName = $user->getName();
		$pageName = $article->getTitle()->getPrefixedText();
		self::log( "User '{$userName}' started watching '{$pageName}'" );
		return true;
	}
}

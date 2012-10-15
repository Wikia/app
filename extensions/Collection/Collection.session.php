<?php

/**
 * Collection Extension for MediaWiki
 *
 * Copyright (C) PediaPress GmbH
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
 * http://www.gnu.org/copyleft/gpl.html
 */

class CollectionSession {
	static function hasSession() {
		if ( !session_id() ) return false;
		return isset( $_SESSION['wsCollection'] );
	}

	static function startSession() {
		if ( session_id() == '' ) {
			wfSetupSession();
		}
		self::clearCollection();
	}

	static function touchSession() {
		$collection = $_SESSION['wsCollection'];
		$collection['timestamp'] = wfTimestampNow();
		$_SESSION['wsCollection'] = $collection;
	}

	static function clearCollection() {
		$_SESSION['wsCollection'] = array(
			'enabled' => true,
			'title' => '',
			'subtitle' => '',
			'items' => array(),
		);
		CollectionSuggest::clear();
		self::touchSession();
	}

	static function enable() {
		if ( !self::hasSession() ) {
			self::startSession();
		} else {
			$_SESSION['wsCollection']['enabled'] = true;
			self::touchSession();
		}
	}

	static function disable() {
		if ( !self::hasSession() ) {
			return;
		}
		self::clearCollection();
		$_SESSION['wsCollection']['enabled'] = false;
		self::touchSession();
	}

	static function isEnabled() {
		return ( self::hasSession() && $_SESSION['wsCollection']['enabled'] );
	}

	static function countArticles() {
		if ( !self::hasSession() ) {
			return 0;
		}
		$count = 0;
		foreach ( $_SESSION['wsCollection']['items'] as $item ) {
			if ( $item['type'] == 'article' ) {
				$count++;
			}
		}
		return $count;
	}

	static function findArticle( $title, $oldid = 0 ) {
		if ( !self::hasSession() ) {
			return - 1;
		}

		foreach ( $_SESSION['wsCollection']['items'] as $index => $item ) {
			if ( $item['type'] == 'article' && $item['title'] == $title ) {
				if ( $oldid ) {
					if ( $item['revision'] == strval( $oldid ) ) {
						return $index;
					}
				} else {
					if ( $item['revision'] == $item['latest'] ) {
						return $index;
					}
				}
			}
		}
		return - 1;
	}

	static function purge() {
		if ( !self::hasSession() ) {
			return false;
		}
		$coll = $_SESSION['wsCollection'];
		$newitems = array();
		if ( isset( $coll['items'] ) ) {
			$batch = new LinkBatch;
			$lc = LinkCache::singleton();
			foreach ( $coll['items'] as $item ) {
				if ( $item['type'] == 'article' ) {
					$t = Title::newFromText( $item['title'] );
					$batch->addObj( $t );
				}
			}
			$batch->execute();
			foreach ( $coll['items'] as $item ) {
				if ( $item['type'] == 'article' ) {
					$t = Title::newFromText( $item['title'] );
					if ( $t && !$lc->isBadLink( $t->getPrefixedDbKey() ) ) {
						$newitems[] = $item;
					}
				} else {
					$newitems[] = $item;
				}
			}
		}
		$coll['items'] = $newitems;
		$_SESSION['wsCollection'] = $coll;
		return true;
	}

	static function getCollection() {
		return self::purge() ? $_SESSION['wsCollection'] : array();
	}

	static function setCollection( $collection ) {
		$_SESSION['wsCollection'] = $collection;
		self::touchSession();
	}
}

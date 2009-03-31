<?php
/*
 * Copyright (C) 2008 Victor Vasiliev <vasilvv@gmail.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 */

if( !defined( 'MEDIAWIKI' ) )
	exit;

class SpecialListClosedWikis extends SpecialPage {
	public function __construct() {
		wfLoadExtensionMessages( 'CloseWikis' );
		parent::__construct( 'ListClosedWikis' );
	}

	public function getDescription() {
		return wfMsg( 'closewikis-list' );
	}

	public function execute( $par ) {
		global $wgUser, $wgOut, $wgLang;

		$this->setHeaders();
		$wgOut->addWikiMsg( 'closewikis-list-intro' );
		$wgOut->addHTML( '<table class="TablePager" style="width: 100%"><tr>' );
		foreach( array( 'wiki', 'by', 'timestamp', 'dispreason' ) as $column )
			$wgOut->addHTML( '<th>' . wfMsgExt( "closewikis-list-header-{$column}", 'parseinline' ) . '</th>' );
		$wgOut->addHTML( '</tr>' );
		$list = CloseWikis::getAll();
		foreach( $list as $entry ) {
			$wgOut->addHTML( '<tr>' );
			$wgOut->addHTML( '<td>' . $entry->getWiki() . '</td>' );
			$wgOut->addHTML( '<td>' . $entry->getBy() . '</td>' );
			$wgOut->addHTML( '<td>' . $wgLang->timeanddate( $entry->getTimestamp() ) . '</td>' );
			$wgOut->addHTML( '<td>' ); $wgOut->addWikiText( $entry->getReason() ); $wgOut->addHTML( '</td>' );
			$wgOut->addHTML( '</tr>' );
		}
		$wgOut->addHTML( '</table>' );
	}
}

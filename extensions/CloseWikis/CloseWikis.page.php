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

class SpecialCloseWiki extends SpecialPage {
	public function __construct() {
		wfLoadExtensionMessages( 'CloseWikis' );
		parent::__construct( 'CloseWiki', 'closewikis' );
	}

	public function getDescription() {
		return wfMsg( 'closewikis-page' );
	}

	public function execute( $par ) {
		global $wgUser;

		$this->setHeaders();
		if( !$this->userCanExecute( $wgUser ) ) {
			$this->displayRestrictionError();
			return;
		}

		$this->closeForm();
		if( CloseWikis::getList() )
			$this->reopenForm();
	}

	protected function buildSelect( $list, $name, $default = '' ) {
		sort( $list );
		$select = new XmlSelect( $name );
		$select->setDefault( $default );
		foreach( $list as $wiki )
			$select->addOption( $wiki );
		return $select->getHTML();
	}

	protected function closeForm() {
		global $wgOut, $wgUser, $wgRequest, $wgTitle;

		$status = '';
		$statusOK = false;
		if( $wgRequest->wasPosted() && $wgUser->matchEditToken( $wgRequest->getVal( 'wpcEdittoken' ) ) ) {
			global $wgLocalDatabases;
			$wiki = $wgRequest->getVal( 'wpcWiki' );
			$dreason = $wgRequest->getVal( 'wpcDisplayReason' );
			$lreason = $wgRequest->getVal( 'wpcReason' );
			if( !in_array( $wiki, $wgLocalDatabases ) ) {
				$status = wfMsgExt( 'closewikis-page-err-nowiki', 'parseinline' );
			} else {
				$statusOK = CloseWikis::close( $wiki, $dreason, $wgUser );
				if( $statusOK ) {
					$status = wfMsgExt( 'closewikis-page-close-success', 'parseinline' );
					$logpage = new LogPage( 'closewiki' );
					$logpage->addEntry( 'close', $wgTitle /* dummy */, $lreason, array( $wiki ) );
				} else {
					$status = wfMsgExt( 'closewikis-page-err-closed', 'parseinline' );
				}
			}
		}

		$legend = wfMsgHtml( 'closewikis-page-close' );

		// If operation was successful, empty all fields
		$defaultWiki = $statusOK ? '' : $wgRequest->getVal( 'wpcWiki' );
		$defaultDisplayReason = $statusOK ? '' : $wgRequest->getVal( 'wpcDisplayReason' );
		$defaultReason = $statusOK ? '' : $wgRequest->getVal( 'wpcReason' );
		// For some reason Xml::textarea( 'blabla', null ) produces an unclosed tag
		if( !$defaultDisplayReason )
			$defaultDisplayReason = '';

		$wgOut->addHTML( "<fieldset><legend>{$legend}</legend>" );
		if( $status ) {
			$statusStyle = $statusOK ? 'success' : 'error';
			$wgOut->addHTML( "<p><strong class=\"{$statusStyle}\">{$status}</strong></p>" );
		}
		$wgOut->addHTML( '<form method="post" action="' . htmlspecialchars( $wgTitle->getLocalURL() ) . '">' );
		$form = array();
		$form['closewikis-page-close-wiki'] = $this->buildSelect( CloseWikis::getUnclosedList(), 'wpcWiki', $defaultWiki );
		$form['closewikis-page-close-dreason'] = Xml::textarea( 'wpcDisplayReason', $defaultDisplayReason );
		$form['closewikis-page-close-reason'] = Xml::input( 'wpcReason', false, $defaultReason );
		$wgOut->addHTML( Xml::buildForm( $form, 'closewikis-page-close-submit' ) );
		$wgOut->addHTML( Xml::hidden( 'wpcEdittoken', $wgUser->editToken() ) );
		$wgOut->addHTML( "</form></fieldset>" );
	}

	protected function reopenForm() {
		global $wgOut, $wgUser, $wgRequest, $wgTitle;

		$status = '';
		$statusOK = false;
		if( $wgRequest->wasPosted() && $wgUser->matchEditToken( $wgRequest->getVal( 'wprEdittoken' ) ) ) {
			global $wgLocalDatabases;
			$wiki = $wgRequest->getVal( 'wprWiki' );
			$lreason = $wgRequest->getVal( 'wprReason' );
			if( !in_array( $wiki, $wgLocalDatabases ) ) {
				$status = wfMsgExt( 'closewikis-page-err-nowiki', 'parseinline' );
			} else {
				$statusOK = CloseWikis::reopen( $wiki );
				if( $statusOK ) {
					$status = wfMsgExt( 'closewikis-page-reopen-success', 'parseinline' );
					$logpage = new LogPage( 'closewiki' );
					$logpage->addEntry( 'reopen', $wgTitle /* dummy */, $lreason, array( $wiki ) );
				} else {
					$status = wfMsgExt( 'closewikis-page-err-opened', 'parseinline' );
				}
			}
		}

		$legend = wfMsgHtml( 'closewikis-page-reopen' );

		// If operation was successful, empty all fields
		$defaultWiki = $statusOK ? '' : $wgRequest->getVal( 'wprWiki' );
		$defaultReason = $statusOK ? '' : $wgRequest->getVal( 'wprReason' );

		$wgOut->addHTML( "<fieldset><legend>{$legend}</legend>" );
		if( $status ) {
			$statusStyle = $statusOK ? 'success' : 'error';
			$wgOut->addHTML( "<p><strong class=\"{$statusStyle}\">{$status}</strong></p>" );
		}
		$wgOut->addHTML( '<form method="post" action="' . htmlspecialchars( $wgTitle->getLocalURL() ) . '">' );
		$form = array();
		$form['closewikis-page-reopen-wiki'] = $this->buildSelect( CloseWikis::getList(), 'wprWiki', $defaultWiki );
		$form['closewikis-page-reopen-reason'] = Xml::input( 'wprReason', false, $defaultReason );
		$wgOut->addHTML( Xml::buildForm( $form, 'closewikis-page-reopen-submit' ) );
		$wgOut->addHTML( Xml::hidden( 'wprEdittoken', $wgUser->editToken() ) );
		$wgOut->addHTML( "</form></fieldset>" );
	}


}

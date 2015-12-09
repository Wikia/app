<?php

class InsightsItemData {
	/**
	 * Get data about revision
	 * Who and when made last edition
	 *
	 * @param int $rev
	 * @return mixed
	 */
	public function prepareRevisionData( $revId ) {
		$data = [];
		$rev = Revision::newFromId( $revId );

		if ( $rev ) {
			$data['timestamp'] = wfTimestamp( TS_UNIX, $rev->getTimestamp() );

			$user = $rev->getUserText();

			if ( $rev->getUser() ) {
				$userpage = Title::newFromText( $user, NS_USER )->getFullURL();
			} else {
				$userpage = SpecialPage::getTitleFor( 'Contributions', $user )->getFullUrl();
			}

			$data['username'] = $user;
			$data['userpage'] = $userpage;
		}

		return $data;
	}

	/**
	 * Prepare a data to create a link element
	 *
	 * @param Title $title A target article's Title object
	 * @param $params
	 * @return array
	 */
	public static function getTitleLink( Title $title, $params ) {
		$prefixedTitle = $title->getPrefixedText();

		$data = [
			'text' => $prefixedTitle,
			'url' => $title->getFullURL( $params ),
			'title' => $prefixedTitle,
			'classes' => '',
		];

		if ( !$title->exists() ) {
			$data['classes'] = 'new';
			$data['title'] = wfMessage( 'red-link-title', $prefixedTitle )->escaped();
		}

		return $data;
	}

	/**
	 * Get param to show proper editor based on user preferences
	 *
	 * @return mixed
	 */
	public static function getEditUrlParams() {
		global $wgUser;

		if ( EditorPreference::isVisualEditorPrimary() && $wgUser->isLoggedIn() ) {
			$param['veaction'] = 'edit';
		} else {
			$param['action'] = 'edit';
		}

		return $param;
	}

	/**
	 * Returns a link to a WhatLinksHere page for the given Title.
	 * @param Title $title The target article's title object
	 * @return string
	 */
	public function getWlhUrl( Title $title ) {
		return SpecialPage::getTitleFor( 'Whatlinkshere', $title->getPrefixedText() )->getFullUrl();
	}

}
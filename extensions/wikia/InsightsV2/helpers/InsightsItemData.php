<?php

class InsightsItemData {
	private $config;
	private $params;

	public function __construct( InsightsConfig $config, $params ) {
		$this->config = $config;
		$this->params = $params;
	}

	/**
	 * Get common article data
	 *
	 * @param Title $title
	 * @return array
	 */
	public function getArticleData( Title $title ) {
		$article['link'] = $this->getTitleLink( $title, $this->params );
		$article['metadata']['lastRevision'] = $this->prepareRevisionData( $title->getLatestRevID() );

		if ( $this->config->showPageViews() ) {
			$article['metadata'] = array_merge( $article['metadata'], $this->initPageViews() );
		}

		return $article;
	}
	/**
	 * Get data about article revision
	 *
	 * @param int $rev
	 * @return array
	 */
	public function prepareRevisionData( $revId ) {
		$data = [];
		$userpage = null;
		$rev = Revision::newFromId( $revId );

		if ( $rev ) {
			$data['timestamp'] = wfTimestamp( TS_UNIX, $rev->getTimestamp() );

			$user = $rev->getUserText();

			if ( $rev->getUser() ) {
				$userpage = Title::newFromText( $user, NS_USER );
			}

			if ( $userpage instanceof Title ) {
				$userpageUrl = $userpage->getFullURL();
			} else {
				$userpageUrl = SpecialPage::getTitleFor( 'Contributions', $user )->getFullUrl();
			}

			$data['username'] = $user;
			$data['userpage'] = $userpageUrl;
		}

		return $data;
	}

	/**
	 * Prepare a data to create a link element
	 *
	 * @param Title $title A target article's Title object
	 * @param array $params
	 * @return array
	 */
	public static function getTitleLink( Title $title, $params ) {
		$prefixedTitle = $title->getPrefixedText();

		$data = [
			'text' => $prefixedTitle,
			'articleurl' => $title->getFullURL(),
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
	 * @return array
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

	public function getWhatLinksHereData( $title, $value ) {
		return  [
			'message' => $this->config->getWhatLinksHereMessage(),
			'value' => (int)$value,
			'url' => $this->getWlhUrl( $title ),
		];
	}

	private function initPageViews() {
		return [
			'pv7' => 0,
			'pv28' => 0,
			'pvDiff' => 0
		];
	}
}

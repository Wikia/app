<?php
namespace CommunityHeader;

use \SpecialPage;

class WikiButtons implements \Iterator {
	private $buttons;

	public function __construct() {
		$wgUser = \F::app()->wg->User;

		if ( $wgUser->isLoggedIn() ) {
			if ( $wgUser->isAllowed( 'admindashboard' ) ) {
				$this->buttons = $this->adminButtons();
			} else {
				$this->buttons = $this->userButtons();
			}

		} else {
			$this->buttons = $this->anonButtons();
		}

	}

	private function anonButtons() {
		$addNewPageButton =
			new WikiButton( $this->getAddNewPageURL(),
				new Label( 'community-header-add-new-page', Label::TYPE_TRANSLATABLE_TEXT ),
				new Label( 'community-header-add-new-page', Label::TYPE_TRANSLATABLE_TEXT ),
				'wds-icons-add-new-page-small' );

		return [ $addNewPageButton ];
	}

	private function userButtons() {
		$addNewPageButton =
			new WikiButton( $this->getAddNewPageURL(),
				new Label( 'community-header-add', Label::TYPE_TRANSLATABLE_TEXT ),
				new Label( 'community-header-add-new-page', Label::TYPE_TRANSLATABLE_TEXT ),
				'wds-icons-add-new-page-small' );

		$wikiActivityButton =
			new WikiButton( $this->getWikiActivityURL(), null,
				new Label( 'community-header-wiki-activity', Label::TYPE_TRANSLATABLE_TEXT ),
				'wds-icons-activity-small' );

		return [ $addNewPageButton, $wikiActivityButton ];
	}

	private function adminButtons() {
		$addNewPageButton =
			new WikiButton( $this->getAddNewPageURL(), null,
				new Label( 'community-header-add-new-page', Label::TYPE_TRANSLATABLE_TEXT ),
				'wds-icons-add-new-page-small' );

		$wikiActivityButton =
			new WikiButton( $this->getWikiActivityURL(), null,
				new Label( 'community-header-wiki-activity', Label::TYPE_TRANSLATABLE_TEXT ),
				'wds-icons-activity-small' );

		$adminDashboardURL = $this->getAdminDashboardURL();
		$adminDashboardButton =
			new WikiButton( $adminDashboardURL, null,
				new Label( 'community-header-admin-dashboard', Label::TYPE_TRANSLATABLE_TEXT ),
				'wds-icons-dashboard-small' );

		return [ $addNewPageButton, $wikiActivityButton, $adminDashboardButton ];
	}

	private function getAddNewPageURL() {
		return SpecialPage::getTitleFor( 'CreatePage' )->getLocalURL();
	}

	private function getWikiActivityURL() {
		return SpecialPage::getTitleFor( 'WikiActivity' )->getLocalURL();
	}

	private function getAdminDashboardURL() {
		return SpecialPage::getTitleFor( 'AdminDashboard' )->getLocalURL();
	}

	/**
	 * Return the current element
	 * @link http://php.net/manual/en/iterator.current.php
	 * @return mixed Can return any type.
	 * @since 5.0.0
	 */
	public function current() {
		return current( $this->buttons );
	}

	/**
	 * Move forward to next element
	 * @link http://php.net/manual/en/iterator.next.php
	 * @return void Any returned value is ignored.
	 * @since 5.0.0
	 */
	public function next() {
		next( $this->buttons );
	}

	/**
	 * Return the key of the current element
	 * @link http://php.net/manual/en/iterator.key.php
	 * @return mixed scalar on success, or null on failure.
	 * @since 5.0.0
	 */
	public function key() {
		key( $this->buttons );
	}

	/**
	 * Checks if current position is valid
	 * @link http://php.net/manual/en/iterator.valid.php
	 * @return boolean The return value will be casted to boolean and then evaluated.
	 * Returns true on success or false on failure.
	 * @since 5.0.0
	 */
	public function valid() {
		$key = key( $this->buttons );

		return $key !== NULL && $key !== FALSE;
	}

	/**
	 * Rewind the Iterator to the first element
	 * @link http://php.net/manual/en/iterator.rewind.php
	 * @return void Any returned value is ignored.
	 * @since 5.0.0
	 */
	public function rewind() {
		reset( $this->buttons );
	}
}

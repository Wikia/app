<?php
/**
 * Chat Ban List special page.
 *
 * A special page for listing chat bans on a given wiki.
 *
 * @author wladek
 */

class ChatBanListSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'ChatBanList' );
	}

	public function index() {
		$this->specialPage->setHeaders();
		$this->getOutput()->addModuleStyles( 'mediawiki.special' );

		$pager = new ChatBanPager( $this );

		$html = $pager->getNavigationBar() .
			$pager->getBody() .
			$pager->getNavigationBar();

		$this->response->setVal( 'html', $html );
	}

}

class ChatBanPager extends TablePager {
	function __construct( $page ) {
		global $wgExternalDatawareDB;
		$this->mPage = $page;
		parent::__construct( $this->mPage->getContext() );

		$this->mDb = wfGetDB( DB_SLAVE, [], $wgExternalDatawareDB );
	}

	public function getQueryInfo() {
		return [
			'tables' => [ 'chat_ban_users' ],
			'fields' => [
				'cbu_user_id',
				'cbu_admin_user_id',
				'start_date',
				'end_date',
				'reason',
			],
		];
	}

	public function getFieldNames() {
		$headers = [
			'start_date' => $this->msg( 'blocklist-timestamp' )->escaped(),
			'cbu_user_id' => $this->msg( 'blocklist-target' )->escaped(),
			'end_date' => $this->msg( 'blocklist-expiry' )->escaped(),
			'cbu_admin_user_id' => $this->msg( 'blocklist-by' )->escaped(),
			'reason' => $this->msg( 'blocklist-reason' )->escaped(),
		];

		return $headers;
	}

	public function formatValue( $name, $value ) {
		switch( $name ) {
			case 'start_date':
				$formatted = $this->getLanguage()->userTimeAndDate( $value, $this->getUser() );
				break;

			case 'cbu_user_id':
				$formatted = $this->formatUser( $value );
				break;

			case 'end_date':
				$formatted = $this->getLanguage()->formatExpiry( $value, /* User preference timezone */ true );
				break;

			case 'cbu_admin_user_id':
				$formatted = $this->formatUser( $value );
				break;

			case 'reason':
				$formatted = Linker::commentBlock( $value );
				break;

			default:
				$formatted = "Unable to format $name";
				break;
		}

		return $formatted;
	}

	public function getIndexField() {
		return 'start_date';
	}

	public function getDefaultSort() {
		return 'start_date';
	}

	public function getDefaultDirections() {
		return true;
	}

	public function isFieldSortable( $name ) {
		return false;
	}

	public function getTableClass() {
		return 'TablePager mw-blocklist';
	}

	/**
	 * @param int $userId
	 * @return string
	 */
	protected function formatUser( $userId ) {
		$user = User::newFromId( $userId );
		if ( $user ) {
			$formatted = Linker::userLink( $userId, $user );
		} else {
			$formatted = sprintf( "%s %d", $this->msg( 'uid' )->escaped(), $userId );
		}

		return $formatted;
	}
}

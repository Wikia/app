<?php

/**
 * Chat Ban List special page.
 *
 * A special page for listing chat bans on a given wiki.
 *
 * @author wladek
 */
class ChatBanListSpecialController extends WikiaSpecialPageController {

	private $target;

	public function __construct() {
		parent::__construct( 'ChatBanList' );
	}

	public function index() {
		$this->specialPage->setHeaders();
		$this->getOutput()->addModuleStyles( 'mediawiki.special' );

		$this->target = trim( $this->getRequest()->getVal( 'wpTarget', $this->getPar() ) );

		$conds = [ ];
		$conds['cbu_wiki_id'] = $this->wg->CityId;
		$targetUser = User::newFromName( $this->target );
		if ( $targetUser && $targetUser->getId() > 0 ) {
			$conds['cbu_user_id'] = $targetUser->getId();
		}

		$formHtml = $this->getForm();

		$pager = new ChatBanPager( $this, $conds );

		$resultsHtml =
			$pager->getNavigationBar() .
			$pager->getBody() .
			$pager->getNavigationBar();

		$this->response->setVal( 'formHtml', $formHtml );
		$this->response->setVal( 'resultsHtml', $resultsHtml );
	}

	private function getForm() {
		$lang = $this->getLanguage();

		$fields = array(
			'Target' => array(
				'type' => 'text',
				'label-message' => 'username',
				'tabindex' => '1',
				'size' => '45',
				'default' => $this->target,
			),
			'Limit' => array(
				'class' => 'HTMLBlockedUsersItemSelect',
				'label-message' => 'table_pager_limit_label',
				'options' => array(
					$lang->formatNum( 20 ) => 20,
					$lang->formatNum( 50 ) => 50,
					$lang->formatNum( 100 ) => 100,
					$lang->formatNum( 250 ) => 250,
					$lang->formatNum( 500 ) => 500,
				),
				'name' => 'limit',
				'default' => 50,
			),
		);
		$form = new HTMLForm( $fields, $this->getContext() );
		$form->setMethod( 'get' );
		$form->setWrapperLegendMsg( 'ipblocklist-legend' );
		$form->setSubmitTextMsg( 'ipblocklist-submit' );
		$form->prepareForm();

		return $form->getHTML( '' );
	}

}

class ChatBanPager extends TablePager {
	function __construct( $page, $conds ) {
		global $wgExternalDatawareDB;
		$this->mPage = $page;
		$this->mConds = $conds;
		parent::__construct( $this->mPage->getContext() );

		$this->mDb = wfGetDB( DB_SLAVE, [ ], $wgExternalDatawareDB );
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
			'conds' => $this->mConds,
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
		switch ( $name ) {
			case 'start_date':
				$formatted = $this->getLanguage()->userTimeAndDate( $value, $this->getUser() );
				break;

			case 'cbu_user_id':
				$formatted = $this->formatUser( $value );
				break;

			case 'end_date':
				$formatted = $this->getLanguage()->formatExpiry( $value, /* User preference timezone */
					true );
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

	/**
	 * @param int $userId
	 * @return string
	 */
	protected function formatUser( $userId ) {
		$user = User::newFromId( $userId );
		if ( $user ) {
			$formatted =
				Linker::userLink( $userId, $user ) .
				Linker::userToolLinks( $userId, $user );
		} else {
			$formatted = sprintf( "%s %d", $this->msg( 'uid' )->escaped(), $userId );
		}

		return $formatted;
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
}

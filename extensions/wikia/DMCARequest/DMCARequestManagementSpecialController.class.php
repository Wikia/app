<?php
/**
 * DMCA Request Management special page.
 *
 * A special page for managing DMCA requests and passing
 * them to ChillingEffects.
 *
 * @author grunny
 */

use DMCARequest\DMCARequestHelper;

class DMCARequestManagementSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'DMCARequestManagement', 'dmcarequestmanagement', /* $listed = */ false );
	}

	/**
	 * Main entry point.
	 */
	public function index() {
		$this->specialPage->setHeaders();
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
		if ( !$this->getUser()->isAllowed( 'dmcarequestmanagement' ) ) {
			$this->displayRestrictionError();
			return false;
		}

		$request = $this->getRequest();

		$dmcaId = intval( $this->getPar() );

		if ( $dmcaId ) {
			$this->forward( 'DMCARequestManagementSpecial', 'manageNotice' );
			return;
		}

		// List out all DMCA requests, optionally filtering on an email address
		$conds = [];
		$email = $request->getVal( 'email' );
		if ( $email ) {
			$conds['dmca_email'] = $email;
		}
		$pager = new DMCARequestPager( $this, $conds );

		$dmcaList = $pager->getNavigationBar() .
			$pager->getBody() .
			$pager->getNavigationBar();

		$this->response->setVal( 'dmcaList', $dmcaList );
	}

	/**
	 * View to manage a specific DMCA notice.
	 *
	 * @return void
	 */
	public function manageNotice() {
		$request = $this->getRequest();
		$user = $this->getUser();
		// Sanity check in case a user tries to call this directly
		if ( !$user->isAllowed( 'dmcarequestmanagement' ) || !$request->isInternal() ) {
			$this->displayRestrictionError();
			return false;
		}
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
		$this->getOutput()->addModuleStyles( 'ext.dmcaRequest' );

		$dmcaId = intval( $this->getPar() );

		$helper = new DMCARequestHelper();
		$result = $helper->loadNotice( $dmcaId );

		$this->response->setVal( 'returnto', $this->msg( 'returnto' )->rawParams(
			Linker::link( $this->getTitle() ) )->escaped() );

		if ( !$result ) {
			$this->response->setVal( 'error', $this->msg( 'dmcarequestmanagement-error-no-notice', $dmcaId )->text() );
			return;
		}

		if ( $request->wasPosted() && $user->matchEditToken( $request->getVal( 'token' ) ) ) {
			// Handle submission
		}

		$noticeData = $helper->getNoticeData();

		$this->response->setValues( [
			'noticeTextHeader' => $this->msg( 'dmcarequestmanagement-notice-email-text' )->text(),
			'noticeText' => $helper->getNoticeText(),
			'editToken' => $user->getEditToken(),
		] );
	}
}

/**
 * Use the MediaWiki pager class for convenience.
 *
 * @todo Convert to a Wikia style guide pager
 */
class DMCARequestPager extends TablePager {
	function __construct( $page, $conds ) {
		global $wgExternalSharedDB;
		$this->mPage = $page;
		$this->mConds = $conds;
		parent::__construct( $this->mPage->getContext() );

		$this->mDb = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );
	}

	public function getQueryInfo() {
		return [
			'tables' => [ 'dmca_request' ],
			'fields' => [
				'dmca_id',
				'dmca_date',
				'dmca_fullname',
				'dmca_email',
				'dmca_action_taken',
			],
			'conds' => $this->mConds,
		];
	}

	public function getFieldNames() {
		$headers = [
			'dmca_id' => $this->msg( 'dmcarequestmanagement-list-id' )->escaped(),
			'dmca_date' => $this->msg( 'dmcarequestmanagement-list-date' )->escaped(),
			'dmca_fullname' => $this->msg( 'dmcarequestmanagement-list-fullname' )->escaped(),
			'dmca_email' => $this->msg( 'dmcarequestmanagement-list-email' )->escaped(),
			'dmca_action_taken' => $this->msg( 'dmcarequestmanagement-list-action-taken' )->escaped(),
		];

		return $headers;
	}

	public function formatValue( $name, $value ) {
		$lang = $this->getLanguage();

		switch ( $name ) {
			case 'dmca_id':
				return Linker::link(
					SpecialPage::getTitleFor( 'DMCARequestManagement', intval( $value ) ),
					$lang->formatNum( intval( $value ) )
				);

			case 'dmca_date':
				return $lang->date( $value, true );

			case 'dmca_email':
				return Linker::link(
					SpecialPage::getTitleFor( 'DMCARequestManagement' ),
					htmlspecialchars( $value, ENT_QUOTES ),
					[],
					[ 'email' => $value ]
				);

			default:
				return htmlspecialchars( $value, ENT_QUOTES );
		}
	}

	public function getDefaultSort() {
		return 'dmca_id';
	}

	public function getDefaultDirections() {
		return true;
	}

	public function getRowClass( $row ) {
		if ( !$row->dmca_action_taken ) {
			return 'dmcarequest-list-noaction';
		}

		return 'dmcarequest-list-' . Sanitizer::escapeClass( $row->dmca_action_taken );
	}

	public function isFieldSortable( $name ) {
		$sortableFields = [
			'dmca_id',
			'dmca_date',
		];
		return in_array( $name, $sortableFields );
	}
}

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
use DMCARequest\ChillingEffectsClient;

class DMCARequestManagementSpecialController extends WikiaSpecialPageController {

	const DEFAULT_TEMPLATE_ENGINE = \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	private $apiClient;
	private $helper;

	public function __construct() {
		parent::__construct( 'DMCARequestManagement', 'dmcarequestmanagement', /* $listed = */ false );
	}

	/**
	 * Main entry point.
	 */
	public function index() {
		$this->specialPage->setHeaders();
		if ( !$this->getUser()->isAllowed( 'dmcarequestmanagement' ) ) {
			$this->displayRestrictionError();
			return false;
		}
		$this->getOutput()->addModuleStyles( 'ext.dmcaRequest' );

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

		$dmcaId = intval( $this->getPar() );

		$helper = $this->getHelper();
		$result = $helper->loadNotice( $dmcaId );

		$this->response->setVal( 'returnto', $this->msg( 'returnto' )->rawParams(
			Linker::link( $this->getTitle(), $this->msg( 'dmcarequestmanagement' )->escaped() ) )->escaped() );

		if ( !$result ) {
			$this->response->setVal( 'error',
				$this->msg( 'dmcarequestmanagement-error-no-notice', $dmcaId )->escaped() );
			return;
		}

		$noticeData = $helper->getNoticeData();
		$sentToChillingEffects = !empty( $noticeData['ce_id'] );

		if ( !$sentToChillingEffects &&
			$request->wasPosted() &&
			$user->matchEditToken( $request->getVal( 'token' ) )
		) {
			$result = $this->handlePost( $noticeData );

			if ( $result !== false ) {
				$this->setVal( 'ceNoticeId', $result );
				$this->forward( 'DMCARequestManagementSpecial', 'success', /* $resetData = */false );
				return;
			}
		}

		$this->response->setValues( [
			'noticeTextHeader' => $this->msg( 'dmcarequestmanagement-notice-email-text' )->text(),
			'noticeText' => $helper->getNoticeText(),
			'sentToChillingEffects' => $sentToChillingEffects,
		] );

		if ( $sentToChillingEffects ) {
			$this->response->setVal(
				'submittedMsg',
				$this->msg( 'dmcarequestmanagement-chillingeffects-submitted' )
					->rawParams( $this->getChillingEffectsLink( $noticeData['ce_id'] ) )->escaped()
			);
		} else {
			$this->response->setValues( [
				'formHeader' => $this->msg( 'dmcarequestmanagement-chillingeffects-header' )->text(),
				'form' => $this->getFormHtml( $noticeData ),
			] );
		}
	}

	/**
	 * Page to display on successfully submitting a notice.
	 */
	public function success() {
		if ( !$this->getUser()->isAllowed( 'dmcarequestmanagement' ) || !$this->getRequest()->isInternal() ) {
			$this->displayRestrictionError();
			return false;
		}

		$noticeLink = $this->getChillingEffectsLink( $this->response->getVal( 'ceNoticeId' ) );
		$this->response->setVal( 'success',
			$this->msg( 'dmcarequestmanagement-chillingeffects-success' )->rawParams( $noticeLink )->escaped() );
	}

	/**
	 * Handle the submission of the form and send to ChillingEffects
	 * if all is well.
	 *
	 * @return boolean
	 */
	private function handlePost( $noticeData ) {
		$requestData = $this->getRequestData();

		if ( !$requestData ) {
			return false;
		}

		$requestData['date'] = $noticeData['date'];

		$client = $this->getClient();

		$preparedNoticeData = $client->prepareNoticeData( $requestData,
			$this->wg->ChillingEffectsAPIConf['recipient_details'] );

		$response = $client->sendNotice( $preparedNoticeData );

		if ( !$client->requestSuccessful( $response ) ) {
			$this->error = $this->msg( 'dmcarequestmanagement-error-submission' )->escaped();
			return false;
		}

		$ceNoticeId = $client->getNoticeIdFromResponse( $response );

		if ( !$ceNoticeId ) {
			$this->error = $this->msg( 'dmcarequestmanagement-error-submission' )->escaped();
			return false;
		}

		$this->getHelper()->setChillingEffectsNoticeId( $noticeData['id'], $ceNoticeId );

		return $ceNoticeId;
	}

	/**
	 * Get and validate data posted to the form.
	 *
	 * @return array|boolean The resulting request data or false on failure
	 */
	private function getRequestData() {
		$request = $this->getRequest();

		$requestData = [];

		$requiredParameters = [
			'reporttitle',
			'fullname',
		];
		foreach ( $requiredParameters as $param ) {
			$paramValue = trim( $request->getVal( $param ) );
			if ( empty( $paramValue ) ) {
				$this->error = $this->msg( 'dmcarequest-request-error-incomplete' )->escaped();
				$this->errorParam = $param;
				return false;
			}

			$requestData[$param] = $paramValue;
		}

		$urlParams = [ 'original_urls', 'infringing_urls' ];
		foreach ( $urlParams as $param ) {
			$requestData[$param] = [];
			$requestVal = trim( $request->getVal( $param ) );
			if ( !empty( $requestVal ) ) {
				$requestData[$param] = array_map( 'trim', explode( PHP_EOL, $requestVal ) );
			}
		}

		$requestData['subject'] = trim( $request->getVal( 'subject' ) );
		$requestData['source'] = trim( $request->getVal( 'source' ) );
		$requestData['description'] = trim( $request->getVal( 'description' ) );
		$requestData['kind'] = trim( $request->getVal( 'kind' ) );

		$requestData['actiontaken'] = trim( $request->getVal( 'actiontaken' ) );
		if ( !$this->helper->isValidAction( $requestData['actiontaken'] ) ) {
			$this->error = $this->msg( 'dmcarequest-request-error-invalid' )->escaped();
			$this->errorParam = 'actiontaken';
			return false;
		}

		$requestData['sendertype'] = trim( $request->getVal( 'sendertype' ) );
		if ( !$this->helper->isValidSenderType( $requestData['sendertype'] ) ) {
			$this->error = $this->msg( 'dmcarequest-request-error-invalid' )->escaped();
			$this->errorParam = 'sendertype';
			return false;
		}

		return $requestData;
	}

	/**
	 * Get the form HTML from the WikiaStyleGuideForm builder.
	 *
	 * @param  array  $noticeData The current notice data
	 * @return string             The form HTML
	 */
	private function getFormHtml( $noticeData ) {
		$request = $this->getRequest();
		return $this->app->renderView( 'WikiaStyleGuideForm', 'index', [ 'form' => [
			'class' => 'dmca-form',
			'isInvalid' => !empty( $this->error ),
			'errorMsg' => $this->error,
			'inputs' => [
				[
					'type' => 'text',
					'name' => 'reporttitle',
					'isRequired' => true,
					'attributes' => [ 'required' => 'required' ],
					'label' => $this->msg( 'dmcarequestmanagement-title-label' )->escaped(),
					'value' => Sanitizer::encodeAttribute( $request->getVal( 'reporttitle',
						$this->msg( 'dmcarequestmanagement-title-default' )->inLanguage( 'en' )->plain() ) ),
					'isInvalid' => $this->errorParam === 'reporttitle',
					'errorMsg' => $this->error,
				],
				[
					'type' => 'text',
					'name' => 'subject',
					'label' => $this->msg( 'dmcarequestmanagement-subject-label' )->escaped(),
					'value' => Sanitizer::encodeAttribute( $request->getVal( 'subject' ) ),
				],
				[
					'type' => 'text',
					'name' => 'source',
					'label' => $this->msg( 'dmcarequestmanagement-source-label' )->escaped(),
					'value' => Sanitizer::encodeAttribute( $request->getVal( 'source',
						$this->msg( 'dmcarequestmanagement-source-default' )->inLanguage( 'en' )->plain() ) ),
					'isInvalid' => $this->errorParam === 'source',
					'errorMsg' => $this->error,
				],
				[
					'type' => 'select',
					'name' => 'actiontaken',
					'label' => $this->msg( 'dmcarequestmanagement-action-label' )->escaped(),
					'options' => $this->getActionOptions(),
					'value' => Sanitizer::encodeAttribute( $request->getVal( 'actiontaken' ) ),
				],
				[
					'type' => 'text',
					'name' => 'fullname',
					'isRequired' => true,
					'attributes' => [ 'required' => 'required' ],
					'label' => $this->msg( 'dmcarequestmanagement-name-label' )->escaped(),
					'value' => Sanitizer::encodeAttribute( $request->getVal( 'fullname', $noticeData['fullname'] ) ),
					'isInvalid' => $this->errorParam === 'fullname',
					'errorMsg' => $this->error,
				],
				[
					'type' => 'select',
					'name' => 'sendertype',
					'label' => $this->msg( 'dmcarequestmanagement-sendertype-label' )->escaped(),
					'options' => $this->getSenderTypeOptions(),
					'value' => Sanitizer::encodeAttribute( $request->getVal( 'sendertype' ) ),
				],
				[
					'type' => 'textarea',
					'name' => 'original_urls',
					'isRequired' => true,
					'attributes' => [ 'required' => 'required' ],
					'label' => $this->msg( 'dmcarequest-request-links-original-label' )->escaped(),
					'value' => htmlspecialchars( $request->getVal( 'original_urls', $noticeData['original_urls'] ), ENT_QUOTES ),
					'isInvalid' => $this->errorParam === 'original_urls',
					'errorMsg' => $this->error,
				],
				[
					'type' => 'textarea',
					'name' => 'infringing_urls',
					'isRequired' => true,
					'attributes' => [ 'required' => 'required' ],
					'label' => $this->msg( 'dmcarequest-request-links-wikia-label' )->escaped(),
					'value' => htmlspecialchars( $request->getVal( 'infringing_urls', $noticeData['infringing_urls'] ), ENT_QUOTES ),
					'isInvalid' => $this->errorParam === 'infringing_urls',
					'errorMsg' => $this->error,
				],
				[
					'type' => 'textarea',
					'name' => 'description',
					'label' => $this->msg( 'dmcarequestmanagement-links-description-label' )->escaped(),
					'value' => htmlspecialchars( $request->getVal( 'description' ), ENT_QUOTES ),
				],
				[
					'type' => 'text',
					'name' => 'kind',
					'label' => $this->msg( 'dmcarequestmanagement-kind-label' )->escaped(),
					'value' => Sanitizer::encodeAttribute( $request->getVal( 'kind' ) ),
				],
				[
					'type' => 'hidden',
					'name' => 'token',
					'value' => Sanitizer::encodeAttribute( $this->getUser()->getEditToken() ),
				],
				[
					'type' => 'submit',
					'value' => $this->msg( 'dmcarequestmanagement-send-label' )->escaped(),
				],
			],
			'method' => 'POST',
			'action' => $this->getTitle( $this->getPar() )->getLocalUrl(),
		] ] );
	}

	/**
	 * Get the select options for the actions.
	 *
	 * @return array
	 */
	private function getActionOptions() {
		$options = [];
		$actions = $this->getHelper()->getActions();

		foreach ( $actions as $action ) {
			$options[] = [
				'value' => $action,
				// Messages used here:
				// * dmcarequestmanagement-action-yes
				// * dmcarequestmanagement-action-no
				// * dmcarequestmanagement-action-partial
				'content' => $this->msg( 'dmcarequestmanagement-action-' . strtolower( $action ) )->escaped(),
			];
		}
		return $options;
	}

	/**
	 * Get the select options for the sender type.
	 *
	 * @return array
	 */
	private function getSenderTypeOptions() {
		$options = [];
		$senderTypes = $this->getHelper()->getSenderTypes();

		foreach ( $senderTypes as $senderType ) {
			$options[] = [
				'value' => $senderType,
				// Messages used here:
				// * dmcarequestmanagement-sender-type-organization
				// * dmcarequestmanagement-sender-type-individual
				'content' => $this->msg( 'dmcarequestmanagement-sender-type-' . $senderType )->escaped(),
			];
		}
		return $options;
	}

	/**
	 * Get a link to the notice stored on Chilling Effects.
	 *
	 * @param  int    $ceNoticeId The ID of the notice on Chilling Effects.
	 * @return string             HTML link
	 */
	private function getChillingEffectsLink( $ceNoticeId ) {
		return Xml::element(
				'a',
				[ 'href' => $this->wg->ChillingEffectsAPIConf['url'] . '/notices/' . $ceNoticeId ],
				$ceNoticeId
			);
	}

	/**
	 * Get API client.
	 *
	 * @return ChillingEffectsClient
	 */
	private function getClient() {
		if ( $this->apiClient === null ) {
			$this->apiClient = new ChillingEffectsClient(
				$this->wg->ChillingEffectsAPIConf['url'],
				$this->wg->ChillingEffectsAPIConf['key']
			);
		}

		return $this->apiClient;
	}

	/**
	 * Get DMCA request helper.
	 *
	 * @return DMCARequestHelper
	 */
	private function getHelper() {
		if ( $this->helper === null ) {
			$this->helper = new DMCARequestHelper();
		}

		return $this->helper;
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
				'dmca_ce_id',
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
			'dmca_ce_id' => $this->msg( 'dmcarequestmanagement-list-ce-id' )->escaped(),
		];

		return $headers;
	}

	public function formatValue( $name, $value ) {
		global $wgChillingEffectsAPIConf;
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

			case 'dmca_ce_id':
				return Xml::element(
					'a',
					[ 'href' => $wgChillingEffectsAPIConf['url'] . '/notices/' . $value ],
					$value
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
		if ( !$row->dmca_ce_id ) {
			return 'dmcarequest-list';
		}

		return 'dmcarequest-list-submitted';
	}

	public function isFieldSortable( $name ) {
		$sortableFields = [
			'dmca_id',
			'dmca_date',
		];
		return in_array( $name, $sortableFields );
	}
}

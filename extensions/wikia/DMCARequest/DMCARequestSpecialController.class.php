<?php
/**
 * DMCA Request special page
 * @author grunny
 */

use DMCARequest\DMCARequestHelper;

class DMCARequestSpecialController extends WikiaSpecialPageController {

	const DEFAULT_TEMPLATE_ENGINE = \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	private $helper;

	public function __construct() {
		parent::__construct( 'DMCARequest' );
		$this->helper = new DMCARequestHelper();
	}

	/**
	 * Main entry point.
	 */
	public function index() {
		$this->specialPage->setHeaders();
		$this->getOutput()->addModuleStyles( 'ext.dmcaRequest' );

		$request = $this->getRequest();

		if ( $request->wasPosted()
			&& $this->getUser()->matchEditToken( $request->getVal( 'token' ) )
		) {
			$result = $this->handlePost();

			if ( $result ) {
				$this->forward( 'DMCARequestSpecial', 'success' );
				return;
			}
		}

		$this->response->setData( [
			'intro' => $this->msg( 'dmcarequest-request-intro' )->parseAsBlock(),
			'form' => $this->getFormHtml(),
		] );
	}

	/**
	 * Page to display on successfully submitting a notice.
	 */
	public function success() {
		$this->response->setData( [
			'success' => $this->msg( 'dmcarequest-request-success' )->escaped(),
			'returnto' => $this->msg( 'returnto' )->rawParams(
				Linker::link( Title::newMainPage() ) )->escaped(),
		] );
	}

	/**
	 * Handle the submission of the form and send the notice
	 * if all is well.
	 *
	 * @return boolean
	 */
	private function handlePost() {
		$requestData = $this->getRequestData();

		if ( !$requestData ) {
			return false;
		}

		$this->helper->setNoticeData( $requestData );

		$result = $this->helper->saveNotice();

		if ( !$result ) {
			$this->error = $this->msg( 'dmcarequest-request-error-submission' )->parse();
			return false;
		}

		$result = $this->helper->sendNoticeEmail();

		if ( !$result ) {
			$this->error = $this->msg( 'dmcarequest-request-error-submission' )->parse();
			return false;
		}

		return true;
	}

	/**
	 * Get and validate data posted to the form.
	 *
	 * @return array|boolean The resulting request data or false on failure
	 */
	private function getRequestData() {
		$request = $this->getRequest();

		$requiredParameters = [
			'email',
			'fullname',
			'address',
			'telephone',
			'original_urls',
			'infringing_urls',
			'signature',
		];

		$requestData = [];

		foreach ( $requiredParameters as $param ) {
			$paramValue = trim( $request->getVal( $param ) );
			if ( empty( $paramValue ) ) {
				$this->error = $this->msg( 'dmcarequest-request-error-incomplete' )->escaped();
				$this->errorParam = $param;
				return false;
			}

			$requestData[$param] = $paramValue;
		}

		$requestData['type'] = $request->getInt( 'type' );
		if ( !$this->helper->isValidRequestorType( $requestData['type'] ) ) {
			$this->error = $this->msg( 'dmcarequest-request-error-invalid' )->escaped();
			$this->errorParam = 'type';
			return false;
		}

		if ( !Sanitizer::validateEmail( $requestData['email'] ) ) {
			$this->error = $this->msg( 'dmcarequest-request-error-invalid-email' )->escaped();
			$this->errorParam = 'email';
			return false;
		}

		$requestData['comments'] = trim( $request->getVal( 'comments' ) );

		if ( !$request->getBool( 'goodfaith' )
			|| !$request->getBool( 'perjury' )
			|| !$request->getBool( 'wikiarights' )
		) {
			$this->error = $this->msg( 'dmcarequest-request-error-agreements' )->escaped();
			return false;
		}

		$requestData['screenshots'] = $this->getScreenshots();

		return $requestData;
	}

	/**
	 * Get screenshots uploaded to the form.
	 *
	 * @return array An array of the screenshots suitable for
	 *               attaching to the email.
	 */
	private function getScreenshots() {
		$screenshots = $this->getContext()->getRequest()->getFileTempname( 'screenshots' );
		$magic = MimeMagic::singleton();

		$result = [];
		if ( !empty( $screenshots ) ) {
			foreach ( $screenshots as $image ) {
				if ( !empty( $image ) ) {
					$extList = '';
					$mime = $magic->guessMimeType( $image );
					if ( $mime !== 'unknown/unknown' ) {
							// Get a space separated list of extensions
							$extList = $magic->getExtensionsForType( $mime );
							$fileExtension = strtok( $extList, ' ' );
					} else {
							$mime = 'application/octet-stream';
					}
					$result[] = [ 'file' => $image, 'ext' => $fileExtension, 'mime' => $mime ];
				}
			}
		}

		return $result;
	}

	/**
	 * Get the form HTML from the WikiaStyleGuideForm builder.
	 *
	 * @return string The form HTML
	 */
	private function getFormHtml() {
		$request = $this->getRequest();
		return $this->app->renderView( 'WikiaStyleGuideForm', 'index', [ 'form' => [
			'class' => 'dmca-form',
			'attributes' => [ 'enctype' => 'multipart/form-data' ],
			'isInvalid' => !empty( $this->error ),
			'errorMsg' => $this->error,
			'inputs' => [
				[
					'type' => 'select',
					'name' => 'type',
					'label' => $this->msg( 'dmcarequest-request-type-label' )->escaped(),
					'options' => $this->getTypeOptions(),
					'value' => Sanitizer::encodeAttribute( $request->getInt( 'type' ) ),
				],
				[
					'type' => 'text',
					'name' => 'fullname',
					'isRequired' => true,
					'attributes' => [ 'required' => 'required' ],
					'label' => $this->msg( 'dmcarequest-request-name-label' )->escaped(),
					'value' => Sanitizer::encodeAttribute( $request->getVal( 'fullname' ) ),
					'isInvalid' => $this->errorParam === 'fullname',
					'errorMsg' => $this->error,
				],
				[
					'type' => 'textarea',
					'name' => 'address',
					'isRequired' => true,
					'attributes' => [ 'required' => 'required' ],
					'label' => $this->msg( 'dmcarequest-request-address-label' )->escaped(),
					'value' => htmlspecialchars( $request->getVal( 'address' ), ENT_QUOTES ),
					'isInvalid' => $this->errorParam === 'address',
					'errorMsg' => $this->error,
				],
				[
					'type' => 'text',
					'name' => 'telephone',
					'isRequired' => true,
					'attributes' => [ 'required' => 'required' ],
					'label' => $this->msg( 'dmcarequest-request-telephone-label' )->escaped(),
					'value' => Sanitizer::encodeAttribute( $request->getVal( 'telephone' ) ),
					'isInvalid' => $this->errorParam === 'telephone',
					'errorMsg' => $this->error,
				],
				[
					'type' => 'email',
					'name' => 'email',
					'isRequired' => true,
					'attributes' => [ 'required' => 'required' ],
					'label' => $this->msg( 'dmcarequest-request-email-label' )->escaped(),
					'value' => Sanitizer::encodeAttribute( $request->getVal( 'email' ) ),
					'isInvalid' => $this->errorParam === 'email',
					'errorMsg' => $this->error,
				],
				[
					'type' => 'textarea',
					'name' => 'original_urls',
					'isRequired' => true,
					'attributes' => [ 'required' => 'required' ],
					'label' => $this->msg( 'dmcarequest-request-links-original-label' )->escaped(),
					'value' => htmlspecialchars( $request->getVal( 'original_urls' ), ENT_QUOTES ),
					'isInvalid' => $this->errorParam === 'original_urls',
					'errorMsg' => $this->error,
				],
				[
					'type' => 'custom',
					'output' => Xml::label( $this->msg( 'dmcarequest-request-upload-label' )->text(), 'dmca-screenshots' ) .
						Xml::element( 'input', [
							'id' => 'dmca-screenshots',
							'name' => 'screenshots[]',
							'type' => 'file',
							'accept' => 'image/*',
							'multiple' => 'multiple',
						] ),
				],
				[
					'type' => 'textarea',
					'name' => 'infringing_urls',
					'isRequired' => true,
					'attributes' => [ 'required' => 'required' ],
					'label' => $this->msg( 'dmcarequest-request-links-wikia-label' )->escaped(),
					'value' => htmlspecialchars( $request->getVal( 'infringing_urls' ), ENT_QUOTES ),
					'isInvalid' => $this->errorParam === 'infringing_urls',
					'errorMsg' => $this->error,
				],
				[
					'type' => 'textarea',
					'name' => 'comments',
					'label' => $this->msg( 'dmcarequest-request-comments-label' )->escaped(),
					'value' => htmlspecialchars( $request->getVal( 'comments' ), ENT_QUOTES ),
				],
				[
					'type' => 'checkbox',
					'name' => 'goodfaith',
					'isRequired' => true,
					'attributes' => [ 'required' => 'required' ],
					'label' => $this->msg( 'dmcarequest-request-good-faith-label' )->escaped(),
				],
				[
					'type' => 'checkbox',
					'name' => 'perjury',
					'isRequired' => true,
					'attributes' => [ 'required' => 'required' ],
					'label' => $this->msg( 'dmcarequest-request-perjury-label' )->escaped(),
				],
				[
					'type' => 'checkbox',
					'name' => 'wikiarights',
					'isRequired' => true,
					'attributes' => [ 'required' => 'required' ],
					'label' => $this->msg( 'dmcarequest-request-wikiarights-label' )->escaped(),
				],
				[
					'type' => 'text',
					'name' => 'signature',
					'isRequired' => true,
					'attributes' => [ 'required' => 'required' ],
					'label' => $this->msg( 'dmcarequest-request-signature-label' )->escaped(),
					'value' => Sanitizer::encodeAttribute( $request->getVal( 'signature' ) ),
					'isInvalid' => $this->errorParam === 'signature',
					'errorMsg' => $this->error,
				],
				[
					'type' => 'custom',
					'output' => $this->msg( 'dmcarequest-request-outro' )->parseAsBlock(),
				],
				[
					'type' => 'hidden',
					'name' => 'token',
					'value' => Sanitizer::encodeAttribute( $this->getUser()->getEditToken() ),
				],
				[
					'type' => 'submit',
					'value' => $this->msg( 'dmcarequest-request-send-label' )->escaped(),
				],
			],
			'method' => 'POST',
			'action' => $this->getTitle()->getLocalUrl(),
		] ] );
	}

	/**
	 * Get the select options for the types.
	 *
	 * @return array
	 */
	private function getTypeOptions() {
		$options = [];
		$requestorTypes = $this->helper->getRequestorTypes();

		foreach ( $requestorTypes as $type => $typeName ) {
			$options[] = [
				'value' => $type,
				// Messages used here:
				// * dmcarequest-request-type-copyrightholder
				// * dmcarequest-request-type-representative
				// * dmcarequest-request-type-none
				'content' => $this->msg( "dmcarequest-request-type-$typeName" )->escaped(),
			];
		}
		return $options;
	}
}

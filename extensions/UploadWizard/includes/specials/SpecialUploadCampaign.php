<?php

/**
 * Special:UploadCampaign
 *
 * Configuration interface for an upload wizard campaign.
 *
 * @file
 * @ingroup SpecialPage
 * @ingroup Upload
 *
 * @since 1.2
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SpecialUploadCampaign extends FormSpecialPage {

	protected $subPage;

	/**
	 * Constructor.
	 *
	 * @param $request is the request (usually wgRequest)
	 * @param $par is everything in the URL after Special:UploadCampaign. Not sure what we can use it for
	 */
	public function __construct( $request = null, $par = null ) {
		parent::__construct ( 'UploadCampaign', 'upwizcampaigns', false );
	}

	/**
	 * (non-PHPdoc)
	 * @see SpecialPage::getDescription()
	 */
	public function getDescription() {
		return wfMsg( 'mwe-upwiz-' . strtolower( $this->getName() ) );
	}

	/**
	 * (non-PHPdoc)
	 * @see FormSpecialPage::setParameter()
	 */
	protected function setParameter( $par ){
		$this->subPage = $par;
	}

	/**
	 * (non-PHPdoc)
	 * @see FormSpecialPage::getForm()
	 */
	protected function getForm() {
		$form = parent::getForm();
		$form->addButton(
			'cancelEdit',
			wfMsg( 'cancel' ),
			'cancelEdit',
			array(
				'onclick' => 'window.location="' . SpecialPage::getTitleFor( 'UploadCampaigns' )->getFullURL() . '";return false;'
			)
		);

		return $form;
	}

	/**
	 * (non-PHPdoc)
	 * @see FormSpecialPage::getFormFields()
	 */
	protected function getFormFields() {
		$campaign = UploadWizardCampaign::newFromName( $this->subPage );

		$id = $campaign ? $campaign->getId() : null;
		$enabled = $campaign ? $campaign->getIsEnabled() : false;
		$configFields = $campaign ? $campaign->getAllConfig() : UploadWizardCampaign::getDefaultConfig();

		$fields = array();

		$fields['Campaignid'] = array ( 'type' => 'hidden', 'default' => $id );
		$fields['Campaignname'] = array ( 'type' => 'text', 'default' => $this->subPage, 'label-message' => 'mwe-upwiz-campaign-name' );
		$fields['Campaignenabled'] = array ( 'type' => 'check', 'default' => $enabled, 'label-message' => 'mwe-upwiz-campaign-enabled' );

		foreach ( $configFields as $name => $data ) {
			$data['label-message'] = 'mwe-upwiz-campaign-conf-' . $name;

			// Special handling for lists of values per input type.
			if ( is_array( $data['default'] ) ) {
				switch ( $data['type'] ) {
					case 'text': case 'textarea':
						$data['default'] = implode( '|', $data['default'] );
						break;
				}
			}

			$fields[$name] = $data;
		}

		return $fields;
	}

	/**
	 * Process the form.  At this point we know that the user passes all the criteria in
	 * userCanExecute(), and if the data array contains 'Username', etc, then Username
	 * resets are allowed.
	 * @param $data array
	 * @return Bool|Array
	 */
	public function onSubmit( array $data ) {
		$id = $data['Campaignid'] == '' ? null : $data['Campaignid'];
		unset( $data['Campaignid'] );

		$name = $data['Campaignname'];
		unset( $data['Campaignname'] );

		$enabled = $data['Campaignenabled'];
		unset( $data['Campaignenabled'] );

		if ( is_null( $id ) ) {
			$existingCampaign = UploadWizardCampaign::newFromName( $name, false );
			$id = $existingCampaign === false ? null : $existingCampaign->getId();
		}
		
		$campaign = new UploadWizardCampaign( $id, $name, $enabled, $data );

		$success = $campaign->writeToDB();

		if ( $success ) {
			return true;
		}
		else {
			return array(); // TODO
		}
	}

	public function onSuccess() {
		$this->getOutput()->redirect( SpecialPage::getTitleFor( 'UploadCampaigns' )->getLocalURL( array( 'refresh' => '1' ) ) );
	}

}

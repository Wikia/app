<?php

/**
 * Special:UploadCampaigns
 *
 * Lists the upload campaigns.
 *
 * @file
 * @ingroup SpecialPage
 * @ingroup Upload
 *
 * @since 1.2
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SpecialUploadCampaigns extends SpecialPage {

	/**
	 * Constructor.
	 *
	 * @param $request is the request (usually wgRequest)
	 * @param $par is everything in the URL after Special:UploadCampaigns. Not sure what we can use it for
	 */
	public function __construct( $request = null, $par = null ) {
		parent::__construct( 'UploadCampaigns', 'upwizcampaigns' );
	}

	/**
	 * (non-PHPdoc)
	 * @see SpecialPage::getDescription()
	 */
	public function getDescription() {
		return wfMsg( 'mwe-upwiz-' . strtolower( $this->getName() ) );
	}

	/**
	 * Main method.
	 *
	 * @param string $subPage, e.g. the "foo" in Special:UploadCampaigns/foo.
	 */
	public function execute( $subPage ) {
		global $wgRequest, $wgUser;

		$this->setHeaders();
		$this->outputHeader();

		// If the user is authorized, display the page, if not, show an error.
		if ( $this->userCanExecute( $wgUser ) ) {
			if ( $wgRequest->wasPosted()
				&& $wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) )
				&& $wgRequest->getCheck( 'newcampaign' ) ) {
					$this->getOutput()->redirect( SpecialPage::getTitleFor( 'UploadCampaign', $wgRequest->getVal( 'newcampaign' ) )->getLocalURL() );
			}
			else {
				$this->displayUploadCamaigns();
			}
		} else {
			$this->displayRestrictionError();
		}
	}

	/**
	 * Displays the pages regular output.
	 *
	 * @since 1.2
	 */
	protected function displayUploadCamaigns() {
		$this->displayAddNewControl();

		// If the refresh flag is set, fetch from the master.
		// This is to ensure changes show up right away for the person that makes then
		// instead of getting hidden due to replag on installs with multiple db servers.
		$db = wfGetDB( $this->getRequest()->getCheck( 'refresh' ) ? DB_MASTER : DB_SLAVE );

		$campaigns = $db->select(
			'uw_campaigns',
			array(
				'campaign_id',
				'campaign_name',
				'campaign_enabled',
			),
			'',
			__METHOD__
		);

		if ( $campaigns->numRows() > 0 ) {
			$this->displayCampaignTable( $campaigns );
		}
	}

	/**
	 * Displays a small form to add a new campaign.
	 *
	 * @since 1.2
	 */
	protected function displayAddNewControl() {
		$out = $this->getOutput();

		$out->addHTML( Html::openElement(
			'form',
			array(
				'method' => 'post',
				'action' => $this->getTitle()->getLocalURL(),
			)
		) );

		$out->addHTML( '<fieldset>' );

		$out->addHTML( '<legend>' . htmlspecialchars( wfMsg( 'mwe-upwiz-campaigns-addnew' ) ) . '</legend>' );

		$out->addHTML( Html::element( 'p', array(), wfMsg( 'mwe-upwiz-campaigns-namedoc' ) ) );

		$out->addHTML( Html::element( 'label', array( 'for' => 'newcampaign' ), wfMsg( 'mwe-upwiz-campaigns-newname' ) ) );

		$out->addHTML( '&#160;' . Html::input( 'newcampaign' ) . '&#160;' );

		$out->addHTML( Html::input(
			'addnewcampaign',
			wfMsg( 'mwe-upwiz-campaigns-add' ),
			'submit'
		) );

		global $wgUser;
		$out->addHTML( Html::hidden( 'wpEditToken', $wgUser->editToken() ) );

		$out->addHTML( '</fieldset></form>' );
	}

	/**
	 * Displays a list of all campaigns.
	 *
	 * @since 1.2
	 *
	 * @param ResultWrapper $campaigns
	 */
	protected function displayCampaignTable( ResultWrapper $campaigns ) {
		$out = $this->getOutput();

		$out->addHTML( Html::element( 'h2', array(), wfMsg( 'mwe-upwiz-campaigns-existing' ) ) );

		$out->addHTML( Xml::openElement(
			'table',
			array( 'class' => 'wikitable sortable', 'style' => 'width:400px' )
		) );

		$out->addHTML(
			'<thead><tr>' .
				Html::element( 'th', array(), wfMsg( 'mwe-upwiz-campaigns-name' ) ) .
				Html::element( 'th', array(), wfMsg( 'mwe-upwiz-campaigns-status' ) ) .
				Html::element( 'th', array( 'class' => 'unsortable' ), wfMsg( 'mwe-upwiz-campaigns-edit' ) ) .
				Html::element( 'th', array( 'class' => 'unsortable' ), wfMsg( 'mwe-upwiz-campaigns-delete' ) ) .
			'</tr></thead>'
		);

		$out->addHTML( '<tbody>' );
		
		global $wgUser;
		
		foreach ( $campaigns as $campaign ) {
			$out->addHTML(
				'<tr>' .
					'<td>' .
						Html::element(
							'a',
							array(
								'href' => SpecialPage::getTitleFor( 'UploadWizard' )->getLocalURL( array( 'campaign' => $campaign->campaign_name ) )
							),
							$campaign->campaign_name
						) .
					'</td>' .
					Html::element( 'td', array(), wfMsg( 'mwe-upwiz-campaigns-' . ( $campaign->campaign_enabled ? 'enabled' : 'disabled' ) ) ) .
					'<td>' .
						Html::element(
							'a',
							array(
								'href' => SpecialPage::getTitleFor( 'UploadCampaign', $campaign->campaign_name )->getLocalURL()
							),
							wfMsg( 'mwe-upwiz-campaigns-edit' )
						) .
					'</td>' .
					'<td>' .
						Html::element(
							'a',
							array(
								'href' => '#',
								'class' => 'campaign-delete',
								'data-campaign-id' => $campaign->campaign_id,
								'data-campaign-token' => $wgUser->editToken( 'deletecampaign' . $campaign->campaign_id )
							),
							wfMsg( 'mwe-upwiz-campaigns-delete' )
						) .
					'</td>' .
				'</tr>'
			);
		}

		$out->addHTML( '</tbody>' );
		$out->addHTML( '</table>' );
		
		$out->addModules( 'ext.uploadWizard.campaigns' );
	}

}

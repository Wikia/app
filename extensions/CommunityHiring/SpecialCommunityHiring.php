<?php

class SpecialCommunityHiring extends SpecialPage {
	function __construct() {
		parent::__construct( 'CommunityHiring' );
	}
	
	function execute( $par ) {
		global $wgOut;
		
		$wgOut->setPageTitle( wfMsg( 'communityhiring-header' ) );
		
		$formDescriptor = array(
			'about-intro' => array(
				'type' => 'info',
				'default' => wfMsgExt( 'communityhiring-about-intro', 'parse' ),
				'raw' => 1,
				'section' => 'aboutyou',
			),
			'given-name' => array(
				'type' => 'text',
				'label-message' => 'communityhiring-given',
				'section' => 'aboutyou',
				'validation-callback' => array( $this, 'validateRequired' ),
			),
			'family-name' => array(
				'type' => 'text',
				'label-message' => 'communityhiring-family',
				'section' => 'aboutyou',
				'validation-callback' => array( $this, 'validateRequired' ),
			),
			'address-line1' => array(
				'type' => 'textarea',
				'label-message' => 'communityhiring-address',
				'section' => 'aboutyou',
				'rows' => '3',
				'cols' => '20',
			),
			'address-city' => array(
				'type' => 'text',
				'label-message' => 'communityhiring-address-city',
				'section' => 'aboutyou',
				'validation-callback' => array( $this, 'validateRequired' ),
			),
			'address-postal' => array(
				'type' => 'text',
				'label-message' => 'communityhiring-address-postal',
				'section' => 'aboutyou',
			),
			'address-country' => array(
				'type' => 'text',
				'label-message' => 'communityhiring-address-country',
				'section' => 'aboutyou',
				'validation-callback' => array( $this, 'validateRequired' ),
			),
			'phone' => array(
				'type' => 'text',
				'label-message' => 'communityhiring-phone',
				'section' => 'aboutyou',
			),
			'email' => array(
				'type' => 'text',
				'label-message' => 'communityhiring-email',
				'section' => 'aboutyou',
				'validation-callback' => array( $this, 'validateRequired' ),
			),
			
			// Pararaph answers
			'paragraph-intro' => array(
				'type' => 'info',
				'default' => wfMsgExt( 'communityhiring-paragraphs-intro', 'parse' ),
				'raw' => 1,
				'section' => 'paragraphs',
				'vertical-label' => 1,
				'validation-callback' => array( $this, 'validateRequired' ),
			),
			'significance' => array(
				'type' => 'textarea',
				'label-message' => 'communityhiring-significance',
				'section' => 'paragraphs',
				'rows' => 10,
				'vertical-label' => 1,
				'validation-callback' => array( $this, 'validateRequired' ),
			),
			'excitement' => array(
				'type' => 'textarea',
				'label-message' => 'communityhiring-excitement',
				'section' => 'paragraphs',
				'rows' => 10,
				'vertical-label' => 1,
				'validation-callback' => array( $this, 'validateRequired' ),
			),
			'experiences' => array(
				'type' => 'textarea',
				'label-message' => 'communityhiring-experiences',
				'section' => 'paragraphs',
				'rows' => 10,
				'vertical-label' => 1,
				'validation-callback' => array( $this, 'validateRequired' ),
			),
			'other' => array(
				'type' => 'textarea',
				'label-message' => 'communityhiring-other',
				'section' => 'paragraphs',
				'rows' => 10,
				'vertical-label' => 1,
			),
			
			// Demonstrative info
			'languages' => array(
				'type' => 'textarea',
				'options' => array_flip( Language::getLanguageNames() ),
				'section' => 'demonstrative/languages',
				'rows' => '3',
				'label-message' => 'communityhiring-languages-label',
				'vertical-label' => 1,
				'validation-callback' => array( $this, 'validateRequired' ),
			),
			
			'contributor' => array(
				'type' => 'radio',
				'label-message' => 'communityhiring-contributor',
				'section' => 'demonstrative/involvement',
				'options' => array(
					'Yes' => 'yes',
					'No' => 'no',
				),
			),
			'usernames' => array(
				'type' => 'textarea',
				'rows' => '3',
				'cols' => '20',
				'label-message' => 'communityhiring-usernames',
				'section' => 'demonstrative/involvement',
				'vertical-label' => 1,
			),
			'wikimedia-links' => array(
				'type' => 'textarea',
				'label-message' => 'communityhiring-links',
				'section' => 'demonstrative/involvement',
				'rows' => '3',
				'cols' => '20',
				'vertical-label' => 1,
			),
			'other-links' => array(
				'type' => 'textarea',
				'label-message' => 'communityhiring-links-other',
				'section' => 'demonstrative',
				'rows' => '3',
				'cols' => '20',
				'vertical-label' => 1,
			),
			
			// Availability
			'availability-time' => array(
				'type' => 'text',
				'label-message' => 'communityhiring-availability-intro',
				'section' => 'availability',
				'vertical-label' => 1,
				'validation-callback' => array( $this, 'validateRequired' ),
			),
			'availability-info' => array(
				'type' => 'textarea',
				'label-message' => 'communityhiring-availability-info',
				'section' => 'availability',
				'rows' => '5',
				'cols' => '20',
				'vertical-label' => 1,
			),
			'relocation' => array(
				'type' => 'radio',
				'label-message' => 'communityhiring-relocation-ok',
				'section' => 'availability',
				'vertical-label' => 1,
				'options' => array(
						'Yes' => 'yes',
						'No' => 'no',
						'It would be hard, but maybe I would' => 'maybe'
						),
			),
			
			// Quick research question
			'research' => array(
				'type' => 'textarea',
				'rows' => '5',
				'label-message' => 'communityhiring-research',
				'vertical-label' => 1,
				'validation-callback' => array( $this, 'validateRequired' ),
			),
		);
		
		$form = new HTMLForm( $formDescriptor, 'communityhiring' );
		
		$form->setIntro( wfMsgExt( 'communityhiring-intro', 'parse' ) );
		$form->setSubmitCallback( array( $this, 'submit' ) );
		$form->setTitle( $this->getTitle() );
		
		$form->show();
	}
	
	function submit( $info ) {
		global $wgOut, $wgCommunityHiringDatabase;
		
		$dbw = wfGetDB( DB_MASTER, array(), $wgCommunityHiringDatabase );
		
		$dbw->insert( 'community_hiring_application',
				array( 'ch_data' => json_encode($info),
					'ch_ip' => wfGetIP(),
					'ch_timestamp' => wfTimestampNow(TS_DB) ),
				__METHOD__ );
				
		$wgOut->addWikiMsg( 'communityhiring-done' );
		
		return true;
	}
	
	function validateRequired( $input ) {
		if (!$input) {
			return wfMsgExt( 'communityhiring-field-required', 'parseinline' );
		}
		
		return true;
	}
}

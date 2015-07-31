<?php
/**
 * Special:AddVideo - special page for adding Videos
 *
 * @ingroup extensions
 * @file
 */

class AddVideo extends SpecialPage {

	/**
	 * New video object created when the title field is validated
	 *
	 * @var Video
	 */
	protected $video;

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'AddVideo' /*class*/, 'addvideo' /*restriction*/);
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 * @return bool|null
	 */
	public function execute( $par ) {
		global $wgExtensionAssetsPath;

		$out = $this->getOutput();
		// Add CSS
		if ( defined( 'MW_SUPPORTS_RESOURCE_MODULES' ) ) {
			$out->addModuleStyles( 'ext.video' );
		} else {
			$out->addExtensionStyle( $wgExtensionAssetsPath . '/Video/Video.css' );
		}

		// If the user doesn't have the required 'addvideo' permission, display an error
		if( !$this->userCanExecute( $this->getUser() ) ) {
			$this->displayRestrictionError();
			return;
		}

		// Show a message if the database is in read-only mode
		if ( wfReadOnly() ) {
			throw new ReadOnlyError;
		}

		// If user is blocked, s/he doesn't need to access this page
		if( $this->getUser()->isBlocked() ) {
			throw new UserBlockedError( $this->getUser()->mBlock );
		}

		$this->setHeaders();

		$form = new HTMLForm( $this->getFormFields(), $this->getContext() );
		$form->setIntro( wfMsgExt( 'video-addvideo-instructions', 'parse' ) );
		$form->setWrapperLegend( wfMsg( 'video-addvideo-title' ) );
		$form->setSubmitText( wfMsg( 'video-addvideo-button' ) );
		$form->setSubmitCallback( array( $this, 'submit' ) );

		if ( $this->getRequest()->getCheck( 'forReUpload' ) ) {
			$form->addHiddenField( 'forReUpload', true );
		}

		$form->show();
	}

	/**
	 * Extracts the URL and provider type from a raw string
	 *
	 * @param string $value Value form the Video input
	 * @return array Element 0 is the URL, 1 is the provider
	 */
	protected function getUrlAndProvider( $value ) {
		$url = $value;
		if ( !Video::isURL( $url ) ) {
			$url = Video::getURLfromEmbedCode( $value );
		}

		return array( $url, Video::getProviderByURL( $url ) );
	}

	/**
	 * Custom validator for the Video field
	 *
	 * Checks to see if the string given is a valid URL and corresponds
	 * to a supported provider.
	 *
	 * @param $value Array
	 * @param $allData Array
	 * @return bool|String
	 */
	public function validateVideoField( $value, $allData ) {
		list( , $provider ) = $this->getUrlAndProvider( $value );

		if ( $provider == 'unknown' ) {
			return wfMsg( 'video-addvideo-invalidcode' );
		}

		return true;
	}

	/**
	 * Custom validator for the Title field
	 *
	 * Just checks that it's a valid title name and that it doesn't already
	 * exist (unless it's an overwrite)
	 *
	 * @param $value Array
	 * @param $allData Array
	 * @return bool|String
	 */
	public function validateTitleField( $value, $allData ) {
		$video = Video::newFromName( $value, $this->getContext() );

		if ( $video === null || !( $video instanceof Video ) ) {
			return wfMsg( 'badtitle' );
		}

		// TODO: Check to see if this is a new version
		if ( $video->exists() && !$this->getRequest()->getCheck( 'forReUpload' ) ) {
			return wfMsgHtml( 'video-addvideo-exists' );
		}

		$this->video = $video;

		return true;
	}

	/**
	 * Actually inserts the Video into the DB if validation passes
	 *
	 * @param $data Array
	 * @return bool
	 */
	public function submit( array $data ) {
		list( $url, $provider ) = $this->getUrlAndProvider( $data['Video'] );

		$this->video->addVideo( $url, $provider, false, $data['Watch'] );

		$this->getOutput()->redirect( $this->video->getTitle()->getFullURL() );

		return true;
	}

	/**
	 * Fields for HTMLForm
	 *
	 * @return array
	 */
	protected function getFormFields() {
		$fields = array(
			'Title' => array(
				'type' => 'text',
				'label-message' => 'video-addvideo-title-label',
				'size' => '30',
				'required' => true,
				'validation-callback' => array( $this, 'validateTitleField' ),
			),
			'Video' => array(
				'type' => 'textarea',
				'label-message' => 'video-addvideo-embed-label',
				'rows' => '5',
				'cols' => '65',
				'required' => true,
				'validation-callback' => array( $this, 'validateVideoField' ),
			),
			'Watch' => array(
				'type' => 'check',
				'label-message' => 'watchthisupload',
				'default' => $this->getUser()->getGlobalPreference( 'watchdefault' ),
			),
		);

		return $fields;
	}
}
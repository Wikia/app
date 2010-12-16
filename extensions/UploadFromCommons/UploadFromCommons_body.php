<?php
class UploadFromCommons extends UploadFromUrl {
	/**
	 * Hook to UploadCreateOnRequest.
	 * 
	 * This class processes wpSourceType=Commons
	 */
	public static function onCreateFromRequest( $type, &$className ) {
		if ( $type == 'Commons' ) {
			$className = 'UploadFromCommons';
			// Stop processing
			return false;
		}
		return true;
	}
	
	public static function isEnabled() { return true; }
	/**
	 * A valid request requires wpUploadCommonsName to be set
	 */
	public static function isValidRequest( $request ) {
		if ( !$request->getVal( 'wpUploadCommonsName' ) )
			return false;
		$title = Title::newFromText( $request->getVal( 'wpUploadCommonsName' ), NS_FILE );
		return !is_null( $title );
	}
	
	public function initializeFromRequest( &$request ) {
		$name = $request->getText( 'wpUploadCommonsName' );
		$title = Title::newFromText( $name, NS_FILE );
		$md5 = md5( $title->getDbKey() );
		$url = 'http://upload.wikimedia.org/wikipedia/commons/' . 
			$md5{0} . '/' . $md5{0} . $md5{1} . '/' .
			$title->getDbKey();
		
		$desiredDestName = $request->getText( 'wpDestFile' );
		if( !$desiredDestName )
			$desiredDestName = $name;
		
		
			
		return $this->initialize(
			$desiredDestName,
	 		$url,
			false
		);
	}
	
	/**
	 * UI hook to add an extra text box to the upload form
	 */
	public static function onUploadFormSourceDescriptors( &$descriptor, &$radio, $selectedSourceType ) {
		$descriptor['UploadCommonsName'] = array(
			'class' => 'UploadSourceField',
			'section' => 'source',
			'id' => 'wpUploadCommonsName',
			'label-message' => 'uploadfromcommons-source',
			'upload-type' => 'Commons',
			'radio' => &$radio,
			'checked' => $selectedSourceType == 'commons',
		);
		$radio = true;
		return true;
	}
}

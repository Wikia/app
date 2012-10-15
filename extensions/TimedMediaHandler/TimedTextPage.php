<?php 
/** 
 * TimedText page display the current video with subtitles to the right.
 * 
 * Future features for this page"
 *  @todo add srt download links
 *  @todo parse and validate srt files
 *  @todo link-in or include the universal subtitles editor 
 */
class TimedTextPage extends Article {
	
	// The width of the video plane:
	static private $videoWidth = 400;
	 
	public function view() {
		global $wgOut, $wgShowEXIF, $wgRequest, $wgUser;
		
		$diff = $wgRequest->getVal( 'diff' );
		$diffOnly = $wgRequest->getBool( 'diffonly', $wgUser->getOption( 'diffonly' ) );

		if ( $this->mTitle->getNamespace() != NS_TIMEDTEXT || ( isset( $diff ) && $diffOnly ) ) {
			return parent::view();
		}
		$titleParts = explode( '.', $this->mTitle->getDBKey() );
		$srt = array_pop( $titleParts );
		$lanugaeKey = array_pop( $titleParts );
		$videoTitle = Title::newFromText( implode('.', $titleParts ), NS_FILE );
		
		// Look up the language name: 	
		$languages = Language::getTranslatedLanguageNames( 'en' );
		if( isset( $languages[ $lanugaeKey ] ) ) {
			$languageName = $languages[ $lanugaeKey ];
		} else {
			$languageName = $lanugaeKey;
		}
		
		// Set title 
		$wgOut->setPageTitle( wfMsg('mwe-timedtext-language-subtitles-for-clip', $languageName,  $videoTitle) );

		// Get the video with with a max of 600 pixel page
		$wgOut->addHTML( 
			xml::tags( 'table', array( 'style'=> 'border:none' ), 
				xml::tags( 'tr', null, 
					xml::tags( 'td', array( 'valign' => 'top',  'width' => self::$videoWidth ), $this->getVideoHTML( $videoTitle ) ) .
					xml::tags( 'td', array( 'valign' => 'top' ) , $this->getSrtHTML( $languageName ) )
				)
			)
		);	
	}
	/**
	 * Gets the video HTML ( with the current language set as default )
	 * @param unknown_type $videoTitle
	 */
	private function getVideoHTML( $videoTitle ){
		// Get the video embed:
		$file = wfFindFile( $videoTitle );
		if( !$file ){
			return wfMsg( 'timedmedia-subtitle-no-video' );
		} else {
			$videoTransform= $file->transform( 
				array(
					'width' => self::$videoWidth
				) 
			);
			return $videoTransform->toHTML();
		}
	}
	/**
	 * Gets the srt text 
	 * 
	 * XXX We should add srt parsing and links to seek to that time in the video  
	 */
	private function getSrtHTML( $languageName ){
		if( !$this->exists() ){
			return wfMessage( 'timedmedia-subtitle-no-subtitles',  $languageName );
		}
		return '<pre style="margin-top:0px;">'. $this->getContent() . '</pre>';
	}
}

<?php

/**
* Checks to see if Reflect should be deployed on the to-be-rendered page. 
* If so, it adds the appropriate JS and CSS to the output. 
*/		
class ReflectDispatch {

	/**
	* Adds Reflect CSS & JS to the output
	* 
	* @param $output 
	* 
	* @return Returns true
	*/			
	static private function reflectAddJSandCSS( &$output ) {

		global $wgScriptPath, $wgReflectExtensionName, $wgReflectStudy;

		$basePath = "$wgScriptPath/extensions/$wgReflectExtensionName/client";

		$output->addExtensionStyle( "$basePath/css/reflect.css" );
		$output->addExtensionStyle( "$basePath/css/reflect.liquidthreads.css" );
		$output->addExtensionStyle( "$basePath/css/reflect.study.css" );
		$output->addScriptFile( "$basePath/js/third_party/inheritance.js" );
		$output->addScriptFile( "$basePath/js/third_party/jquery.color.js" );
		$output->addScriptFile( "$basePath/js/third_party/jquery.highlight.js" );
		$output->addScriptFile( "$basePath/js/third_party/jquery.noblecount.min.js" );
		$output->addScriptFile( "$basePath/js/third_party/jquery.pulse.js" );
		$output->addScriptFile( "$basePath/js/third_party/jquery.jqote2.min.js" );

		$output->addScriptFile( "$basePath/js/third_party/json2.js" );
		$output->addScriptFile( "$basePath/js/reflect.js" );
		if ( $wgReflectStudy )
			$output->addScriptFile( "$basePath/js/reflect.study.js" );
		$output->addScriptFile( "$basePath/js/reflect.liquidthreads.js" );
		return true;
	}

	/**
	* View for altering a Reflect-ed talkpage. Currently only need to add CSS / JS. 
	* 
	* @param $output
	* 
	* @return true if successfully alter page
	*/			
	static private function talkpageMain( &$output ) {
		// We are given a talkpage article and title. Just insert the Reflect client side magic.
		return self::reflectAddJSandCSS( $output );
	}


	/**
	* Checks whether the current page should be Reflected. First, only LQT pages
	* can be Reflected. Second, either Reflect must be enabled for all pages, or 
	* the current page must belong to a subset of pages Reflect is enabled on. 
	* 
	* @param $title Title of current page. 
	* 
	* @return Returns whether the current page should have Reflect added.
	*/			
	static private function isReflectPage( $title ) {
		global $wgReflectPages, $wgReflectTalkPages;

		$isReflectPage = LqtDispatch::isLqtPage( $title ) &&
							  ( $wgReflectTalkPages  ||
								in_array( $title->getPrefixedText(), $wgReflectPages ) );
		return $isReflectPage;
	}


	/**
	* If the current page is a Reflect page of any kind, process it
	* as needed. This is the main dispatcher method.
	* 
	* @param $output
	* 
	* @return Whether processing is successful. 
	*/		
	static function tryPage( $output ) {
		$title = $output->getTitle();
		if ( ReflectDispatch::isReflectPage( $title ) )
			return self::talkpageMain( $output );
		return true;
	}

}

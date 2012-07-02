<?php

class SemanticFormsToolbar {
	
	/**
	 * Get the HTML to display a form.
	 * @param $form Mixed: Title object of the form to use, or a string form definition.
	 * @param $data Array: Associative array as would be POSTed to the form, to prefill
	 * @param $existing_wikitext String: The wikitext to preload the form with.
	 * @return HTML form output
	 */
	public static function getFormHTML( $form, $data = array(), $existing_wikitext = '' ) {
	
		$printer = new SFFormPrinter;
		
		if ( $form instanceof Title ) {
			$article = new Article( $form );
			$form = $article->getContent();
		}
		
		global $wgRequest;
		
		if ( count($data) ) {
			// Process into arrays and what not
			$data = self::convertFlatToArray( $data );
			
			$oldRequest = $wgRequest;
			$wgRequest = new FauxRequest( $data );
		}
		
		$output = $printer->formHTML( $form, count($data) > 0,
			strlen($existing_wikitext)>0, null, $existing_wikitext );
		list( $form_text, $javascript_text, $data_text, $form_page_title,
			$generated_page_name ) = $output;

		if ( count($data) ) {			
			$wgRequest = $oldRequest;
		}
			
		return $form_text;
	}
	
	/**
	 * Get the wikitext output from a form.
	 * @param $form Mixed: Title object of the form to use, or a String form definition.
	 * @param $data Array: Associative array as would be POSTed to the form.
	 * @return Wikitext
	 */
	public static function getWikitext( $form, $data = array() ) {
	
		$printer = new SFFormPrinter;
		
		if ( $form instanceof Title ) {
			$article = new Article( $form );
			$form = $article->getContent();
		}
		
		global $wgRequest;
		
		// Process into arrays and what not
		$data = self::convertFlatToArray( $data );
		
		$oldRequest = $wgRequest;
		$wgRequest = new FauxRequest( $data );
		
		$output = $printer->formHTML( $form, count($data) > 0, false );
		list( $form_text, $javascript_text, $data_text, $form_page_title,
			$generated_page_name ) = $output;
		
		$wgRequest = $oldRequest;
			
		return $data_text;
	}
	
	/**
	 * Converts a flat array which implements arrays using square brackets to a
	 * proper array.
	 * @param $data Array: Input array, with sub-items declared with square brackets in keys.
	 * @return Array: Output array, with sub-items declared with sub-arrays.
	 */
	protected static function convertFlatToArray( $data ) {
		$didReplace = true;
		
		while ( $didReplace ) {
			$didReplace = false;
			$output = array();
			foreach( $data as $key => $value ) {
				if ( $key[strlen($key)-1] == ']' && strpos( $key, '[' ) >= 0 ) {
					$start = strrpos($key, '[');
					$subkey = substr( $key, $start + 1, -1 );
					$newkey = substr( $key, 0, $start );
					
					if ( isset( $output[$newkey] ) ) {
						$output[$newkey][$subkey] = $value;
					} else {
						$output[$newkey] = array( $subkey => $value );
					}
					$didReplace = true;
				} else {
					$output[$key] = $value;
				}
			}
			
			$data = $output;
		}
		
		return $data;
	}
}

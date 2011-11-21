<?php
/**
 * WikiaMobile Hooks handlers
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class WikiaMobileHooks extends WikiaObject{
	public function onOutputPageParserOutput( &$out, $parserOutput ){
		//cleanup page output from unwanted stuff
		if ( get_class( $this->wg->User->getSkin() ) == 'SkinWikiaMobile' ) {
			$text = $parserOutput->getText();
			
			//remove inline styling
			$text = reg_replace('/style=(\'|")[^"\']*(\'|")/im', '', $text);
			
			//remove image sizes
			//$text = reg_replace('/(width|height)=(\'|")[^"\']*(\'|")/im', '', $text);
			
			$parserOutput->setText( $text );
		}
		
		return true;
	}
}
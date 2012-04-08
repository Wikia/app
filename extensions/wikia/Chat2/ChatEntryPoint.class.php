<?php
/**
 * @author Jacek "mech" Wozniak <mech@wikia-inc.com>
 *
 * ChatEntryPoint object implementation
 */
class ChatEntryPoint {
	
	/**
	 * @brief This function set parseTag hook
	 */
	static public function onParserFirstCallInit( &$parser ) {
		wfProfileIn( __METHOD__ );
		$parser->setHook( CHAT_TAG, array( __CLASS__, "parseTag" ) );
		wfProfileOut( __METHOD__ );
		return true;
	}
	
	/**
	 * Chat tag parser implementation
	 */
	static public function parseTag( $input, $args, $parser ) {
		wfProfileIn( __METHOD__ );

		$template = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		
		$template->set('linkToSpecialChat', SpecialPage::getTitleFor("Chat")->escapeLocalUrl());
		
		$html = $template->execute( 'entryPointTag' );
		
		wfProfileOut( __METHOD__ );
		return $html;
	}
}
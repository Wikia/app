<?php
/**
 * Class for gathering templates replacing MediaWiki core email HTML messages
 * @author: Kamil Koterba
 * @since 3 June 2013
 */

class EmailTemplatesController extends WikiaController {

	public function executeNewBlogPostMail( $params ) {
		$this->msgParams = array( 'parsemag', 'language' => $params['language'] );

		$this->language = $params['language'];
		$this->greeting = $params['greeting'];
		$this->content = $params['content'];
		$this->link123 = $params['link'];
		$this->linkTxt123 = $params['link_txt'];
	}

	public function executeBasicMail( $params ) {
		$this->msgParams = array( 'parsemag', 'language' => $params['language'] );

		$this->language = $params['language'];
		$this->content = $params['content'];
	}

}
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
		$this->content = $params['content'];
	}

	public function executePostInfo( $params ) {
		$this->msgParams = array( 'parsemag', 'language' => $params['language'] );

		$this->post_url = $params['post_url'];
		$this->post_title = $params['post_title'];
		$this->avatar_url = $params['avatar_url'];
		$this->username = $params['username'];
		$this->user_page_url = $params['user_page_url'];
		$this->date = $params['date'];
		$this->short_text = $params['short_text'];
	}

	public function executeButton( $params ) {
		$this->msgParams = array( 'parsemag', 'language' => $params['language'] );

		$this->link_url = $params['link_url'];
		$this->link_text = $params['link_text'];
	}

}
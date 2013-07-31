<?php
/**
 * Class for gathering templates replacing MediaWiki core email HTML messages
 * @author: Kamil Koterba
 * @since 3 June 2013
 */

class EmailTemplatesController extends WikiaController {

	/**
	 * Execute function for generating view of NewBlogPostMail template
	 * Sets params' values of template
	 * @param $params array of params described below
	 * @param $params['content'] string HTML code to be included in main part of template
	 */
	public function executeNewBlogPostMail( $params ) {
		$this->content = $params['content'];
	}

	/**
	 * Execute function for generating view of PostInfo template
	 * Sets params' values of template
	 * @param $params array of params described below
	 * @param $params['post_url'] string Full link to full article
	 * @param $params['post_title'] string Title of post
	 * @param $params['avatar_url'] string Full url to user avatar image
	 * @param $params['username'] string Name of post author
	 * @param $params['user_page_url'] string Full url to author page
	 * @param $params['date'] string Date of post publish
	 * @param $params['short_text'] string Shortened version of text
	 */
	public function executePostInfo( $params ) {
		wfProfileIn( __METHOD__ );

		$this->post_url = array_key_exists( 'post_url', $params ) ? $params['post_url'] : '';
		$this->post_title = array_key_exists( 'post_title', $params ) ? $params['post_title'] : '';
		$this->avatar_url = array_key_exists( 'avatar_url', $params ) ? $params['avatar_url'] : AvatarService::renderAvatar('',EmailTemplatesHooksHelper::EMAIL_AVATAR_DEFAULT_WIDTH);
		$this->username = array_key_exists( 'username', $params ) ? $params['username'] : wfMessage('oasis-anon-user')->plain();
		$this->user_page_url = array_key_exists( 'user_page_url', $params ) ? $params['user_page_url'] : '';
		$this->date = array_key_exists( 'date', $params ) ? $params['date'] : '';
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Execute function for generating view of Button template
	 * Sets params' values of template
	 * @param $params array of params described below
	 * @param $params['link_url'] string Full link to some destination (mandatory)
	 * @param $params['link_text'] string Description showed on a button
	 */
	public function executeButton( $params ) {
		wfProfileIn( __METHOD__ );

		$this->link_url = $params['link_url'];
		$this->link_text = array_key_exists( 'link_text', $params ) ? $params['link_text'] : $this->link_url;
		wfProfileOut( __METHOD__ );
	}

}

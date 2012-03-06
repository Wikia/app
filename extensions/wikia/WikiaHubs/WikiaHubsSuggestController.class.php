<?php

/**
 * WikiaHubsSuggest Controller
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Hyun Lim
 * @author Marcin Maciejewski
 * @author Saipetch Kongkatong
 * @author Sebastian Marzjan
 *
 */
class WikiaHubsSuggestController extends WikiaController {

	public function init() {
	}

	public function index() {
		$this->sendRequest('WikiaHubsSuggest', 'modalRelatedVideos');
	}

	/**
	 * render template on GET. if POSTed, add content to related video page
	 * @requestParam string videourl
	 * @requestParam string wikiname
	 * @requestParam string cancel [true/false]
	 * @responseParam string result [ok/error]
	 * @responseParam string msg - result message
	 * @responseParam string errParam - error param
	 */
	public function modalRelatedVideos() {
		if ( $this->request->getVal( 'submit', false ) && $_COOKIE['wikicitiesUserID'] == $_SESSION['wsUserID'] ) {
			$hubname = $this->request->getVal( 'hubname', '' );
			$videoUrl = trim( $this->request->getVal( 'videourl', '' ) );
			$wikiname = trim( $this->request->getVal( 'wikiname', '' ) );
			$submissiondate = date('r');

			if ( $this->request->getVal( 'cancel', false ) ) {
				return;
			} else if ( strlen($videoUrl) < 10) {
				$this->result = 'error';
				$this->errParam = 'videourl';
				$this->msg = $this->wf->msg( 'wikiahubs-error-invalid-video-url-length' );
				return;
			} else if ( empty($wikiname) ) {
				$this->result = 'error';
				$this->errParam = 'wikiname';
				$this->msg = $this->wf->msg( 'wikiahubs-error-invalid-wikiname-length' );
				return;
			}

			$title = Title::newFromText($hubname.'/Suggested_videos');
			$article  = new Article( $title );
			$username = $this->wg->user->getName();
			$content = "$videoUrl | $wikiname | $username | $submissiondate \n\n".$article->getRawText();
			$summary = "Hubs: $username suggests video";
			$status = $article->doEdit( $content, $summary );
			
			$this->result = 'ok';
			$this->msg = $this->wf->msg( 'wikiahubs-suggest-video-success' );
		}
	}

	/**
	 * render template on GET. if POSTed, add content to article page
	 * @requestParam string articleurl
	 * @requestParam string reason
	 * @requestParam string cancel [true/false]
	 * @responseParam string result [ok/error]
	 * @responseParam string msg - result message
	 * @responseParam string errParam - error param
	 */
	public function modalArticle() {
		if ( $this->request->getVal( 'submit', false ) && $_COOKIE['wikicitiesUserID'] == $_SESSION['wsUserID'] ) {
			$hubname = $this->request->getVal( 'hubname', '' );
			$articleUrl = trim( $this->request->getVal( 'articleurl', '' ) );
			$reason = trim( $this->request->getVal( 'reason', '' ) );
			$submissiondate = date('r');

			if ( $this->request->getVal( 'cancel', false ) ) {
				return;
			} else if ( strlen($articleUrl) < 10 ) {
				$this->result = 'error';
				$this->errParam = 'articleurl';
				$this->msg = $this->wf->msg( 'wikiahubs-error-invalid-article-url-length' );
				return;
			} else if ( empty($reason) || strlen($reason) > 140 ) {
				$this->result = 'error';
				$this->errParam = 'reason';
				$this->msg = $this->wf->msg( 'wikiahubs-error-invalid-reason-length' );
				return;
			}

			$title = Title::newFromText($hubname.'/Suggested_content');
			$article  = new Article( $title );
			$username = $this->wg->user->getName();
			$content = "$articleUrl | $reason | $username | $submissiondate \n\n".$article->getRawText();
			$summary = "Hubs: $username suggests article";
			$status = $article->doEdit( $content, $summary );

			$this->result = 'ok';
			$this->msg = $this->wf->msg( 'wikiahubs-suggest-article-success' );
		}
	}


}

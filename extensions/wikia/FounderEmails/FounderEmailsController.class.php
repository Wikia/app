<?php
class FounderEmailsController extends WikiaController {

	// This function is only used for testing / previewing / debugging the FounderEmails templates
	public function executeIndex() {
		global $wgRequest, $wgContLang;

		$day = $wgRequest->getVal( 'day' );
		$type = $wgRequest->getVal( 'type' );
		$lang = $wgRequest->getVal( 'lang', 'en' );

		if ( $type != 'views-digest' && $type != 'complete-digest' ) {
			$wgContLang = wfGetLangObj( $lang );
		}

		if ( !empty( $day ) ) {
			$this->previewBody = F::app()->renderView( "FounderEmails", $day, array( 'language' => $lang ) );
			$this->previewBody = strtr( $this->previewBody,
				array( '$USERNAME' => 'UserName',
					'$WIKINAME' => '<a href="#" style="color:#2C85D5;">WikiName</a>',
					'$HDWIKINAME' => '<a href="#" style="color:#fa5c1f;">WikiName</a>',
					'$UNIQUEVIEWS' => '6' )
			);
		} else if ( !empty( $type ) ) {
			$this->previewBody = F::app()->renderView( "FounderEmails", 'GeneralUpdate',
				array( 'type' => $type,
					'language' => $lang,
					'$PAGEURL' => 'http://www.wikia.com',
					'$MYHOMEURL' => 'http://www.wikia.com',
					'$UNIQUEVIEWS' => '1',
					'$USEREDITS' => '2',
					'$USERJOINS' => '3',
					'$EDITORTALKPAGEURL' => 'http://www.wikia.com',
					)
				);
			$this->previewBody = strtr( $this->previewBody,
				array( '$USERNAME' => 'UserName',
					'$WIKINAME' => '<a href="#" style="color:#2C85D5;">WikiName</a>',
					'$PAGETITLE' => '<a href="#" style="color:#2C85D5;">PageTitle</a>',
					'$EDITORNAME' => '<a href="#" style="color:#2C85D5;">EditorName</a>',
					)
			);
		}
	}

	/**
	 * General Entry point for Event emails
	 *
	 * @requestParam String type which set of messages to use
	 *
	 * types so far are:
	 * user-registered
	 * anon-edit
	 * general-edit
	 * first-edit
	 * lot-happening
	 * views-digest
	 * complete-digest
	 *
	 */
	public function executeGeneralUpdate( $params ) {
		$this->type = $params['type'];
		$this->language = $params['language'];
		$this->greeting = wfMsgForContent( 'founderemails-email-' . $this->type . '-greeting' );
		$this->headline = wfMsgForContent( 'founderemails-email-' . $this->type . '-headline' );
		$this->signature = wfMsgForContent( 'founderemails-email-' . $this->type . '-signature' );
		$this->button = wfMsgForContent( 'founderemails-email-' . $this->type . '-button' );
		if ( $this->type != 'complete-digest' ) {
			$this->content = wfMsgForContent( 'founderemails-email-' . $this->type . '-content' );
		}
		if ( isset( $params['$PAGEURL'] ) ) {
			$this->buttonUrl = $params['$PAGEURL'];
		}
		switch( $this->type ) {
			case 'anon-edit':
				break;
			case 'general-edit':
				break;
			case 'first-edit':
				break;
			case 'lot-happening':
				$this->buttonUrl = $params['$MYHOMEURL'];
				break;
			case 'views-digest':
				$this->headline = wfMsgExt( 'founderemails-email-' . $this->type . '-headline', array( 'content', 'parsemag' ), $params['$UNIQUEVIEWS'] );
				break;
			case 'complete-digest':
				$this->heading1 = wfMsgExt( 'founderemails-email-complete-digest-content-heading1', array( 'content', 'parsemag' ), $params['$UNIQUEVIEWS'] );
				$this->content1 = wfMsgForContent( 'founderemails-email-complete-digest-content1' );
				$this->heading2 = wfMsgExt( 'founderemails-email-complete-digest-content-heading2', array( 'content', 'parsemag' ), $params['$USEREDITS'] );
				$this->content2 = wfMsgForContent( 'founderemails-email-complete-digest-content2' );
				$this->heading3 = wfMsgExt( 'founderemails-email-complete-digest-content-heading3', array( 'content', 'parsemag' ), $params['$USERJOINS'] );
				$this->content3 = wfMsgForContent( 'founderemails-email-complete-digest-content3' );
				break;
			default:
				break;
		}
	}

}

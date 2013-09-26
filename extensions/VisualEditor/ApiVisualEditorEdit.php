<?php
/**
 * Parsoid API wrapper.
 *
 * @file
 * @ingroup Extensions
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

class ApiVisualEditorEdit extends ApiVisualEditor {

	protected function saveWikitext( $title, $wikitext, $params ) {
		$apiParams = array(
			'action' => 'edit',
			'title' => $title->getPrefixedDBkey(),
			'text' => $wikitext,
			'summary' => $params['summary'],
			'basetimestamp' => $params['basetimestamp'],
			'starttimestamp' => $params['starttimestamp'],
			'token' => $params['token'],
		);

		if ( $params['minor'] ) {
			$apiParams['minor'] = true;
		} else {
			$apiParams['notminor'] = true;
		}

		// FIXME add some way that the user's preferences can be respected
		$apiParams['watchlist'] = $params['watch'] ? 'watch' : 'unwatch';

		if ( $params['captchaid'] ) {
			$apiParams['captchaid'] = $params['captchaid'];
		}

		if ( $params['captchaword'] ) {
			$apiParams['captchaword'] = $params['captchaword'];
		}

		$api = new ApiMain(
			new DerivativeRequest(
				$this->getRequest(),
				$apiParams + $this->getRequest()->getValues(),
				true // was posted
			),
			true // enable write
		);

		$api->execute();

		return $api->getResultData();
	}

	public function execute() {
		global $wgVisualEditorNamespaces, $wgVisualEditorUseChangeTagging;

		$user = $this->getUser();
		$params = $this->extractRequestParams();
		$page = Title::newFromText( $params['page'] );
		if ( !$page ) {
			$this->dieUsageMsg( 'invalidtitle', $params['page'] );
		}
		if ( !in_array( $page->getNamespace(), $wgVisualEditorNamespaces ) ) {
			$this->dieUsage( "VisualEditor is not enabled in namespace " .
				$page->getNamespace(), 'novenamespace' );
		}

		$parserParams = array();
		if ( isset( $params['oldid'] ) ) {
			$parserParams['oldid'] = $params['oldid'];
		}

		$wikitext = $this->postHTML( $page, $params['html'], $parserParams );

		if ( $wikitext === false ) {
			$this->dieUsage( 'Error contacting the Parsoid server', 'parsoidserver' );
		}

		$saveresult = $this->saveWikitext( $page, $wikitext, $params );
		$editStatus = $saveresult['edit']['result'];

		// Error
		if ( !isset( $saveresult['edit']['result'] ) || $editStatus !== 'Success' ) {
			$result = array(
				'result' => 'error',
				'edit' => $saveresult['edit']
			);

		// Success
		} else {
			if ( isset( $saveresult['edit']['newrevid'] ) && $wgVisualEditorUseChangeTagging ) {
				ChangeTags::addTags( 'visualeditor', null,
					intval( $saveresult['edit']['newrevid'] ),
					null
				);
				if ( $params['needcheck'] ) {
					ChangeTags::addTags( 'visualeditor-needcheck', null,
						intval( $saveresult['edit']['newrevid'] ),
						null
					);
				}
			}

			// Return result of parseWikitext instead of saveWikitext so that the
			// frontend can update the page rendering without a refresh.
			$result = $this->parseWikitext( $page );
			if ( $result === false ) {
				$this->dieUsage( 'Error contacting the Parsoid server', 'parsoidserver' );
			}

			if ( isset( $saveresult['edit']['newrevid'] ) ) {
				$result['newrevid'] = intval( $saveresult['edit']['newrevid'] );
			}

			$result['result'] = 'success';
		}

		$this->getResult()->addValue( null, $this->getModuleName(), $result );
	}

	public function getAllowedParams() {
		return array(
			'page' => array(
				ApiBase::PARAM_REQUIRED => true,
			),
			'token' => array(
				ApiBase::PARAM_REQUIRED => true,
			),
			'wikitext' => null,
			'basetimestamp' => null,
			'starttimestamp' => null,
			'needcheck' => array(
				ApiBase::PARAM_TYPE => 'boolean'
			),
			'oldid' => null,
			'minor' => null,
			'watch' => null,
			'html' => null,
			'summary' => null,
			'captchaid' => null,
			'captchaword' => null,
		);
	}

	public function needsToken() {
		return true;
	}

	public function getTokenSalt() {
		return '';
	}

	public function mustBePosted() {
		return true;
	}

	public function isWriteMode() {
		return true;
	}

	public function getParamDescription() {
		return array(
			'page' => 'The page to perform actions on.',
			'oldid' => 'The revision number to use. Defaults to latest revision. Use 0 for new page.',
			'minor' => 'Flag for minor edit.',
			'html' => 'HTML to send to Parsoid in exchange for wikitext',
			'summary' => 'Edit summary',
			'basetimestamp' => 'When saving, set this to the timestamp of the revision that was'
				. ' edited. Used to detect edit conflicts.',
			'starttimestamp' => 'When saving, set this to the timestamp of when the page was loaded.'
				. ' Used to detect edit conflicts.',
			'token' => 'Edit token',
			'needcheck' => 'When saving, set this parameter if the revision might have roundtrip'
				. ' problems. This will result in the edit being tagged.',
			'captchaid' => 'Captcha ID (when saving with a captcha response).',
			'captchaword' => 'Answer to the captcha (when saving with a captcha response).',
		);
	}

	public function getDescription() {
		return 'Save an HTML5 page to MediaWiki (converted to wikitext via the Parsoid service).';
	}
}

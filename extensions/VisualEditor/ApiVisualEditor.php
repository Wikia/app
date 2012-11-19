<?php
/**
 * Parsoid API wrapper.
 *
 * @file
 * @ingroup Extensions
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

class ApiVisualEditor extends ApiBase {
	protected function getHTML( $title, $parserParams ) {
		global $wgVisualEditorParsoidURL, $wgVisualEditorParsoidPrefix,
			$wgVisualEditorParsoidTimeout;
		if ( !$title->exists() ) {
			return '';
		}
		return Http::get(
			// Insert slash since $wgVisualEditorParsoidURL does not
			// end in a slash
			wfAppendQuery(
				$wgVisualEditorParsoidURL . '/' . $wgVisualEditorParsoidPrefix .
					'/' . urlencode( $title->getPrefixedDBkey() ),
				$parserParams
			),
			$wgVisualEditorParsoidTimeout
		);
	}

	protected function postHTML( $title, $html ) {
		global $wgVisualEditorParsoidURL, $wgVisualEditorParsoidTimeout;
		return Http::post(
			$wgVisualEditorParsoidURL . '/' . urlencode( $title->getPrefixedDBkey() ),
			array(
				'postData' => array( 'content' => $html ),
				'timeout' => $wgVisualEditorParsoidTimeout
			)
		);
	}

	protected function saveWikitext( $title, $wikitext, $params ) {
		$apiParams = array(
			'action' => 'edit',
			'title' => $title->getPrefixedDBkey(),
			'text' => $wikitext,
			'summary' => $params['summary'],
			'basetimestamp' => $params['basetimestamp'],
			'token' => $params['token'],
		);
		if ( $params['minor'] ) {
			$apiParams['minor'] = true;
		}
		// FIXME add some way that the user's preferences can be respected
		$apiParams['watchlist'] = $params['watch'] ? 'watch' : 'unwatch';
		$api = new ApiMain(
			new DerivativeRequest(
				$this->getRequest(),
				$apiParams,
				true // was posted
			),
			true // enable write
		);
		$api->execute();
		return $api->getResultData();
	}

	protected function parseWikitext( $title ) {
		$apiParams = array(
			'action' => 'parse',
			'page' => $title->getPrefixedDBkey()
		);
		$api = new ApiMain(
			new DerivativeRequest(
				$this->getRequest(),
				$apiParams,
				false // was posted?
			),
			true // enable write?
		);

		$api->execute();
		$result = $api->getResultData();
		return isset( $result['parse']['text']['*'] ) ? $result['parse']['text']['*'] : false;
	}

	protected function diffWikitext( $title, $wikitext ) {
		$apiParams = array(
			'action' => 'query',
			'prop' => 'revisions',
			'titles' => $title->getPrefixedDBkey(),
			'rvdifftotext' => $wikitext
		);
		$api = new ApiMain(
			new DerivativeRequest(
				$this->getRequest(),
				$apiParams,
				false // was posted?
			),
			false // enable write?
		);
		$api->execute();
		$result = $api->getResultData();
		return isset( $result['query']['pages'][$title->getArticleID()]['revisions'][0]['diff']['*'] ) ?
			$result['query']['pages'][$title->getArticleID()]['revisions'][0]['diff']['*'] :
			false;
	}

	public function execute() {
		global $wgVisualEditorNamespaces;
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
		if ( is_numeric( $params['oldid'] ) ) {
			$parserParams['oldid'] = intval( $params['oldid'] );
		}

		if ( $params['paction'] === 'parse' ) {
			$parsed = $this->getHTML( $page, $parserParams );

			if ( $parsed !== false ) {
				$result = array(
					'result' => 'success',
					'parsed' => $parsed
				);
			} else {
				$this->dieUsage( 'Error contacting the Parsoid server', 'parsoidserver' );
			}
		} elseif ( $params['paction'] === 'save' || $params['paction'] === 'diff' ) {
			$wikitext = $this->postHTML( $page, $params['html'] );

			if ( $wikitext === false ) {
				$this->dieUsage( 'Error contacting the Parsoid server', 'parsoidserver' );
			} else if ( $params['paction'] === 'save' ) {
				// Save page
				$editResult = $this->saveWikitext( $page, $wikitext, $params );
				if (
					!isset( $editResult['edit']['result'] ) ||
					$editResult['edit']['result'] !== 'Success'
				) {
					$result = array(
						'result' => 'error',
						'edit' => $editResult['edit']
					);
				} else {
					$parsed = $this->parseWikitext( $page );
					$result = array( 'result' => 'success' );
					if ( $parsed !== false ) {
						$result['content'] = $parsed;
					}
				}
			} else if ( $params['paction'] === 'diff' ) {
				$diff = $this->diffWikitext( $page, $wikitext );
				if ( $diff === false ) {
					$this->dieUsage( 'Diff failed', 'difffailed' );
				}
				$result = array(
					'result' => 'success',
					'diff' => $diff
				);
			}

		}

		$this->getResult()->addValue( null, $this->getModuleName(), $result );
	}

	public function getAllowedParams() {
		return array(
			'page' => array(
				ApiBase::PARAM_REQUIRED => true,
			),
			'paction' => array(
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_TYPE => array( 'parse', 'save', 'diff' ),
			),
			'oldid' => array(
				ApiBase::PARAM_REQUIRED => false,
			),
			'minor' => array(
				ApiBase::PARAM_REQUIRED => false,
			),
			'watch' => array(
				ApiBase::PARAM_REQUIRED => false,
			),
			'html' => array(
				ApiBase::PARAM_REQUIRED => false,
			),
			'summary' => null,
			'basetimestamp' => null,
			'token' => null,
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

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}

	public function getParamDescription() {
		return array(
			'page' => 'The page to perform actions on.',
			'paction' => 'Action to perform',
			'oldid' => 'The revision number to use.',
			'minor' => 'Flag for minor edit.',
			'html' => 'HTML to send to parsoid in exchange for wikitext',
			'summary' => 'Edit summary',
			'basetimestamp' => 'When saving, set this to the timestamp of the revision that was edited. Used to detect edit conflicts.',
			'token' => 'Edit token',
		);
	}

	public function getDescription() {
		return 'Returns HTML5 for a page from the parsoid service.';
	}
}

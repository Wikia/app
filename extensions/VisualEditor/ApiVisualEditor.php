<?php
/**
 * Parsoid API wrapper.
 *
 * @file
 * @ingroup Extensions
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

class ApiVisualEditor extends ApiBase {

	protected function getHTML( $title, $parserParams ) {
		global $wgDevelEnvironment,
			$wgVisualEditorParsoidURL,
			$wgVisualEditorParsoidPrefix,
			$wgVisualEditorParsoidTimeout;

		$restoring = false;

		if ( $title->exists() ) {
			$latestRevision = Revision::newFromTitle( $title );
			if ( $latestRevision === null ) {
				return false;
			}
			$revision = null;
			if ( !isset( $parserParams['oldid'] ) || $parserParams['oldid'] === 0 ) {
				$parserParams['oldid'] = $latestRevision->getId();
				$revision = $latestRevision;
			} else {
				$revision = Revision::newFromId( $parserParams['oldid'] );
				if ( $revision === null ) {
					return false;
				}
			}

			$restoring = $revision && !$revision->isCurrent();
			$oldid = $parserParams['oldid'];

			$req = MWHttpRequest::factory( wfAppendQuery(
					$wgVisualEditorParsoidURL . '/' . $wgVisualEditorParsoidPrefix .
						'/' . urlencode( $title->getPrefixedDBkey() ),
					$parserParams
				),
				array(
					'method' => 'GET',
					'timeout' => $wgVisualEditorParsoidTimeout,
					'noProxy' => !empty( $wgDevelEnvironment )
				)
			);
			$status = $req->execute();

			if ( $status->isOK() ) {
				$content = $req->getContent();
			} elseif ( $status->isGood() ) {
				$this->dieUsage( $req->getContent(), 'parsoidserver-http-'.$req->getStatus() );
			} elseif ( $errors = $status->getErrorsByType( 'error' ) ) {
				$error = $errors[0];
				$code = $error['message'];
				if ( count( $error['params'] ) ) {
					$message = $error['params'][0];
				} else {
					$message = 'MWHttpRequest error';
				}
				$this->dieUsage( $message, 'parsoidserver-'.$code );
			}

			if ( $content === false ) {
				return false;
			}
			$timestamp = $latestRevision->getTimestamp();
		} else {
			$content = '';
			$timestamp = wfTimestampNow();
			$oldid = 0;
		}
		return array(
			'result' => array(
				'content' => $content,
				'basetimestamp' => $timestamp,
				'starttimestamp' => wfTimestampNow(),
				'oldid' => $oldid,
			),
			'restoring' => $restoring,
		);
	}

	protected function postHTML( $title, $html, $parserParams ) {
		global $wgDevelEnvironment,
			$wgVisualEditorParsoidURL,
			$wgVisualEditorParsoidPrefix,
			$wgVisualEditorParsoidTimeout;

		if ( $parserParams['oldid'] === 0 ) {
			$parserParams['oldid'] = '';
		}
		return Http::post(
			$wgVisualEditorParsoidURL . '/' . $wgVisualEditorParsoidPrefix .
				'/' . urlencode( $title->getPrefixedDBkey() ),
			array(
				'postData' => array(
					'content' => $html,
					'oldid' => $parserParams['oldid']
				),
				'timeout' => $wgVisualEditorParsoidTimeout,
				'noProxy' => !empty( $wgDevelEnvironment )
			)
		);
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
		$content = isset( $result['parse']['text']['*'] ) ? $result['parse']['text']['*'] : false;
		$revision = Revision::newFromId( $result['parse']['revid'] );
		$timestamp = $revision ? $revision->getTimestamp() : wfTimestampNow();

		if ( $content === false || ( strlen( $content ) && $revision === null ) ) {
			return false;
		}

		return array(
			'content' => $content,
			'basetimestamp' => $timestamp,
			'starttimestamp' => wfTimestampNow()
		);
	}

	protected function parseWikitextFragment( $wikitext, $title = null ) {
		$apiParams = array(
			'action' => 'parse',
			'title' => $title,
			'prop' => 'text',
			'disablepp' => true,
			'text' => $wikitext
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
		if ( !isset( $result['query']['pages'][$title->getArticleID()]['revisions'][0]['diff']['*'] ) ) {
			return array( 'result' => 'fail' );
		}
		$diffRows = $result['query']['pages'][$title->getArticleID()]['revisions'][0]['diff']['*'];

		if ( $diffRows !== '' ) {
			$context = new DerivativeContext( $this->getContext() );
			$context->setTitle( $title );
			$engine = new DifferenceEngine( $context );
			return array(
				'result' => 'success',
				'diff' => $engine->addHeader(
					$diffRows,
					wfMessage( 'currentrev' )->parse(),
					wfMessage( 'yourtext' )->parse()
				)
			);
		} else {
			return array( 'result' => 'nochanges' );
		}
	}

	public function execute() {
		global $wgVisualEditorNamespaces, $wgVisualEditorEditNotices;

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

		switch ( $params['paction'] ) {
			case 'parse':
				$parsed = $this->getHTML( $page, $parserParams );
				// Dirty hack to provide the correct context for edit notices
				global $wgTitle; // FIXME NOOOOOOOOES
				$wgTitle = $page;
				// TODO: In MW 1.19.7 method getEditNotices does not exist so for now fallback to just an empty
				// but in future figure out what's the proper backward compatibility solution.
				// #back-compat
				// $notices = $page->getEditNotices();
				$notices = array();
				if ( $user->isAnon() ) {
					$wgVisualEditorEditNotices[] = 'anoneditwarning';
				}
				if ( $parsed && $parsed['restoring'] ) {
					$wgVisualEditorEditNotices[] = 'editingold';
				}
				// Page protected from editing
				if ( $page->getNamespace() != NS_MEDIAWIKI && $page->isProtected( 'edit' ) ) {
					# Is the title semi-protected?
					if ( $page->isSemiProtected() ) {
						$wgVisualEditorEditNotices[] = 'semiprotectedpagewarning';
					} else {
						# Then it must be protected based on static groups (regular)
						$wgVisualEditorEditNotices[] = 'protectedpagewarning';
					}
				}
				// Creating new page
				if ( !$page->exists() ) {
					$wgVisualEditorEditNotices[] = $user->isLoggedIn() ? 'newarticletext' : 'newarticletextanon';
					// Page protected from creation
					if ( $page->getRestrictions( 'create' ) ) {
						$wgVisualEditorEditNotices[] = 'titleprotectedwarning';
					}
				}
				if ( count( $wgVisualEditorEditNotices ) ) {
					foreach ( $wgVisualEditorEditNotices as $key ) {
						$notices[] = wfMessage( $key )->parseAsBlock();
					}
				}

				// HACK: Build a fake EditPage so we can get checkboxes from it
				$article = new Article( $page ); // Deliberately omitting ,0 so oldid comes from request
				$ep = new EditPage( $article );
				$req = $this->getRequest();
				$ep->importFormData( $req ); // By reference for some reason (bug 52466)
				$tabindex = 0;
				$states = array( 'minor' => false, 'watch' => false );
				$checkboxes = $ep->getCheckboxes( $tabindex, $states );

				if ( $parsed === false ) {
					$this->dieUsage( 'Error contacting the Parsoid server', 'parsoidserver' );
				} else {
					$result = array_merge(
						array(
							'result' => 'success',
							'notices' => $notices,
							'checkboxes' => $checkboxes,
						),
						$parsed['result']
					);
				}
				break;
			case 'parsefragment':
				$content = $this->parseWikitextFragment( $params['wikitext'], $page->getText() );
				if ( $content === false ) {
					$this->dieUsage( 'Error querying MediaWiki API', 'parsoidserver' );
				} else {
					$result = array(
						'result' => 'success',
						'content' => $content
					);
				}
				break;
			case 'serialize':
				if ( $params['html'] === null ) {
					$this->dieUsageMsg( 'missingparam', 'html' );
				}
				$content = $this->postHTML( $page, $params['html'], $parserParams );
				if ( $content === false ) {
					$this->dieUsage( 'Error contacting the Parsoid server', 'parsoidserver' );
				} else {
					$result = array( 'result' => 'success', 'content' => $content );
				}
				break;
			case 'diff':
				$wikitext = $this->postHTML( $page, $params['html'], $parserParams );

				if ( $wikitext === false ) {
					$this->dieUsage( 'Error contacting the Parsoid server', 'parsoidserver' );
				}

				$diff = $this->diffWikitext( $page, $wikitext );
				if ( $diff['result'] === 'fail' ) {
					$this->dieUsage( 'Diff failed', 'difffailed' );
				}
				$result = $diff;

				break;
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
				ApiBase::PARAM_TYPE => array( 'parse', 'parsefragment', 'serialize', 'diff' ),
			),
			'wikitext' => null,
			'basetimestamp' => null,
			'starttimestamp' => null,
			'oldid' => null,
			'html' => null,
		);
	}

	public function needsToken() {
		return false;
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
			'oldid' => 'The revision number to use (defaults to latest version).',
			'html' => 'HTML to send to parsoid in exchange for wikitext',
			'basetimestamp' => 'When saving, set this to the timestamp of the revision that was'
				.' edited. Used to detect edit conflicts.',
			'starttimestamp' => 'When saving, set this to the timestamp of when the page was loaded.'
				.' Used to detect edit conflicts.',
		);
	}

	public function getDescription() {
		return 'Returns HTML5 for a page from the parsoid service.';
	}
}

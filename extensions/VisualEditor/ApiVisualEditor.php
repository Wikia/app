<?php
/**
 * Parsoid API wrapper.
 *
 * @file
 * @ingroup Extensions
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

use \Wikia\Logger\WikiaLogger;

class ApiVisualEditor extends ApiBase {

	/**
	 * Parsoid HTTP proxy configuration for MWHttpRequest
	 */
	protected function getProxyConf() {
		global $wgVisualEditorParsoidHTTPProxy, $wgDevelEnvironment;
		if ( $wgVisualEditorParsoidHTTPProxy ) {
			return array( 'proxy' => $wgVisualEditorParsoidHTTPProxy );
		} else {
			return array( 'noProxy' => !empty( $wgDevelEnvironment ) );
		}
	}

	protected function requestParsoid( $method, $title, $params ) {
		global $wgVisualEditorParsoidURL,
			$wgVisualEditorParsoidTimeout,
			$wgVisualEditorParsoidForwardCookies;

		$url = $wgVisualEditorParsoidURL . '/' .
			urlencode( $this->getApiSource() ) . '/' .
			urlencode( $title->getPrefixedDBkey() );

		$data = array_merge(
			$this->getProxyConf(),
			array(
				'method' => $method,
				'timeout' => $wgVisualEditorParsoidTimeout,
			)
		);

		if ( $method === 'POST' ) {
			$data['postData'] = $params;
		} else {
			$url = wfAppendQuery( $url, $params );
		}

		$req = MWHttpRequest::factory( $url, $data );
		// Forward cookies, but only if configured to do so and if there are read restrictions
		if ( $wgVisualEditorParsoidForwardCookies && !User::isEveryoneAllowed( 'read' ) ) {
			$req->setHeader( 'Cookie', $this->getRequest()->getHeader( 'Cookie' ) );
		}
		$status = $req->execute();
		if ( $status->isOK() ) {
			// Pass thru performance data from Parsoid to the client, unless the response was
			// served directly from Varnish, in  which case discard the value of the XPP header
			// and use it to declare the cache hit instead.
			$xCache = $req->getResponseHeader( 'X-Cache' );
			if ( is_string( $xCache ) && strpos( strtolower( $xCache ), 'hit' ) !== false ) {
				$xpp = 'cached-response=true';
				$hit = true;
			} else {
				$xpp = $req->getResponseHeader( 'X-Parsoid-Performance' );
				$hit = false;
			}

			WikiaLogger::instance()->debug( 'ApiVisualEditor', array(
				'hit' => $hit,
				'method' => $method,
				'url' => $url
			) );

			if ( $xpp !== null ) {
				$resp = $this->getRequest()->response();
				$resp->header( 'X-Parsoid-Performance: ' . $xpp );
			}
		} elseif ( $status->isGood() ) {
			$this->dieUsage( $req->getContent(), 'parsoidserver-http-' . $req->getStatus() );
		} elseif ( $errors = $status->getErrorsByType( 'error' ) ) {
			$error = $errors[0];
			$code = $error['message'];
			if ( count( $error['params'] ) ) {
				$message = $error['params'][0];
			} else {
				$message = 'MWHttpRequest error';
			}
			$this->dieUsage( $message, 'parsoidserver-' . $code );
		}
		// TODO pass through X-Parsoid-Performance header, merge with getHTML above
		return $req->getContent();
	}

	protected function getHTML( $title, $parserParams ) {
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

			$content = $this->requestParsoid( 'GET', $title, $parserParams );

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

	protected function storeInSerializationCache( $title, $oldid, $html ) {
		global $wgMemc, $wgVisualEditorSerializationCacheTimeout;
		$content = $this->postHTML( $title, $html, array( 'oldid' => $oldid ) );
		if ( $content === false ) {
			return false;
		}
		$hash = md5( $content );
		$key = wfMemcKey( 'visualeditor', 'serialization', $hash );
		$wgMemc->set( $key, $content, $wgVisualEditorSerializationCacheTimeout );
		return $hash;
	}

	protected function trySerializationCache( $hash ) {
		global $wgMemc;
		$key = wfMemcKey( 'visualeditor', 'serialization', $hash );
		return $wgMemc->get( $key );
	}

	protected function postHTML( $title, $html, $parserParams ) {
		$postData = array( 'content' => $html );
		if ( isset( $parserParams['oldwt'] ) ) {
			$postData['oldwt'] = $parserParams['oldwt'];
		} else {
			if ( $parserParams['oldid'] === 0 ) {
				$parserParams['oldid'] = '';
			}
			$postData['oldid'] = $parserParams['oldid'];
		}
		return $this->requestParsoid( 'POST', $title, $postData );
	}

	protected function parseWikitextFragment( $title, $wikitext ) {
		return $this->requestParsoid( 'POST', $title,
			array(
				'wt' => $wikitext,
				'body' => 1,
			)
		);
	}

	protected function parseWikitext( $title, $skin = null ) {
		$apiParams = array(
			'action' => 'parse',
			'page' => $title->getPrefixedDBkey(),
			'prop' => 'text|revid|categorieshtml'
		);
		if ( !empty( $skin ) ) {
			$apiParams['useskin'] = $skin;
		}
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
		$categorieshtml = isset( $result['parse']['categorieshtml']['*'] ) ?
			$result['parse']['categorieshtml']['*'] : false;
		$links = isset( $result['parse']['links'] ) ? $result['parse']['links'] : array();
		$revision = Revision::newFromId( $result['parse']['revid'] );
		$timestamp = $revision ? $revision->getTimestamp() : wfTimestampNow();

		if ( $content === false || ( strlen( $content ) && $revision === null ) ) {
			return false;
		}

		return array(
			'content' => $content,
			'categorieshtml' => $categorieshtml,
			'basetimestamp' => $timestamp,
			'starttimestamp' => wfTimestampNow()
		);
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

	protected function getLangLinks( $title ) {
		$apiParams = array(
			'action' => 'query',
			'prop' => 'langlinks',
			'lllimit' => 500,
			'titles' => $title->getPrefixedDBkey(),
			'indexpageids' => 1,
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
		if ( !isset( $result['query']['pages'][$title->getArticleID()]['langlinks'] ) ) {
			return false;
		}
		$langlinks = $result['query']['pages'][$title->getArticleID()]['langlinks'];
		$langnames = Language::getLanguageNames();
		foreach ( $langlinks as $i => $lang ) {
			$langlinks[$i]['langname'] = $langnames[$langlinks[$i]['lang']];
		}
		return $langlinks;
	}

	/**
	 * @protected
	 * @description Simple helper to retrieve relevant api uri
	 * @return String
	 */
	protected function getApiSource() {
		return wfExpandUrl( wfScript( 'api' ) );
	}

	public function execute() {
		global $wgVisualEditorNamespaces, $wgVisualEditorParsoidURL, $wgVisualEditorParsoidTimeout, $wgDevelEnvironment;

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
		if ( isset( $params['oldwt'] ) ) {
			$parserParams['oldwt'] = $params['oldwt'];
		} else if ( isset( $params['oldid'] ) ) {
			$parserParams['oldid'] = $params['oldid'];
		}

		switch ( $params['paction'] ) {
			case 'parsewt':
				// FIXME: Perhaps requestParsoid method should be used here
				$postData = array(
					'wt' => $params['wikitext']
				);
				$content = Http::post(
					$wgVisualEditorParsoidURL . '/' . urlencode( $this->getApiSource() ).
						'/' . urlencode( $page->getPrefixedDBkey() ),
					array(
						'postData' => $postData,
						'timeout' => $wgVisualEditorParsoidTimeout,
						'noProxy' => !empty( $wgDevelEnvironment )
					)
				);
				$result = array(
					'result' => 'success',
					'content' => $content
				);
				break;
			case 'parse':
				$parsed = $this->getHTML( $page, $parserParams );
				// Dirty hack to provide the correct context for edit notices
				global $wgTitle; // FIXME NOOOOOOOOES
				$wgTitle = $page;
				RequestContext::getMain()->setTitle( $page );
				// TODO: In MW 1.19.7 method getEditNotices does not exist so for now fallback to just an empty
				// but in future figure out what's the proper backward compatibility solution.
				// #back-compat
				// $notices = $page->getEditNotices();
				$notices = array();
				$anoneditwarning = false;
				$anoneditwarningMessage = $this->msg( 'VisualEditor-anoneditwarning' );
				if ( $user->isAnon() && $anoneditwarningMessage->exists() ) {
					$notices[] = $anoneditwarningMessage->parseAsBlock();
					$anoneditwarning = true;
				}
				if ( $parsed && $parsed['restoring'] ) {
					$notices[] = $this->msg( 'editingold' )->parseAsBlock();
				}

				// Creating new page
				if ( !$page->exists() ) {
					$notices[] = $this->msg(
						$user->isLoggedIn() ? 'newarticletext' : 'newarticletextanon',
						Skin::makeInternalOrExternalUrl(
							$this->msg( 'helppage' )->inContentLanguage()->text()
						)
					)->parseAsBlock();
					// Page protected from creation
					if ( $page->getRestrictions( 'create' ) ) {
						$notices[] = $this->msg( 'titleprotectedwarning' )->parseAsBlock();
					}
				}

				// Look at protection status to set up notices + surface class(es)
				$protectedClasses = array();
				if ( MWNamespace::getRestrictionLevels( $page->getNamespace() ) !== array( '' ) ) {
					// Page protected from editing
					if ( $page->isProtected( 'edit' ) ) {
						# Is the title semi-protected?
						if ( $page->isSemiProtected() ) {
							$protectedClasses[] = 'mw-textarea-sprotected';

							$noticeMsg = 'semiprotectedpagewarning';
						} else {
							$protectedClasses[] = 'mw-textarea-protected';

							# Then it must be protected based on static groups (regular)
							$noticeMsg = 'protectedpagewarning';
						}
						$notices[] = $this->msg( $noticeMsg )->parseAsBlock();
					}

					// Deal with cascading edit protection
					list( $sources, $restrictions ) = $page->getCascadeProtectionSources();
					if ( isset( $restrictions['edit'] ) ) {
						$protectedClasses[] = ' mw-textarea-cprotected';

						$notice = $this->msg( 'cascadeprotectedwarning' )->parseAsBlock() . '<ul>';
						// Unfortunately there's no nice way to get only the pages which cause
						// editing to be restricted
						foreach ( $sources as $source ) {
							$notice .= "<li>" . Linker::link( $source ) . "</li>";
						}
						$notice .= '</ul>';
						$notices[] = $notice;
					}
				}

				// Show notice when editing user / user talk page of a user that doesn't exist
				// or who is blocked
				// HACK of course this code is partly duplicated from EditPage.php :(
				if ( $page->getNamespace() == NS_USER || $page->getNamespace() == NS_USER_TALK ) {
					$parts = explode( '/', $page->getText(), 2 );
					$targetUsername = $parts[0];
					$targetUser = User::newFromName( $targetUsername, false /* allow IP users*/ );

					if (
						!( $targetUser && $targetUser->isLoggedIn() ) &&
						!User::isIP( $targetUsername )
					) { // User does not exist
						$notices[] = "<div class=\"mw-userpage-userdoesnotexist error\">\n" .
							$this->msg( 'userpage-userdoesnotexist', wfEscapeWikiText( $targetUsername ) ) .
							"\n</div>";
					}
					// Some upstream code is deleted from here, more information:
					// https://github.com/Wikia/app/commit/d54b481d3f6e5b092b212a2c98b2cb5452bee26c
					// https://github.com/Wikia/app/commit/681e7437078206460f7c0cb1837095e656d8ba85
				}

				if ( class_exists( 'GlobalBlocking' ) ) {
					$error = GlobalBlocking::getUserBlockErrors(
						$user,
						$this->getRequest()->getIP()
					);
					if ( count( $error ) ) {
						$notices[] = call_user_func_array(
							array( $this, 'msg' ),
							$error
						)->parseAsBlock();
					}
				}

				// HACK: Build a fake EditPage so we can get checkboxes from it
				$article = new Article( $page ); // Deliberately omitting ,0 so oldid comes from request
				$ep = new EditPage( $article );
				$req = $this->getRequest();
				$req->setVal( 'format', 'text/x-wiki' );
				$ep->importFormData( $req ); // By reference for some reason (bug 52466)
				$tabindex = 0;
				$states = array( 'minor' => false, 'watch' => false );
				$checkboxes = $ep->getCheckboxes( $tabindex, $states );

				// HACK: Find out which red links are on the page
				// We do the lookup for the current version. This might not be entirely complete
				// if we're loading an oldid, but it'll probably be close enough, and LinkCache
				// will automatically request any additional data it needs.
				$links = array();
				$wikipage = WikiPage::factory( $page );
				$popts = $wikipage->makeParserOptions( 'canonical' );
				$cached = ParserCache::singleton()->get( $article, $popts, true );
				if ( $cached ) {
					foreach ( $cached->getLinks() as $ns => $dbks ) {
						foreach ( $dbks as $dbk => $id ) {
							$links[ Title::makeTitle( $ns, $dbk )->getPrefixedText() ] = array(
								'missing' => $id == 0
							);
						}
					}
				}
				// On parser cache miss, just don't bother populating red link data

				if ( $parsed === false ) {
					$this->dieUsage( 'Error contacting the Parsoid server', 'parsoidserver' );
				} else {
					$result = array_merge(
						array(
							'result' => 'success',
							'notices' => $notices,
							'checkboxes' => $checkboxes,
							'links' => $links,
							'protectedClasses' => implode( ' ', $protectedClasses ),
							'anoneditwarning' => $anoneditwarning
						),
						$parsed['result']
					);
				}
				break;

			case 'parsefragment':
				$content = $this->parseWikitextFragment( $page, $params['wikitext'] );
				if ( $content === false ) {
					$this->dieUsage( 'Error contacting the Parsoid server', 'parsoidserver' );
				} else {
					$result = array(
						'result' => 'success',
						'content' => $content
					);
				}
				break;

			case 'serialize':
				if ( $params['cachekey'] !== null ) {
					$content = $this->trySerializationCache( $params['cachekey'] );
					if ( !is_string( $content ) ) {
						$this->dieUsage( 'No cached serialization found with that key', 'badcachekey' );
					}
				} else {
					if ( $params['html'] === null ) {
						$this->dieUsageMsg( 'missingparam', 'html' );
					}
					$html = $params['html'];
					$content = $this->postHTML( $page, $html, $parserParams );
					if ( $content === false ) {
						$this->dieUsage( 'Error contacting the Parsoid server', 'parsoidserver' );
					}
				}
				$result = array( 'result' => 'success', 'content' => $content );
				break;

			case 'diff':
				if ( $params['cachekey'] !== null ) {
					$wikitext = $this->trySerializationCache( $params['cachekey'] );
					if ( !is_string( $wikitext ) ) {
						$this->dieUsage( 'No cached serialization found with that key', 'badcachekey' );
					}
				} else {
					$wikitext = $this->postHTML( $page, $params['html'], $parserParams );
					if ( $wikitext === false ) {
						$this->dieUsage( 'Error contacting the Parsoid server', 'parsoidserver' );
					}
				}

				$diff = $this->diffWikitext( $page, $wikitext );
				if ( $diff['result'] === 'fail' ) {
					$this->dieUsage( 'Diff failed', 'difffailed' );
				}
				$result = $diff;

				break;

			case 'serializeforcache':
				$key = $this->storeInSerializationCache( $page, $parserParams['oldid'], $params['html'] );
				$result = array( 'result' => 'success', 'cachekey' => $key );
				break;

			case 'getlanglinks':
				$langlinks = $this->getLangLinks( $page );
				if ( $langlinks === false ) {
					$this->dieUsage( 'Error querying MediaWiki API', 'parsoidserver' );
				} else {
					$result = array( 'result' => 'success', 'langlinks' => $langlinks );
				}
				break;
		}

		$this->getResult()->addValue( null, $this->getModuleName(), $result );
	}

	/**
	 * Gets the relevant HTML for the latest log entry on a given title, including a full log link.
	 *
	 * @param $title Title
	 * @param $types array|string
	 * @returns string
	 */
	private function getLastLogEntry( $title, $types = '' ) {
		$lp = new LogPager(
			new LogEventsList( $this->getContext() ),
			$types,
			'',
			$title->getPrefixedDbKey()
		);
		$lp->mLimit = 1;

		return $lp->getBody() . Linker::link(
			SpecialPage::getTitleFor( 'Log' ),
			$this->msg( 'log-fulllog' )->escaped(),
			array(),
			array(
				'page' => $title->getPrefixedDBkey(),
				'type' => is_string( $types ) ? $types : null
			)
		);
	}

	public function getAllowedParams() {
		return array(
			'page' => array(
				ApiBase::PARAM_REQUIRED => true,
			),
			'format' => array(
				ApiBase::PARAM_DFLT => 'json',
				ApiBase::PARAM_TYPE => array( 'json', 'jsonfm' ),
			),
			'paction' => array(
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_TYPE => array(
					'parsewt',
					'parse',
					'parsefragment',
					'serialize',
					'serializeforcache',
					'diff',
					'getlanglinks',
				),
			),
			'wikitext' => null,
			'basetimestamp' => null,
			'starttimestamp' => null,
			'oldid' => null,
			'html' => null,
			'oldwt' => null,
			'cachekey' => null,
		);
	}

	public function needsToken() {
		return false;
	}

	public function mustBePosted() {
		return false;
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
				. ' edited. Used to detect edit conflicts.',
			'starttimestamp' => 'When saving, set this to the timestamp of when the page was loaded.'
				. ' Used to detect edit conflicts.',
			'cachekey' => 'For serialize or diff, use the result of a previous serializeforcache'
				. ' request with this key. Overrides html.',
		);
	}

	public function getDescription() {
		return 'Returns HTML5 for a page from the parsoid service.';
	}
}

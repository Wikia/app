<?php
/**
 * Parsoid API wrapper.
 *
 * @file
 * @ingroup Extensions
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

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

	protected function getHTML( $title, $parserParams ) {
		global $wgVisualEditorParsoidURL,
			$wgVisualEditorParsoidPrefix,
			$wgVisualEditorParsoidTimeout,
			$wgVisualEditorParsoidForwardCookies,
			$wgDevelEnvironment;

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
					$wgVisualEditorParsoidURL . '/' . $this->getApiSource() .
						'/' . wfUrlencode( $title->getPrefixedDBkey() ),
					$parserParams
				),
				array_merge(
					$this->getProxyConf(),
					array(
						'method'  => 'GET',
						'timeout' => $wgVisualEditorParsoidTimeout,
					)
				)
			);
			// Forward cookies, but only if configured to do so and if there are read restrictions
			if ( $wgVisualEditorParsoidForwardCookies && !User::isEveryoneAllowed( 'read' ) ) {
				$req->setHeader( 'Cookie', $this->getRequest()->getHeader( 'Cookie' ) );
			}
			$status = $req->execute();

			if ( $status->isOK() ) {
				$content = $req->getContent();
				// Pass thru performance data from Parsoid to the client, unless the response was
				// served directly from Varnish, in  which case discard the value of the XPP header
				// and use it to declare the cache hit instead.
				$xCache = $req->getResponseHeader( 'X-Cache' );
				if ( is_string( $xCache ) && strpos( $xCache, 'hit' ) !== false ) {
					$xpp = 'cached-response=true';
				} else {
					$xpp = $req->getResponseHeader( 'X-Parsoid-Performance' );
				}
				if ( $xpp !== null ) {
					$resp = $this->getRequest()->response();
					$resp->header( 'X-Parsoid-Performance: ' . $xpp );
				}
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
		global $wgVisualEditorParsoidURL,
			$wgVisualEditorParsoidPrefix,
			$wgVisualEditorParsoidTimeout,
			$wgVisualEditorParsoidForwardCookies,
			$wgDevelEnvironment;

		$postData = array( 'content' => $html );
		if ( isset( $parserParams['oldwt'] ) ) {
			$postData['oldwt'] = $parserParams['oldwt'];
		} else {
			if ( $parserParams['oldid'] === 0 ) {
				$parserParams['oldid'] = '';
			}
			$postData['oldid'] = $parserParams['oldid'];
		}

		$req = MWHttpRequest::factory(
			$wgVisualEditorParsoidURL . '/' . $this->getApiSource() .
				'/' . wfUrlencode( $title->getPrefixedDBkey() ),
			array_merge(
				$this->getProxyConf(),
				array(
					'method' => 'POST',
					'postData' => $postData,
					'timeout' => $wgVisualEditorParsoidTimeout,
				)
			)
		);
		// Forward cookies, but only if configured to do so and if there are read restrictions
		if ( $wgVisualEditorParsoidForwardCookies && !User::isEveryoneAllowed( 'read' ) ) {
			$req->setHeader( 'Cookie', $this->getRequest()->getHeader( 'Cookie' ) );
		}
		$status = $req->execute();
		if ( !$status->isOK() ) {
			// TODO proper error handling, merge with getHTML above
			return false;
		}
		// TODO pass through X-Parsoid-Performance header, merge with getHTML above
		return $req->getContent();
	}

	protected function parseWikitext( $title ) {
		$apiParams = array(
			'action' => 'parse',
			'page' => $title->getPrefixedDBkey(),
			'prop' => 'text|revid|categorieshtml',
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

	protected function parseWikitextFragment( $wikitext, $title = null ) {
		$apiParams = array(
			'action' => 'parse',
			'title' => $title,
			'prop' => 'text',
			'disablepp' => true,
			'pst' => true,
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
		$langnames = Language::fetchLanguageNames();
		foreach ( $langlinks as $i => $lang ) {
			$langlinks[$i]['langname'] = $langnames[$langlinks[$i]['lang']];
		}
		return $langlinks;
	}

	/**
	 * @protected
	 * @description Simple helper to retrieve relevant api uri, eg: http://muppet.wikia.com/api.php
	 * @return String
	 */
	protected function getApiSource() {
		global $wgVisualEditorParsoidPrefix;
		return empty( $wgVisualEditorParsoidPrefix ) ?
				wfExpandUrl( wfScript( 'api' ) ) : $wgVisualEditorParsoidPrefix;
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
				$postData = array(
					'wt' => $params['wikitext']
				);
				$content = Http::post(
					$wgVisualEditorParsoidURL . '/' . $this->getApiSource() .
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
				// TODO: In MW 1.19.7 method getEditNotices does not exist so for now fallback to just an empty
				// but in future figure out what's the proper backward compatibility solution.
				// #back-compat
				// $notices = $page->getEditNotices();
				$notices = array();
				if ( $user->isAnon() ) {
					$notices[] = $this->msg( 'anoneditwarning' )->parseAsBlock();
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

				// Page protected from editing
				if ( $page->getNamespace() != NS_MEDIAWIKI && $page->isProtected( 'edit' ) ) {
					# Is the title semi-protected?
					if ( $page->isSemiProtected() ) {
						$noticeMsg = 'semiprotectedpagewarning';
					} else {
						# Then it must be protected based on static groups (regular)
						$noticeMsg = 'protectedpagewarning';
					}

					$notices[] = $this->msg( $noticeMsg )->parseAsBlock() .
						$this->getLastLogEntry( $page, 'protect' );
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
					} elseif ( $targetUser->isBlocked() ) { // Show log extract if the user is currently blocked
						$notices[] = $this->msg(
							'blocked-notice-logextract',
							$targetUser->getName() // Support GENDER in notice
						)->parseAsBlock() . $this->getLastLogEntry( $targetUser->getUserPage(), 'block' );
					}
				}

				if ( $user->isBlockedFrom( $page ) && $user->getBlock()->prevents( 'edit' ) !== false ) {
					$notices[] = call_user_func_array(
						array( $this, 'msg' ),
						$user->getBlock()->getPermissionsError( $this->getContext() )
					)->parseAsBlock();
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

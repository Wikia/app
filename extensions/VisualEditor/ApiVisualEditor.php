<?php
/**
 * Parsoid API wrapper.
 *
 * @file
 * @ingroup Extensions
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

class ApiVisualEditor extends ApiBase {
	// These are safe even if VE is not enabled on the page.
	// This is intended for other VE interfaces, such as Flow's.
	protected static $SAFE_ACTIONS = array(
		'parsefragment',
	);

	/**
	 * @var Config
	 */
	protected $veConfig;

	/**
	 * @var VirtualRESTServiceClient
	 */
	protected $serviceClient;

	public function __construct( ApiMain $main, $name ) {
		parent::__construct( $main, $name );
		// Wikia change begin, @author: Paul Oslund
		$this->veConfig = ConfigFactory::getDefaultInstance()->makeConfig( 'visualeditor' );

		// NOTE: These are temporarily commented out
		// $this->serviceClient = new VirtualRESTServiceClient( new MultiHttpClient( array() ) );
		// $this->serviceClient->mount( '/parsoid/', $this->getVRSObject() );
		// Wikia change end
	}

	/**
	 * Returns the version information of this file
	 *
	 * @return array
	 */
	public function getVersion() {
		$vers = array();
		$vers[] = __CLASS__ . ': $Id: ApiVisualEditor.php $';
		return $vers;
	}

	/**
	 * Creates the virtual REST service object to be used in VE's API calls. The
	 * method determines whether to instantiate a ParsoidVirtualRESTService or a
	 * RestbaseVirtualRESTService object based on configuration directives: if
	 * $wgVirtualRestConfig['modules']['restbase'] is defined, RESTBase is chosen,
	 * otherwise Parsoid is used (either by using the MW Core config, or the
	 * VE-local one).
	 *
	 * @return VirtualRESTService the VirtualRESTService object to use
	 */
	private function getVRSObject() {
		// the params array to create the service object with
		$params = array();
		// the VRS class to use, defaults to Parsoid
		$class = 'ParsoidVirtualRESTService';
		$config = $this->veConfig;
		// the global virtual rest service config object, if any
		$vrs = $this->getConfig()->get( 'VirtualRestConfig' );
		if ( isset( $vrs['modules'] ) && isset( $vrs['modules']['restbase'] ) ) {
			// if restbase is available, use it
			$params = $vrs['modules']['restbase'];
			$class = 'RestbaseVirtualRESTService';
			// remove once VE generates restbase paths
			$params['parsoidCompat'] = true;
		} elseif ( isset( $vrs['modules'] ) && isset( $vrs['modules']['parsoid'] ) ) {
			// there's a global parsoid config, use it next
			$params = $vrs['modules']['parsoid'];
		} else {
			// no global modules defined, fall back to old defaults
			$params = array(
				'URL' => $config->get( 'VisualEditorParsoidURL' ),
				'prefix' => $config->get( 'VisualEditorParsoidPrefix' ),
				'timeout' => $config->get( 'VisualEditorParsoidTimeout' ),
				'HTTPProxy' => $config->get( 'VisualEditorParsoidHTTPProxy' ),
				'forwardCookies' => $config->get( 'VisualEditorParsoidForwardCookies' )
			);
		}
		// merge the global and service-specific params
		if ( isset( $vrs['global'] ) ) {
			$params = array_merge( $vrs['global'], $params );
		}
		// set up cookie forwarding
		if ( $params['forwardCookies'] && !User::isEveryoneAllowed( 'read' ) ) {
			$params['forwardCookies'] = RequestContext::getMain()->getRequest()->getHeader( 'Cookie' );
		} else {
			$params['forwardCookies'] = false;
		}
		// create the VRS object and return it
		return new $class( $params );
	}

	// Wikia change begin, @author: Paul Oslund
	/**
	 * These functions are legacy code brought in to make the legacy version of
	 * requestParsoid work. The goal is to revert requestParsoid to be the
	 * updated version, however it requires a large amount of extra work around
	 * bringing in VirtualRestService
	 */

	/**
	 * @protected
	 * @description Simple helper to retrieve relevant api uri
	 * @return String
	 */
	protected function getApiSource() {
		return wfExpandUrl( wfScript( 'api' ) );
	}

	/**
	 * Parsoid HTTP proxy configuration for MWHttpRequest
	 */
	protected function getProxyConf() {
		global $wgDevelEnvironment;
		$parsoidHTTPProxy = $this->veConfig->get( 'VisualEditorParsoidHTTPProxy' );
		if ( $parsoidHTTPProxy ) {
			return array( 'proxy' => $parsoidHTTPProxy );
		} else {
			return array( 'noProxy' => !empty( $wgDevelEnvironment ) );
		}
	}
	// Wikia change end

	private function requestParsoid( $method, $path, $params ) {
		// Wikia change begin, @author: Paul Oslund
		// NOTE: This was temporarily reverted back to the old version of
		//       requestParsoid to get the API response to work. The goal is to
		//       update to the new version, however that requires VRS heavily
		$url = $this->veConfig->get( 'VisualEditorParsoidURL' ) . '/' .
			urlencode( $this->getApiSource() ) . '/' .
			$path;
		$data = array_merge(
			$this->getProxyConf(),
			array(
				'method' => $method,
				'timeout' => $this->veConfig->get( 'VisualEditorParsoidTimeout' ),
			)
		);

		if ( $method === 'POST' ) {
			$data['postData'] = $params;
		} else {
			$url = wfAppendQuery( $url, $params );
		}

		$req = MWHttpRequest::factory( $url, $data );
		// Forward cookies, but only if configured to do so and if there are read restrictions
		if ( $this->veConfig->get( 'VisualEditorParsoidForwardCookies' )
			&& !User::isEveryoneAllowed( 'read' )
		) {
			$req->setHeader( 'Cookie', $this->getRequest()->getHeader( 'Cookie' ) );
		}
		$status = $req->execute();
		if ( $status->isOK() ) {
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
			$this->dieUsage( $req->getContent(), 'parsoidserver-http-' . $req->getStatus() );
		} elseif ( $errors = $status->getErrorsByType( 'error' ) ) {
			$error = $errors[0];
			$code = $error['message'];
			if ( count( $error['params'] ) ) {
				$message = $error['params'][0];
			} else {
				$message = 'MWHttpRequest error';
			}
			$this->dieUsage( "$message: " . $req->getContent(), 'parsoidserver-' . $code );
		}
		// TODO pass through X-Parsoid-Performance header, merge with getHTML above
		return $req->getContent();
		// Wikia change end
	}

	protected function storeInSerializationCache( $title, $oldid, $html ) {
		global $wgMemc;

		// Convert the VE HTML to wikitext
		$text = $this->postHTML( $title, $html, array( 'oldid' => $oldid ) );
		if ( $text === false ) {
			return false;
		}

		// Store the corresponding wikitext, referenceable by a new key
		$hash = md5( $text );
		$key = wfMemcKey( 'visualeditor', 'serialization', $hash );
		$wgMemc->set( $key, $text,
			$this->veConfig->get( 'VisualEditorSerializationCacheTimeout' ) );

		// Also parse and prepare the edit in case it might be saved later
		$page = WikiPage::factory( $title );
		$content = ContentHandler::makeContent( $text, $title, CONTENT_MODEL_WIKITEXT );

		$res = ApiStashEdit::parseAndStash( $page, $content, $this->getUser() );
		if ( $res === ApiStashEdit::ERROR_NONE ) {
			wfDebugLog( 'StashEdit', "Cached parser output for VE content key '$key'." );
		}

		return $hash;
	}

	protected function trySerializationCache( $hash ) {
		global $wgMemc;
		$key = wfMemcKey( 'visualeditor', 'serialization', $hash );
		return $wgMemc->get( $key );
	}

	protected function postHTML( $title, $html, $parserParams ) {
		if ( $parserParams['oldid'] === 0 ) {
			$parserParams['oldid'] = '';
		}
		return $this->requestParsoid(
			'POST',
			'transform/html/to/wikitext/' . urlencode( $title->getPrefixedDBkey() ),
			array(
				'html' => $html,
				'oldid' => $parserParams['oldid'],
				'scrubWikitext' => 1,
			)
		);
	}

	protected function pstWikitext( $title, $wikitext ) {
		return ContentHandler::makeContent( $wikitext, $title, CONTENT_MODEL_WIKITEXT )
			->preSaveTransform(
				$title,
				$this->getUser(),
				WikiPage::factory( $title )->makeParserOptions( $this->getContext() )
			)
			->serialize( 'text/x-wiki' );
	}

	protected function parseWikitextFragment( $title, $wikitext ) {
		return $this->requestParsoid(
			'POST',
			'transform/wikitext/to/html/' . urlencode( $title->getPrefixedDBkey() ),
			array(
				'wikitext' => $wikitext,
				'body' => 1,
			)
		);
	}

	protected function diffWikitext( $title, $wikitext ) {
		$apiParams = array(
			'action' => 'query',
			'prop' => 'revisions',
			'titles' => $title->getPrefixedDBkey(),
			'rvdifftotext' => $this->pstWikitext( $title, $wikitext )
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
		if ( defined( 'ApiResult::META_CONTENT' ) ) {
			$result = $api->getResult()->getResultData( null, array(
				'BC' => array(), // Transform content nodes to '*'
				'Types' => array(), // Add back-compat subelements
			) );
		} else {
			$result = $api->getResultData();
		}
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
					$context->msg( 'currentrev' )->parse(),
					$context->msg( 'yourtext' )->parse()
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
		if ( defined( 'ApiResult::META_CONTENT' ) ) {
			$result = $api->getResult()->getResultData( null, array(
				'BC' => array(), // Backwards-compatible structure transformations
				'Types' => array(), // Backwards-compatible structure transformations
				'Strip' => 'all', // Remove any metadata keys from the langlinks array
			) );
		} else {
			$result = $api->getResultData();
		}
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

	public function execute() {
		$user = $this->getUser();
		$params = $this->extractRequestParams();

		$title = Title::newFromText( $params['page'] );
		if ( !$title ) {
			$this->dieUsageMsg( 'invalidtitle', $params['page'] );
		}

		$isSafeAction = in_array( $params['paction'], self::$SAFE_ACTIONS, true );

		$availableNamespaces = $this->veConfig->get( 'VisualEditorAvailableNamespaces' );
		if ( !$isSafeAction && (
			!isset( $availableNamespaces[$title->getNamespace()] ) ||
			!$availableNamespaces[$title->getNamespace()]
		) ) {

			$this->dieUsage( "VisualEditor is not enabled in namespace " .
				$title->getNamespace(), 'novenamespace' );
		}

		$parserParams = array();
		if ( isset( $params['oldid'] ) ) {
			$parserParams['oldid'] = $params['oldid'];
		}

		$html = $params['html'];
		if ( substr( $html, 0, 11 ) === 'rawdeflate,' ) {
			$deflated = base64_decode( substr( $html, 11 ) );
			wfSuppressWarnings();
			$html = gzinflate( $deflated );
			wfRestoreWarnings();
			if ( $deflated === $html || $html === false ) {
				$this->dieUsage( "HTML provided is not properly deflated", 'invaliddeflate' );
			}
		}

		wfDebugLog( 'visualeditor', "called on '$title' with paction: '{$params['paction']}'" );
		switch ( $params['paction'] ) {
			case 'parse':
			case 'metadata':
				// Dirty hack to provide the correct context for edit notices
				global $wgTitle; // FIXME NOOOOOOOOES
				$wgTitle = $title;
				RequestContext::getMain()->setTitle( $title );

				// Get information about current revision
				if ( $title->exists() ) {
					$latestRevision = Revision::newFromTitle( $title );
					if ( $latestRevision === null ) {
						$this->dieUsage( 'Could not find latest revision for title', 'latestnotfound' );
					}
					$revision = null;
					if ( !isset( $parserParams['oldid'] ) || $parserParams['oldid'] === 0 ) {
						$parserParams['oldid'] = $latestRevision->getId();
						$revision = $latestRevision;
					} else {
						$revision = Revision::newFromId( $parserParams['oldid'] );
						if ( $revision === null ) {
							$this->dieUsage( 'Could not find revision ID ' . $parserParams['oldid'], 'oldidnotfound' );
						}
					}

					$restoring = $revision && !$revision->isCurrent();
					$baseTimestamp = $latestRevision->getTimestamp();
					$oldid = intval( $parserParams['oldid'] );

					// If requested, request HTML from Parsoid
					if ( $params['paction'] === 'parse' ) {
						$content = $this->requestParsoid(
							'GET',
							'page/' . urlencode( $title->getPrefixedDBkey() ) . '/html',
							$parserParams
						);
						if ( $content === false ) {
							$this->dieUsage( 'Error contacting the Parsoid server', 'parsoidserver' );
						}
					}

				} else {
					$content = '';
					$baseTimestamp = wfTimestampNow();
					$oldid = 0;
					$restoring = false;
				}

				// Get edit notices
				// $notices = $title->getEditNotices();

				// Anonymous user notice
				if ( $user->isAnon() ) {
					$notices[] = $this->msg(
						'anoneditwarning',
						// Log-in link
						'{{fullurl:Special:UserLogin|returnto={{FULLPAGENAMEE}}}}',
						// Sign-up link
						'{{fullurl:Special:UserLogin/signup|returnto={{FULLPAGENAMEE}}}}'
					)->parseAsBlock();
				}

				// Old revision notice
				if ( $restoring ) {
					$notices[] = $this->msg( 'editingold' )->parseAsBlock();
				}

				// New page notices
				if ( !$title->exists() ) {
					$notices[] = $this->msg(
						$user->isLoggedIn() ? 'newarticletext' : 'newarticletextanon',
						wfExpandUrl( Skin::makeInternalOrExternalUrl(
							$this->msg( 'helppage' )->inContentLanguage()->text()
						) )
					)->parseAsBlock();
					// Page protected from creation
					if ( $title->getRestrictions( 'create' ) ) {
						$notices[] = $this->msg( 'titleprotectedwarning' )->parseAsBlock();
					}
				}

				// Look at protection status to set up notices + surface class(es)
				$protectedClasses = array();
				if ( MWNamespace::getRestrictionLevels( $title->getNamespace() ) !== array( '' ) ) {
					// Page protected from editing
					if ( $title->isProtected( 'edit' ) ) {
						# Is the title semi-protected?
						if ( $title->isSemiProtected() ) {
							$protectedClasses[] = 'mw-textarea-sprotected';

							$noticeMsg = 'semiprotectedpagewarning';
						} else {
							$protectedClasses[] = 'mw-textarea-protected';

							# Then it must be protected based on static groups (regular)
							$noticeMsg = 'protectedpagewarning';
						}
						$notices[] = $this->msg( $noticeMsg )->parseAsBlock() .
						$this->getLastLogEntry( $title, 'protect' );
					}

					// Deal with cascading edit protection
					list( $sources, $restrictions ) = $title->getCascadeProtectionSources();
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

				// Permission notice
				if ( !$title->userCan( 'create' ) && !$title->exists() ) {
					$notices[] = $this->msg(
						'permissionserrorstext-withaction', 1, $this->msg( 'action-createpage' )
					) . "<br>" . $this->msg( 'nocreatetext' )->parse();
				}

				// Show notice when editing user / user talk page of a user that doesn't exist
				// or who is blocked
				// HACK of course this code is partly duplicated from EditPage.php :(
				if ( $title->getNamespace() == NS_USER || $title->getNamespace() == NS_USER_TALK ) {
					$parts = explode( '/', $title->getText(), 2 );
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

				// Blocked user notice
				if ( $user->isBlockedFrom( $title ) && $user->getBlock()->prevents( 'edit' ) !== false ) {
					$notices[] = call_user_func_array(
						array( $this, 'msg' ),
						$user->getBlock()->getPermissionsError( $this->getContext() )
					)->parseAsBlock();
				}

				// Blocked user notice for global blocks
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
				$article = new Article( $title ); // Deliberately omitting ,0 so oldid comes from request
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
				$wikipage = WikiPage::factory( $title );
				$popts = $wikipage->makeParserOptions( 'canonical' );
				$cached = ParserCache::singleton()->get( $article, $popts, true );
				$links = array(
					// Array of linked pages that are missing
					'missing' => array(),
					// For current revisions: 1 (treat all non-missing pages as known)
					// For old revisions: array of linked pages that are known
					'known' => $restoring || !$cached ? array() : 1,
				);
				if ( $cached ) {
					foreach ( $cached->getLinks() as $namespace => $cachedTitles ) {
						foreach ( $cachedTitles as $cachedTitleText => $exists ) {
							$cachedTitle = Title::makeTitle( $namespace, $cachedTitleText );
							if ( !$cachedTitle->isKnown() ) {
								$links['missing'][] = $cachedTitle->getPrefixedText();
							} elseif ( $links['known'] !== 1 ) {
								$links['known'][] = $cachedTitle->getPrefixedText();
							}
						}
					}
				}
				// Add information about current page
				if ( !$title->isKnown() ) {
					$links['missing'][] = $title->getPrefixedText();
				} elseif ( $links['known'] !== 1 ) {
					$links['known'][] = $title->getPrefixedText();
				}

				// On parser cache miss, just don't bother populating red link data

				$result = array(
					'result' => 'success',
					'notices' => $notices,
					'checkboxes' => $checkboxes,
					'links' => $links,
					'protectedClasses' => implode( ' ', $protectedClasses ),
					'watched' => $user->isWatched( $title ),
					'basetimestamp' => $baseTimestamp,
					'starttimestamp' => wfTimestampNow(),
					'oldid' => $oldid,

				);
				if ( $params['paction'] === 'parse' ) {
					$result['content'] = $content;
				}
				break;

			case 'parsefragment':
				$wikitext = $params['wikitext'];
				if ( $params['pst'] ) {
					$wikitext = $this->pstWikitext( $title, $wikitext );
				}
				$content = $this->parseWikitextFragment( $title, $wikitext );
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
					$content = $this->postHTML( $title, $html, $parserParams );
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
					$wikitext = $this->postHTML( $title, $html, $parserParams );
					if ( $wikitext === false ) {
						$this->dieUsage( 'Error contacting the Parsoid server', 'parsoidserver' );
					}
				}

				$diff = $this->diffWikitext( $title, $wikitext );
				if ( $diff['result'] === 'fail' ) {
					$this->dieUsage( 'Diff failed', 'difffailed' );
				}
				$result = $diff;

				break;

			case 'serializeforcache':
				if ( !isset( $parserParams['oldid'] ) ) {
					$parserParams['oldid'] = Revision::newFromTitle( $title )->getId();
				}
				$key = $this->storeInSerializationCache( $title, $parserParams['oldid'], $html );
				$result = array( 'result' => 'success', 'cachekey' => $key );
				break;

			case 'getlanglinks':
				$langlinks = $this->getLangLinks( $title );
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
	 * @return string
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
				ApiBase::PARAM_DFLT => 'jsonfm',
				ApiBase::PARAM_TYPE => array( 'json', 'jsonfm' ),
			),
			'paction' => array(
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_TYPE => array(
					'parse',
					'metadata',
					'parsefragment',
					'serialize',
					'serializeforcache',
					'diff',
					'getlanglinks',
				),
			),
			'wikitext' => null,
			'oldid' => null,
			'html' => null,
			'cachekey' => null,
			'pst' => false,
		);
	}

	public function needsToken() {
		return false;
	}

	public function mustBePosted() {
		return false;
	}

	public function isInternal() {
		return true;
	}

	public function isWriteMode() {
		return true;
	}

	/**
	 * @deprecated since MediaWiki core 1.25
	 */
	public function getParamDescription() {
		return array(
			'page' => 'The page to perform actions on.',
			'paction' => 'Action to perform',
			'oldid' => 'The revision number to use (defaults to latest version).',
			'html' => 'HTML to send to Parsoid to convert to wikitext',
			'wikitext' => 'Wikitext to send to Parsoid to convert to HTML (paction=parsefragment)',
			'pst' => 'Pre-save transform wikitext before sending it to Parsoid (paction=parsefragment)',
			'cachekey' => 'For serialize or diff, use the result of a previous serializeforcache'
				. ' request with this key. Overrides html.',
		);
	}

	/**
	 * @deprecated since MediaWiki core 1.25
	 */
	public function getDescription() {
		return 'Returns HTML5 for a page from the parsoid service.';
	}
}

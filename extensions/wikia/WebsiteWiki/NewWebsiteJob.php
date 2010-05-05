<?php

/**
 * NeueWebsiteJob -- actual work on new web site
 *
 * @file
 * @ingroup JobQueue
 *
 * @copyright Copyright © Krzysztof Krzyżaniak for Wikia Inc.
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 * @date 2010-03-15
 * @version 1.0
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class NewWebsiteJob extends Job {

	private
		$mDebug,
		$mTargetUrl,
		$mHeaders,
		$mBody,
		$mUserAgent,
		$mRelated,
		$mDomain,
		$mIsRedirect,
		$mRedirectUrl;

	/**
	 * constructor
	 *
	 * @access public
	 */
	public function __construct( $title, $params, $id = 0 ) {

		global $wgContLang;

		parent::__construct( "newsite", $title, $params, $id );

		/**
		 * init for local stuffs
		 */
		$this->mDomain    = $wgContLang->lc( $this->title->getDBKey() );
		$this->mTargetUrl = sprintf( "http://%s/", $this->mDomain );
		$this->mParams    = $params;
		$this->mBody      = "";
		$this->mHeaders   = array();
		$this->mUserAgent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; de; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3 (.NET CLR 3.5.30729)";
		$this->mDebug     = true;
	}

	/**
	 * main entry point
	 *
	 * @access public
	 */
	public function run() {
		global $wgUser, $wgOut, $wgContLang, $wgTitle;

		wfProfileIn( __METHOD__ );

		/**
		 * overwrite $wgTitle
		 */
		$wgTitle = $this->title;

		/**
		 * keep article or not
		 */
		$delete = false;

		wfLoadExtensionMessages( 'Newsite' );

		/**
		 * build url
		 */
		Wikia::log( __METHOD__, false, "target url {$this->mTargetUrl}" );

		$page = Http::get(
			$this->mTargetUrl,
			"default",
			array(
				CURLOPT_HEADER         => 1,
				CURLOPT_USERAGENT      => $this->mUserAgent,
				CURLOPT_FOLLOWLOCATION => 1,
				CURLOPT_MAXREDIRS      => 5
			)
		);
		if( $page ) {
			/**
			 *  split headers and rest of body
			 */
			$page = preg_replace( "/\r\n/ms", "\n", $page );
			preg_match_all( "|HTTP/\d\.\d \d+.+\n\n|Ums", $page, $location );
			$index    = 0;
			$sections = array_shift( $location );
			$headers  = array();
			foreach( $sections as $section ) {
				$headers[ $index ] = array();

				foreach( explode( "\n", $section ) as $line ) {
					/**
					 * check for status and store it as HTTP-Status
					 */
					if( preg_match( "|HTTP/\d\.\d (\d+)|", $line, $matches ) ) {
						$headers[ $index ][ "HTTP-Status"] = trim( $matches[ 1 ] );
					}
					else {
						preg_match( "/([^:]+):(.+)/", $line, $matches );
						if( isset( $matches[ 1 ] ) && isset( $matches[ 2 ] ) ) {
							$headers[ $index ][ $matches[ 1 ] ] = trim( $matches[ 2 ] );
						}
					}
				}
				$index++;
			}
			/**
			 * check redirects
			 */
			foreach( $headers as $header ) {
				if( isset( $header[ "HTTP-Status" ] ) && preg_match( "/^30/", $header[ "HTTP-Status" ] ) ) {
					/**
					 * there is redirect! but maybe it is internal redirect
					 */
					if( isset( $header[ "Location" ] ) ) {
						/**
						 * check if url has protocol or is just file redirect,
						 * actually we handle only http requests
						 */
						if( preg_match( "|^http://|", $header[ "Location" ] ) ) {
							$target = self::normalizeDomain( $header[ "Location" ] );
							if( $this->mDomain != $target ) {
								/**
								 * external redirect to another domain
								 */
								$this->mIsRedirect  = true;
								$this->mRedirectUrl = $target;
								Wikia::log( __METHOD__, "redir", "External redirect to {$target}" );
							}
							else {
								Wikia::log( __METHOD__, "redir", "Internal redirect to {$target}" );
							}
						}
						else {
							$target = $header[ "Location" ];
							Wikia::log( __METHOD__, "redir", "Internal redirect to {$target}" );
						}
					}
				}
			}

			/**
			 * only last headers section is interesting
			 */
			$this->mHeaders = array_pop( $headers );
			$this->mBody = $page;

			$this->makeRelated();
			$this->makeArticle();

			/**
			 * do not make thumbnails for redirects
			 */
			if( !$this->mIsRedirect ) {
				$this->makeThumbnail();
			}
		}
		else {
			$delete  = true;
			$message = wfMsg( 'newsite-error-nocontact', $this->mDomain );
		}

		if( $delete ) {
			/**
			 * remove article
			 */
			$article = new Article( $this->title, 0 );
			$article->doDeleteArticle( $message );
			Wikia::log( __METHOD__, false, "Delete article about {$this->mTargetUrl}" );
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * create article from gathered information
	 *
	 * @author Krzysztof Krzyżaniak (eloy)
	 * @access private
	 */
	private function makeArticle() {
		global $wgContLang;

		wfProfileIn( __METHOD__ );

		$text = "";
		$metainfo = $this->getMetaInfo();

		/**
		 * if external redirect add redirect page and add job if target does not
		 * exists
		 */
		if( $this->mIsRedirect ) {
			$text = sprintf( "#redirect %s", $this->wikilink( $this->mRedirectUrl ) );
			/**
			 * check if target page exists, if not add another task to make it
			 * but first make placeholder!
			 */
			$redirTitle = Title::makeTitle( NS_MAIN, $this->mRedirectUrl );
			$article = new Article( $redirTitle, 0 );
			if( ! $article->exists( ) ) {

				/**
				 * create page
				 */
				$article->doEdit( wfMsg( 'newsite-article-placeholder'), wfMsg( 'newsite-article-placeholder-log' ) );

				$job = new NewWebsiteJob( $redirTitle, array() );
				$job->insert();
				Wikia::log( __METHOD__, "info", "job added" );
			}
		}
		else {

			$text .= WSINFO_PLACEHOLDER . "\n";

			if( isset( $metainfo[ "title"] ) ) {
				$text .= sprintf("'''%s'''\n\n", $metainfo[ "title"] );
			}

			if( isset( $metainfo[ "description"] ) && strcmp( $metainfo[ "title"], $metainfo[ "description"] ) ) {
				$text .= sprintf( "%s\n%s\n\n",
					wfMsgForContent( 'newsite-output-description' ),
					$metainfo[ "description"]
				);
			}


			if( isset( $metainfo[ "error" ] ) && $metainfo[ "error" ] >= 400 ) {
				$text .= wfMsgForContent( 'newsite-output-status' ) . "\n";
				$text .=  wfMsgForContent( 'newsite-output-status-error', $this->wikilink( $metainfo[ "error" ] ) ) . "\n";
			}

			/**
			 * technology
			 */
			$text .= wfMsgForContent( 'newsite-output-technology' ) . "\n";
			$text .= wfMsgForContent( 'newsite-output-technology-content' ) . "\n";

			if( stristr( $this->mBody, "<frameset" ) ) {
				$text .= wfMsgForContent( 'newsite-output-technology-content-framesets' ) . "\n";
			}

			if( stristr( $this->mBody, "<iframe" ) ) {
				$text .= wfMsgForContent( 'newsite-output-technology-content-iframes' ) . "\n";
			}
			if( stristr( $this->mBody, "<script" ) ) {
				$text .= wfMsgForContent( 'newsite-output-technology-content-scripts' ) . "\n";
			}

			$text .= wfMsgForContent( 'newsite-output-technology-content-charset', $this->wikilink( $metainfo[ "charset"] ) ) . "\n";

			if( isset( $metainfo[ "generator" ] ) ) {
				$text .= wfMsgForContent( 'newsite-output-technology-content-generator', $this->wikilink( $metainfo[ "generator" ] ) ) . "\n";
			}

			if( isset( $metainfo[ "server" ] ) ) {
				$text .= wfMsgForContent( 'newsite-output-technology-server' ) . "\n";
				$text .= wfMsgForContent( 'newsite-output-technology-server-webserver', $this->wikilink( $metainfo[ "server" ], false) ) . "\n";
			}

			if( isset( $metainfo[ "system" ] ) ) {
				$text .= wfMsgForContent( 'newsite-output-technology-server-os', $this->wikilink( $metainfo[ "system" ] ) ) . "\n";
			}
			if( isset( $metainfo[ "server-components" ] ) && count( $metainfo[ "server-components" ] ) ) {
				 $text .= wfMsgForContent( 'newsite-output-technology-server-components' ) . "\n";
				 foreach( $metainfo[ "server-components" ] as $component ) {
					 $text .= "**" . $this->wikilink( $component, false) . "\n";
				 }
			}

			if( isset( $metainfo[ "keywords" ] ) ) {
				$text .= wfMsgForContent( 'newsite-output-keywords', $wgContLang->ucfirst( $this->mDomain ) ) . "\n";
				$text .= Xml::openElement( "keywords" );
				$text .= implode( ", ", $metainfo[ "keywords" ] );
				$text .= Xml::closeElement( "keywords" );
				$text .= "\n";
			}

			/**
			 * related info
			 */
			if( count( $this->mRelated ) ) {
				$text .= wfMsgForContent( 'newsite-output-related' ) . "\n";
				$text .= Xml::openElement( "span", array( "class" => "small" ) );
				foreach( $this->mRelated as $site ) {
					$text .= $this->wikilink( $site );
					$text .= " ";
				}
				$text .= Xml::closeElement( "span" );
				$text .= "\n";
			}
		}
		$article = new Article( $this->title, 0 );
		$article->doEdit( $text, wfMsg( "newsite-article-created", $this->mDomain ) );
		wfProfileOut( __METHOD__ );
	}

	/**
	 * get info from HTML body
	 *
	 * @access private
	 */
	private function getMetaInfo() {

		$info = array();

		/**
		 * get charset, first from headers then from meta
		 */
		if( isset( $this->mHeaders[ "Content-Type" ] ) && preg_match( "|charset=([\w\d\-]+)|", $this->mHeaders[ "Content-Type" ], $match ) ) {
			$info[ "charset" ] = $match[ 1 ];
		}
		else {
			/**
			 * check meta headers
			 */
		    if(	preg_match( "|<meta.*charset=([\w\d\-]+)|i", $this->mBody, $match ) )  {
				$info[ "charset" ] = $match[ 1 ];
			}
			else {
				$info[ "charset" ] = "iso-8859-1";
			}
		}
		/**
		 * get title
		 */
		if( preg_match("|<title>([^<]*)</title>|i", $this->mBody, $match ) ) {
			$match[ 1 ] = $this->webclean( $match[ 1 ], $info[ "charset" ] );
			$info[ "title" ] = $match[ 1 ];
		}

		/**
		 * get description
		 */
		if( preg_match( "|<META[^>]*name=\"description\"[^>]*content=\"([^\"]*)\"[^>]*>|i", $this->mBody, $match ) ||
			preg_match( "|<META[^>]*content=\"([^\"]*)\"[^>]*name=\"description\"[^>]*>|i", $this->mBody, $match )) {
			$info[ "description" ] = $this->webclean( $match[ 1 ], $info[ "charset" ] );
		}

		/**
		 * get keywords
		 */
		if( preg_match( "|<META[^>]*name=\"keywords\"[^>]*content=\"([^\"]*)\"[^>]*>|i", $this->mBody, $match ) ||
			preg_match( "|<META[^>]*content=\"([^\"]*)\"[^>]*name=\"keywords\"[^>]*>|i", $this->mBody, $match )) {
			if( isset( $match[ 1 ] ) ) {
				$match[ 1 ] = $this->webclean( $match[ 1 ], $info[ "charset" ] );
				$info[ "keywords" ] = preg_split( "/[\s;,]/", $match[ 1 ] );
			}
		}

		/**
		 * get generator
		 */
		if( preg_match( "|<META[^>]*name=\"generator\"[^>]*content=\"([^\">\n]*)\"[^>\n]*>|i", $this->mBody, $match ) ||
			preg_match( "|<META[^>]*content=\"([^\"]*)\"[^>]*name=\"generator\"[^>]*>|i", $this->mBody, $match )) {
			$match[ 1 ] = $this->webclean( $match[ 1 ], $info[ "charset" ] );
			$info[ "generator" ] = $match[ 1 ];
		}

		/**
		 * get redirect via meta tag
		 */
		if( preg_match( "|<META[^>]*http-equiv=\"Refresh\"[^>]*content=\"[^uU]*url=http://([^\"]*)\"[^>]*>|i", $this->mBody, $match ) ||
			preg_match( "|<META[^>]*content=\"[^uU]*url=http://([^\"]*)\"[^>]*http-equiv=\"Refresh\"[^>]*>|i", $this->mBody, $match )) {
			$info[ "metaredir" ] = $match[ 1 ];
		}


		/**
		 * check agains errors
		 */
		if( isset( $this->mHeaders[ "HTTP-Status" ] ) ) {
			$info[ "error" ] = $this->mHeaders[ "HTTP-Status" ];
		}

		/**
		 * technology
		 */
		if( isset( $this->mHeaders[ "Server" ] ) ) {
			$parts = explode( " ", $this->mHeaders[ "Server" ], 2 );
			if( isset( $parts[ 0 ] ) ) {
				$info[ "server" ] = $parts[ 0 ];
			}

			/**
			 * if apache check for more information
			 */
			if( preg_match( "/^Apache/", $this->mHeaders[ "Server" ] ) ) {
				$info[ "server" ] = "Apache";
				if( preg_match( "/^Apache[^\(]+\(([^\)]+)\)(.*)/", $this->mHeaders[ "Server" ], $match  ) ) {
					if( isset( $match[ 1 ] ) ) {
						$info[ "system" ] = $match[ 1 ];
					}
					if( isset( $match[ 2 ] ) ) {
						$info[ "server-components" ] = array();
						foreach( explode( " ", $match[ 2 ] ) as $c ) {
							/**
							 * skip empty values
							 */
							if( strlen( trim( $c ) ) ) {
								$info[ "server-components" ][] = trim( $c );
							}
						}
					}
				}
			}
			elseif( stristr( $this->mHeaders[ "Server" ], "Microsoft") ) {
				$info[ "system" ] = "Windows";
		    }
		}
		return $info;
	}

	/**
	 * create thumbnail for web site
	 */
	private function makeThumbnail() {

		wfProfileIn( __METHOD__ );

		$job = new SiteThumbnailJob( $this->title, array() );
		$job->insert();
		Wikia::log( __METHOD__, "info", sprintf( "SiteThumbnailJob for %s added", $this->title->getDBKey( ) ) );


		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * make related pages data using google related info
	 *
	 * @access private
	 *
	 * @param String $domain -- domain name we search google against
	 * @param String $key -- primary key used in table related
	 *
	 * @todo change to multiline insert
	 * @todo change to english google
	 * @todo check what is in $exDomainList
	 * @todo replace ereg with preg_match
	 */
	private function makeRelated() {
		global $exDomainList;

		/**
		 * curl doesn't work, google is blocking somehow it
		 */
		$go = Http::get(
			"http://www.google.de/ie?safe=off&q=related%3A{$this->mDomain}&hl=de&start=0&num=30&sa=N",
			"default",
			array(
				CURLOPT_HEADER         => 1,
				CURLOPT_USERAGENT      => $this->mUserAgent,
				CURLOPT_FOLLOWLOCATION => 1,
				CURLOPT_MAXREDIRS      => 5
			)
		);

		$this->mRelated = array();

		if( !strstr( $go, "keine mit Ihrer Suchanfrage" ) ) {
			$matches = array();
			$newmatches = array();
			preg_match_all( '|http://([^/]+)/|', $go, $matches );
			$matches = $matches[ 1 ];

			foreach( $matches as $match ) {
				/**
				 * only valid domain names
				 */
				if( !preg_match( "/[\d\w\.\-]+/", $match ) ) {
					continue;
				}
				$n = strtolower($match);
				if( !strncmp( $n, "www.", 4 ) ) {
					$n = substr($n, 4);
					if( preg_match( "/{$exDomainList}/", $n ) && stripos($n, "google") === false ) {
						$newmatches[] = $n;
					}
				}

				$this->mRelated = array_unique( $newmatches );
			}
		}
		else {
			echo "0 related sites\n";
		}
	}

	/**
	 * create safe string
	 *
	 * @access private
	 */
	private function webclean( $str, $cset ) {
		global $wgContLang;

		$cset = $wgContLang->uc( $cset );

		if( $cset != "UTF-8" ) {
			$str = @iconv( $cset, "UTF-8//IGNORE", $str );
		}

		$str = strip_tags( $str );
		$str = preg_replace( "|[ ]+|", " ", $str);
		$str = html_entity_decode( $str, ENT_QUOTES, "utf-8");
		$str = htmlspecialchars( $str, ENT_QUOTES, "utf-8");

		return $str;
	}

	/**
	 * create link to wiki article
	 */
	private function wikilink( $str, $lower = true ) {
		global $wgContLang;

		$str = trim($str);
		if( $lower ) {
			$str = $wgContLang->lc($str );
		}
		$str = $wgContLang->ucfirst( $str );
	    return "[[{$str}]]";
	}


	/**
	 * lowercase, remove protocol and request uri and remove www
	 *
	 * @access public
	 * @static
	 *
	 * @return string with normalized url
	 */
	static public function normalizeDomain( $url ) {
		global $wgContLang;

		$url = $wgContLang->lc( $url );
		if( preg_match( "|[^:]+://([^/]+)/*|", $url, $match ) ) {
			if( isset( $match[ 1 ] ) ) {
				$url = $match[ 1 ];
			}
		}
		$url = preg_replace( "/^www\./", "", $url );

		return $url;
	}
}

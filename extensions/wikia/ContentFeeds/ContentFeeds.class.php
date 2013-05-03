<?php

class ContentFeeds {

	public static $wikiTweetsTagCount = 0;
	public static $userTweetsTagCount = 0;

	private static function extractArgs( $args ) {
		global $wgContLang;

		$limit = 5;
		$ns = array();

		foreach($args as $argName => $argValue) {
			switch($argName) {
				case 'size':
					$limit = intval($argValue);
					break;
				case 'ns':
					foreach(explode(',', $argValue) as $nsText) {
						$nsIndex = $wgContLang->getNsIndex(strtr($nsText," ", "_"));
						if( !in_array($nsIndex, $ns) ) {
							$ns[] = empty($nsIndex) ? 0 : $nsIndex;
						}
					}
					break;
			}
		}

		return array( 'limit' => $limit, 'ns' => $ns );
	}

	/**
	 * parser hook for <mostvisited> tag
	 * @return string tag body
	 */
	public static function mostVisitedParserHook( $input, $args, $parser ) {
		$args = self::extractArgs( $args );

		$tagBody = '<ul class="cfMostVisitedTag">';
		foreach ( DataProvider::singleton()->GetMostVisitedArticles( $args['limit'], ( count($args['ns']) ? $args['ns'] : array( NS_MAIN ) ), false ) as $article ) {
			$tagBody .= '<li><a href="' . htmlspecialchars( $article['url'] ) . '">' . htmlspecialchars( $article['text'] ) . '</a></li>';
		}
		$tagBody .= '</ul>';

		return $tagBody;
	}

	/**
	 * parser hook for <wikitweets> tag
	 * @return string tag body
	 */
	public static function wikiTweetsParserHook( $input, $args, $parser ) {
		global $wgOut, $wgExtensionsPath, $wgTitle;

		$limit = isset($args['size']) && intval($args['size']) ? $args['size'] : 5;
		$phrase = isset($args['keywords']) ? $args['keywords'] : '';

		if(empty($phrase)) {
			return '';
		}

		// parse all "magic words" in the phrase
		$phrase = trim( strip_tags( ParserPool::parse( $phrase, $wgTitle, $parser->mOptions )->getText() ) );

		$phrase = urlencode($phrase);
		self::$wikiTweetsTagCount++;
		$tagId = 'cfWikiTweetsTag' . self::$wikiTweetsTagCount;

		$tagBody = '<ul class="cfWikiTweetsTag" id="' . $tagId . '">';
		$tagBody.= '<a href="http://search.twitter.com/search?q=' . urlencode($phrase) . '" target="_blank">Loading ...</a>';
		$tagBody.= '</ul>';

		$tagBody .= JSSnippets::addToStack(
			array( '/extensions/wikia/ContentFeeds/js/ContentFeeds.js' ),
			array(),
			'ContentFeeds.getTweets',
			array(
				'tagId' => $tagId,
				'phrase' => $phrase,
				'limit' => $limit,
			)
		);

		return $tagBody;
	}

	/**
	 * parser hook for <twitteruser> tag
	 * @author macbre
	 * @return string tag body
	 */
	public static function userTweetsParserHook( $input, $args, $parser ) {
		global $wgOut, $wgExtensionsPath, $wgTitle;

		$limit = isset($args['limit']) && intval($args['limit']) ? $args['limit'] : 5;
		$user = isset($args['username']) ? $args['username'] : '';

		if(empty($user)) {
			return '';
		}

		self::$userTweetsTagCount++;
		$tagId = 'cfUserTweetsTag' . self::$userTweetsTagCount;

		$tagBody = '<ul class="cfUserTweetsTag" id="' . $tagId . '">';
		$tagBody.= '<a href="http://twitter.com/' . urlencode($user) . '" target="_blank">Loading ...</a>';
		$tagBody.= '</ul>';

		$tagBody .= JSSnippets::addToStack(
			array( '/extensions/wikia/ContentFeeds/js/ContentFeeds.js' ),
			array(),
			'ContentFeeds.getUserTweets',
			array(
				'tagId' => $tagId,
				'user' => $user,
				'limit' => $limit,
			)
		);

		return $tagBody;
	}

	/**
	 * parser hook for <newpageslist> tag
	 * @return string tag body
	 */
	public static function newPagesListParserHook( $input, $args, $parser ) {
		$args = self::extractArgs( $args );

		$tagBody = '<ul class="cfNewPageListTag">';
		foreach ( DataProvider::singleton()->GetNewlyCreatedArticles( $args['limit'], ( count($args['ns']) ? $args['ns'] : array( NS_MAIN ) ) ) as $article ) {
			$tagBody .= '<li><a href="' . htmlspecialchars( $article['href'] ) . '">' . htmlspecialchars( $article['name'] ) . '</a></li>';
		}
		$tagBody .= '</ul>';

		return $tagBody;
	}

	/**
	 * parser hook for <topuserslist> tag
	 * @return string tag body
	 */
	public static function topUsersListParserHook( $input, $args, $parser ) {
		$args = self::extractArgs( $args );

		$tagBody = '<ul class="cfTopUsersListTag">';
		foreach ( DataProvider::singleton()->GetTopFiveUsers( $args['limit'] ) as $article ) {
			$tagBody .= '<li><a href="' . htmlspecialchars( $article['url'] ) . '">' . htmlspecialchars( $article['text'] ) . '</a></li>';
		}
		$tagBody .= '</ul>';

		return $tagBody;
	}

	/**
	 * parser hook for <topvotedlist> tag
	 * @return string tag body
	 */
	public static function highestRatedParserHook( $input, $args, $parser ) {
		$args = self::extractArgs( $args );

		$tagBody = '<ul class="cfTopVotedListTag">';
		foreach ( DataProvider::singleton()->GetTopVotedArticles( $args['limit'] ) as $article ) {
			$tagBody .= '<li><a href="' . htmlspecialchars( $article['url'] ) . '">' . htmlspecialchars( $article['text'] ) . '</a></li>';
		}
		$tagBody .= '</ul>';

		return $tagBody;
	}

	/**
	 * nifty "parser hook" for <recentimages> tag
	 * @return string tag body
	 */
	public static function recentImagesParserHook( Parser $parser, $text, $strip_state ) {
		global $wgRTEParserEnabled;

		if (!empty($wgRTEParserEnabled)) {
			return true;
		}

		$tags = array();
		$text = $parser->extractTagsAndParams( array( 'recentimages' ), $text, $tags );

		foreach( $tags as $uniqId => $tagData ) {
			if( $tagData[0] == 'recentimages') {
				$args = self::extractArgs( $tagData[2] );

				// preserve all <gallery> tag params
				unset( $tagData[2]['size'] );
				unset( $tagData[2]['ns'] );
				$galleryTagParams = '';

				foreach( $tagData[2] as $paramKey => $paramValue ) {
					$galleryTagParams .= $paramKey . '="' . $paramValue . '" ';
				}

				$tagBody = "<gallery $galleryTagParams>\n";
				foreach ( DataProvider::GetRecentlyUploadedImages( $args['limit'] ) as $image ) {
					$tagBody .= $image['name'] . "\n";
				}
				$tagBody .= "</gallery>\n";

				$text = str_replace( $uniqId, $tagBody, $text );
			}
			else {
				// small hack to restore everything accidentally replaced UNIQ marker (e.g. <!-- --> tag)
				$text = str_replace( $uniqId, $tagData[3], $text );
			}
		}
		return true;
	}

	/**
	 * dummy parser hook callback function, since we use different approach for <recentimages> tag
	 */
	public static function dummyRecentImagesParserHook( $input, $args, $parser ) {
		return "Życie..";
	}

	public static function specialNewImagesHook( $images, $gallery, $limit ) {
		global $wgRequest;

		if( $wgRequest->getVal('feed') == 'rss' ) {
			//filter images and get the file url
			$filteredImages = array();
			foreach( array_slice( $images, 0, $limit ) as $image ) {
				$imageFile = wfFindFile( $image->img_name );
				if( is_object( $imageFile ) ) {
					/* @var $imageFile LocalFile */
					$imageType = $imageFile->minor_mime;
					$imageSize = $imageFile->size;

					// don't show PNG files / files smaller than 2 kB
					if( ($imageType == 'png') || ($imageSize < 2048) ) {
						continue;
					}

					$filteredImage = $image;
					$filteredImage->img_file_url = $imageFile->getFullUrl();

					$filteredImages[] = $filteredImage;
				}
			}

			// render RSS template
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates' );
			$oTmpl->set_vars(
				array(
					'url' => $wgRequest->getFullRequestURL(),
					'images' => $filteredImages,
					'dateFormat' => 'D, d M Y H:i:s O'
				));

			$wgRequest->response()->header('Cache-Control: max-age=60');
			$wgRequest->response()->header('Content-Type: application/xml');

			echo $oTmpl->render( 'newImagesRss' );
			exit;
		}
		return true;
	}

	/**
	 * parser hook for <firstfewarticles> tag
	 *
	 * TODO: finish it
	 *
	 * @return string tag body
	 */
	public static function firstFewArticlesParserHook( $input, $args, $parser ) {
		global $wgExtensionsPath;

		$limit = isset( $args['limit'] ) ? $args['limit'] : 1;

		$emptyTitleErrorMsg = wfMsg( 'contentfeeds-firstfewarticles-tag-empty-title-error' );
		$emptyBodyErrorMsg = wfMsg( 'contentfeeds-firstfewarticles-tag-empty-body-error' );

		// TODO: refactor using JS snippets (see wikiTweetsParserHook and userTweetsParserHook methods)
		$jsBody = <<<SCRIPT
<script type="text/javascript">/*<![CDATA[*/
	wgAfterContentAndJS.push(function() {
		$.getScript('{$wgExtensionsPath}/wikia/JavascriptAPI/Mediawiki.js', function() {
			$( function() {
				$.getScript('{$wgExtensionsPath}/wikia/ContentFeeds/js/FirstFewArticles.js', function() {
					$( function() { } );
				});
			});
		});
	});
/*]]>*/</script>
SCRIPT;

		// remove whitespaces from inline JS code
		$jsBody = preg_replace("#[\n\t]+#", '', $jsBody);

		$template = new EasyTemplate( dirname( __FILE__ )."/templates/" );
		$template->set_vars( array() );

		$tagBody = $template->render( 'firstFewArticlesTag' );

		return $tagBody . $jsBody;
	}

}

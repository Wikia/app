<?php
class WikiaRssExternalController extends WikiaController {

	const CACHE_TIME = 3600;

	/**
	 * @brief Returns status flag and data in html tags
	 * @desc Here we use 3rd-part extension magpierss which fetches rss feeds from given url
	 */
	public function getRssFeeds() {
		$this->response->setVal( 'status', false );
		$options = $this->request->getVal( 'options', false );

		$this->response->setCachePolicy( WikiaResponse::CACHE_PUBLIC );
		$this->response->setCacheValidity( self::CACHE_TIME ); //cache it on varnish for 1h

		//somehow empty arrays are lost
		//we need to restore then its default values
		foreach ( [ 'highlight', 'filter', 'filterout' ] as $option ) {
			if ( !isset( $options[$option] ) ) {
				$options[$option] = array();
			}
		}

		if ( !empty( $options ) && !empty( $options['url'] ) ) {
			$url = html_entity_decode( $options['url'] );

			\Wikia\Logger\WikiaLogger::instance()->info(
				__METHOD__,
				[ 'providerUrl' => $url ]
			);

			$feedData = WikiaDataAccess::cacheWithLock(
				wfSharedMemcKey( 'WikiaRss', 'feed', $url ),
				self::CACHE_TIME,
				function () use ( $url ) {
					return WikiaRssHelper::getFeedData( $url );
				}
			);

			if ( !empty( $feedData['errorMessageKey'] ) ) {
				$this->response->setVal(
					'error',
					wfMessage( $feedData['errorMessageKey'], $url, $feedData['error'] )->escaped()
				);

				return;
			}

			$rss = $feedData['rss'];

			$short = ( $options['short'] == 'true' ) ? true : false;
			$reverse = ( $options['reverse'] == 'true' ) ? true : false;

			if ( $reverse ) {
				$rss->items = array_reverse( $rss->items );
			}

			$description = false;
			foreach ( $rss->items as $item ) {
				if ( isset( $item['description'] ) && $item['description'] ) {
					$description = true;
					break;
				}
			}

			if ( !$short && $description ) {
				$items = $this->getFullItemList( $rss->items, $options );
				$html = $this->app->renderView( 'WikiaRssExternal', 'fullList', [ 'items' => $items ] );
			} else {
				$items = $this->getShortItemList( $rss->items, $options );
				$html = $this->app->renderView( 'WikiaRssExternal', 'shortList', [ 'items' => $items ] );
			}

			$this->response->setVal( 'status', true );
			$this->response->setVal( 'html', $html );
		} else {
			$this->response->setVal( 'error', wfMessage( 'wikia-rss-error-invalid-options' )->escaped() );
		}
	}

	public function fullList() {
		$this->response->setVal('items', $this->request->getVal('items', array()));
	}

	public function shortList() {
		$this->response->setVal('items', $this->request->getVal('items', array()));
	}

	/**
	 * @brief Depending on given options it returns an array with full data of a rss feed
	 *
	 * @param Array $items an array with feeds' data returned from magpierss (3rd-part ext)
	 * @param Array $options an array with displaying options given with a parser tag <rss>
	 *
	 * @return Array
	 */
	private function getFullItemList($items, $options) {
		// TODO DRY see getShortItemList()

		$app = F::app();
		$result = array();

		$charset = !empty( $options['charset'] ) ? $options['charset'] : array();
		// dateFormat is only for backwards compatibility of requests.
		$date = $options['date'] || $options['dateFormat'];
		$rssFilter = $options['filter'];
		$rssFilterout = $options['filterout'];
		$rssHighlight = $options['highlight'];
		$maxheads = $options['maxheads'];

		$headcnt = 0;
		$outputEncoding = 'UTF-8';

		foreach( $items as $i => $item ) {
			$d_text = true;
			$d_title = true;

			$href = htmlspecialchars(trim(mb_convert_encoding($item['link'],$outputEncoding,$charset)));
			$sanitizedHref = Sanitizer::validateAttributes( [ 'href' => $href ], [ 'href' ] );
			$title = htmlspecialchars(trim(mb_convert_encoding($item['title'],$outputEncoding,$charset)));

			if( $date != 'false' && isset($item['dc']) && is_array($item['dc']) && isset($item['dc']['date']) ) {
				$pubdate = trim(mb_convert_encoding($item['dc']['date'],$outputEncoding,$charset));
				$pubdate = $app->wg->ContLang->date( strtotime( $pubdate ), false, false );
			} else {
				$pubdate = false;
			}

			$d_title = $this->doRssFilter($title, $rssFilter);
			$d_title = $this->doRssFilterOut($title, $rssFilterout);
			$title = $this->doRssHighlight($title, $rssHighlight);

			if( $item['description'] ) {
				$text = trim(mb_convert_encoding($item['description'],$outputEncoding,$charset));
				$text = str_replace( array("\r", "\n", "\t", '<br>'), ' ', $text );
				$text = strip_tags( $text, '<img><a><br>' );

				$globalStateWrapper = new \Wikia\Util\GlobalStateWrapper( [ 'wgAllowImageTag' => true ] );
				$text = $globalStateWrapper->wrap( function () use ( $text ) {
					return Sanitizer::removeHTMLtags( $text, null, [], [ 'a' ] );
				} );

				$d_text = $this->doRssFilter($text, $rssFilter );
				$d_text = $this->doRssFilterOut($text, $rssFilterout);
				$text = $this->doRssHighlight($text, $rssHighlight);

				$display = $d_text || $d_title;
 			} else {
				$text = '';
				$display = $d_title;
			}

			if( $display ) {
				$result[$i] = array(
					'href' => isset( $sanitizedHref['href'] ) ? $sanitizedHref['href'] : '',
					'title' => $title,
				);

				if( $date ) {
					$result[$i]['date'] = $pubdate;
				}

				if( $text ) {
					$result[$i]['text'] = $text;
				}
			}

			if ( ++$headcnt == $maxheads ) break;
		}

		return $result;
	}

	/**
	 * @brief Depending on given options it returns an array with short data of a rss feed
	 *
	 * @param Array $items an array with feeds' data returned from magpierss (3rd-part ext)
	 * @param Array $options an array with displaying options given with a parser tag <rss>
	 *
	 * @return Array
	 */
	private function getShortItemList($items, $options) {
		$app = F::app();
		$result = array();

		$supportedEncodings = array_map( 'strtolower', mb_list_encodings() );
		$charset = !empty( $options['charset'] ) && in_array( strtolower( $options['charset'] ), $supportedEncodings ) ?
			$options['charset'] : [ ];
		// dateFormat is only for backwards compatibility of requests.
		$date = ( $options['date'] ?? false ) || $options['dateFormat'];
		$rssFilter = $options['filter'];
		$rssFilterout = $options['filterout'];
		$rssHighlight = $options['highlight'];
		$maxheads = $options['maxheads'];

		$displayed = array();
		$headcnt = 0;
		$outputEncoding = 'UTF-8';

		foreach( $items as $i => $item ) {
			$href = htmlspecialchars( trim( mb_convert_encoding( $item['link'], $outputEncoding, $charset ) ) );
			$sanitizedHref = Sanitizer::validateAttributes( [ 'href' => $href ], [ 'href' ] );
			$title = htmlspecialchars( trim( mb_convert_encoding( $item['title'], $outputEncoding, $charset ) ) );

			$d_title = $this->doRssFilter($title, $rssFilter) && $this->doRssFilterOut($title, $rssFilterout);
			$attrTitle = $title;
			$title = $this->doRssHighlight($title, $rssHighlight);

			if( $date !== 'false' ) {
				$pubdate = isset( $item['pubdate'] ) ? trim( mb_convert_encoding( $item['pubdate'], $outputEncoding, $charset ) ) : '';

				if( $pubdate == '' ) {
					$pubdate = isset( $item['dc'] ) && is_array( $item['dc'] ) && isset( $item['dc']['date'] ) ?
						trim( mb_convert_encoding( $item['dc']['date'], $outputEncoding, $charset ) ) : false;
				}

				$pubdate = $app->wg->ContLang->date( strtotime( $pubdate ), false, false );
			} else {
				$pubdate = false;
			}

			if( $d_title && !in_array( $title, $displayed ) ) {
				$result[$i] = array(
					'href' => isset( $sanitizedHref['href'] ) ? $sanitizedHref['href'] : '',
					'title' => $title,
					'attrTitle' => $attrTitle,
				);

				if( $date ) {
					$result[$i]['date'] = $pubdate;
				}

				$displayed[] = $title;

				if( ++$headcnt == $maxheads ) break;
			}
		}

		return $result;
	}

	/**
	 * @brief Returns true if user wants to display the feed; false otherwise
	 *
	 * @param String $text rss feed's title/text
	 * @param Array an array with texts which should be filtered
	 *
	 * @return Boolean
	 */
	private function doRssFilter($text, $rssFilter) {
		$display = true;
		if( is_array($rssFilter) ) {
			foreach( $rssFilter as $term ) {
				if( $term ) {
					$display = false;
					if( preg_match("|$term|i", $text, $a) ) {
						$display = true;
						return $display;
					}
				}

				if( $display ) break;
			}
		}

		return $display;
	}

	/**
	 * @brief Returns true if user doesn't want to display the feed; false otherwise
	 *
	 * @param String $text rss feed's title/text
	 * @param Array an array with texts which should be filtered
	 *
	 * @return Boolean
	 */
	private function doRssFilterOut($text, $rssFilterout) {
		$display = true;

		if( is_array($rssFilterout) ) {
			foreach( $rssFilterout as $term ) {
				if( $term ) {
					if( preg_match("|$term|i", $text, $a) ) {
						$display = false;
						return $display;
					}
				}
			}
		}

		return $display;
	}

	/**
	 * @brief Changes old text to highlighted text
	 *
	 * @param String $text rss feed's title/text
	 * @param Array an array with texts which should be highlighted
	 *
	 * @return String
	 */
	private function doRssHighlight($text, $rssHighlight) {
		$i = 0;
		$starttag = 'v8x5u3t3u8h';
		$endtag = 'q8n4f6n4n4x';

		$color[] = 'coral';
		$color[] = 'greenyellow';
		$color[] = 'lightskyblue';
		$color[] = 'gold';
		$color[] = 'violet';
		$countColor = count($color);

		if( is_array($rssHighlight) ) {
			foreach( $rssHighlight as $term ) {
				if( $term ) {
					$text = preg_replace("|\b(\w*?".$term."\w*?)\b|i", "$starttag"."_".$i."\\1$endtag", $text);
					$i++;
					if ( $i == $countColor ) $i = 0;
				}
			}
		}

		for( $i = 0; $i < 5; $i++ ) {
			$text = preg_replace("|$starttag"."_".$i."|", "<span style=\"background-color:".$color[$i]."; font-weight: bold;\">", $text);
			$text = preg_replace("|$endtag|", '</span>', $text);
		}

		return $text;
	}

}

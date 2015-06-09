<?php

/**
 * Class FeedRenderer
 */
class FeedRenderer {

	// icon types definition - this value will be used as CSS class name
	const FEED_SUN_ICON = 'new';
	const FEED_PENCIL_ICON = 'edit';
	const FEED_TALK_ICON = 'talk';
	const FEED_PHOTO_ICON = 'photo';
	const FEED_FILM_ICON = 'video';
	const FEED_COMMENT_ICON = 'talk';
	const FEED_MOVE_ICON = 'move';
	const FEED_DELETE_ICON = 'delete';
	const FEED_CATEGORY_ICON = 'categorization';

	protected $template;
	protected $type;

	public function __construct( $type ) {
		$this->type = $type;

		$this->template = new EasyTemplate(dirname(__FILE__) . '/../templates');

		global $wgBlankImgUrl;
		$this->template->set_vars(array(
			'assets' => array(
				'blank' => $wgBlankImgUrl,
			),
			'type' => $this->type,
		));
	}

	/**
	 * Add header and wrap feed HTML
	 * @param $content
	 * @param bool $showMore
	 * @return string
	 */
	public function wrap( $content, $showMore = true ) {
		$this->template->set_vars(array(
			'content' => $content,
			'defaultSwitch' => $this->renderDefaultSwitch(),
			'showMore' => $showMore,
			'type' => $this->type,
		));
		return $this->template->render('feed.wrapper');
	}

	/**
	 * @param $data
	 * @param bool $wrap
	 * @param array $parameters
	 * @return string
	 */
	public function render( $data, $wrap = true, $parameters = array() ) {
		wfProfileIn(__METHOD__);

		$template = 'feed';
		if ( isset($parameters['flags']) && in_array('shortlist', $parameters['flags']) ) {
			$template = 'feed.simple';
		}
		if ( isset($parameters['flags']) && in_array('hidedetails', $parameters['flags']) ) {
			$template = 'feed.nodtl';
		}
		if ( isset($parameters['type']) && $parameters['type'] == 'widget' ) {
			$template = 'feed.widget';
		}

		$this->template->set('data', $data['results']);
		if ( !empty($parameters['style']) ) {
			$this->template->set('style', " style=\"{$parameters['style']}\"");
		}

		// handle message to be shown when given feed is empty
		if ( empty($data['results']) ) {
			$this->template->set('emptyMessage', wfMsgExt("myhome-{$this->type}-feed-empty", array( 'parse' )));
		}

		$tagid = isset($parameters['tagid']) ? $parameters['tagid'] : 'myhome-activityfeed';
		$this->template->set('tagid', $tagid);

		// render feed
		$content = $this->template->render($template);

		// add header and wrap
		if ( !empty($wrap) ) {
			// show "more" link?
			$showMore = isset($data['query-continue']);

			// store timestamp for next entry to fetch when "more" is requested
			if ( $showMore ) {
				$content .= "\t<script type=\"text/javascript\">MyHome.fetchSince.{$this->type} = '{$data['query-continue']}';</script>\n";
			}

			$content = $this->wrap($content, $showMore);

		}
		wfProfileOut(__METHOD__);

		return $content;
	}

	/**
	 * Return HTML of default view switch for activity / watchlist feed
	 *
	 * @return string
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	private function renderDefaultSwitch() {

		// only add switch to activity / watchlist feed
		$feeds = array('activity', 'watchlist');

		if ( !in_array($this->type, $feeds) ) {
			return '';
		}

		// check current default view
		$defaultView = MyHome::getDefaultView();

		if ( $defaultView == $this->type ) {
			return '';
		}

		// render checkbox with label
		$html = '';
		$html .= Xml::openElement('div', array(
			'id' => 'myhome-feed-switch-default',
			'class' => 'accent',
		));
		$html .= Xml::element('input', array(
			'id' => 'myhome-feed-switch-default-checkbox',
			'type' => 'checkbox',
			'name' => $this->type,
			'disabled' => 'true'
		));
		$html .= Xml::element('label', array(
			'for' => 'myhome-feed-switch-default-checkbox'
		), wfMsg('myhome-default-view-checkbox', wfMsg("myhome-{$this->type}-feed")));
		$html .= Xml::closeElement('div');

		return $html;
	}

	/**
	 * Return action of given row (edited / created / ...)
	 *
	 * @param $row
	 * @return string
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	public static function getActionLabel( $row ) {
		wfProfileIn(__METHOD__);

		switch ( $row['type'] ) {
			case 'new':
				$ns = $row['ns'];

				if (
					( defined( 'NS_USER_WALL_MESSAGE' ) && $ns == NS_USER_WALL_MESSAGE ) ||
					( defined( 'NS_BLOG_ARTICLE_TALK' ) && $ns == NS_BLOG_ARTICLE_TALK )
				) {
					$msgType = 'comment';
				} else if ( defined( 'NS_BLOG_ARTICLE' ) && $ns == NS_BLOG_ARTICLE ) {
					$msgType = 'posted';
				} else if ( !empty( $row['articleComment'] ) ) {
					$msgType = 'article-comment-created';
				} else {
					$msgType = 'created';
				}
				break;

			case 'delete':
				$msgType = 'deleted';
				break;

			case 'move':
				$msgType = 'moved';
				break;

			default:
				if ( !empty($row['articleComment']) ) {
					$msgType = 'article-comment-edited';
				} else {
					$msgType = 'edited';
				}
		}

		$res = wfMsg("myhome-feed-{$msgType}-by", self::getUserPageLink($row))  . ' ';

		wfProfileOut(__METHOD__);

		return $res;
	}

	/**
	 * Return formatted timestamp
	 *
	 * @param $stamp
	 * @return String
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	public static function formatTimestamp( $stamp ) {
		return wfTimeFormatAgo($stamp);
	}

	/**
	 * Returns intro which should be no more than 150 characters.
	 * The cut off ends with an ellipsis (...), coming after the last whole word.
	 *
	 * @param $intro
	 * @return mixed|string
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	public static function formatIntro( $intro ) {
		wfProfileIn(__METHOD__);

		// remove newlines
		$intro = str_replace("\n", ' ', $intro);

		if ( mb_strlen($intro) == 150 ) {
			// find last space in intro
			$last_space = strrpos($intro, ' ');

			if ( $last_space > 0 ) {
				$intro = substr($intro, 0, $last_space) . wfMsg('ellipsis');
			}
		}

		wfProfileOut(__METHOD__);

		return $intro;
	}

	/**
	 * Returns one row for details section (Label: content)
	 *
	 * @param $type
	 * @param $content
	 * @param bool $encodeContent
	 * @param bool $count
	 * @return string
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	public static function formatDetailsRow( $type, $content, $encodeContent = true, $count = false ) {
		wfProfileIn(__METHOD__);

		if ( is_numeric($count) ) {
			$msg = wfMsgExt("myhome-feed-{$type}-details", array('parsemag'), $count);
		} else {
			$msg = wfMsg("myhome-feed-{$type}-details");
		}

		$html = Xml::openElement('tr', array('data-type' => $type));
		$html .= Xml::openElement('td', array('class' => 'activityfeed-details-label'));
		$html .= Xml::element('em', array('class' => 'dark_text_2'), $msg);
		$html .= ': ';
		$html .= Xml::closeElement('td');
		$html .= Xml::openElement('td');
		$html .= $encodeContent ? htmlspecialchars($content) : $content;
		$html .= Xml::closeElement('td');
		$html .= Xml::closeElement('tr');

		// indent
		$html = "\n\t\t\t{$html}";

		wfProfileOut(__METHOD__);

		return $html;
	}

	/**
	 * Returns rows with message wall comments
	 *
	 * @param Array $comments an array with comments
	 *
	 * @return string
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public static function formatMessageWallRows( $comments ) {
		$html = '';

		foreach ( $comments as $comment ) {
			$authorLine = '';

			if ( !empty($comment['user-profile-url']) ) {
				if ( !empty($comment['author']) ) {
					$authorLine .= Xml::element('a', array(
						'href' => $comment['user-profile-url'],
						'class' => 'real-name',
					), $comment['real-name']);
					$authorLine .= ' ';
					$authorLine .= Xml::element('a', array(
						'href' => $comment['user-profile-url'],
						'class' => 'username',
					), $comment['author']);
				} else {
					$authorLine .= Xml::element('a', array(
						'href' => $comment['user-profile-url'],
						'class' => 'real-name',
					), $comment['real-name']);
				}
			} else {
				$authorLine .= $comment['author'];
			}

			$timestamp = '';
			if ( !empty($comment['timestamp']) ) {
				$timestamp .= Xml::openElement('time', array(
					'class' => 'wall-timeago',
					'datetime' => wfTimestamp(TS_ISO_8601, $comment['timestamp']),
				));
				$timestamp .= self::formatTimestamp($comment['timestamp']);
				$timestamp .= Xml::closeElement('time');
			}

			$html .= Xml::openElement('tr');
				$html .= Xml::openElement('td');
					$html .= $comment['avatar'];
				$html .= Xml::closeElement('td');
				$html .= Xml::openElement('td');
					$html .= Xml::openElement('p');
						$html .= $authorLine;
					$html .= Xml::closeElement('p');
					$html .= Xml::openElement('p');
						$html .= $comment['wall-comment'];
						$html .= ' ';
						$html .= Xml::openElement('a', array('href' => $comment['wall-message-url']));
							$html .= $timestamp;
						$html .= Xml::closeElement('a');
					$html .= Xml::closeElement('p');
				$html .= Xml::closeElement('td');
			$html .= Xml::closeElement('tr');
		}

		return $html;
	}

	/**
	 * Returns <a> tag pointing to user page
	 *
	 * @param $row
	 * @return string
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	public static function getUserPageLink( $row ) {
		return $row['user'];
	}

	/**
	 * Returns <a> tag with an image pointing to diff page
	 *
	 * @param $row
	 * @return string
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	public static function getDiffLink( $row ) {
		if ( empty($row['diff']) ) {
			return '';
		}

		global $wgExtensionsPath;

		$html = Xml::openElement('a', array(
			'class' => 'activityfeed-diff',
			'href' => $row['diff'],
			'title' => wfMsg('myhome-feed-diff-alt'),
			'rel' => 'nofollow',
		));
		$html .= Xml::element('img', array(
			'src' => $wgExtensionsPath . '/wikia/MyHome/images/diff.png',
			'width' => 16,
			'height' => 16,
			'alt' => 'diff',
		));
		$html .= Xml::closeElement('a');

		return ' ' . $html;
	}

	/**
	 * Returns icon type for given row
	 *
	 * @param $row
	 * @return bool|string
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	public static function getIconType( $row ) {

		if ( !isset($row['type']) ) {
			return false;
		}

		wfProfileIn(__METHOD__);

		$type = false;

		switch ( $row['type'] ) {
			case 'new':
				switch ( $row['ns'] ) {
					// blog post
					case 500:
						$type = self::FEED_SUN_ICON;
						break;

					// blog comment
					case 501:
					// wall comment
					case 1001:
						$type = self::FEED_COMMENT_ICON;
						break;

					// content NS
					default:
						if ( empty($row['articleComment']) ) {
							$type = MWNamespace::isTalk($row['ns']) ? self::FEED_TALK_ICON : self::FEED_SUN_ICON;
						} else {
							$type = self::FEED_COMMENT_ICON;
						}
				}
				break;

			case 'edit':
				// edit done from editor
				if ( empty($row['viewMode']) ) {
					// talk pages
					if ( isset($row['ns']) && MWNamespace::isTalk($row['ns']) ) {
						if ( empty($row['articleComment']) ) {
							$type = self::FEED_TALK_ICON;
						} else {
							$type = self::FEED_COMMENT_ICON;
						}
					}
					// content pages
					else {
						$type = self::FEED_PENCIL_ICON;
					}
				}
				// edit from view mode
				else {
					// category added
					if ( !empty($row['CategorySelect']) ) {
						$type = self::FEED_CATEGORY_ICON;
					}
					// category added
					elseif ( !empty($row['new_categories']) ) {
						$type = self::FEED_PENCIL_ICON;
					}
					// image(s) added
					elseif ( !empty($row['new_images']) ) {
						$type = self::FEED_PHOTO_ICON;
					}
					// video(s) added
					// TODO: uncomment when video code is fixed
					else /*if ( !empty($row['new_videos'])) */{
						$type = self::FEED_FILM_ICON;
					}
				}
				break;

			case 'delete':
				$type = self::FEED_DELETE_ICON;
				break;

			case 'move':
			case 'redirect':
				$type = self::FEED_MOVE_ICON;
				break;

			case 'upload':
				$type = self::FEED_PHOTO_ICON;
				break;
		}

		wfProfileOut(__METHOD__);

		return $type;
	}

	/**
	 * Returns alt text for icon (RT #23974)
	 *
	 * @param $row
	 * @return null|string
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	public static function getIconAltText( $row ) {
		$type = self::getIconType($row);

		if ( $type === false ) {
			return '';
		}

		wfProfileIn(__METHOD__);

		switch ( $type ) {
		 	case self::FEED_SUN_ICON:
				$msg = 'newpage';
				break;

			case self::FEED_PENCIL_ICON:
				$msg = 'edit';
				break;

			case self::FEED_MOVE_ICON:
				$msg = 'move';
				break;

			case self::FEED_TALK_ICON:
				$msg = 'talkpage';
				break;

			case self::FEED_COMMENT_ICON:
				$msg = 'blogcomment';
				break;

			case self::FEED_DELETE_ICON:
				$msg = 'delete';
				break;

			case self::FEED_PHOTO_ICON:
				$msg = 'image';
				break;

			case self::FEED_FILM_ICON:
				$msg = 'video';
				break;

			case self::FEED_CATEGORY_ICON:
				$msg = 'categorization';
				break;
		}

		$alt = wfMsg("myhome-feed-{$msg}");
		$ret = Xml::expandAttributes( array('alt' => $alt, 'title' => $alt) );

		wfProfileOut(__METHOD__);

		return $ret;
	}

	/**
	 * Render an HTML sprite.
	 *
	 * @param $row Row details.
	 * @param $src string The src of the sprite <img> element.
	 * @return string HTML for an appropriate sprite, based on $row.
	 */
	public static function getSprite( $row, $src = '' ) {
		$r = '';
		$r .= '<img'.
			' class="' . self::getIconType( $row ) . ' sprite"'.
			' src="'. $src .'"'.
			' '. self::getIconAltText( $row ).
			' width="16" height="16" />';
		return $r;
	}

	/**
	 * Returns 3rd row (with details) for given feed item
	 *
	 * @param $row
	 * @return string
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	public static function getDetails( $row ) {
		wfProfileIn(__METHOD__);

		$html = '';
		//
		// let's show everything we have :)
		//

		if ( isset($row['to_title']) && isset($row['to_url']) ) {
			$html .= self::formatDetailsRow('move', Xml::element('a', array('href' => $row['to_url']), $row['to_title']), false);
		}

		if ( isset($row['intro']) ) {
			// new blog post
			if ( defined('NS_BLOG_ARTICLE') && $row['ns'] == NS_BLOG_ARTICLE ) {
				$html .= self::formatDetailsRow('new-blog-post', self::formatIntro($row['intro']),false);
			}
			// blog comment
			else if ( defined('NS_BLOG_ARTICLE_TALK') && $row['ns'] == NS_BLOG_ARTICLE_TALK ) {
				$html .= self::formatDetailsRow('new-blog-comment', self::formatIntro($row['intro']),false);
			}
			// article comment
			else if ( !empty($row['articleComment']) ) {
				$html .= self::formatDetailsRow('new-article-comment', self::formatIntro($row['intro']),false);
			}
			// message wall thread
			else if ( !empty($row['wall']) ) {
				if ( !empty($row['comments']) ) {
					$html .= self::formatMessageWallRows($row['comments']);
					$html .= '';
				} else {
					$html .= '';
				}
			} else if ( $row['ns'] == NS_USER_TALK ) { // BugId:15648
				$html = '';
			} else {
				// another new content
				$html .= self::formatDetailsRow('new-page', self::formatIntro($row['intro']), false);
			}
		}

		// section name
		if ( isset($row['section']) ) {
			$html .= self::formatDetailsRow('section-edit', $row['section']);
		}

		// edit summary (don't show auto summary and summaries added by tools using edit from view mode)
		if ( isset($row['comment']) && trim($row['comment']) != '' && !isset($row['autosummaryType']) && !isset($row['viewMode']) ) {
			$html .= self::formatDetailsRow('summary', RequestContext::getMain()->getSkin()->formatComment($row['comment']), false);
		}

		// added categories
		if ( isset($row['new_categories']) ) {
			$categories = array();

			// list of comma separated categories
			foreach ( $row['new_categories'] as $cat ) {
				$category = Title::newFromText($cat, NS_CATEGORY);

				if ( !empty($category) ) {
					$link = $category->getLocalUrl();
					$categories[] = Xml::element('a', array('href' => $link), str_replace('_', ' ', $cat));
				}
			}

			$html .= self::formatDetailsRow('inserted-category', implode(', ', $categories), false, count($categories));
		}

		// added image(s)
		$html .= self::getAddedMediaRow($row, 'images');

		// added video)s)
		$html .= self::getAddedMediaRow($row, 'videos');

		wfProfileOut(__METHOD__);

		return $html;
	}

	/**
	 * Returns row with added images / videos
	 *
	 * @param $row
	 * @param $type
	 * @return string
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	public static function getAddedMediaRow( $row, $type ) {
		$wg = F::app()->wg;

		$key = "new_{$type}";

		if ( empty($row[$key]) ) {
			return '';
		}

		wfProfileIn(__METHOD__);

		$thumbs = array();
		$namespace = NS_FILE;

		foreach ( $row[$key] as $item ) {

			// localised title for popup
			$popupTitle = $wg->Lang->getNsText($namespace) . ':' . $item['name'];

			$titleObj = Title::newFromText($item['name'], NS_FILE);
			$fileName = $titleObj->getText(); // Pass display version of title to Lightbox

			// wrapper for thumbnail
			$attribs = array(
				'class' => 'lightbox',
				'rel' => 'nofollow',
				'ref' => 'File:' . $item['name'], /* TODO: check that name doesn't have NS prefix */
				'data-' . ($type == 'videos' ? 'video-name' : 'image-name') => $fileName,
				'title' => $popupTitle,
			);

			// get URL to file / video page
			$title = Title::newFromText($item['name'], $namespace);
			if ( !empty($title) ) {
				$attribs['href'] = $title->getLocalUrl();
			}

			$hookDummy = new DummyLinker;
			$hookFile = false;
			$hookFrameParams = [];
			$hookHandlerParams = [];
			$hookTime = false;
			$hookRes = null;

			if ( !wfRunHooks( 'ImageBeforeProduceHTML',
				array( &$hookDummy, &$title, &$hookFile, &$hookFrameParams, &$hookHandlerParams, &$hookTime, &$hookRes ) ) ) {
				$thumbs[] = "<li>$hookRes</li>";
			} else {
				$thumb = $item['html'];
				// Only wrap the line in an anchor if it doesn't already include one
				if ( preg_match('/<a[^>]+href/', $thumb) ) {
					$thumbs[] = "<li>$thumb</li>";
				} else {
					$thumbs[] = "<li><a data-image-link href=\"{$title->getLocalUrl()}\">$thumb</a></li>";
				}
			}
		}

		// render thumbs
		$html = '<ul class="activityfeed-inserted-media reset">' . implode("\n", $thumbs) . '</ul>';

		// wrap them
		$html = self::formatDetailsRow('inserted-'.($type == 'images' ? 'image' : 'video'), $html, false, count($thumbs));

		wfProfileOut(__METHOD__);

		return $html;
	}
}

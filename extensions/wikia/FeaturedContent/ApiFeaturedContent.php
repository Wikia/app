<?php

/**
 * @package MediaWiki
 * @subpackage API
 * @author Przemek Piotrowski <ppiotr@wikia.com> for Wikia, Inc.
 * @copyright (C) 2007 Wikia, Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: $Id$
 */

class ApiFeaturedContent extends ApiBase
{
	private $_FA_list = array
	(
		array('title' => 'Featured_content', 'ns' => NS_PROJECT),
		array('title' => 'Featured_article', 'ns' => NS_PROJECT),
		array('title' => 'Featured_Article', 'ns' => NS_PROJECT),
	);

	public function __construct($main, $action)
	{
		parent::__construct($main, $action, 'fc');
	}

	public function execute()
	{
		wfProfileIn(__METHOD__);

		$data = $this->getData();
		$this->setOutput($data);

		wfProfileOut(__METHOD__);
	}

	protected function getData()
	{
		wfProfileIn(__METHOD__);

		foreach ($this->_FA_list as $page)
		{
			$list = $this->getHtmlContent($page['title'], $page['ns']);
			if (!empty($list))
			{
				break;
			}
		}
		//wfDebug(sprintf("FeaturedContent: API: %s\n", $list));

		$data = array();
		if (preg_match_all('/(?:<li>(.+)<\/li>|<tr>\s*<td>(.+)<\/td>\s*<\/tr>)/sU', $list, $preg, PREG_SET_ORDER))
		{
			//wfDebug(sprintf("FeaturedContent: API: %s\n", print_r($preg, true)));
			foreach ($preg as $match)
			{
				if (!empty($match[1]))
				{
					$content2 = $match[1];
				} else
				{
					$content2 = $match[2];
				}
				$content2 = trim($content2);

				// its either ...link...link... or ..link... (dots may contain a timestamp, links may lead to the article and to the snippet)
				// second regexp is matched by the first, too ---> ORDER IS IMPORTANT !!!
				if (preg_match('/^(.*)<a href="([^"]+)"[^>]*title="([^"]+)"[^>]*>.+<\/a>(.*)<a href="([^"]+)"[^>]*title="([^"]+)"[^>]*>.+<\/a>(.*)$/sU', $content2, $preg2) ||
					 preg_match('/^(.*)<a href="([^"]+)"[^>]*title="([^"]+)"[^>]*>.+<\/a>(.*)$/sU', $content2, $preg2))
				{
					//wfDebug(sprintf("FeaturedContent: API: %s\n", print_r($preg2, true)));

					$links = array();
					// links may be matched as #2+3 and 5+6
					foreach (array(2, 5) as $i)
					{
						if (!empty($preg2[$i]) && !empty($preg2[$i + 1]))
						{
							$links[] = array('url' => $preg2[$i], 'title' => $preg2[$i + 1]);
						}
					}

					$timestamps = array();
					// timestamps may be matched as #1, 4 or 7
					foreach (array(1, 4, 7) as $i)
					{
						if (!empty($preg2[$i]))
						{
							$timestamps[] = $preg2[$i];
						}
					}

					$article = $snippet = $timestamp = '';
					list($article, $snippet) = $this->_parseLinks($links);
					     $timestamp          = $this->_parseTimestamps($timestamps);

					if (!empty($article) && !empty($timestamp))
					{
						$row = array
						(
							'title'     => $article,
							'timestamp' => $timestamp,
							'snippet'   => $snippet,
						);
						if (!in_array($row, $data))
						{
							$data[] = $row;
						}
					}
				}
			}
		}

		/*
		$data = array_reverse($data, true);      // true = preserve keys
		$data = array_slice($data, 0, 10, true); // true = preserve keys
		*/
		wfDebug(sprintf("FeaturedContent: API: %s\n", print_r($data, true)));

		$data2 = array();
		foreach ($data as $row)
		{
			$snippet = '';
			if (!empty($row['snippet']))
			{
				$snippet = $this->getHtmlContent($row['snippet']);
			} elseif (!empty($row['title']))
			{
				$snippet = $this->getHtmlContent($row['title']);
			}

			$headline = $this->getHeadlineFromHtml($snippet);
			$image   = $this->getImageFromHtml($snippet);
			$snippet = $this->getMinimalHtml($snippet);

			$data2[$row['timestamp'] . mt_rand(1000, 9999)] = array
			(
				'title'     => $row['title'],
				'timestamp' => $row['timestamp'],
				'headline'  => $headline,
				'image'     => $image,
				'snippet'   => $snippet,
			);
		}

		krsort($data2);
		$data2 = array_slice($data2, 0, 10);

		$data = array_values($data2);

		wfProfileOut(__METHOD__);
		return $data;
	}

	static public function getMinimalHtml($text, $N_words = 100)
	{
		wfProfileIn(__METHOD__);

		$text = preg_replace('/<h3><span class="editsection">\[[^\]]+\]<\/span> <span class="mw-headline">[^<]+<\/span><\/h3>/sU', '', $text);
		$text = strip_tags($text, '<p><br><i><b>');
		$text = trim($text);

		// more or less c&p from grab_N_words() in wiki2blog.php
		$n_words = '';

		$text2 = $text; // $text2 will have tags masked with #
		$text2 = str_replace('#', 'X', $text2); // get rid of #
		$text2 = str_replace(array('"', '\'', '\\'), '#', $text2); // get rid of chars which get escaped inside preg+/e and mess strlen
		$text2 = preg_replace('/<([^>]*)>/e', "'#'.str_repeat('#', strlen('\\1')).'#'", $text2); // mask html tags with equal number of #
		$text2 = preg_replace('/(\s+)(#+)(\s+)/e', "'\\1\\2'.str_repeat('#', strlen('\\3'))", $text2); // mask trailing spaces from spc-#-spc

		if (!preg_match('/^(?:\S+\s+){' . $N_words . '}/', $text2, $preg))
		{
			// less than N_WORDS (or error...) -> post the whole snippet
			$n_words = $text;
		} else
		{
			$n_words_len = strlen($preg[0]); // n-words are this long
			$n_words = substr($text, 0, $n_words_len) . '...';

			// ...now lets terminate them properly

			// FIXME
			// ignore it for now; getMinimalHtml allows only <p> so lets just add </p> and hope for the best
			$n_words .= '</p>';
		}

		wfProfileOut(__METHOD__);
		return $n_words;
	}

	protected function _parseLinks($data)
	{
		wfProfileIn(__METHOD__);

		$article = $snippet = '';

		foreach ($data as $link)
		{
			$url   = trim($link['url']);
			$title = trim($link['title']);

			if (preg_match('/action=edit$/', $url, $preg))
			{
				continue;
			}

			if (preg_match('/Template:/', $url, $preg) && empty($snippet))
			{
				$snippet = $title;
				continue;
			}

			if (empty($article))
			{
				$article = $title;
				continue;
			}
		}

		wfProfileOut(__METHOD__);
		return array($article, $snippet);
	}

	protected function _parseTimestamps($data)
	{
		wfProfileIn(__METHOD__);

		// FIXME localize
		$months = array(1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		$months_mask = join('|', $months);

		$timestamp = '';

		foreach ($data as $row)
		{
			$year = $month = $day = '';

			if (preg_match("/({$months_mask}) ([0-9]{1,2}), ([0-9]{4})/", $row, $preg))
			{
				$year  = $preg[3];
				$month = array_keys($months, $preg[1]); $month = $month[0];
				$day   = $preg[2];
			} elseif (preg_match('/([0-9]{4})-([0-9]{2})-([0-9]{2})/', $row, $preg))
			{
				$year  = $preg[1];
				$month = $preg[2];
				$day   = $preg[3];
			}

			if (!empty($year) && !empty($month) && !empty($day))
			{
				$timestamp = sprintf('%04d-%02d-%02dT00:00:00Z', $year, $month, $day);
				break;
			}
		}

		wfProfileOut(__METHOD__);
		return $timestamp;
	}

	static public function getHtmlContent($title, $ns = null)
	{
		wfProfileIn(__METHOD__);

		$content = '';

		$title = Title::NewFromText($title, $ns);
		if ($title->exists())
		{
			$article = new Article($title);
			if ($article->isRedirect())
			{
				$title = $article->followRedirect();
				if (!$title->exists())
				{
					// enough is enough
					wfProfileOut(__METHOD__);
					return '';
				}
				$article = new Article($title);
				if ($article->isRedirect())
				{
					// enough is enough
					wfProfileOut(__METHOD__);
					return '';
				}
			}
			$article = $article->getContent();

			global $wgParser;
			$content = $wgParser->parse($article, $title, new ParserOptions());
			$content = $content->mText;
		}

		wfProfileOut(__METHOD__);
		return $content;
	}

	static public function getImageFromHtml($content)
	{
		wfProfileIn(__METHOD__);

		$image = '';

		$data = array();
		if (preg_match_all('/<img src="([^"]+)"[^>]*width="([^"]*)"[^>]*height="([^"]*)"[^>]*>/', $content, $preg, PREG_SET_ORDER))
		{
			wfDebug(sprintf("FeaturedContent: API: %s\n", print_r($preg, true)));
			foreach ($preg as $match)
			{
				$width  = settype($match[2], 'integer');
				$height = settype($match[3], 'integer');

				$row = array
				(
					'image'  => $match[1],
					'width'  => $width,
					'height' => $height,
				);
				if (!in_array($row, $data))
				{
					$data[] = $row;
				}
			}
		}

		$image_50x50 = $image_50x_0 = $image__0x50 = $image__0x_0 = '';
		foreach ($data as $row)
		{
			// get first big image or first wide image or first tall image or just first image from the rest
			if (      (50 <= $row['width']) && (50 <= $row['height']) && empty($image_50x50))
			{
				$image_50x50 = $row['image'];
			} elseif ((50 <= $row['width'])                           && empty($image_50x_0))
			{
				$image_50x_0 = $row['image'];
			} elseif (                         (50 <= $row['height']) && empty($image__0x50))
			{
				$image__0x50 = $row['image'];
			} elseif (                                                   empty($image__0x_0))
			{
				$image__0x_0 = $row['image'];
			} 
		}

		if (      !empty($image_50x50))
		{
			$image = $image_50x50;
		} elseif (!empty($image_50x_0))
		{
			$image = $image_50x_0;
		} elseif (!empty($image__0x50))
		{
			$image = $image__0x50;
		} elseif (!empty($image__0x_0))
		{
			$image = $image__0x_0;
		}

		wfProfileOut(__METHOD__);
		return $image;
	}

	static public function getHeadlineFromHtml($content)
	{
		wfProfileIn(__METHOD__);

		$headline = '';
		if (preg_match('/<h3><span class="editsection">\[[^\]]+\]<\/span> <span class="mw-headline">([^<]+)<\/span><\/h3>/sU', $content, $preg))
		{
			wfDebug(sprintf("FeaturedContent: API: getHeadlineFromHtml: %s\n", print_r($preg, true)));
			$headline = trim($preg[1]);
		}

		wfProfileOut(__METHOD__);
		return $headline;
	}

	protected function setOutput($data)
	{
		wfProfileIn(__METHOD__);

		$result =& $this->getResult();
		$result->setIndexedTagName($data, 'fc');
		$result->addValue('query', $this->getModuleName(), $data);

		wfProfileOut(__METHOD__);
	}

	public function getAllowedParams()
	{
		return array
		(
		);
	}

	public function getParamDescription()
	{
		return array
		(
		);
	}

	public function getDescription()
	{
		return array
		(
			'This module is used to show pages featured by the community, Best of Wiki.',
		);
	}
	
	public function getExamples()
	{
		return array
		(
			'api.php?action=featuredcontent',
		);
	}

	public function getVersion()
	{
		return __CLASS__ . ': $Id$';
	}
}

?>

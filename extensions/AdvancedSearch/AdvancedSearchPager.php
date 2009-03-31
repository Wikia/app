<?php
/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author Roan Kattouw <roan.kattouw@home.nl>
 * @copyright Copyright (C) 2008 Roan Kattouw 
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 *
 * An extension that allows for searching inside categories
 * Written for MixesDB <http://mixesdb.com> by Roan Kattouw <roan.kattouw@home.nl>
 * For information how to install and use this extension, see the README file.
 *
 */
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the extension file directly.
if (!defined('MEDIAWIKI')) {
	echo <<<EOT
To install the AdvancedSearch extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/AdvancedSearch/AdvancedSearch.setup.php" );
EOT;
	exit(1);
}

/**
 * Class that pages search results
 * 
 * FIXME: Only works with MySQL, not with PostGreSQL or Oracle
 */
class AdvancedSearchPager
{
	// array(array('foo', bar'), array('baz')) means
	// foo AND bar OR baz
	protected $mInclText, $mExclText, $mInclCats, $mExclCats, $mNamespaces;
	protected $mSearchTitle, $mSearchContent, $mKey;
	
	/** A list of stop words ignored by the MySQL fulltext search */
	static $stopWords = array(
		'a\'s', 'able', 'about', 'above', 'according', 'accordingly',
		'across', 'actually', 'after', 'afterwards', 'again', 'against',
		'ain\'t', 'all', 'allow', 'allows', 'almost', 'alone', 'along',
		'already', 'also', 'although', 'always', 'am', 'among',
		'amongst', 'an', 'and', 'another', 'any', 'anybody', 'anyhow',
		'anyone', 'anything', 'anyway', 'anyways', 'anywhere', 'apart',
		'appear', 'appreciate', 'appropriate', 'are', 'aren\'t',
		'around', 'as', 'aside', 'ask', 'asking', 'associated', 'at',
		'available', 'away', 'awfully', 'be', 'became', 'because',
		'become', 'becomes', 'becoming', 'been', 'before', 'beforehand',
		'behind', 'being', 'believe', 'below', 'beside', 'besides',
		'best', 'better', 'between', 'beyond', 'both', 'brief', 'but',
		'by', 'c\'mon', 'c\'s', 'came', 'can', 'can\'t', 'cannot',
		'cant', 'cause', 'causes', 'certain', 'certainly', 'changes',
		'clearly', 'co', 'com', 'come', 'comes', 'concerning',
		'consequently', 'consider', 'considering', 'contain',
		'containing', 'contains', 'corresponding', 'could',
		'couldn\'t', 'course', 'currently', 'definitely', 'described',
		'despite', 'did', 'didn\'t', 'different', 'do', 'does',
		'doesn\'t', 'doing', 'don\'t', 'done', 'down', 'downwards',
		'during', 'each', 'edu', 'eg', 'eight', 'either', 'else',
		'elsewhere', 'enough', 'entirely', 'especially', 'et', 'etc',
		'even', 'ever', 'every', 'everybody', 'everyone', 'everything',
		'everywhere', 'ex', 'exactly', 'example', 'except', 'far',
		'few', 'fifth', 'first', 'five', 'followed', 'following', 
		'follows', 'for', 'former', 'formerly', 'forth', 'four',
		'from', 'further', 'furthermore', 'get', 'gets', 'getting',
		'given', 'gives', 'go', 'goes', 'going', 'gone', 'got',
		'gotten', 'greetings', 'had', 'hadn\'t', 'happens', 'hardly',
		'has', 'hasn\'t', 'have', 'haven\'t', 'having', 'he', 'he\'s',
		'hello', 'help', 'hence', 'her', 'here', 'here\'s',
		'hereafter', 'hereby', 'herein', 'hereupon', 'hers', 'herself',
		'hi', 'him', 'himself', 'his', 'hither', 'hopefully', 'how',
		'howbeit', 'however', 'i\'d', 'i\'ll', 'i\'m', 'i\'ve', 'ie',
		'if', 'ignored', 'immediate', 'in', 'inasmuch', 'inc',
		'indeed', 'indicate', 'indicated', 'indicates', 'inner',
		'insofar', 'instead', 'into', 'inward', 'is', 'isn\'t', 'it',
		'it\'d', 'it\'ll', 'it\'s', 'its', 'itself', 'just', 'keep',
		'keeps', 'kept', 'know', 'knows', 'known', 'last', 'lately',
		'later', 'latter', 'latterly', 'least', 'less', 'lest', 'let',
		'let\'s', 'like', 'liked', 'likely', 'little', 'look',
		'looking', 'looks', 'ltd', 'mainly', 'many', 'may', 'maybe',
		'me', 'mean', 'meanwhile', 'merely', 'might', 'more',
		'moreover', 'most', 'mostly', 'much', 'must', 'my', 'myself',
		'name', 'namely', 'nd', 'near', 'nearly', 'necessary', 'need',
		'needs', 'neither', 'never', 'nevertheless', 'new', 'next',
		'nine', 'no', 'nobody', 'non', 'none', 'noone', 'nor',
		'normally', 'not', 'nothing', 'novel', 'now', 'nowhere',
		'obviously', 'of', 'off', 'often', 'oh', 'ok', 'okay', 'old',
		'on', 'once', 'one', 'ones', 'only', 'onto', 'or', 'other',
		'others', 'otherwise', 'ought', 'our', 'ours', 'ourselves',
		'out', 'outside', 'over', 'overall', 'own', 'particular',
		'particularly', 'per', 'perhaps', 'placed', 'please', 'plus',
		'possible', 'presumably', 'probably', 'provides', 'que',
		'quite', 'qv', 'rather', 'rd', 're', 'really', 'reasonably',
		'regarding', 'regardless', 'regards', 'relatively',
		'respectively', 'right', 'said', 'same', 'saw', 'say',
		'saying', 'says', 'second', 'secondly', 'see', 'seeing',
		'seem', 'seemed', 'seeming', 'seems', 'seen', 'self', 'selves',
		'sensible', 'sent', 'serious', 'seriously', 'seven', 'several',
		'shall', 'she', 'should', 'shouldn\'t', 'since', 'six', 'so',
		'some', 'somebody', 'somehow', 'someone', 'something',
		'sometime', 'sometimes', 'somewhat', 'somewhere', 'soon',
		'sorry', 'specified', 'specify', 'specifying', 'still', 'sub',
		'such', 'sup', 'sure', 't\'s', 'take', 'taken', 'tell',
		'tends', 'th', 'than', 'thank', 'thanks', 'thanx', 'that',
		'that\'s', 'thats', 'the', 'their', 'theirs', 'them',
		'themselves', 'then', 'thence', 'there', 'there\'s',
		'thereafter', 'thereby', 'therefore', 'therein', 'theres',
		'thereupon', 'these', 'they', 'they\'d', 'they\'ll',
		'they\'re', 'they\'ve', 'think', 'third', 'this', 'thorough',
		'thoroughly', 'those', 'though', 'three', 'through',
		'throughout', 'thru', 'thus', 'to', 'together', 'too', 'took',
		'toward', 'towards', 'tried', 'tries', 'truly', 'try',
		'trying', 'twice', 'two', 'un', 'under', 'unfortunately',
		'unless', 'unlikely', 'until', 'unto', 'up', 'upon', 'us',
		'use', 'used', 'useful', 'uses', 'using', 'usually', 'value',
		'various', 'very', 'via', 'viz', 'vs', 'want', 'wants', 'was',
		'wasn\'t', 'way', 'we', 'we\'d', 'we\'ll', 'we\'re', 'we\'ve',
		'welcome', 'well', 'went', 'were', 'weren\'t', 'what',
		'what\'s', 'whatever', 'when', 'whence', 'whenever', 'where',
		'where\'s', 'whereafter', 'whereas', 'whereby', 'wherein',
		'whereupon', 'wherever', 'whether', 'which', 'while',
		'whither', 'who', 'who\'s', 'whoever', 'whole', 'whom',
		'whose', 'why', 'will', 'willing', 'wish', 'with', 'within',
		'without', 'won\'t', 'wonder', 'would', 'would', 'wouldn\'t',
		'yes', 'yet', 'you', 'you\'d', 'you\'ll', 'you\'re', 'you\'ve',
		'your', 'yours', 'yourself', 'yourselves', 'zero');

	/**
	 * Constructor
	 * @param $incltext string Text from the content-incl form field
	 * @param $excltext string Text from the content-excl form field
	 * @param $inclcats string Text from the cats-incl form field
	 * @param $exclcats string Text from the cats-excl form field
	 * @param $speedcats array Array of speedcat categories
	 * @param $namespaces array Array of NS_* constants
	 * @param $permalink bool If true, cache this query longer
	 */
	public function __construct($incltext, $excltext, $inclcats, $exclcats, $speedcats, $dropdown, $namespaces, $searchTitle, $searchContent)
	{
		$this->mInclText = $this->parse($incltext, true);
		$this->mExclText = $this->parse($excltext, true);

		$sc = implode(' ' . wfMsg('advancedsearch-keyword-or') . ' ', $speedcats);
		$ic = "( $inclcats ) AND ( $sc ) AND ( $dropdown )";
		$this->mInclCats = $this->parse($ic, false);
		$this->mExclCats = $this->parse($exclcats, false);
		$this->mNamespaces = $namespaces;
		$this->mSearchTitle = $searchTitle;
		$this->mSearchContent = $searchContent;
		$this->mKey = md5(implode("\0", array($incltext, $excltext, $ic, $exclcats,
						implode(',', $namespaces),
						$searchTitle ? 1 : 0,
						$searchContent ? 1 : 0)));

		# Check whether all namespace boxes were checked
		# If so, save some work
		if($this->mNamespaces == array_keys(AdvancedSearch::searchableNamespaces()))
			$this->mNamespaces = array();
		$this->mDb = wfGetDb(DB_SLAVE);
	}
	
	public function getSearchTitle()
	{
		return $this->mSearchTitle;
	}
	
	public function getSearchContent()
	{
		return $this->mSearchContent;
	}
	
	public function cacheQuery()
	{
		global $wgMemc;
		$key = wfMemcKey('advancedsearch', $this->mKey);
		$wgMemc->set($key, $this);
		return $this->mKey;
	}
	
	public static function newFromKey($key)
	{
		global $wgMemc;
		$retval = $wgMemc->get(wfMemcKey('advancedsearch', $key));
		if($retval instanceof AdvancedSearchPager)
			$retval->mDb = wfGetDb(DB_SLAVE);
		return $retval;
	}

	/**
	 * Find out whether any errors occurred when parsing the search strings
	 * @return array Array of errors, which are either strings or false (no error)
	 */
	public function getParseErrors()
	{
		return array(
			(is_string($this->mInclText) ? $this->mInclText : false),
			(is_string($this->mExclText) ? $this->mExclText : false),
			(is_string($this->mInclCats) ? $this->mInclCats : false),
			(is_string($this->mExclCats) ? $this->mExclCats : false)
		);
	}

	/**
	 * Get a value from an array
	 * @param $arr array Array to get the value from
	 * @param $indices array Array of indices, i.e. array(1,2,3) gets $arr[1][2][3]
	 * @return mixed
	 */
	public static function getFromArray($arr, $indices)
	{
		$i = array_shift($indices);
		if(empty($indices))
			return @$arr[$i];
		return self::getFromArray(@$arr[$i], $indices);
	}

	/**
	 * Set a value in an array
	 * @param $value mixed Value to set
	 * @param $arr array Array to work on
	 * @param $indices array See getFromArray()
	 */
	public static function setInArray($value, &$arr, $indices)
	{
		$i = array_shift($indices);
		if(empty($indices))
			$arr[$i] = $value;
		else
			self::setInArray($value, $arr[$i], $indices);
	}

	/**
	 * Parse text from a form field
	 * @param $text string Text from a form field
	 * @param $parseSpaces bool If true, parse spaces as ANDs
	 * @return mixed Array, or error message (string) if $text is invalid
	 */
	protected function parse($text, $parseSpaces)
	{
		$arr = array();
		$boom = explode(' ', $text);
		// Keep track of where we are in $arr
		$indices = array(0, 0);
		$depth = 0;
		$tokens = array(wfMsg('advancedsearch-keyword-and'),
				wfMsg('advancedsearch-keyword-or'),
				'(', ')', '');
		// We can expect two things:
		// 'token': we expect AND, OR, ) or a continuation
		// 'word': we expect ( or text
		$expecting = 'word';
		for($i = 0; $i < count($boom); $i++)
		{
			if($expecting == 'token')
			{
				if($boom[$i] == wfMsg('advancedsearch-keyword-and'))
				{
					// Increment the last index
					end($indices);
					$indices[key($indices)]++;
					$expecting = 'word';
					continue;
				}
				if($boom[$i] == wfMsg('advancedsearch-keyword-or'))
				{
					// Increment the second-to-last index
					// and set the last one to 0
					end($indices);
					$indices[key($indices)] = 0;
					prev($indices);
					$indices[key($indices)]++;
					$expecting = 'word';
					continue;
				}
				// ( is invalid here
				if($boom[$i] == '(')
					return wfMsg('advancedsearch-parse-error-1',
						htmlspecialchars(@$boom[$i - 1]),
						htmlspecialchars($boom[$i]),
						htmlspecialchars(@$boom[$i + 1]));
				// We found a word, so it's a continuation
				if($parseSpaces && $boom[$i] != ')')
				{
					// Increment the last index
					end($indices);
					$indices[key($indices)]++;
				}
			}
			// We're expecting a word
			// Check that it's not a token
			if($boom[$i] == wfMsg('advancedsearch-keyword-and') ||
						$boom[$i] == wfMsg('advancedsearch-keyword-or'))
				return wfMsg('advancedsearch-parse-error-1',
					htmlspecialchars(@$boom[$i - 1]),
					htmlspecialchars($boom[$i]),
					htmlspecialchars(@$boom[$i + 1]));
			// See if it's ( or )
			if($boom[$i] == '(')
			{
				// Go one level deeper
				$indices[] = 0;
				$indices[] = 0;
				$depth++;
				$expecting = 'word';
				continue;
			}
			if($boom[$i] == ')')
			{
				// Go one level down
				$depth--;
				if($depth < 0)
					// More ) than (
					return wfMsg('advancedsearch-parse-error-2',
						htmlspecialchars(@$boom[$i - 1]),
						htmlspecialchars($boom[$i]),
						htmlspecialchars(@$boom[$i + 1]));
				array_pop($indices);
				array_pop($indices);
				$expecting = 'token';
				continue;
			}
			// Parse quotes
			if(substr($boom[$i], 0, 1) == '"')
			{
				$word = $boom[$i];
				while(substr($word, -1) !== '"')
				{
					$i++;
					if(!isset($boom[$i]))
						return wfMsg('advancedsearch-parse-error-4');
					$word .= ' '. $boom[$i];
				}
				# Strip the quotes
				$word = substr($word, 1, -1);
			}
			else
				$word = $boom[$i];
			// Put this word in the array
			$lastAdded = self::getFromArray($arr, $indices);
			if(empty($lastAdded))
			{
				if($parseSpaces || in_array(@$boom[$i + 1], $tokens))
				{ 
					# We got a single word. Check that it's not too
					# short or a stop word
					if(strlen($word) <= 3 && $word != '')
						return wfMsg('advancedsearch-parse-error-5', $word);
					if(in_array($word, self::$stopWords))
						return wfMsg('advancedsearch-parse-error-6', $word);
				}
				self::setInArray($word, $arr, $indices);
			}
			else
				self::setInArray("$lastAdded $word", $arr, $indices);
			$expecting = 'token';
		}
		// Check if all ( were closed
		if($depth != 0)
			return wfMsg('advancedsearch-parse-error-3');
		return $arr;
	}
	
	/**
	 * Is an array really empty? Also checks for nested emptiness, e.g.
	 * array(array(''))
	 * @param $arr array
	 * @return bool
	 */
	static function isEmpty($arr)
	{
		if(empty($arr))
			return true;
		if(!is_array($arr))
			return false;
		foreach($arr as $a)
			if(!self::isEmpty($a))
				return false;
		return true;
	} 

	/**
	 * Generate a MATCH condition
	 * @param $arr array $m{Incl,Excl}{Text,Cats}
	 * @return string A MATCH condition
	 */
	protected function getMatchString($arr)
	{
		$conds = array();
		foreach($arr as $a)
		{
			$subconds = array();
			foreach((array)$a as $b)
			{
				if(is_array($b))
				{
					$m = $this->getMatchString($b);
					if(!empty($m))
						$subconds[] = "+($m)";
				}
				else
				{
					global $wgContLang;
					$s = $wgContLang->stripForSearch($b);
					$s = $this->mDb->strencode($s);
					# If $s contains spaces or ( ) :, quote it
					if(strpos($s, ' ') !== false
						|| strpos($s, '(') !== false
						|| strpos($s, ')') !== false
						|| strpos($s, ':') !== false)
							$s = "\"$s\"";
					if(!empty($s))
						$subconds[] = "+$s";
				}
			}
			$sc = implode(' ', $subconds);
			if(!empty($sc))
				$conds[] = "($sc)";
		}
		return implode(' ', $conds);
	}
	
	/**
	 * Get the DB key for a category
	 * @param $c string Category name
	 */
	public static function categoryKey(&$c)
	{
		$t = Title::makeTitleSafe(NS_CATEGORY, $c);
		if(!$t)
			return false;
		$c = $t->getDBkey();
	}

	public function getQueryInfo()
	{
		$db = $this->mDb;
		$retval = array();

		$incltext = $db->strencode($this->getMatchString($this->mInclText));
		$excltext = $db->strencode($this->getMatchString($this->mExclText));
		array_walk_recursive($this->mInclCats, array(__CLASS__, 'categoryKey'));
		array_walk_recursive($this->mExclCats, array(__CLASS__, 'categoryKey'));
		$inclcats = $db->strencode($this->getMatchString($this->mInclCats));
		$exclcats = $db->strencode($this->getMatchString($this->mExclCats));
		
		$retval['tables'][] = 'page';
		if(!self::isEmpty($this->mInclText) || !self::isEmpty($this->mExclText))
		{
			$retval['tables'][] = 'searchindex';
			$retval['conds'][] = 'page_id=si_page';
			if(!self::isEmpty($this->mInclText))
			{
				$titlecond = $contentcond = $cond = '';
				if($this->mSearchTitle)
					$titlecond = "MATCH (si_title) AGAINST ('$incltext' IN BOOLEAN MODE)";
				if($this->mSearchContent)
					$contentcond = "MATCH (si_text) AGAINST ('$incltext' IN BOOLEAN MODE)";
				if(!empty($titlecond) && !empty($contentcond))
					$cond = "$titlecond OR $contentcond";
				else
					$cond = $titlecond . $contentcond;
				if(!empty($cond))
					$retval['conds'][] = $cond;
			}
			if(!self::isEmpty($this->mExclText))
			{
				$titlecond = $contentcond = $cond = '';
				if($this->mSearchTitle)
					$titlecond = "NOT MATCH (si_title) AGAINST ('$excltext' IN BOOLEAN MODE)";
				if($this->mSearchContent)
					$contentcond = "NOT MATCH (si_text) AGAINST ('$excltext' IN BOOLEAN MODE)";
				if(!empty($titlecond) && !empty($contentcond))
					$cond = "$titlecond OR $contentcond";
				else
					$cond = $titlecond . $contentcond;
				if(!empty($cond))
					$retval['conds'][] = $cond;
			}
		}
		if(!self::isEmpty($this->mInclCats) || !self::isEmpty($this->mExclCats))
		{
			$retval['tables'][] = 'categorysearch';
			$retval['conds'][] = 'page_id=cs_page';
			if(!self::isEmpty($this->mInclCats))
				$retval['conds'][] = "MATCH (cs_categories) AGAINST ('$inclcats' IN BOOLEAN MODE)";
			if(!self::isEmpty($this->mExclCats))
				$retval['conds'][] = "NOT MATCH (cs_categories) AGAINST ('$exclcats' IN BOOLEAN MODE)";
		}
		if(!empty($this->mNamespaces))
			$retval['conds']['page_namespace'] = $this->mNamespaces;
			
		$retval['fields'] = array('page_namespace', 'page_title');
		return $retval;
	}

	public function reallyDoQuery()
	{
		if(isset($this->mResult))
			return $this->mResult;
		global $wgRequest;
		list($this->mLimit, $this->mOffset) = $wgRequest->getLimitOffset(50, 'limit');
		$info = $this->getQueryInfo();
		$tables = $info['tables'];
		$fields = $info['fields'];
		$conds = isset($info['conds']) ? $info['conds'] : array();
		$options = isset($info['options']) ? $info['options'] : array();
		$join_conds = isset($info['join_conds']) ? $info['join_conds'] : array();
		if($this->mOffset != '')
			$options['OFFSET'] = intval($this->mOffset);
		$options['LIMIT'] = intval($this->mLimit);
		$this->mResult = $this->mDb->select($tables, $fields, $conds, __METHOD__, $options, $join_conds);
		return new ResultWrapper($this->mDb, $this->mResult);		
	}
	
	public function getNumRows()
	{
		if(!isset($this->mResult))
			$this->reallyDoQuery();
		return $this->mResult->numRows();
	}		

	public function preprocessResults($result)
	{
		# Run a LinkBatch query
		$lb = new LinkBatch;
		$result->rewind();
		while(($row = $result->fetchObject()))
			$lb->add($row->page_namespace, $row->page_title);
		$lb->execute();
		$result->rewind();
	}

	public function getStartBody()
	{
		return Xml::openElement('table') . Xml::openElement('tr');
	}

	public function getEndBody()
	{
		return Xml::closeElement('tr') . Xml::closeElement('table');
	}

	public function formatRow($row)
	{
		global $wgUser;
		static $i = 0;
		$open = Xml::openElement('td', array('valign' => 'top')) . Xml::openElement('ul');
		$close = Xml::closeElement('ul') . Xml::closeElement('td');
		$tdb = $tdf = '';
		if($i == 0)
			$tdb = $open;
		else if($i == ceil($this->mLimit / 2))
			$tdb = $close . $open;
		else if($i == $this->mLimit - 1)
			$tdf = $close;
		$i++; 
		$title = Title::makeTitle($row->page_namespace, $row->page_title);
		$link = $wgUser->getSkin()->makeLinkObj($title, htmlspecialchars($title->getPrefixedText()));
		return $tdb . Xml::tags('li', null, $link) . $tdf . "\n";		
	}
	
	protected function getDefaultQuery()
	{
		$retval = $_GET;
		unset($retval['offset']);
		unset($retval['limit']);
		unset($retval['title']);
		return $retval;
	}
	
	public function getBody()
	{
		$res = $this->reallyDoQuery();
		$this->preprocessResults($res);
		$prevnext = wfViewPrevNext($this->mOffset, $this->mLimit,
				SpecialPage::getTitleFor('AdvancedSearch'),
				wfArrayToCGI($this->getDefaultQuery()),
				($this->getNumRows() < $this->mLimit));
		$retval = $this->getStartBody();
		while(($row = $res->fetchObject()))
			$retval .= $this->formatRow($row);
		$retval .= $this->getEndBody();
		return $prevnext . $retval . $prevnext;
	}
}

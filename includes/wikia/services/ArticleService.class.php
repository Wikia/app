<?php
class ArticleService extends Service {

	const MAX_CACHED_TEXT_LENGTH = 500;
	const CACHE_KEY = 'article_service_cache';

	private $mArticle = null;

	private $mTagsToRemove = array(
			'noscript',
			'script',
			'th',
			'figure',
			'h[1-6]'
	);

	public function __construct( $articleId = 0 ) {
		$this->setArticleById( $articleId );
	}

	public function setArticleById( $articleId ) {
		$this->mArticle = F::build('Article',array($articleId), 'newFromID');
	}

	/**
	 * get text snippet of article content
	 *
	 * @param int $articleId article id
	 * @param int $length snippet length
	 * @return string
	 */
	public function getTextSnippet( $length = 100 ) {
		wfProfileIn(__METHOD__);

		$wgParser = F::App()->wg->parser;
		$wgContLang = F::App()->wg->contLang;

		// it may sometimes happen that the aricle is just not there
		if ( is_null( $this->mArticle ) ) {
			wfProfileOut(__METHOD__);
			return '';
		}

		$oMemCache = F::App()->wg->memc;
		$sKey = F::App()->wf->sharedMemcKey(
			self::CACHE_KEY,
			$this->mArticle->getID(),
			F::App()->wg->cityId
		);

		$cachedResult = self::MAX_CACHED_TEXT_LENGTH >= $length ? $oMemCache->get( $sKey ) : false;
		if(!is_string($cachedResult)){
			wfProfileIn(__METHOD__ . '::miss');

			$content = $this->mArticle->getContent();
			// Run hook to allow wikis to modify the content (ie: customize their snippets) before the stripping and length limitations are done.
			wfRunHooks( 'ArticleService::getTextSnippet::beforeStripping', array( &$this->mArticle, &$content, $length ) );

			// Perl magic will happen! Beware! Perl 5.10 required!
			$re_magic = '#SSX(?<R>([^SE]++|S(?!S)|E(?!E)|SS(?&R))*EE)#i';

			// (RT #73141) saves {{PAGENAME}} and related tags from deletion; Not using parser because of options problems via ajax.
			$content = str_replace("{{PAGENAME}}", wfEscapeWikiText( $this->mArticle->getTitle()->getText() ), $content);
			$content = str_replace("{{FULLPAGENAME}}", wfEscapeWikiText( $this->mArticle->getTitle()->getPrefixedText() ), $content);
			$content = str_replace("{{BASEPAGENAME}}", wfEscapeWikiText( $this->mArticle->getTitle()->getBaseText() ), $content);

			// remove {{..}} tags
			$re = strtr( $re_magic, array( 'S' => "\\{", 'E' => "\\}", 'X' => '' ));
			$content = preg_replace($re, '', $content);

			// remove [[Image:...]] and [[File:...]] tags
			$nsFile = $wgContLang->getNsText( NS_FILE );
			$nsFileAlias = $this->getNsAlias( NS_FILE ); // [[Image:...]]
			if( empty( $nsFileAlias ) ) {
				// hardcoded "Image" as fallback, just in case
				$nsFileAlias = 'Image';
			}
			$re = strtr( $re_magic, array( 'S' => "\\[", 'E' => "\\]", 'X' => "($nsFileAlias:$nsFile):" ));
			$content = preg_replace($re, '', $content);

			// skip "edit" section and TOC
			$content .= "\n__NOEDITSECTION__\n__NOTOC__";

			// remove parser hooks from wikitext (RT #72703)
			$hooks = $wgParser->getTags();
			$hooksRegExp = implode('|', array_map('preg_quote', $hooks));
			$content = preg_replace('#<(' . $hooksRegExp . ')[^>]{0,}>(.*)<\/[^>]+>#', '', $content);

			$tmpParser = new Parser();
			$content = $tmpParser->parse( $content,  $this->mArticle->getTitle(), new ParserOptions )->getText();

			// the ? in (.*?) is INCREDIBLY important, guaranting non-greedy behaviour
			foreach ( $this->mTagsToRemove as $tag ) {
				$content = preg_replace( "#<{$tag}[^>]*>(.*?)<\/{$tag}>#s", '', $content );
			}

			// strip HTML tags
			$content = trim(strip_tags($content));
			$content = mb_substr($content, 0, $length + 200);
			// stripping some html entities
			$content = strtr($content, array('&nbsp;' => ' ', '&amp;' => '&', '&bull;' => ''));
			// stripping leftover '[' & ']' as well as things between them
			$content = preg_replace('/\[(.*?)\]/', '', $content);
			// stripping leading non-alnum characters
			$content = preg_replace('/^[[:punct:][:space:][:cntrl:]]*/', "", $content);
			// compress white characters
			$content = preg_replace('/\s+/',' ',$content);
			$content = trim( $content );
			if(mb_strlen($content) > $length) {
				$content = mb_substr( $content, 0, $length-3 );
				$content = mb_substr( $content, 0, mb_strrpos($content,' ')) . '...';
			}

			$cacheContent = mb_substr( $content, 0, self::MAX_CACHED_TEXT_LENGTH-3 );

			if ( $length <= self::MAX_CACHED_TEXT_LENGTH ){
				$oMemCache->set( $sKey, $cacheContent, 86400 );
			} else {
				wfDebug(__METHOD__ . ": requested string to long to be cached. Served without cache \n");
			}

			wfProfileOut(__METHOD__ . '::miss');
		} else {
			$content = $cachedResult;
		}

		$content = mb_substr( $content, 0, $length );

		// store first x characters of parsed content
		if ($content == '') {
			wfDebug(__METHOD__ . ": got empty snippet for article #{$this->mArticle->getID()}\n");
		}

		wfProfileOut(__METHOD__);
		return $content;
	}

	private function getNsAlias( $ns ) {
		foreach( F::app()->wg->NamespaceAliases as $alias => $nsAlias ) {
			if( $nsAlias == $ns ) {
				return $alias;
			}
		}
		return null;
	}

	static public function onArticlePurge( Article $article ) {
		$title = $article->getTitle();

		$a = new Title;

		$oMemCache = F::App()->wg->memc;
		$sKey = F::App()->wf->sharedMemcKey(
			self::CACHE_KEY,
			$article->getID(),
			F::App()->wg->cityId
		);

		$oMemCache->delete( $sKey );

		return true;
	}
}

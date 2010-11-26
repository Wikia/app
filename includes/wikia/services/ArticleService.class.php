<?php
class ArticleService extends Service {

	private $mArticle = null;

	public function __construct( $articleId = 0 ) {
		$this->setArticleById( $articleId );
	}

	public function setArticleById( $articleId ) {
		$this->mArticle = Article::newFromID( $articleId );
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
		global $wgTitle, $wgParser;

		$content = $this->mArticle->getContent();

		if( !empty( $content) ) {
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
			$re = strtr( $re_magic, array( 'S' => "\\[", 'E' => "\\]", 'X' => "(Image|File):" ));
			$content = preg_replace($re, '', $content);

			// skip "edit" section and TOC
			$content .= "\n__NOEDITSECTION__\n__NOTOC__";

			// remove parser hooks from wikitext (RT #72703)
			$hooks = $wgParser->getTags();
			$hooksRegExp = implode('|', array_map('preg_quote', $hooks));
			$content = preg_replace('#<(' . $hooksRegExp . ')[^>]{0,}>(.*)<\/[^>]+>#', '', $content);

			$tmpParser = new Parser();
			$content = $tmpParser->parse( $content,  $this->mArticle->getTitle(), new ParserOptions )->getText();

			// remove <script> tags (RT #46350)
			$content = preg_replace('#<script[^>]+>(.*)<\/script>#', '', $content);

			// experimental: remove <th> tags
			$content = preg_replace('#<th[^>]*>(.*?)<\/th>#s', '', $content);

			// remove HTML tags
			$content = trim(strip_tags($content));

			// compress white characters
			$content = mb_substr($content, 0, $length + 200);
			$content = strtr($content, array('&nbsp;' => ' ', '&amp;' => '&'));
			$content = preg_replace('/\s+/',' ',$content);

			// store first x characters of parsed content
			$content = trim(mb_substr($content, 0, $length));

			if ($content == '') {
				wfDebug(__METHOD__ . ": got empty snippet for article #{$this->mArticle->getID()}\n");
			}
		}

		wfProfileOut(__METHOD__);
		return $content;
	}
}
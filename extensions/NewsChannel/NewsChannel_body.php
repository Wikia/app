<?php
/**
* News Channel extension
* This MediaWiki extension represents a RSS 2.0/Atom 1.0 news channel for wiki project.
* 	The channel is implemented as a dynamic [[Special:NewsChannel|special page]].
* 	All pages from specified category (e.g. "Category:News") are considered
* 	to be articles about news and published on the site's news channel.
* File with extension's main source code.
* Requires MediaWiki 1.8 or higher.
* Extension's home page: http://www.mediawiki.org/wiki/Extension:News_Channel
*
* Copyright (c) Moscow, 2008, Iaroslav Vassiliev  <codedriller@gmail.com>
* Distributed under GNU General Public License 2.0 or later (http://www.gnu.org/copyleft/gpl.html)
*/

if (!defined('MEDIAWIKI')) die();

/**
 * Class manages Special:NewsChannel page and feed ouput.
 */
class NewsChannel extends SpecialPage
{
	var $feedFormat = '';
	var $renderingPage = null;

	/**
	 * Constructor is used to initialize class member variables and load extension messages.
	 */
	function NewsChannel() {
		SpecialPage::SpecialPage( 'NewsChannel' );
	}

	/**
	 * This essential function is called when user requests Special:NewsChannel page or
	 * requests feed data. It also checks some configuration settings.
	 *
	 * @param string $par Custom parameters.
	 */
	function execute( $par ) {
		global $wgRequest, $wgVersion, $wgOut, $wgNewsChannelCategory, $wgNewsChannelDefaultItems;

		wfLoadExtensionMessages( 'NewsChannel' );

		if( version_compare( $wgVersion, '1.8', '<' ) === true ) {
			$wgOut->showErrorPage( "Error: Upgrade required", "The News Channel extension can't work " .
				"on MediaWiki older than 1.8. Please, upgrade." );
			return;
		}

		if( $wgNewsChannelCategory == '' || $wgNewsChannelCategory == null ) {
			$wgOut->showErrorPage( "Error: Misconfiguration", "Main category containing news articles " .
				"was not defined for News Channel extension. Please, define it." );
			return;
		}

		if( $wgNewsChannelDefaultItems <= 0 ) {
			$wgOut->showErrorPage( "Error: Misconfiguration", "Default number of recent (most fresh) " .
				"news to list on the channel was not defined correctly. Please, redefine it." );
			return;
		}

		$this->feedFormat = $wgRequest->getVal( 'format' );
		if( $this->feedFormat == '' || $this->feedFormat == null )
			$this->showForm();
		elseif( $this->feedFormat == 'rss20' || $this->feedFormat == 'atom10' )
			$this->showChannel();
		else
			$wgOut->showErrorPage( "Error: Unknown output format", "The News Channel extension " .
				"does not support specified output format: " . htmlentities( $this->feedFormat ) .
				". Please, choose another format." );
	}

	/**
	 * This is extension's main function. It processes user request, queries the database
	 * and formats news items for feed. Then it outputs the feed by calling
	 * outputChannelMarkup( $newsItems ) function.
	 */
	function showChannel() {
		global $wgContLang, $wgCanonicalNamespaceNames, $wgServer, $wgStylePath, $wgRequest, $wgOut;
		global $wgNewsChannelDefaultItems, $wgNewsChannelMaxItems, $wgNewsChannelAuthorizedEditors;
		global $wgNewsChannelCategory, $wgNewsChannelExcludeCategory, $wgNewsChannelRemoveArticlePrefix;

		wfProfileIn( 'NewsChannel::showChannel' );

		$wgOut->clearHTML();
		$wgOut->disable();

		print $this->formatFeedHeader();

		$dbr = wfGetDB( DB_SLAVE );

		$authorizedEditorsStr = $dbr->makeList( $wgNewsChannelAuthorizedEditors );

		$format = $wgRequest->getVal( 'format' );

		$limit = $wgRequest->getInt( 'limit', $wgNewsChannelDefaultItems );
		if( $limit <= 0 )
			$limit = $wgNewsChannelDefaultItems;
		elseif( $limit > $wgNewsChannelMaxItems )
			$limit = $wgNewsChannelMaxItems;

		$categoryPrefixesRegex = '/^(' .
			preg_quote( $wgContLang->getNsText( NS_CATEGORY ), "/" ) . '|' .
			preg_quote( $wgCanonicalNamespaceNames[ NS_CATEGORY ] ) . '):/i';

		$inCategoriesStr = $dbr->addQuotes( str_replace( ' ', '_', $wgNewsChannelCategory ) ) . ',';
		$inCategoriesCount = 1;
		if( $this->newsWikiExcludeCategory != '' || $this->newsWikiExcludeCategory != null ) {
			$exCategoriesStr = $dbr->addQuotes( str_replace( ' ', '_', $wgNewsChannelExcludeCategory ) ) . ',';
			$exCategoriesCount = 1;
		}
		else {
			$exCategoriesStr = '';
			$exCategoriesCount = 0;
		}
		for( $i = 1; $i <= 8; $i++ ) {
			$category = trim( $wgRequest->getVal( 'cat' . $i ) );
			if( $category != null && $category != '' ) {
				$category = ucfirst( preg_replace( $categoryPrefixesRegex, '', $category ) );
				$inCategoriesStr .= $dbr->addQuotes( str_replace( ' ', '_', $category ) ) . ',';
				$inCategoriesCount++;
			}
			$category = trim( $wgRequest->getVal( 'excat' . $i ) );
			if( $category != null && $category != '' ) {
				$category = ucfirst( preg_replace( $categoryPrefixesRegex, '', $category ) );
				$exCategoriesStr .= $dbr->addQuotes( str_replace( ' ', '_', $category ) ) . ',';
				$exCategoriesCount++;
			}
		}
		$inCategoriesStr = rtrim( $inCategoriesStr, ',' );
		$exCategoriesStr = rtrim( $exCategoriesStr, ',' );

		if( version_compare( mysql_get_server_info(), '4.1', '>=' ) === true )
			$subquerySupport = true;
		else
			$subquerySupport = false;

		$pageTableName = $dbr->tableName( 'page' );
		$revisionTableName = $dbr->tableName( 'revision' );
		$catlinksTableName = $dbr->tableName( 'categorylinks' );
		$newsItemsCount = 0;
		$sqlQueryStr = '';
		$exCatSqlQueryStr = '';

		if ( $subquerySupport == false ) {
			$sqlQueryStr =
				"SELECT {$catlinksTableName}.cl_from, " .
					"MIN({$catlinksTableName}.cl_timestamp) AS timestamp, COUNT(*) AS match_count, " .
					"{$pageTableName}.page_namespace AS ns, {$pageTableName}.page_title AS title, " .
					"{$pageTableName}.page_id AS id, {$revisionTableName}.rev_user_text AS user " .
				"FROM {$catlinksTableName}, {$pageTableName}, {$revisionTableName} " .
				"WHERE cl_to IN({$inCategoriesStr}) " .
					"AND {$catlinksTableName}.cl_from = {$pageTableName}.page_id " .
					"AND {$pageTableName}.page_latest = {$revisionTableName}.rev_id " .
				"GROUP BY cl_from " .
				"HAVING match_count = {$inCategoriesCount} " .
				"ORDER BY match_count DESC, timestamp DESC " .
				"LIMIT " . strval( $limit * 2 );
			$exCatSqlQueryStr = "SELECT COUNT(*) AS count FROM {$catlinksTableName} " .
				"WHERE cl_from = %s AND cl_to IN({$exCategoriesStr})";
			$dbr2 = wfGetDB( DB_SLAVE );
		}
		else {
			$accessResriction = (count( $this->authorizedEditors ) > 0)
				? "AND {$revisionTableName}.rev_user_text IN ({$authorizedEditorsStr})" : '';
			$exCatSqlQueryStr = ($exCategoriesCount > 0) ? "AND cl_from NOT IN " .
					"(SELECT cl_from FROM {$catlinksTableName} WHERE cl_to IN({$exCategoriesStr}))" : '';
			$sqlQueryStr =
				"SELECT {$pageTableName}.page_namespace AS ns, {$pageTableName}.page_title AS title, " .
					"matches.min_timestamp AS timestamp " .
				"FROM {$pageTableName}, {$revisionTableName}, " .
					"(SELECT cl_from, MIN(cl_timestamp) AS min_timestamp, COUNT(*) AS match_count " .
					"FROM {$catlinksTableName} " .
					"WHERE cl_to IN({$inCategoriesStr}) {$exCatSqlQueryStr} " .
					"GROUP BY cl_from) AS matches " .
				"WHERE matches.match_count = {$inCategoriesCount} " .
					"AND matches.cl_from = {$pageTableName}.page_id " .
					"AND {$pageTableName}.page_latest = {$revisionTableName}.rev_id " .
					"{$accessResriction} " .
				"ORDER BY timestamp DESC " .
				"LIMIT {$limit}";
		}

		$res = $dbr->query( $sqlQueryStr, 'NewsChannel::showChannel', false );
		while( ($row = $dbr->fetchObject( $res )) && $newsItemsCount <= $limit ) {
			if( $subquerySupport == false ) {
				if( count( $wgNewsChannelAuthorizedEditors ) > 0 &&
					!in_array( $row->user, $wgNewsChannelAuthorizedEditors ) )
						continue;
				if( $exCategoriesCount > 0 ) {
					$res2 = $dbr2->query( sprintf( $exCatSqlQueryStr, $row->id ),
						'NewsChannel::showChannel', false );
					$row2 = $dbr2->fetchObject( $res2 );
					$skipRow = intval( $row2->count );
					$dbr2->freeResult( $res2 );
					if( $skipRow > 0 )
						continue;
				}
			}
			$titleObj = Title::newFromText( $row->title, $row->ns );
			$title = $titleObj->getText();
			if( strlen( $wgNewsChannelRemoveArticlePrefix ) > 0
				&& strpos( $title, $wgNewsChannelRemoveArticlePrefix ) === 0)
					$title = substr( $title, strlen( $wgNewsChannelRemoveArticlePrefix ) );
			$title = $this->xmlEncode( $title );
			$article = new Article( $titleObj, 0 );
			$content = $this->renderWikiMarkup( $article->getContent() );
			$link = $this->xmlEncode( $titleObj->getFullURL() );
			if( $this->feedFormat == 'rss20' ) {
				print "\n" .
'		<item>
			<title>' . $title . '</title>
			<link>' . $link . '</link>
			<description>' . $content . '</description>
			<pubDate>' . date( DATE_RSS, wfTimestamp( TS_UNIX, $row->timestamp ) ) . '</pubDate>
			<guid>' . $link . '</guid>
		</item>';
			}
			elseif( $this->feedFormat == 'atom10' ) {
				print "\n" .
'		<entry>
			<title>' . $title . '</title>
			<link href="' . $link . '" />
			<summary type="html">' . $content . '</summary>
			<updated>' . date( DATE_ATOM, wfTimestamp( TS_UNIX, $row->timestamp ) ) . '</updated>
			<id>' . $link . '</id>
		</entry>';
			}
			$newsItemsCount++;
		}
		$dbr->freeResult( $res );

		print $this->formatFeedFooter();

		wfProfileOut( 'NewsChannel::showChannel' );

	}

	/**
	 * Function formats channel's header.
	 */
	function formatFeedHeader() {
		global $wgRequest, $wgServer, $wgContLanguageCode, $wgOut;
		global $wgNewsChannelTitle, $wgNewsChannelDescription, $wgNewsChannelCopyright,
			$wgNewsChannelLanguage, $wgNewsChannelLogoImage, $wgNewsChannelUpdateInterval,
			$wgNewsChannelEditorName, $wgNewsChannelEditorAddress, $wgNewsChannelWebMasterName,
			$wgNewsChannelWebMasterAddress;

		if( empty( $wgNewsChannelLanguage ) )
			$wgNewsChannelLanguage = $wgContLanguageCode;

		$output = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

		if( $this->feedFormat == 'rss20' ) {
			header( 'Content-type: application/rss+xml; charset=utf-8' );
			$output .=
'<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<title>' . $this->xmlEncode( $wgNewsChannelTitle ) . '</title>
		<link>' . $this->xmlEncode( $wgServer ) . '/</link>
		<description>' . $this->xmlEncode( $wgNewsChannelDescription ) . '</description>
		<language>' . $this->xmlEncode( $wgNewsChannelLanguage ) . '</language>
		<copyright>' . $this->xmlEncode( $wgNewsChannelCopyright ) . '</copyright>
		<image>
			<url>' . $this->xmlEncode( $wgNewsChannelLogoImage ) . '</url>
			<title>' . $this->xmlEncode( $wgNewsChannelTitle ) . '</title>
			<link>' . $this->xmlEncode( $wgServer ) . '/</link>
		</image>
		<lastBuildDate>' . date( DATE_RSS ) . '</lastBuildDate>
		<generator>News Channel 1.61 (MediaWiki extension)</generator>
		<docs>http://www.rssboard.org/rss-specification</docs>
		<ttl>' . $this->xmlEncode( strval ( $wgNewsChannelUpdateInterval ) ) . '</ttl>
		<atom:link href="' . $this->xmlEncode( $wgRequest->getFullRequestURL() ) .
			'" rel="self" type="application/rss+xml" />';
			if ($wgNewsChannelEditorAddress != null && $wgNewsChannelEditorAddress != '')
				$output .=
'		<managingEditor>' . $this->xmlEncode( $wgNewsChannelEditorAddress ) . ' (' .
			$this->xmlEncode( $wgNewsChannelEditorName ) . ')</managingEditor>';
			if ($wgNewsChannelWebMasterAddress != null && $wgNewsChannelWebMasterAddress != '')
				$output .=
'		<webMaster>' . $this->xmlEncode( $wgNewsChannelWebMasterAddress ) . ' (' .
			$this->xmlEncode( $wgNewsChannelWebMasterName ) . ')</webMaster>';
		}
		elseif( $this->feedFormat == 'atom10' ) {
			header( 'Content-type: application/atom+xml; charset=utf-8' );
			$langCode = $wgNewsChannelLanguage;
			if( strrpos( $langCode, '-' ) !== false )
				$langCode = substr( $langCode, 0, strrpos( $langCode, '-') );
			$output .=
'<feed xmlns="http://www.w3.org/2005/Atom" xml:lang="' . $langCode . '">
	<title>' . $this->xmlEncode( $wgNewsChannelTitle ) . '</title>
	<subtitle>' . $this->xmlEncode( $wgNewsChannelDescription ) . '</subtitle>
	<link href="' . $this->xmlEncode( $wgServer ) . '/" />
	<id>' . $this->xmlEncode( $wgServer ) . '/</id>
	<rights>' . $this->xmlEncode( $wgNewsChannelCopyright ) . '</rights>
	<icon>' . $this->xmlEncode( $wgNewsChannelLogoImage ) . '</icon>
	<updated>' . date( DATE_ATOM ) . '</updated>
	<generator>News Channel 1.61 (MediaWiki extension)</generator>
	<link href="' . $this->xmlEncode( $wgRequest->getFullRequestURL() ) .
		'" rel="self" type="application/atom+xml" />';
			if ($wgNewsChannelEditorAddress != null && $wgNewsChannelEditorAddress != '')
				$output .=
'	<author>
		<name>' . $this->xmlEncode( $wgNewsChannelEditorName ) . '</name>
		<email>' . $this->xmlEncode( $wgNewsChannelEditorAddress ) . '</email>
	</author>';
		}

		return $output;
	}

	/**
	 * Function formats channel's footer.
	 */
	function formatFeedFooter() {

		if( $this->feedFormat == 'rss20' )
			$output = "\n\n</channel>\n</rss>";
		elseif( $this->feedFormat == 'atom10' )
			$output = "\n</feed>";
		return $output;
	}

	/**
	 * Function converts wiki markup to HTML using MediaWiki parser.
	 *
	 * @param string $text Text with wiki markup to render.
	 */
	function renderWikiMarkup( $text ) {
		global $wgServer;

		if ( $this->renderingPage == null )
			$this->renderingPage = new OutputPage();
		else
			$this->renderingPage->clearHTML();

		$this->renderingPage->addWikiText( $text );
		$text = $this->renderingPage->getHTML();

		if ( $wgNewsChannelExportTextOnly ) {
			$text = preg_replace( '/<(img|embed) [^>]+>/is', '', $text );
			$text = preg_replace( '/<object .+?<\/object>/is', '', $text );
		}
		else {
			$text = str_replace( " src=\"/", " src=\"{$wgServer}/", $text );
			$text = str_replace( " src='/", " src='{$wgServer}/", $text );
		}

		$text = str_replace( " href=\"/", " href=\"{$wgServer}/", $text );
		$text = str_replace( " href='/", " href='{$wgServer}/", $text );

		$text = $this->xmlEncode( $text );
		return $text;
	}

	/**
	 * Function prepares text for publication in XML document.
	 *
	 * @param string $text Text to make suitable for XML.
	 */
	function xmlEncode( $string ) {
		$string = str_replace( "\r\n", "\n", $string );
		$string = preg_replace( '/[\x00-\x08\x0b\x0c\x0e-\x1f]/', '', $string );
		return htmlspecialchars( $string );
	}

	/**
	 * Function arranges HTML form in which user can choose feed parameters.
	 */
	function showForm() {
		global $wgContLang, $wgScript, $wgOut;
		global $wgNewsChannelCategory, $wgNewsChannelExcludeCategory, $wgNewsChannelDefaultItems;

		$wgOut->setPagetitle( wfMsgHtml( 'newschannel' ) );
		$titleObj = Title::makeTitle( NS_SPECIAL, 'NewsChannel' );
		$msgPrefixedTitle = htmlspecialchars( $titleObj->getPrefixedText() );
		$msgFormat = wfMsgHtml( 'newschannel_format' );
		$msgLimit = wfMsgHtml( 'newschannel_limit' );
		$msgCat = htmlspecialchars( $wgContLang->getNsText( NS_CATEGORY ) ) . ':';
		$msgInCat = wfMsgHtml( 'newschannel_include_category' );
		$msgExCat = wfMsgHtml( 'newschannel_exclude_category' );
		$msgSubmitButton = wfMsgHtml( 'newschannel_submit_button' );
		$msgActionScript = htmlspecialchars( $wgScript );
		$msgNewsCategory = htmlspecialchars( $wgNewsChannelCategory );

		$htmlDefaultExcludeCategory = '';
		if ( $wgNewsChannelExcludeCategory != '' && $wgNewsChannelExcludeCategory != null ) {
			$msgNewsExcludeCategory = htmlspecialchars( $wgNewsChannelExcludeCategory );
			$htmlDefaultExcludeCategory = '
		<tr style="margin-top: 2em">
			<td align="right">' . $msgExCat . '</td>
			<td><input type="text" size="60" name="excat" ' .
				'disabled="disabled" value="' . $msgNewsExcludeCategory . '" /></td>
		</tr>';
		}

		$wgOut->addHTML( '
	<form id="newschannel" method="GET" action="' . $msgActionScript . '">
		<input type="hidden" readonly="readonly" name="title" value="' . $msgPrefixedTitle . '" />
	<table border="0">
		<tr>
			<td rowspan="1" align="right">' . $msgFormat . '</td>
			<td><input type="radio" checked="checked" name="format" ' .
				'value="rss20" style="border: none; margin-right: 1em" />RSS 2.0</td>
		</tr>
		<tr>
			<td></td>
			<td><input type="radio" name="format" ' .
				'value="atom10" style="border: none; margin-right: 1em" />Atom 1.0</td>
		</tr>
		<tr style="margin-top: 2em">
			<td align="right">' . $msgLimit . '</td>
			<td><input type="text" maxlength="3" size="12" name="limit" ' .
				'value="' . $wgNewsChannelDefaultItems . '" /></td>
		</tr>
		<tr style="margin-top: 2em">
			<td align="right">' . $msgCat . '</td>
			<td><input type="text" size="60" disabled="disabled" name="cat" ' .
				'value="' . $msgNewsCategory . '" /></td>
		</tr>
		<tr style="margin-top: 2em">
			<td align="right">' . $msgInCat . '</td>
			<td><input type="text" size="60" name="cat1" value="" /></td>
		</tr>
		<tr style="margin-top: 2em">
			<td align="right">' . $msgInCat . '</td>
			<td><input type="text" size="60" name="cat2" value="" /></td>
		</tr>' . $htmlDefaultExcludeCategory . '
		<tr style="margin-top: 2em">
			<td align="right">' . $msgExCat . '</td>
			<td><input type="text" size="60" name="excat1" value="" /></td>
		</tr>
		<tr style="margin-top: 2em">
			<td align="right"></td>
			<td style="padding-top: 1em" align="left">
				<input type="submit" name="wpSubmitNewsChannelParams" ' .
					'value="' . $msgSubmitButton . '" />
			</td>
		</tr>
	</table>
	</form>' . "\n" );
	}
}

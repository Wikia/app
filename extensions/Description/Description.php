<?php
/**
 * Description.php -- Adds meaningful description <meta> tag to MW pages
 * Copyright 2008 Vinismo, Inc. (http://vinismo.com/)
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @author Evan Prodromou <evan@vinismo.com>
 * @addtogroup Extensions
 */


if (!defined('MEDIAWIKI')) {
	exit( 1 );
}

define('DESCRIPTION_VERSION', '0.1');

$wgExtensionFunctions[] = 'DescriptionSetup';
$wgExtensionCredits['other'][] = array('name' => 'Description',
									   'version' => DESCRIPTION_VERSION,
									   'author' => 'Evan Prodromou',
									   'url' => 'http://www.mediawiki.org/wiki/Extension:Description',
									   'description' => 'Adds a description meta-tag to MW pages');

function DescriptionSetup() {
	
	global $wgHooks;
	
	$wgHooks['ArticleViewHeader'][] = 'DescriptionArticleViewHeader';
}

function DescriptionArticleViewHeader(&$article, &$outputDone = null, &$pcache = null) {
	global $wgOut;
	
	$desc = DescriptionFromArticle($article);
	
	if (!is_null($desc)) {
		$wgOut->addMeta('description', htmlspecialchars($desc));
	}
	
	return TRUE;
}

function DescriptionFromArticle(&$article) {

	if (defined('MWRDF_VERSION')) {
		$desc = DescriptionFromRDF($article);
	}
	
	if (is_null($desc) || strlen($desc) == 0) {
		$desc = DescriptionFromText($article);
	}
	
	return $desc;
}

function DescriptionFromRDF(&$article) {

	$nt = $article->getTitle();
	$uri = $nt->getFullUrl();
	
	$model = MwRdfGetModel($article);

	$results = $model->rdqlQuery("SELECT ?description " .
								 "WHERE (<$uri> dc:description ?description) " .
								 "USING dc FOR http://purl.org/dc/elements/1.1/",
								 FALSE);

	$desc = '';
	
	foreach ($results as $row) {
		$rowval = preg_replace("/^\"(.*?)\"$/", '\1', $row['?description']);
		$desc .= (($desc) ? ' ' : '') . $rowval;
	}
	
	return $desc;
}

function DescriptionFromText(&$article) {
	global $wgParser, $wgContLang;
	
	# Expand all templates
	
	$text = $article->getContent(true);
	$text = $wgParser->preprocess($text, $article->mTitle, new ParserOptions());
	
	# Find first non-ws, non-empty, non-image, non-table content

	$imageLabel = $wgContLang->getNsText(NS_IMAGE);

	$paragraphs = explode("\n", $text);

	$desc = '';
	
	foreach ($paragraphs as $paragraph) {
		if (preg_match("/^\s*(=|__|\[\[[Ii]mage:|\[\[$imageLabel:|\{\||\|#|\*)/", $paragraph)) {
			continue;
		} else if (preg_match("/^\s*$/", $paragraph)) {
			continue;
		} else {
			$desc = DescriptionStripParagraph($paragraph);
			break;
		}
	}
	
	return $desc;
}

function DescriptionStripParagraph($para) {
		$para = preg_replace("/'''''(.*?)'''''/", '\1', $para);
		$para = preg_replace("/'''(.*?)'''/", '\1', $para);
		$para = preg_replace("/''(.*?)''/", '\1', $para);
		$para = preg_replace("@<(.*?)>(.*?)</\1>@", '\2', $para);		
		$para = preg_replace("/\[\[([^\]]*?)\|([^\]]*?)\]\]/", '\2', $para);
		$para = preg_replace("/\[\[([^\]]*?)\]\]/", '\1', $para);	
		$para = preg_replace("/\[(\S*)\s+(.*?)\]/", '\2', $para);
		$para = preg_replace("/\[(\S*)\s*\]/", '\1', $para);
	
		return $para;
}
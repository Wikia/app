<?php
if (!defined('MEDIAWIKI')) die();
/**
 * MwRdf.php -- RDF framework for MediaWiki
 * Copyright 2005,2006 Evan Prodromou <evan@wikitravel.org>
 * Copyright 2007 Mark Jaroski
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
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA *
 * @author Evan Prodromou <evan@wikitravel.org>
 * @author Mark Jaroski <mark@geekhive.net>
 * @package MediaWiki
 * @subpackage Extensions
 */

require_once( 'includes/Parser.php' );

class MwRdf_InPage_Modeler extends MwRdf_Modeler {

	public function getName() { return 'inpage'; }

	public function build() {
		$article = $this->Agent->getArticle();
		$text = $article->getContent(true);
		# Strip comments and <nowiki>
		$text = preg_replace("/<!--.*?-->/s", "", $text);
		$text = preg_replace("@<nowiki>.*?</nowiki>@s", "", $text);
		# change template usage to substitution; note that this is WRONG
		#$tchars = Title::legalChars();
		#$text = preg_replace("/(?<!{){{([$tchars]+)(\|.*?)?}}(?!})/", "{{subst:$1$2}}", $text);
		$parser = new Parser();
		# so the magic variables work out right
		$parser->mOptions = new ParserOptions();
		$parser->mTitle = $this->Agent->getTitle();
		$parser->mOutputType = OT_WIKI;
		$parser->initialiseVariables();
		$parser->clearState();
		$text = $parser->replaceVariables($text);
		preg_match_all("@<rdf>(.*?)</rdf>@s", $text, $matches, PREG_PATTERN_ORDER);
		$content = $matches[1];
		$rdf = implode(' ', array_values($content));
		$model = MwRdf::Model();
		if (strlen($rdf) > 0) {
			$parser->mOutputType = OT_HTML;
			$rdf = $parser->replaceVariables($rdf);
			$turtle_parser = MwRdf::Parser('turtle');
			$base_uri = $this->Agent->getTitle()->getFullUrl();
			$prelude = MwRdf::getNamespacePrelude();
			$model->loadStatementsFromString( $turtle_parser, $prelude . $rdf );
		}
		return $model;
	}
}

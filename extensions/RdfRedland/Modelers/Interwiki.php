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

class MwRdf_Interwiki_Modeler extends MwRdf_Modeler {

	public function getName() {
		return 'interwiki';
	}

	public function build() {
		global $wgContLang;

		$dc = MwRdf::Vocabulary( 'dc' );
		$dcterms = MwRdf::Vocabulary( 'dcterms' );
		$rdfs = MwRdf::Vocabulary( 'rdfs' );

		$model = MwRdf::Model();
		$tr = $this->Agent->titleResource();
		$article = $this->Agent->getArticle();
		$text = $article->getContent( true );

		$parser = new Parser();
		$parser->mOptions = new ParserOptions();
		$parser->mTitle = $this;
		$parser->initialiseVariables();
		$parser->clearState();
		$tags = array( 'nowiki' );
		$m = array();
		$text = $parser->extractTagsAndParams( $tags, $text, $m );

		# XXX: maybe it would actually be better to do this at another
		# stage after the parser has already identified interwiki and
		# lang links
		# Find prefixed links
		preg_match_all( "/\[\[([^|\]]+:[^|\]]+)(\|.*)?\]\]/", $text, $m );
		if ( ! isset( $m[0] ) )
		return $model; // nothing found so nevermind

		foreach ($m[1] as $linktext) {
			$iwlink = Title::newFromText( $linktext );
			if ( isset( $iwlink ) ) {
				$pfx = $iwlink->getInterwiki();
				if ( strlen( $pfx ) > 0 ) {
					$iwlinkmf = MwRdf::ModelingAgent( $iwlink );
					$iwr = $iwlinkmf->titleResource();
					# XXX: Wikitravel uses some 4+ prefixes for sister site links
					if ( $wgContLang->getLanguageName( $pfx ) && strlen( $pfx ) < 4) {
						$model->addStatement(
						MwRdf::Statement( $tr, $dcterms->hasVersion, $iwr ) );
						$model->addStatement(
						MwRdf::Statement( $iwr, $dc->language,
						MwRdf::Language( $pfx ) ) );
					} else {
						# XXX: Express the "sister site" relationship better
						$model->addStatement( MwRdf::Statement(
						$tr, $rdfs->seeAlso, $iwr));
					}
				}
			}
		}
		return $model;
	}
}

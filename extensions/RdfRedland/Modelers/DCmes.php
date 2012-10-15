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

require_once( 'includes/Namespace.php' );

class MwRdf_DCmes_Modeler extends MwRdf_Modeler {

	public function getName() {
		return 'dcmes';
	}

	public function isDefault() {
		return 'true';
	}

	public function build() {
		global $wgSitename, $wgContLanguageCode;

		$article = $this->Agent->getArticle();
		$model = MwRdf::Model();

		$rdf    = MwRdf::Vocabulary( 'rdf' );
		$dc     = MwRdf::Vocabulary( 'dc' );
		$dctype = MwRdf::Vocabulary( 'dctype' );

		$artres = $this->Agent->titleResource();

		$model->addStatement( MwRdf::Statement(
		$artres,
		$dc->title,
			MwRdf::LiteralNode( $this->Agent->getTitle()->getText() ) ) );
		$model->addStatement( MwRdf::Statement(
		$artres,
		$dc->publisher,
			MwRdf::PageOrString( wfMsg( 'aboutpage' ), $wgSitename ) ));
		$model->addStatement( MwRdf::Statement(
		$artres,
		$dc->language,
			MwRdf::Language( $wgContLanguageCode ) ) );
		$model->addStatement( MwRdf::Statement(
		$artres,
		$dc->type,
		$dctype->Text ) );
		$model->addStatement( MwRdf::Statement(
		$artres,
		$dc->format,
			MwRdf::MediaType( 'text/html' ) ) );

		if ( $this->Agent->getTimestampResource() ) {
			$model->addStatement( MwRdf::Statement(
			$artres,
			$dc->date,
			$this->Agent->getTimestampResource() ) );
		}

		if ( MWNamespace::isTalk( $this->Agent->getTitle()->getNamespace() ) ) {
			$model->addStatement( MwRdf::Statement(
			$artres,
			$dc->subject,
			$this->Agent->subjectResource() ) );
		} else {
			$talk = MwRdf::ModelingAgent( $this->Agent->getTitle()->getTalkPage() );
			$model->addStatement( MwRdf::Statement(
			$talk->titleResource(),
			$dc->subject,
			$artres ) );
		}

		# 'Creator' is responsible for this version
		$creator = MwRdf::PersonToResource( $article->getUser() );
		$model->addStatement( MwRdf::Statement(
		$artres, $dc->creator, $creator));

		# 'Contributors' are all other version authors
		$contributors = $article->getContributors();
		foreach ($contributors as $user_parts) {
			$contributor = MwRdf::PersonToResource(
			$user_parts[0], $user_parts[1], $user_parts[2]);
			$model->addStatement( MwRdf::Statement(
			$artres, $dc->contributor, $contributor));
		}

		# Rights notification
		global $wgRightsPage, $wgRightsUrl, $wgRightsText;

		$rights = MwRdf::RightsResource();
		if ( $rights ) {
			$model->addStatement( MwRdf::Statement(
			$artres, $dc->rights, $rights));
		}

		return $model;
	}
}

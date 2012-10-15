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

class MwRdf_CreativeCommons_Modeler extends MwRdf_Modeler {

	public function getName() { return 'cc'; }

	public function build() {
		global $wgRightsUrl;
		$rdf = MwRdf::Vocabulary( 'rdf' );
		$cc = MwRdf::Vocabulary( 'cc' );
		$model = MwRdf::Model();

		$tr = $this->Agent->titleResource();
		$model->addStatement( MwRdf::Statement(
		$tr, $rdf->a, $cc->Work ) );

		if ( ! isset( $wgRightsUrl ) ) return $model;
		$lr = MwRdf::UriNode( $wgRightsUrl );
		$model->addStatement( MwRdf::Statement(
		$tr, $cc->license, $lr ) );
		$model->addStatement( MwRdf::Statement(
		$lr, $rdf->a, $cc->License ) );

		$terms = MwRdf::GetCcTerms( $wgRightsUrl );
		if ( ! isset( $terms ) ) return $model;

		foreach ($terms as $term) {
			switch ($term) {
				case 're':
					$model->addStatement( MwRdf::Statement(
					$lr, $cc->permits, $cc->Reproduction));
					break;
				case 'di':
					$model->addStatement( MwRdf::Statement(
					$lr, $cc->permits, $cc->Distribution));
					break;
				case 'de':
					$model->addStatement( MwRdf::Statement(
					$lr, $cc->permits, $cc->DerivativeWorks));
					break;
				case 'nc':
					$model->addStatement( MwRdf::Statement(
					$lr, $cc->prohibits, $cc->CommercialUse));
					break;
				case 'no':
					$model->addStatement( MwRdf::Statement(
					$lr, $cc->requires, $cc->Notice));
					break;
				case 'by':
					$model->addStatement( MwRdf::Statement(
					$lr, $cc->requires, $cc->Attribution));
					break;
				case 'sa':
					$model->addStatement( MwRdf::Statement(
					$lr, $cc->requires, $cc->ShareAlike));
					break;
				case 'sc':
					$model->addStatement( MwRdf::Statement(
					$lr, $cc->requires, $cc->SourceCode));
					break;
			}
		}

		return $model;
	}
}

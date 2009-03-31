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

require_once( 'includes/filerepo/LocalFile.php' );

class MwRdf_Image_Modeler extends MwRdf_Modeler {

	public function getName() { return 'image'; }

	public function build() {
		global $wgServer;
		$dc = MwRdf::Vocabulary( 'dc' );
		$dcterms = MwRdf::Vocabulary( 'dcterms' );
		$dctype = MwRdf::Vocabulary( 'dctype' );
		$model = MwRdf::Model();
		$tr = $this->Agent->titleResource();
		$dbr =& wfGetDB( DB_SLAVE );
		$res = $dbr->select('imagelinks',
		array('il_to'),
		array('il_from = ' . $this->Agent->getTitle()->getArticleID()),
		'MwRdfImage');
		while ($res && $row = $dbr->fetchObject($res)) {
			$img = Image::newFromName($row->il_to);
			if ( ! $img->exists() ) continue;
			$iuri = $img->getURL();
			if ($iuri[0] == '/') $iuri = $wgServer . $iuri;
			$ir = MwRdf::UriNode( $iuri );
			$model->addStatement( MwRdf::Statement(
			$tr, $dcterms->hasPart, $ir ) );
			$model->addStatement( MwRdf::Statement(
			$ir, $dc->type, $dctype->Image ) );
			$mt = $img->getMimeType();
			if (isset($mt)) {
				$model->addStatement( MwRdf::Statement(
				$ir, $dc->format, MwRdf::MediaType( $mt ) ) );
			}
			$hist_line = $img->nextHistoryLine();
			if ( ! isset( $hist_line ) ) continue;
			$creator = MwRdf::PersonToResource(
			$hist_line->img_user, $hist_line->img_user_text,
			User::whoIsReal( $hist_line->img_user ) );
			$model->addStatement( MwRdf::Statement(
			$ir, $dc->creator, $creator));
			$model->addStatement( MwRdf::Statement(
			$ir, $dc->date, MwRdf::TimestampResource( $hist_line->img_timestamp ) ) );
			$seen = array( $hist_line->img_user => true );

			while ( $hist_line = $img->nextHistoryLine() ) {
				if ( isset( $seen[$hist_line->img_user] ) ) continue;
				$contributor = MwRdf::PersonToResource(
				$hist_line->img_user, $hist_line->img_user_text,
				User::whoIsReal($hist_line->img_user ) );
				$model->addStatement( MwRdf::Statement( $ir, $dc->contributor, $contributor ) );
				$seen[$hist_line->img_user] = true;
			}
		}

		$dbr->freeResult($res);
		return $model;
	}
}

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

class MwRdf_LinksFrom_Modeler extends MwRdf_Modeler {

	public function getName() {
		return 'linksfrom';
	}

	public function isDefault() {
		return 'true';
	}

	public function build() {
		$dcterms = MwRdf::Vocabulary( 'dcterms' );
		$model = MwRdf::Model();
		$tr = $this->Agent->titleResource();
		$dbr =& wfGetDB(DB_SLAVE);
		$res = $dbr->select( 'pagelinks',
			array('pl_namespace', 'pl_title'),
			array('pl_from = ' . $this->Agent->getTitle()->getArticleID()),
			'MwRdfLinksFrom',
			array('ORDER BY' => 'pl_namespace, pl_title'));
		while ($res && $row = $dbr->fetchObject($res)) {
			$lt = Title::makeTitle($row->pl_namespace, $row->pl_title);
			$ltmf = MwRdf::ModelingAgent( $lt );
			$model->addStatement( MwRdf::Statement(
			$tr, $dcterms->references, $ltmf->titleResource() ) );
		}
		$dbr->freeResult($res);
		return $model;
	}
}

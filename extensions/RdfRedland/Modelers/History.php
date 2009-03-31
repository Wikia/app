<?php
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

class MwRdf_History_Modeler extends MwRdf_Modeler {

	public function getName() { return 'history'; }

	public function build() {
		global $wgContLanguageCode;
		$dc = MwRdf::Vocabulary( 'dc' );
		$dcterms = MwRdf::Vocabulary( 'dcterms' );
		$model = MwRdf::Model();
		$tr = $this->Agent->titleResource();
		$dbr =& wfGetDB( DB_SLAVE );
		$res = $dbr->select( array('page', 'revision'),
		array('rev_id', 'rev_timestamp', 'rev_user', 'rev_user_text'),
		array('page_namespace = ' . $this->Agent->getTitle()->getNamespace(),
			'page_title = ' . $dbr->addQuotes( $this->Agent->getTitle()->getDBkey() ),
			'rev_page = page_id',
			'rev_id != page_latest'),
		'MwRdfHistory',
		array('ORDER BY' => 'rev_timestamp DESC'));
		while ($res && $row = $dbr->fetchObject($res)) {
			$url = $this->Agent->getTitle()->getFullURL('oldid=' . $row->rev_id);
			$ur = MwRdf::UriNode( $url );
			$model->addStatement( MwRdf::Statement(
			$tr, $dcterms->hasVersion, $ur ) );
			$model->addStatement( MwRdf::Statement(
			$ur, $dcterms->isVersionOf, $tr ) );
			$model->addStatement( MwRdf::Statement(
			$ur, $dc->language, MwRdf::Language( $wgContLanguageCode ) ) );
			$realname = ($row->rev_user == 0) ? null : User::whoIsReal($row->rev_user);
			$pr = MwRdf::PersonToResource(
			$row->rev_user, $row->rev_user_text, $realname );
			$model->addStatement( MwRdf::Statement(
			$ur, $dc->creator, $pr ) );
			$model->addStatement( MwRdf::Statement(
			$ur, $dc->date, MwRdf::TimestampResource( $row->rev_timestamp ) ) );
		}
		$dbr->freeResult($res);
		return $model;
	}
}

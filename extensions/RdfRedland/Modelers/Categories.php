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

class MwRdf_Categories_Modeler extends MwRdf_Modeler {

	public function getName() {
		return 'categories';
	}

	public function isDefault() {
		return 'true';
	}

	public function build() {
		$dc = MwRdf::Vocabulary( 'dc' );
		$model = MwRdf::Model();
		$ar = $this->Agent->titleResource();
		$categories = $this->Agent->getTitle()->getParentCategories();
		if ( is_array( $categories ) ) {
			foreach ( array_keys($categories) as $category ) {
				$catmf = MwRdf::ModelingAgent( Title::newFromText( $category ) );
				$model->addStatement( MwRdf::Statement(
				$ar, $dc->subject, $catmf->titleResource() ) );

			}
		}
		return $model;
	}
}

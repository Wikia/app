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

abstract class MwRdf_Modeler implements MwRdf_ModelMaker {

	public $Agent;

	public function __construct( $modeling_agent ) {
		$this->Agent = $modeling_agent;
	}

	public function isDefault() { return false; }

	public function getName() {}

	public function build() {}

	public function store() {
		$model = $this->build();
		$context = $this->Agent->getContextNode( $this->getName() );
		$store = MwRdf::StoredModel();
		$stream = librdf_model_as_stream( $model->getModel() );
		librdf_model_context_add_statements(
		$store->getModel(),
		$context->getNode(),
		$stream );
		librdf_free_stream( $stream );
		return true;
	}

	public function retrieve() {
		$sm = MwRdf::StoredModel();
		$model = MwRdf::Model();
		$context = $this->Agent->getContextNode( $this->getName() );
		$stream = librdf_model_context_as_stream(
		$sm->getModel(), $context->getNode() );
		librdf_model_add_statements( $model->getModel(), $stream );
		librdf_free_stream( $stream );
		$sm->rewind();
		return $model;
	}

	public function getQueryString() { return null; }
}

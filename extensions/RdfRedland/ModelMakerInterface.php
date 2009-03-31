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

/*
 * The model maker interface allows developers to add models to the
 * Special Rdf page model selector.  The functions defined allow for
 * the creation, storage, and retrieval, or just retrieval of triples
 * in just about any way that the developer can imagine.
 *
 * The MwRdf_Modeler class provides an abstract implementation of this
 * interface which handles storage and retrieval which leaves you with
 * only the build() and getName() methods to implement.
 *
 * The MwRdf_QueryModeler class provides an abstract implementation
 * which allows you to create models from the store by mearly declaring
 * a SPARQL CONSTRUCT query.
 *
 */
interface MwRdf_ModelMaker {

/*
 * Called by the ModelingAgent object during setup, the constructor
 * should set the $Agent member for reference by build().
 */
public function __construct( $modeling_agent );

/*
 * This function is called several times within the the MwRdf
 * library.  It should return the name of the model as it is to
 * appear in the selector of the RDF Special Page.
 *
 * @returns string $modelname
 */
public function getName();

/*
 * This function is actually more of a constant.  Use it to
 * indicate whether or not your model should be returned in the
 * default model search.
 *
 * @returns boolean $isDefault
 */
public function isDefault();

/*
 * This method should build a LibRDF model for the title contained
 * in this ModelMaker's ModelingAgent.  You can fetch the title
 * with a call to $this->Agent->getTitle(), or the page object
 * with a call to $this->Agent->getArticle().  See
 * ModelingAgent.php for more useful methods.
 *
 * @returns LibRDF_Model $model
 */
public function build();

/*
 * This method should store the model in the persistent RDF store.
 *
 * The MwRDF_Modeler abstract class implements this method for you.
 */
public function store();

/*
 * This method should retrieve the model from the persistent RDF store.
 * This may be accomplished by a simple modelname lookup or by
 * using a CONSTRUCT SPARQL query.
 */
public function retrieve();

/*
 * Use this method to return a SPARQL query which uses a CONSTRUCT
 * clause to create a new model.  You should usually return null if
 * you are building a model from scratch.
 *
 * @returns String $query
 */
public function getQueryString();
}

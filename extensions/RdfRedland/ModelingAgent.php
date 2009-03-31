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

class MwRdf_ModelingAgent {

	public $ModelMakers = array();

	private $Title;
	private $Article;
	private $linkedTitles;

	function __construct( $par ) {
		$is_obj = ( gettype( $par ) == 'object' );
		if ( $is_obj && $par instanceof Title ) {
			$this->Title = $par;
			$this->Article = new Article( $par );
		} elseif ( $is_obj && $par instanceof Article ) {
			$this->Article = $par;
			$this->Title = $par->getTitle();
		} else {
			throw new Exception( 'An MwRdf_ModelingAgent requires '
			. 'either a Title or an Article Object.' );
		}
		if ( $this->Title->getNamespace() == NS_SPECIAL ) {
			throw new Exception( 'An MwRdf_ModelingAgent cannot be built '
			. 'for a Special page.' );
		}
		foreach ( MwRdf::$ModelMakers as $class ) {
			$this->registerModelMaker( $class );
		}
		return;
	}

	public function getTitle() {
		return $this->Title;
	}

	public function getArticle() {
		return $this->Article;
	}

	public function registerModelMaker( $classname ) {
		$mm = new $classname( $this );
		$name = $mm->getName();
		$this->ModelMakers[$name] = $mm;
	}

	public function unregisterModelMakers() {
		$this->ModelMakers = array();
	}

	public function listModelNames() {
		$names = array_keys( $this->ModelMakers );
		if ( $names ) {
			return $names;
		} else {
			return array();
		}
	}

	public function buildModel( $name ) {
		if ( gettype( $name ) != 'string' )
		throw new Exception(
		"The argument for buildModel() must be a string." );
		if ( ! isset( $this->ModelMakers[$name] ) )
		throw new Exception(
		"$name is not a registered ModelMaker." );
		$mm = $this->ModelMakers[$name];
		return $mm->build();
	}

	public function isDefault( $name ) {
		if ( gettype( $name ) != 'string' )
		throw new Exception(
		"The argument for isDefault() must be a string." );
		if ( ! isset( $this->ModelMakers[$name] ) )
		throw new Exception(
		"$name is not a registered ModelMaker." );
		$mm = $this->ModelMakers[$name];
		return $mm->isDefault();
	}

	public function titleResource() {
		$uri = $this->Title->getFullUrl();
		return MwRdf::UriNode( $uri );
	}

	public function subjectResource() {
		$uri = $this->Title->getSubjectPage()->getFullUrl();
		return MwRdf::UriNode( $uri );
	}

	public function getTimestampResource() {
		if ( ! $this->Title->exists() ) return false;
		$article = $this->Article;
		$timestamp = $article->getTimestamp();
		return MwRdf::TimestampResource( $timestamp );
	}

	public function getContributorResources() {
		if ( ! $this->Title->exists() ) return false;
		$contributors = array();
		$article = $this->Article;
		foreach ( $article->getContributors() as $row ) {
			$contributors[] = MwRdf::PersonToResource(
			$row[0], $row[1], $row[2] );
		}
		return $contributors;
	}

	public function getLinkedTitles() {
		if ( $this->linkedTitles ) return $this->linkedTitles;
		$this->linkedTitles = array();
		$id = $this->Title->getArticleID();
		if ($id != 0) {
			$dbr =& wfGetDB(DB_SLAVE);
			$res = $dbr->select('pagelinks',
				array('pl_namespace', 'pl_title'),
				array('pl_from = ' . $id),
			'MwRdfOnArticleSave');
			while ( $res && $row = $dbr->fetchObject( $res ) ) {
				$this->linkedTitles[] = Title::makeTitle(
				$row->pl_namespace, $row->pl_title );
			}
		}
		return $this->linkedTitles;
	}

	public function getContextNode( $modelname ) {
		$url = $this->Title->getFullUrl();
		$query = '';
		if ( strpos( $url, '?' ) ) {
			list( $url, $query ) = explode( '?', $url );
			return MwRdf::UriNode( $url . "#$modelname?" . $query );
		} else {
			return MwRdf::UriNode( $url . "#$modelname" );
		}
	}

	public function storeModel( $name ) {
		if ( gettype( $name ) != 'string' )
		throw new Exception(
		"The argument for storeModel() must be a string." );
		if ( ! isset( $this->ModelMakers[$name] ) )
		throw new Exception(
		"$name is not a registered ModelMaker." );
		$mm = $this->ModelMakers[$name];
		$res = $mm->store();
		$mm = null;
		return $res;
	}

	public function retrieveModel( $par ) {
		if ( gettype( $par ) == 'string' )
		$par = array( $par );
		if ( ! gettype( $par ) == 'array' )
		throw new Exception( 'retrieveModel takes either a model '
		. 'name string or an array of modelnames' );
		$model = MwRdf::Model();
		foreach ( $par as $name ) {
			$mm = $this->ModelMakers[$name];
			### TODO Retrieve from Cache if it's there
			$sub_model = $mm->retrieve( $name );
			### TODO Cache the sub_model
			$stream = librdf_model_as_stream( $sub_model->getModel() );
			librdf_model_add_statements( $model->getModel(), $stream );
			librdf_free_stream( $stream );
			$sub_model->rewind();
		}
		return $model;
	}

	public function clearStoredModel( $name ) {
		$context = $this->getContextNode( $name );
		$store = MwRdf::StoredModel();
		librdf_model_context_remove_statements(
		$store->getModel(), $context->getNode() );
		$store->rewind();
		$store = null; # __destruct() causes a segfault
	}

	public function clearAllModels() {
		foreach ( $this->listModelNames() as $name ) {
			$this->clearStoredModel( $name );
		}
	}

	public function storeAllModels() {
		foreach ( $this->listModelNames() as $name ) {
			$this->storeModel( $name );
		}
	}

	public function listDefaultModels() {
		$names = array();
		foreach ( $this->listModelNames() as $name ) {
			$mm = $this->ModelMakers[$name];
			if ( $mm->isDefault() ) $names[] = $name;
		}
		return $names;
	}
}

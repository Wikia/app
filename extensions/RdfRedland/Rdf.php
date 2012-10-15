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

dl('redland.so');

require_once( 'LibRDF/LibRDF.php' );

# Model classes
require_once( 'ModelingAgent.php' );
require_once( 'ModelMakerInterface.php' );
require_once( 'Modeler.php' );
require_once( 'ModelingAgent.php' );
require_once( 'QueryModeler.php' );

# Modelers
require_once( 'Modelers/LinksTo.php' );
require_once( 'Modelers/LinksFrom.php' );
require_once( 'Modelers/CreativeCommons.php' );
require_once( 'Modelers/InPage.php' );
require_once( 'Modelers/DCmes.php' );
require_once( 'Modelers/History.php' );
require_once( 'Modelers/Image.php' );
require_once( 'Modelers/Interwiki.php' );
require_once( 'Modelers/Categories.php' );

# Vocabularies
require_once( 'Vocabulary.php' );
require_once( 'Vocabularies/CreativeCommons.php' );
require_once( 'Vocabularies/Rdf.php' );
require_once( 'Vocabularies/RdfSchema.php' );
require_once( 'Vocabularies/DCmes.php' );
require_once( 'Vocabularies/DCTerms.php' );
require_once( 'Vocabularies/DCMiType.php' );

# Pages
require_once( 'Special/QueryPageInterface.php' );
require_once( 'Special/QueryPage.php' );

/*
* a container for librdf_world, librdf_storage, and a factory class
*/
class MwRdf {

	const VERSION = 0.6;

	// Configuration for librdf storage
	// see http://librdf.org/docs/api/redland-storage-modules.html
	public static $store_type;
	public static $store_name;
	public static $store_options;

	// Configuration to set or reset in LocalSettings.php
	public static $TypePrefs = array(
		'rdfxml' => "application/rdf+xml,text/xml;q=0.7,application/xml;q=0.5,text/rdf;q=0.1",
		'turtle' => "application/x-turtle,application/turtle;q=0.5,text/plain;q=0.1",
		'ntriples' => "text/plain"
	);

	// Model Makers
	public static $ModelMakers = array();

	// Vocabularies
	private static $Vocabularies = array();

	// Serializers
	public static $Serializers = array( 'rdfxml', 'turtle', 'ntriples' );

	// End Configuration

	// containers for librdf environment
	private static $Store;
	private static $StoredModel;

	function Setup() {
		self::LoadVocabularies();
	}

	function LoadVocabularies() {
		global $wgRdfVocabularies;
		if ( ! is_array( $wgRdfVocabularies ) ) return;
		foreach ( $wgRdfVocabularies as $ns => $class ) {
			self::registerVocabulary( $ns, $class );
		}
	}

	/*
	*  Display a form allowing the user to select RDF models, and output
	*  format.
	*
	*  @params  $msg - error message to display
	*/
	function ShowForm( $msg = null ) {
		global $wgOut, $wgUser;
		$mf = self::ModelingAgent( Title::newFromText( 'Main Page' ) );
		$sk = $wgUser->getSkin();
		$instructions = $wgOut->parse(wfMsg('rdf-instructions'));
		if (isset($msg) && strlen($msg) > 0) {
			$wgOut->addHTML("<p class='error'>${msg}</p>");
		}
		$wgOut->addHTML("<p>{$instructions}</p>" .
			"<form action='" . $sk->makeSpecialUrl('Rdf') . "' method='POST'>" .
			"<table border='0'>" .
			"<tr>" .
			"<td align='right'><label for='target'>" . wfMsg('rdf-target') . "</label></td>" .
			"<td align='left'><input type='text' size='30' name='target' id='target' /></td> " .
			"</tr>" .
			"<tr>" .
			"<td align='right'><label for='modelnames[]'>" . wfMsg('rdf-modelnames') . "</label></td>" .
			"<td align='left'><select name='modelnames[]' multiple='multiple' size='6'>");

		foreach ( $mf->listModelNames() as $modelname) {
			$selectedpart = $mf->isDefault( $modelname ) ? "selected='selected'" : "";
			$wgOut->addHTML("<option value='{$modelname}' {$selectedpart}>" . wfMsg('rdf-' . $modelname) . "</option>");
		}
		$wgOut->addHTML("</select></td></tr>" .
			"<tr> " .
			"<td align='right'><label for='format'>" . wfMsg('rdf-format') . "</label></td>" .
			"<td align='left'><select name='format'>");

		foreach ( self::listSerializers() as $outputname) {
			$wgOut->addHTML("<option value='${outputname}'>" . wfMsg('rdf-output-' . $outputname) . "</option>");
		}
		$wgOut->addHTML("</select></td></tr>" .
			"<tr><td>&nbsp;</td>" .
			"<td><input type='submit' /></td></tr></table></form>");
	}

	/*
	 *
	 */
	function Store() {
		global $wgRdfStoreType, $wgRdfStoreName, $wgRdfStoreOptions;
		return new LibRDF_Storage( $wgRdfStoreType,
			$wgRdfStoreName,
			$wgRdfStoreOptions );
	}

	/*
	 * Factory method which creates a ModelingAgent from a title.
	 *
	 * @param Title
	 * @retval MwRdf_ModelingAgent
	 */
	function ModelingAgent( $par = null ) {
		global $wgRdfModelMakers;
		// let the constructor do error checking
		$ma = new MwRdf_ModelingAgent( $par );
		if ( ! is_array( $wgRdfModelMakers ) ) return $ma;
		foreach ( $wgRdfModelMakers as $class ) {
			$ma->registerModelMaker( $class );
		}
		return $ma;
	}

	function Vocabulary( $prefix ) {
		if ( ! isset( self::$Vocabularies[$prefix] ) ) return false;
		if ( gettype( self::$Vocabularies[$prefix] == 'string' ) ) {
			$classname = self::$Vocabularies[$prefix];
			self::$Vocabularies[$prefix] = new $classname();
		}
		return self::$Vocabularies[$prefix];
	}

	function RegisterVocabulary( $prefix, $classname ) {
		if ( ! isset( self::$Vocabularies[$prefix] ) )
		self::$Vocabularies[$prefix] = new $classname();
		if ( !  self::$Vocabularies[$prefix] instanceof $classname )
		self::$Vocabularies[$prefix] = new $classname();
		return true;
	}

	function ListVocabularies() {
		return array_keys( self::$Vocabularies );
	}

	function listSerializers() {
		return self::$Serializers;
	}

	function GetNamespace( $prefix ) {
		if ( self::Vocabulary( $prefix ) ) {
			return self::Vocabulary( $prefix )->getNS();
		} else {
			return false;
		}
	}

	function GetNamespacePrelude() {
		$prelude = '';
		foreach ( self::ListVocabularies() as $prefix ) {
			$uri = self::GetNamespace( $prefix );
			$prelude .= "@prefix $prefix: <$uri> .\n";
		}
		return $prelude;
	}

	function Model() {
		return new LibRDF_Model( new LibRdf_Storage() );
	}

	function StoredModel() {
		return new LibRDF_Model( self::Store() );
	}

	function UriNode( $par ) {
		return new LibRDF_URINode( $par );
	}

	function BlankNode( $par = null ) {
		return new LibRDF_BlankNode( $par );
	}

	function LiteralNode( $par, $type = null, $lang = null ) {
		return new LibRDF_LiteralNode(
		$par, $type, $lang );
	}

	function Iterator( $par ) {
		return new LibRDF_StreamIterator( $par );
	}

	function URI( $par ) {
		return new LibRDF_URI( $par );
	}

	function Statement( $subject, $predicate, $object) {
		if ( ! $subject instanceof LibRdf_Node )
		throw new Exception( "Subject must be of type LibRDF_Node." );
		if ( ! $predicate instanceof LibRdf_Node )
		throw new Exception( "Predicate must be of type LibRDF_Node." );
		if ( ! $object instanceof LibRdf_Node )
		throw new Exception( "Object must be of type LibRDF_Node." );
		return new LibRDF_Statement( $subject, $predicate, $object );
	}

	function Parser( $name = null, $type = null, $uri = null ) {
		return new LibRDF_Parser( $name, $type, $uri );
	}

	function Query( $query_string, $base_uri = null,
	$query_language = 'sparql', $query_uri = null ) {
		return new LibRdf_Query( $query_string, $base_uri,
		$query_language, $query_uri );
	}

	function Serializer( $name ) {
		$ser = new LibRDF_Serializer( $name );
		foreach( self::$Vocabularies as $name => $vocab ) {
			if ( $name == 'rdf' ) continue;
			$ser->setNamespace( $vocab->getNS(), $name );
		}
		return $ser;
	}

	function PageOrString( $pagename, $fallback ) {
		$nt = Title::newFromText( $pagename );
		if ( $nt && $nt->getArticleID() ) {
			$ntr = self::ModelingAgent( $nt );
			return $ntr->titleResource();
		} else {
			return self::LiteralNode( $fallback );
		}
	}

	function NamespacePrefixes() {
		if (!isset($prefixes)) {
			global $wgLang; # all working namespaces
			$prefixes = array();
			$spaces = $wgLang->getNamespaces();
			foreach ($spaces as $code => $text) {
				$prefix = urlencode(str_replace(' ', '_', $text));
				# FIXME: this is a hack
				if (strpos($prefix, '%') === false) {
					# XXX: figure out a less sneaky way to do this
					# XXX: won't work if article title isn't at the end of the URL
					$title = MwRdf_ModelingAgent::makeTitle($code, '');
					$uri = $title->getFullURL();
					$prefixes[$prefix] = $uri;
				}
			}
		}
		return $prefixes;
	}

	function Language( $code ) {
		$ns = self::getNamespace( 'dc' );
		return self::LiteralNode( $code, $ns . 'ISO639-2' );
	}

	function MediaType( $type ) {
		$ns = self::getNamespace( 'dc' );
		return self::LiteralNode( $type, $ns . 'IMT' );
	}

	function PersonToResource( $userid, $username = null, $realname = null ) {
		if ( $userid == 0 )
			return self::LiteralNode( 'anonymous' );
		if ( ! $realname )
			$realname = User::whoIsReal( $userid );
		if ( $realname )
			return self::LiteralNode( $realname );
		if ( ! $username )
		$username = User::whoIs( $userid );
		$user = User::newFromName( $username );
		if ( ! $user )
			return self::LiteralNode( 'anonymous' );
		if ( $user->getUserPage()->exists() ) {
			$mf = self::ModelingAgent( $user->getUserPage() );
			return $mf->titleResource();
		}
		return self::LiteralNode( wfMsg( 'siteuser', $user->getName() ) );
	}

	public function RightsResource() {
		global $wgRightsPage, $wgRightsUrl, $wgRightsText;
		if ( isset( $wgRightsPage )
			&& ( $nt = Title::newFromText($wgRightsPage) )
			&& ( $nt->getArticleID() != 0 ) )
			return self::ModelingAgent( $nt )->titleResource();
		if ( isset($wgRightsUrl) )
			return self::UriNode( $wgRightsUrl );
		if ( isset( $wgRightsText ) )
			return self::LiteralNode( $wgRightsText );
		return false;
	}

	public Function TimestampResource( $timestamp ) {
		$dt = wfTimestamp(TS_DB, $timestamp);
		# 'YYYY-MM-DD HH:MI:SS' => 'YYYY-MM-DDTHH:MI:SSZ'
		$dt = str_replace(" ", "T", $dt) . "Z";
		$ns = self::getNamespace( 'dc' );
		return self::LiteralNode( $dt, $ns . 'W3CDTF' );
	}

	public Function getCcTerms( $url ) {
		static $knownLicenses;

		if ( isset( $knownLicenses ) ) return $knownLicenses[$url];

		$knownLicenses = array();
		$ccLicenses = array('by', 'by-nd', 'by-nd-nc', 'by-nc',
			'by-nc-sa', 'by-sa', 'nd', 'nd-nc',
			'nc', 'nc-sa', 'sa');
		$ccVersions = array('1.0', '2.0', '2.5');

		foreach ($ccVersions as $version) {
			foreach ($ccLicenses as $license) {
				if( $version != '1.0' && substr($license, 0, 2) != 'by' ) {
					# 2.0 dropped the non-attribs licenses
					continue;
				}
				$lurl = "http://creativecommons.org/licenses/{$license}/{$version}/";
				$knownLicenses[$lurl] = explode('-', $license);
				$knownLicenses[$lurl][] = 're';
				$knownLicenses[$lurl][] = 'di';
				$knownLicenses[$lurl][] = 'no';
				if (!in_array('nd', $knownLicenses[$lurl])) {
					$knownLicenses[$lurl][] = 'de';
				}
			}
		}

		/* Handle the GPL and LGPL, too. */

		$knownLicenses['http://creativecommons.org/licenses/GPL/2.0/'] =
			array('de', 're', 'di', 'no', 'sa', 'sc');
		$knownLicenses['http://creativecommons.org/licenses/LGPL/2.1/'] =
			array('de', 're', 'di', 'no', 'sa', 'sc');
		$knownLicenses['http://www.gnu.org/copyleft/fdl.html'] =
			array('de', 're', 'di', 'no', 'sa', 'sc');

		return $knownLicenses[$url];

	}

	public function getTypePrefs( $key ) {
		$prefs = self::$TypePrefs;
		return $prefs[$key];
	}

	public function ReloadConfiguration() {
		self::cleanup();
	}

	public function cleanup() {
		if ( self::$Store )
		self::$Store = null;
		if ( self::$StoredModel )
		self::$StoredModel = null;
	}

	public function turtleToSparql( $turtle ) {
		$lines = split( "\n", $turtle );
		$prefix = $body = "";
		foreach ( $lines as $l ) {
			$matches = array();
			preg_replace( "/\.$/", "", $l );
			if ( preg_match( "/^@prefix (.*) \.$/", $l, $matches ) ) {
				$prefix .= "PREFIX {$matches[1]}\n";
			} else {
				$body .= "$l\n";
			}
			return "{$prefix}ASK\nWHERE { $body }";
		}
	}
}

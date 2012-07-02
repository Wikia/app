<?php
# (c)2010 Christopher Gutteridge / University of Southampton
# License: LGPL
# Version 1.4

# Requires ARC2 to be included.
# suggested call method:
#   include_once("arc/ARC2.php");
#   include_once("Graphite.php");

# Similar libraries
#  EasyRDF - http://code.google.com/p/easyrdf/
#  SimpleGraph - http://code.google.com/p/moriarty/wiki/SimpleGraph
#
# I've used function calls in common with EasyRDF, where it makes sense
# to do so. Easy RDF now uses our dump() style. We're one big happy linked
# data community!

# todo:
# isType, hasRelationValue, hasRelation, filter, addTriple, loadString, renderLink

# to document:
# sort, getString, addTurtle, addRDFXML


class Graphite
{
	public function __construct( $namespaces = array(), $uri = null )
	{
		$this->t = array( "sp" => array(), "op" => array() );
		foreach ( $namespaces as $short => $long )
		{
			$this->ns( $short, $long );
		}
	     	$this->ns( "foaf", "http://xmlns.com/foaf/0.1/" );
	       	$this->ns( "dc",   "http://purl.org/dc/elements/1.1/" );
		$this->ns( "dct",  "http://purl.org/dc/terms/" );
		$this->ns( "rdf",  "http://www.w3.org/1999/02/22-rdf-syntax-ns#" );
		$this->ns( "rdfs", "http://www.w3.org/2000/01/rdf-schema#" );
		$this->ns( "owl",  "http://www.w3.org/2002/07/owl#" );
		$this->ns( "xsd",  "http://www.w3.org/2001/XMLSchema#" );
		$this->ns( "cc",   "http://creativecommons.org/ns#" );
		$this->ns( "bibo", "http://purl.org/ontology/bibo/" );
		$this->ns( "skos", "http://www.w3.org/2004/02/skos/core#" );
		$this->ns( "geo",  "http://www.w3.org/2003/01/geo/wgs84_pos#" );

		$this->loaded = array();
		$this->debug = false;

		$this->firstGraphURI = null;
		if ( $uri )
		{
			$this->forceString( $uri );
			$this->load( $uri );
		}
	}

	public function cacheDir( $dir, $age = 86400 ) # default age is 24 hours
	{
		$error = "";
		if ( !file_exists( $dir ) ) { $error = "No such directory: $dir"; }
		elseif ( !is_dir( $dir ) ) { $error = "Not a directory: $dir"; }
		elseif ( !is_writable( $dir ) ) { $error = "Not writable: $dir"; }
		if ( $error ) {
			print "<ul><li>Graphite cacheDir error: $error</li></ul>";
		}
		else
		{
			$this->cacheDir = $dir;
			$this->cacheAge = $age;
		}
	}

	public function setDebug( $boolean ) { $this->debug = $boolean; }

	public function load( $uri, $aliases = array(), $map = array() )
	{
		$this->forceString( $uri );
		$uri = $this->expandURI( $uri );

		if ( substr( $uri, 0, 5 ) == "data:" )
		{
			$data = urldecode( preg_replace( "/^data:[^,]*,/", "", $uri ) );
			$parser = ARC2::getTurtleParser();
			$parser->parse( $uri, $data );
		}
		else
		{
			if ( isset( $this->loaded[$uri] ) ) { return $this->loaded[$uri]; }
			if ( isset( $this->cacheDir ) )
			{
				$filename = $this->cacheDir . "/" . md5( $uri );

				if ( !file_exists( $filename ) || filemtime( $filename ) + $this->cacheAge < time() )
				{
					# decache if out of date, even if we fail to re cache.
					if ( file_exists( $filename ) ) { unlink( $filename ); }
					$url = $uri;
					$ttl = 16;
					$mime = "";
					$old_user_agent = ini_get( 'user_agent' );
					ini_set( 'user_agent', "PHP\r\nAccept: application/rdf+xml" );
					while ( $ttl > 0 )
					{
						# dirty hack to set the accept header without using curl
						if ( !$rdf_fp = fopen( $url, 'r' ) ) { break; }
						$meta_data = stream_get_meta_data( $rdf_fp );
						$redir = 0;
						foreach ( $meta_data['wrapper_data'] as $response )
						{
  							if ( substr( strtolower( $response ), 0, 10 ) == 'location: ' )
							{
								$newurl = substr( $response, 10 );
								if ( substr( $newurl, 0, 1 ) == "/" )
								{
									$parts = preg_split( "/\//", $url );
									$newurl = $parts[0] . "//" . $parts[2] . $newurl;
								}
								$url = $newurl;
								$redir = 1;
  							}
  							if ( substr( strtolower( $response ), 0, 14 ) == 'content-type: ' )
							{
    								$mime = preg_replace( "/\s*;.*$/", "", substr( $response, 14 ) );
  							}
						}
						if ( !$redir ) { break; }
						$ttl--;
						fclose( $rdf_fp );
					}
					ini_set( 'user_agent', $old_user_agent );
					if ( $ttl > 0 && $mime == "application/rdf+xml" && $rdf_fp )
					{
						# candidate for caching!
						if ( !$cache_fp = fopen( $filename, 'w' ) )
						{
         						echo "Cannot write file ($filename)";
         						exit;
						}

						while ( !feof( $rdf_fp ) ) {
  							fwrite( $cache_fp, fread( $rdf_fp, 8192 ) );
						}
						fclose( $cache_fp );
					}
					fclose( $rdf_fp );
				}

			}
			if ( isset( $filename ) &&  file_exists( $filename ) )
			{
				$parser = ARC2::getRDFXMLParser();
				$parser->parse( $filename );
			}
			else
			{
				$parser = ARC2::getRDFParser();
				# Don't try to load the same URI twice!

				if ( !isset( $this->firstGraphURI ) )
				{
					$this->firstGraphURI = $uri;
				}
				$parser->parse( $uri );
			}
		}

		$errors = $parser->getErrors();
		$parser->resetErrors();
		if ( sizeof( $errors ) )
		{
			if ( $this->debug )
			{
				print "<h3>Error loading: $uri</h3>";
				print "<ul><li>" . join( "</li><li>", $errors ) . "</li></ul>";
			}
			return 0;
		}
                $this->loaded[$uri] = $this->addTriples( $parser->getTriples() );
                return $this->loaded[$uri];
        }

        function addTurtle( $base, $data )
        {
                $parser = ARC2::getTurtleParser();
                $parser->parse( $base, $data );
                $errors = $parser->getErrors();
                $parser->resetErrors();
                if ( sizeof( $errors ) )
                {
                        if ( $this->debug )
                        {
                                print "<h3>Error loading: $uri</h3>";
                                print "<ul><li>" . join( "</li><li>", $errors ) . "</li></ul>";
                        }
                        return 0;
                }
                return $this->addTriples( $parser->getTriples() );
        }
        function addRDFXML( $base, $data )
        {
                $parser = ARC2::getRDFXMLParser();
                $parser->parse( $base, $data );
                $errors = $parser->getErrors();
                $parser->resetErrors();
                if ( sizeof( $errors ) )
                {
                        if ( $this->debug )
                        {
                                print "<h3>Error loading: $uri</h3>";
                                print "<ul><li>" . join( "</li><li>", $errors ) . "</li></ul>";
                        }
                        return 0;
                }
                return $this->addTriples( $parser->getTriples() );
        }

        function addTriples( $triples )
        {
if ( @$_GET["X"] )
{
print "<pre>";
print_r( $triples );
print "</pre>";
}
                foreach ( $triples as $t )
                {
                        $t["s"] = $this->cleanURI( $t["s"] );
                        if ( !isset( $map[$t["s"]] ) ) { continue; }
                        $t["p"] = $this->cleanURI( $t["p"] );
                        if ( $t["p"] != "http://www.w3.org/2002/07/owl#sameAs" ) { continue; }
                        $aliases[$t["o"]] = $t["s"];
                }
                foreach ( $triples as $t )
                {
                        $t["s"] = $this->cleanURI( $t["s"] );
                        $t["p"] = $this->cleanURI( $t["p"] );
                                $mod = 0;
                                if ( isset( $aliases[$t["s"]] ) ) { $t["s"] = $aliases[$t["s"]]; }
                                if ( isset( $aliases[$t["p"]] ) ) { $t["p"] = $aliases[$t["p"]]; }
                                if ( isset( $aliases[$t["o"]] ) ) { $t["o"] = $aliases[$t["o"]]; }
//                              if( $mod )
//                              {
                                        if ( $t["o_type"] == "literal" )
                                        {
                                                $this->t["sp"][$t["s"]][$t["p"]][] = array(
                                                        "v" => $t["o"],
                                                        "d" => $t["o_datatype"],
                                                        "l" => $t["o_lang"] );
                                        }
                                        else
                                        {
                                                $this->t["sp"][$t["s"]][$t["p"]][] = $t["o"];
                                        }
                                        $this->t["op"][$t["o"]][$t["p"]][] = $t["s"];
//                              }
//                      }
                }

                return sizeof( $triples );
	}


	public function cleanURI( $uri )
	{
		if ( !$uri ) { return; }
		return preg_replace( '/^(https?:\/\/[^:\/]+):80\//', '$1/', $uri );
	}

	public function primaryTopic( $uri = null )
	{
		if ( !$uri ) { $uri = $this->firstGraphURI; }
		if ( !$uri ) { return new Graphite_Null( $this->g ); }
		$this->forceString( $uri );

		return $this->resource( $uri )->get( "foaf:primaryTopic", "-foaf:isPrimaryTopicOf" );
	}

	public function ns( $short, $long )
	{
		if ( preg_match( '/^(urn|doi|http|https|ftp|mailto|xmlns|file|data)$/', $short ) )
		{
			print "<ul><li>Setting a namespace called '$short' is just asking for trouble. Abort.</li></ul>";
			exit;
		}
		$this->ns[$short] = $long;
	}

	public function resource( $uri )
	{
		$this->forceString( $uri );
		$uri = $this->expandURI( $uri );
		return new Graphite_Resource( $this, $uri );
	}

	public function allOfType( $uri )
	{
		return $this->resource( $uri )->all( "-rdf:type" );
	}

	public function shrinkURI( $uri )
	{
		$this->forceString( $uri );
		if ( $uri == "" ) { return "* This Document *"; }
		foreach ( $this->ns as $short => $long )
		{
			if ( substr( $uri, 0, strlen( $long ) ) == $long )
			{
				return $short . ":" . substr( $uri, strlen( $long ) );
			}
		}
		return $uri;
	}

	public function expandURI( $uri )
	{
		$this->forceString( $uri );
		if ( preg_match( '/:/', $uri ) )
		{
			list( $ns, $tag ) = preg_split( "/:/", $uri, 2 );
			if ( isset( $this->ns[$ns] ) )
			{
				return $this->ns[$ns] . $tag;
			}
		}
		return $uri;
	}

	# document in next release!
	public function allSubjects()
	{
		$r = new Graphite_ResourceList( $this );
		foreach ( $this->t["sp"] as $subject_uri => $foo )
		{
			 $r[] = new Graphite_Resource( $this, $subject_uri );
		}
		return $r;
	}
	# document in next release!
	public function allObjects()
	{
		$r = new Graphite_ResourceList( $this );
		foreach ( $this->t["op"] as $object_uri => $foo )
		{
			 $r[] = new Graphite_Resource( $this, $object_uri );
		}
		return $r;
	}

	public function dump( $options = array() )
	{
		$r = array();
		foreach ( $this->t["sp"] as $subject_uri => $foo )
		{
			$subject = new Graphite_Resource( $this, $subject_uri );
			$r [] = $subject->dump( $options );
		}
		return join( "", $r );
	}

	public function forceString( &$uri )
	{
		if ( is_object( $uri ) ) { $uri = $uri->toString(); }
		return $uri;
	}
}

class Graphite_Node
{
	function __construct( $g )
	{
		$this->g = $g;
	}
	function has() { return false; }
	function get() { return new Graphite_Null( $this->g ); }
	function type() { return new Graphite_Null( $this->g ); }
	function label() { return "[UNKNOWN]"; }
	function hasLabel() { return false; }
	function all() { return new Graphite_ResourceList( $this->g, array() ); }
	function types() { return $this->all(); }
	function relations() { return $this->all(); }
	function load() { return 0; }
	function loadSameAs() { return 0; }
	function loadSameAsOrg( $prefix ) { return 0; }
	function loadDataGovUKBackLinks() { return 0; }

	function dumpText() { return "Non existant Node"; }
	function dump() { return "<div style='padding:0.5em; background-color:lightgrey;border:dashed 1px grey;'>Non-existant Node</div>"; }
	function nodeType() { return "#node"; }
	function __toString() { return "[NULL]"; }
	function toString() { return $this->__toString(); }

	protected function parsePropertyArg( $arg )
	{
		if ( is_a( $arg, "Graphite_Resource" ) )
		{
			if ( is_a( $arg, "Graphite_InverseRelation" ) )
			{
				$this->g->forceString( $arg );
				return array( "op", "$arg" );
			}
			$this->g->forceString( $arg );
			return array( "sp", "$arg" );
		}

		$set = "sp";
		if ( substr( $arg, 0, 1 ) == "-" )
		{
			$set = "op";
			$arg = substr( $arg, 1 );
		}
		return array( $set, $this->g->expandURI( "$arg" ) );
	}
}
class Graphite_Null extends Graphite_Node
{
	function nodeType() { return "#null"; }
}
class Graphite_Literal extends Graphite_Node
{
	function __construct( $g, $triple )
	{
		$this->g = $g;
		$this->triple = $triple;
		$this->v = $triple["v"];
	}

	function __toString() { return $this->triple["v"]; }

	function dumpValueText()
	{
		$r = '"' . $v . '"';
		if ( isset( $this->triple["l"] ) && $this->triple["l"] )
		{
			$r .= "@" . $this->triple["l"];
		}
		if ( isset( $this->triple["t"] ) )
		{
			$r .= "^^" . $this->g->shrinkURI( $this->triple["t"] );
		}
		return $r;
	}

	function dumpValueHTML()
	{
		$v = htmlspecialchars( $this->triple["v"], ENT_COMPAT, "UTF-8" );

		$v = preg_replace( "/\t/", "<span class='special_char' style='font-size:70%'>[tab]</span>", $v );
		$v = preg_replace( "/\n/", "<span class='special_char' style='font-size:70%'>[nl]</span><br />", $v );
		$v = preg_replace( "/\r/", "<span class='special_char' style='font-size:70%'>[cr]</span>", $v );
		$v = preg_replace( "/  +/e", "\"<span class='special_char' style='font-size:70%'>\".str_repeat(\"␣\",strlen(\"$0\")).\"</span>\"", $v );
		$r = '"' . $v . '"';

		if ( isset( $this->triple["l"] ) && $this->triple["l"] )
		{
			$r .= "@" . $this->triple["l"];
		}
		if ( isset( $this->triple["t"] ) )
		{
			$r .= "^^" . $this->g->shrinkURI( $this->triple["t"] );
		}
		return $r;
	}

	function nodeType()
	{
		if ( isset( $this->triple["d"] ) )
		{
			return $this->triple["d"];
		}
		return "#literal";
	}

	function dumpValue()
	{
		return "<span style='color:blue'>" . $this->dumpValueHTML() . "</span>";
	}
}

class Graphite_Resource extends Graphite_Node
{
	function __construct( $g, $uri )
	{
		$this->g = $g;
		$this->g->forceString( $uri );
		$this->uri = $uri;
	}

	public function get( /* List */ )
	{
		$args = func_get_args();
		if ( $args[0] instanceof Graphite_ResourceList ) { $args = $args[0]; }
		if ( is_array( $args[0] ) ) { $args = func_get_arg( 0 ); }

		$l = $this->all( $args );
		if ( sizeof( $l ) == 0 ) { return new Graphite_Null( $this->g ); }
		return $l[0];
	}

	public function getString( /* List */ )
	{
		$args = func_get_args();
		if ( $args[0] instanceof Graphite_ResourceList ) { $args = $args[0]; }
		if ( is_array( $args[0] ) ) { $args = func_get_arg( 0 ); }

		$l = $this->all( $args );
		if ( sizeof( $l ) == 0 ) { return; }
		return $l[0]->toString();
	}

	public function has(  /* List */ )
	{
		$args = func_get_args();
		if ( $args[0] instanceof Graphite_ResourceList ) { $args = $args[0]; }
		if ( is_array( $args[0] ) ) { $args = func_get_arg( 0 ); }

		foreach ( $args as $arg )
		{
			list( $set, $relation_uri ) = $this->parsePropertyArg( $arg );
			if ( isset( $this->g->t[$set][$this->uri] )
		 	 && isset( $this->g->t[$set][$this->uri][$relation_uri] ) )
			{
				return true;
			}
		}
		return false;
	}

	public function all(  /* List */ )
	{
		$args = func_get_args();
		if ( $args[0] instanceof Graphite_ResourceList ) { $args = $args[0]; }
		if ( is_array( $args[0] ) ) { $args = func_get_arg( 0 ); }
		$l = array();
		$done = array();
		foreach ( $args as $arg )
		{
			list( $set, $relation_uri ) = $this->parsePropertyArg( $arg );
			if ( !isset( $this->g->t[$set][$this->uri] )
		 	 || !isset( $this->g->t[$set][$this->uri][$relation_uri] ) )
			{
				continue;
			}

			foreach ( $this->g->t[$set][$this->uri][$relation_uri] as $v )
			{
				if ( is_array( $v ) )
				{
					$l [] = new Graphite_Literal( $this->g, $v );
				}
				else if ( !isset( $done[$v] ) )
				{
					$l [] = new Graphite_Resource( $this->g, $v );
					$done[$v] = 1;
				}
			}
		}
		return new Graphite_ResourceList( $this->g, $l );
	}

	public function relations()
	{
		$r = array();
		if ( isset( $this->g->t["sp"][$this->uri] ) )
		{
			foreach ( array_keys( $this->g->t["sp"][$this->uri] ) as $pred )
			{
				$r [] = new Graphite_Relation( $this->g, $pred );
			}
		}
		if ( isset( $this->g->t["op"][$this->uri] ) )
		{
			foreach ( array_keys( $this->g->t["op"][$this->uri] ) as $pred )
			{
				$r [] = new Graphite_InverseRelation( $this->g, $pred );
			}
		}

		return new Graphite_ResourceList( $this->g, $r );
	}

	public function load()
	{
		return $this->g->load( $this->uri );
	}

	public function loadSameAsOrg( $prefix )
	{
		$sameasorg_uri = "http://sameas.org/rdf?uri=" . urlencode( $this->uri );
		$n = $this->g->load( $sameasorg_uri );
		$n += $this->loadSameAs( $prefix );
		return $n;
	}

	function loadDataGovUKBackLinks()
	{
		$backurl = "http://backlinks.psi.enakting.org/resource/rdf/" . $this->uri;
		return $this->g->load( $backurl, array(), array( $this->uri => 1 ) );
	}

	public function loadSameAs( $prefix = null )
	{
		$cnt = 0;
		foreach ( $this->all( "owl:sameAs" ) as $sameas )
		{
			$this->g->forceString( $sameas );
			if ( $prefix && substr( $sameas, 0, strlen( $prefix ) ) != $prefix )
			{
				continue;
			}

			$cnt += $this->g->load( $sameas, array( $sameas => $this->uri ) );
		}
		return $cnt;
	}

	public function type()
	{
		return $this->get( "rdf:type" );
	}

	public function types()
	{
		return $this->all( "rdf:type" );
	}

	public function hasLabel()
	{
		return $this->has( "skos:prefLabel", "rdfs:label", "foaf:name", "dct:title", "dc:title" );
	}
	public function label()
	{
		return $this->get( "skos:prefLabel", "rdfs:label", "foaf:name", "dct:title", "dc:title" )->toString();
	}

	public function link()
	{
		return "<a title='" . $this->uri . "' href='" . $this->uri . "'>" . $this->uri . "</a>";
	}

	public function dumpText()
	{
		$r = "";
		$plist = array();
		foreach ( $this->relations() as $prop )
		{
			$olist = array();
			foreach ( $this->all( $prop ) as $obj )
			{
				$olist [] = $obj->dumpValueText();
			}
			$plist [] = $this->g->shrinkURI( $prop ) . " " . join( ", ", $olist );
		}
		return $this->g->shrinkURI( $this->uri ) . "\n    " . join( ";\n    ", $plist ) . " .\n";
	}

	public function dump( $options = array() )
	{
		$r = "";
		$plist = array();
		foreach ( $this->relations() as $prop )
		{
			$olist = array();
			$all = $this->all( $prop );
			foreach ( $all as $obj )
			{
				$olist [] = $obj->dumpValue( $options );
			}
			if ( is_a( $prop, "Graphite_InverseRelation" ) )
			{
				$pattern = "<span style='font-size:130%%'>&larr;</span> is <a title='%s' href='%s' style='text-decoration:none;color: green'>%s</a> of <span style='font-size:130%%'>&larr;</span> %s";
			}
			else
			{
				$pattern = "<span style='font-size:130%%'>&rarr;</span> <a title='%s' href='%s' style='text-decoration:none;color: green'>%s</a> <span style='font-size:130%%'>&rarr;</span> %s";
			}
			$this->g->forceString( $prop );
			$plist [] = sprintf( $pattern, $prop, $prop, $this->g->shrinkURI( $prop ), join( ", ", $olist ) );
		}
		$r .= "\n<a name='" . htmlentities( $this->uri ) . "'></a><div style='font-family: arial;padding:0.5em; background-color:lightgrey;border:dashed 1px grey;margin-bottom:2px;'>\n";
		if ( isset( $options["label"] ) )
		{
			$label = $this->label();
			if ( $label == "[NULL]" ) { $label = ""; } else { $label = "<strong>$label</strong>"; }
			if ( $this->has( "rdf:type" ) )
			{
				if ( $this->get( "rdf:type" )->hasLabel() )
				{
					$typename = $this->get( "rdf:type" )->label();
				}
				else
				{
					$bits = preg_split( "/[\/#]/", $this->get( "rdf:type" )->uri );
					$typename = array_pop( $bits );
					$typename = preg_replace( "/([a-z])([A-Z])/", "$1 $2", $typename );
				}
				$r .= preg_replace( "/>a ([AEIOU])/i", ">an $1", "<div style='float:right'>a $typename</div>" );
			}
			if ( $label != "" ) { $r .= "<div>$label</div>"; }
		}
		$r .= " <!-- DUMP:" . $this->uri . " -->\n <div><a title='" . $this->uri . "' href='" . $this->uri . "' style='text-decoration:none'>" . $this->g->shrinkURI( $this->uri ) . "</a></div>\n";
		$r .= "  <div style='padding-left: 3em'>\n  <div>" . join( "</div>\n  <div>", $plist ) . "</div></div><div style='clear:both;height:1px; overflow:hidden'>&nbsp;</div></div>";
		return $r;
	}

	function __toString() { return $this->uri; }
	function dumpValue( $options = array() )
	{
		$label = $this->dumpValueText();
		if ( $this->hasLabel() && @$options["labeluris"] )
		{
			$label = $this->label();
		}
		return "<a href='" . $this->uri . "' title='" . $this->uri . "' style='text-decoration:none;color:red'>" . $label . "</a>";
	}
	function dumpValueText() { return $this->g->shrinkURI( $this->uri ); }
	function nodeType() { return "#resource"; }
}

class Graphite_Relation extends Graphite_Resource
{
	function nodeType() { return "#relation"; }
}

class Graphite_InverseRelation extends Graphite_Relation
{
	function nodeType() { return "#inverseRelation"; }
}
class Graphite_ResourceList extends ArrayIterator
{
	function __construct( $g, $a = array() )
	{
		$this->g = $g;
		if ( $a instanceof Graphite_ResourceList )
		{
			print "<li>Graphite warning: passing a Graphite_ResourceList as the array passed to new Graphite_ResourceList will make weird stuff happen.</li>";
		}
		parent::__construct( $a );
	}

	function join( $str )
	{
		$first = 1;
		$l = array();
		foreach ( $this as $resource )
		{
			if ( !$first ) { $l [] = $str; }
			$this->g->forceString( $resource );
			$l [] = $resource;
			$first = 0;
		}
		return join( "", $l );
	}

	function dump()
	{
		$l = array();
		foreach ( $this as $resource )
		{
			$l [] = $resource->dump();
		}
		return join( "", $l );
	}

	public function duplicate()
	{
		$l = array();
		foreach ( $this as $resource ) { $l [] = $resource; }
		return new Graphite_ResourceList( $this->g, $l );
	}

	public function sort( /* List */ )
	{
		$args = func_get_args();
		if ( $args[0] instanceof Graphite_ResourceList ) { $args = $args[0]; }
		if ( is_array( $args[0] ) ) { $args = func_get_arg( 0 ); }

		global $graphite_sort_args;
		$graphite_sort_args = array();
		foreach ( $args as $arg )
		{
			if ( $arg instanceof Graphite_Resource ) { $arg = $arg->toString(); }
			$graphite_sort_args [] = $arg;
		}

		$new_list = $this->duplicate();
		usort( $new_list, "graphite_sort_list_cmp" );

		return $new_list;
	}

	public function uasort( $cmp )
	{
		usort( $this, $cmp );
	}

	public function get( /* List */ )
	{
		$args = func_get_args();
		if ( $args[0] instanceof Graphite_ResourceList ) { $args = $args[0]; }
		if ( is_array( $args[0] ) ) { $args = func_get_arg( 0 ); }
		$l = array();
		foreach ( $this as $resource )
		{
			$l [] = $resource->get( $args );
		}
		return new Graphite_ResourceList( $this->g, $l );
	}

	public function label()
	{
		$l = array();
		foreach ( $this as $resource )
		{
			$l [] = $resource->label();
		}
		return new Graphite_ResourceList( $this->g, $l );
	}

	public function load()
	{
		$n = 0;
		foreach ( $this as $resource )
		{
			$n += $resource->load();
		}
		return $n;
	}

	public function all( /* List */ )
	{
		$args = func_get_args();
		if ( $args[0] instanceof Graphite_ResourceList ) { $args = $args[0]; }
		if ( is_array( $args[0] ) ) { $args = func_get_arg( 0 ); }
		$l = array();
		$done = array();
		foreach ( $this as $resource )
		{
			$all = $resource->all( $args );
			foreach ( $all as $to_add )
			{
				if ( isset( $done[$to_add->toString()] ) ) { continue; }
				$l [] = $to_add;
				$done[$to_add->toString()] = 1;
			}
		}
		return new Graphite_ResourceList( $this->g, $l );
	}

	function append( $x /* List */ )
	{
		$args = func_get_args();
		if ( $args[0] instanceof Graphite_ResourceList ) { $args = $args[0]; }
		if ( is_array( $args[0] ) ) { $args = func_get_arg( 0 ); }

		$list = $this->duplicate();
		foreach ( $args as $arg )
		{
			if ( ! $arg instanceof Graphite_Resource ) { $arg = $this->g->resource( $arg ); }
			$list [] = $arg;
		}
		return $list;
	}

	function distinct()
	{
		$l = array();
		$done = array();
		foreach ( $this as $resource )
		{
			if ( isset( $done[$resource->toString()] ) ) { continue; }
			$l [] = $resource;
			$done[$resource->toString()] = 1;
		}
		return new Graphite_ResourceList( $this->g, $l );
	}

	function union( /* List */ )
	{
		$args = func_get_args();
		if ( $args[0] instanceof Graphite_ResourceList ) { $args = $args[0]; }
		if ( is_array( $args[0] ) ) { $args = func_get_arg( 0 ); }

		$list = new Graphite_ResourceList( $this->g );
		$done = array();
		foreach ( $this as $resource )
		{
			if ( isset( $done[$resource->toString()] ) ) { continue; }
			$list [] = $resource;
			$done[$resource->toString()] = 1;
		}
		foreach ( $args as $arg )
		{
			if ( ! $arg instanceof Graphite_Resource ) { $arg = $this->g->resource( $arg ); }
			if ( isset( $done[$arg->toString()] ) ) { continue; }
			$list [] = $arg;
			$done[$arg->toString()] = 1;
		}
		return $list;
	}

	function intersection( /* List */ )
	{
		$args = func_get_args();
		if ( $args[0] instanceof Graphite_ResourceList ) { $args = $args[0]; }
		if ( is_array( $args[0] ) ) { $args = func_get_arg( 0 ); }

		$list = new Graphite_ResourceList( $this->g, array() );
		$seen = array();
		foreach ( $this as $arg )
		{
			if ( ! $arg instanceof Graphite_Resource ) { $arg = $this->g->resource( $arg ); }
			$seen[$arg->toString()] = 1;
		}
		foreach ( $args as $arg )
		{
			if ( ! $arg instanceof Graphite_Resource ) { $arg = $this->g->resource( $arg ); }
			if ( ! isset( $seen[$arg->toString()] ) ) { continue; }
			$list [] = $arg;
		}
		return $list;
	}

	function except( /* List */ )
	{
		$args = func_get_args();
		if ( $args[0] instanceof Graphite_ResourceList ) { $args = $args[0]; }
		if ( is_array( $args[0] ) ) { $args = func_get_arg( 0 ); }

		$list = new Graphite_ResourceList( $this->g, array() );
		$exclude = array();
		foreach ( $args as $arg )
		{
			if ( ! $arg instanceof Graphite_Resource ) { $arg = $this->g->resource( $arg ); }
			$exclude[$arg->toString()] = 1;
		}
		foreach ( $this as $arg )
		{
			if ( ! $arg instanceof Graphite_Resource ) { $arg = $this->g->resource( $arg ); }
			if ( isset( $exclude[$arg->toString()] ) ) { continue; }
			$list [] = $arg;
		}
		return $list;
	}
}

function graphite_sort_list_cmp( $a, $b )
{
	global $graphite_sort_args;

	foreach ( $graphite_sort_args as $arg )
	{
		$va = $a->get( $arg );
		$vb = $b->get( $arg );
		if ( $va < $vb ) return -1;
		if ( $va > $vb ) return 1;
	}
	return 0;
}


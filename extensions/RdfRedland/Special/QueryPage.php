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

/**
 * This is a class for creating query pages against your stored RDF.  The
 * interface extends QueryPage so you can expect roughly the same
 * behaviours.
 *
 * @package MediaWiki
 */
abstract class RdfQueryPage extends QueryPage implements RdfQueryPageInterface {

	var $mModelURI;

	function setModel( $model ) {
		$this->mModel = $model;
		return true;
	}

	/**
	 * As with QueryPage, this is the actual workhorse. It does everything
	 * needed to make a real, honest-to-gosh query page.
	 *
	 * @param $offset database query offset
	 * @param $limit database query limit
	 * @param $shownavigation show navigation like "next 200"?
	 */
	function doQuery( $offset, $limit, $shownavigation=true ) {
		global $wgUser, $wgOut, $wgContLang;

		$this->offset = $offset;
		$this->limit = $limit;
		$sname = $this->getName();
		$fname = get_class($this) . '::doQuery';
		$sk = $wgUser->getSkin( );
		$wgOut->setSyndicated( $this->isSyndicated() );

		$query = MwRdf::Query( $this->getQuery(), $this->getBaseUrl(),
		$this->getQueryLanguage() );

		$librdf_res = $query->execute( MwRdf::StoredModel() );
		# let's just dump the tuples into a normal php array shall
		# we?  This will avoid memory management hassels.
		$res = array();
		foreach ( $librdf_res as $tuple ) {
			$res[] = $tuple;
		}

		$num = count( $res );
		$res = $this->preprocessResults( $res );
		if( $shownavigation ) {
			$wgOut->addHTML( $this->getPageHeader() );
			$top = wfShowingResults( $offset, $num );
			$wgOut->addHTML( "<p>{$top}\n" );

			# often disable 'next' link when we reach the end
			$atend = $num < $limit;

			$sl = wfViewPrevNext( $offset, $limit ,
			$wgContLang->specialPage( $sname ),
			wfArrayToCGI( $this->linkParameters() ), $atend );
			$wgOut->addHTML( "<br />{$sl}</p>\n" );
		}

		if ( $num > 0 ) {
			$s = array();
			if ( ! $this->listoutput )
			$s[] = "<ol start='" . ( $offset + 1 ) . "' class='special'>";

			# here's where we do the offset and limit
			for ( $i = $offset; $i < $num && $i < $offset + $limit; $i++ ) {
				$format = $this->formatResult( $sk, $res[$i] );
				if ( $format )
				$s[] = $this->listoutput ? $format : "<li>{$format}</li>\n";
			}

			if ( ! $this->listoutput )
			$s[] = '</ol>';
			$str = $this->listoutput ? $wgContLang->listToText( $s ) : implode( '', $s );
			$wgOut->addHTML( $str );
		}

		if($shownavigation) {
			$wgOut->addHTML( "<p>{$sl}</p>\n" );
		}

		return $num;
	}

	/**
	 * Do any necessary preprocessing of the result object.
	 * You should pass this by reference: &$model , &$res
	 */
	function preprocessResults( $res ) { return $res; }
}

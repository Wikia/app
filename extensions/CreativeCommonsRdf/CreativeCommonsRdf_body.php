<?php
/**
 * Provides CreativeCommons metadata
 *
 * Copyright 2004, Evan Prodromou <evan@wikitravel.org>.
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
 *  Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA
 *
 * @author Evan Prodromou <evan@wikitravel.org>
 * @file
 */

class CreativeCommonsRdf extends RdfMetaData {

	public function show(){
		if( $this->setup() ){
			global $wgRightsUrl;

			$url = $this->reallyFullUrl();

			$this->prologue();
			$this->subPrologue('Work', $url);

			$this->basics();
			if( $wgRightsUrl ){
				$url = htmlspecialchars( $wgRightsUrl );
				print "\t\t<cc:license rdf:resource=\"$url\" />\n";
			}

			$this->subEpilogue('Work');

			if( $wgRightsUrl ){
				$terms = $this->getTerms( $wgRightsUrl );
				if( $terms ){
					$this->subPrologue( 'License', $wgRightsUrl );
					$this->license( $terms );
					$this->subEpilogue( 'License' );
				}
			}
		}

		$this->epilogue();
	}

	protected function prologue() {
		echo <<<PROLOGUE
<?xml version='1.0'  encoding="UTF-8" ?>
<rdf:RDF xmlns:cc="http://web.resource.org/cc/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">

PROLOGUE;
	}

	protected function subPrologue( $type, $url ){
		$url = htmlspecialchars( $url );
		echo "\t<cc:{$type} rdf:about=\"{$url}\">\n";
	}

	protected function subEpilogue($type) {
		echo "\t</cc:{$type}>\n";
	}

	protected function license($terms) {

		foreach( $terms as $term ){
			switch( $term ) {
			 case 're':
				$this->term('permits', 'Reproduction'); break;
			 case 'di':
				$this->term('permits', 'Distribution'); break;
			 case 'de':
				$this->term('permits', 'DerivativeWorks'); break;
			 case 'nc':
				$this->term('prohibits', 'CommercialUse'); break;
			 case 'no':
				$this->term('requires', 'Notice'); break;
			 case 'by':
				$this->term('requires', 'Attribution'); break;
			 case 'sa':
				$this->term('requires', 'ShareAlike'); break;
			 case 'sc':
				$this->term('requires', 'SourceCode'); break;
			}
		}
	}

	protected function term( $term, $name ){
		print "\t\t<cc:{$term} rdf:resource=\"http://web.resource.org/cc/{$name}\" />\n";
	}

	protected function epilogue() {
		echo "</rdf:RDF>\n";
	}
}

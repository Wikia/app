<?php
/**
 * Provides DublinCore metadata
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

class DublinCoreRdf extends RdfMetaData {

	public function show(){
		if( $this->setup() ){
			$this->prologue();
			$this->basics();
			$this->epilogue();
		}
	}

	/**
	 * begin of the page
	 */
	protected function prologue() {
		$url = htmlspecialchars( $this->reallyFullUrl() );
		print <<<PROLOGUE
<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE rdf:RDF PUBLIC "-//DUBLIN CORE//DCMES DTD 2002/07/31//EN" "http://dublincore.org/documents/2002/07/31/dcmes-xml/dcmes-xml-dtd.dtd">
<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
	xmlns:dc="http://purl.org/dc/elements/1.1/">
	<rdf:Description rdf:about="{$url}">

PROLOGUE;
	}

	/**
	 * end of the page
	 */
	protected function epilogue() {
		print <<<EPILOGUE
	</rdf:Description>
</rdf:RDF>
EPILOGUE;
	}
}
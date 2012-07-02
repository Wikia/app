<?php
/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * @file
 * @ingroup Extensions
 * @author Roan Kattouw <roan.kattouw@gmail.com>
 * @copyright Copyright © 2009 Roan Kattouw
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */

# Alert the user that this is not a valid entry point to MediaWiki if they try
# to access the extension file directly.
if ( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOT
To install the ApiSVGProxy extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/ApiSVGProxy/ApiSVGProxy.php" );
EOT;
	exit( 1 );
}

class ApiSVGProxy extends ApiBase {
	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	public function execute() {
		$params = $this->extractRequestParams();
		$title = Title::newFromText( $params['file'] );
		$file = wfFindFile( $title );

		// Verify that the file exists and is an SVG file
		if ( !$file ) {
			$this->dieUsage( 'The specified file does not exist',
				'nosuchfile', 404 );
		}
		if ( $file->getExtension() != 'svg' || $file->getMimeType() != 'image/svg+xml' ) {
			$this->dieUsage( 'The specified file is not an SVG file',
				'notsvg', 403 );
		}

		// Grab the file's contents
		$contents = Http::get( $file->getFullUrl() );
		if ( $contents === false ) {
			$this->dieUsage( 'The specified file could not be fetched',
				'fetchfailed', 500 );
		}

		// Output the file's contents raw
		$this->getResult()->addValue( null, 'text', $contents );
		$this->getResult()->addValue( null, 'mime', 'image/svg+xml' );
	}

	public function getCustomPrinter() {
		return new ApiFormatRaw(
			$this->getMain(),
			$this->getMain()->createPrinterByName( 'xml' )
		);
	}

	public function getAllowedParams() {
		return array(
			'file' => null,
		);
	}

	public function getParamDescription() {
		return array(
			'file' => 'Name of the file to proxy (including File: prefix)',
		);
	}

	public function getDescription() {
		return array(
			'Proxy an SVG file from a (possibly remote) repository.',
			'The file must have the .svg extension and the image/svg+xml MIME type.',
			'If not, this module will return a 403 response. If the file doesn\'t exist,',
			'a 404 response will be returned. If fetching the file failed, a 500 response',
			'will be returned.',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiSVGProxy.body.php 64584 2010-04-03 23:09:39Z siebrand $';
	}
}

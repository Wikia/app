<?php

if ( !defined( 'MEDIAWIKI' ) ) die( 'Not a valid entry point.' );

class ScanSet {
	/** Context */
	var $attributes, $parser, $text, $indexText, $vol, $page, $name, $path, $directory;
	/** Settings */
	var $basePath, $baseDirectory, $type, $height, $width;

	function ScanSet( $attributes, &$parser, $settings = array() ) {
		global $wgUploadPath, $wgUploadDirectory;

		// Defaults
		$this->basePath = "$wgUploadPath/scans";
		$this->baseDirectory = "$wgUploadDirectory/scans";
		$this->type = 'png';
		$this->width = 700;
		$this->height = 941;

		// Overrides from global settings
		foreach ( $settings as $name => $value ) {
			$this->$name = $value;
		}

		// Non-overrideable variables
		$this->attributes = $attributes;
		$this->parser =& $parser;

		wfLoadExtensionMessages( 'ScanSet' );
	}

	function execute() {
		global $wgRequest, $wgHooks;

		// Depends on parameters
		$this->parser->disableCache();

		// Add style to the head
		$wgHooks['SkinTemplateSetupPageCss'][] = array( &$this, 'getCss' );

		$this->text = '';

		$this->indexText = '';
		$this->currentVolDir = false;
		$this->prev = false;
		$this->next = false;

		// Get name
		if ( isset( $this->attributes['name'] ) ) {
			$this->name = $this->attributes['name'];
		} else {
			$this->doError( 'no_name' );
			return $this->text;
		}

		// Remove parent directory references, for security
		$this->name = preg_replace( '/\.[.]+/', '.', $this->name );
		$this->path = $this->basePath . '/' . $this->name;
		$this->directory = $this->baseDirectory . '/' . $this->name;

		// Check that the directory exists
		if ( !is_dir( $this->directory ) ) {
			$this->doError( 'invalid_name' );
			return $this->text;
		}

		// Process some other settings
		if ( isset( $this->attributes['indexformat'] ) ) {
			$indexFormat = strtolower( $this->attributes['indexformat'] );
		} else {
			$indexFormat = 'none';
		}

		$this->vol = false;
		$this->page = false;

		if ( isset( $this->attributes['vol'] ) ) $this->vol = $this->attributes['vol'];
		if ( isset( $this->attributes['page'] ) ) $this->page = $this->attributes['page'];
		if ( isset( $this->attributes['type'] ) ) $this->type = $this->attributes['type'];
		if ( isset( $this->attributes['width'] ) ) $this->width = intval( $this->attributes['width'] );
		if ( isset( $this->attributes['height'] ) ) $this->height = intval( $this->attributes['height'] );

		$this->vol = $wgRequest->getText( 'vol', $this->vol );
		$this->page = $wgRequest->getText( 'page', $this->page );

		// Do the index
		switch ( $indexFormat ) {
			case 'none':
				$success = $this->doDirIndex();
				break;
			case 'grosz':
				$success = $this->doGroszIndex();
				break;
			default:
				$this->doError( 'unrecognised_index_format' );
				$success = false;
		}

		// Do the page
		if ( $success ) {
			$success = $this->doPage();
		}

		if ( $success ) {
			$text = $this->getPrevNextLinks() . $this->text . $this->indexText;
		} else {
			$text = $this->text . $this->indexText;
		}

		return $text;
	}

	function getCss( &$css ) {
		if ( $css === false ) {
			$css = '';
		}
		$css .= '
			/*<![CDATA[*/
			.scanset_vollist {
				border-color: #cccccc;
				border-width: thin;
				border-style: solid;
				float: left;
			}
			.scanset_pagelist {
				border-color: #cccccc;
				border-width: thin;
				border-style: solid;
				float: left;
			}
			.scanset_index {
				float: left;
			}
			.scanset_image {
				clear: both;
				text-align: center;
			}
			.scanset_next_right {
				float: right;
			}
			.scanset_next_left {
				float: left;
			}
			/*]]>*/';
		return true;
	}

	function doDirIndex() {
		$dir = opendir( $this->directory );
		if ( !$dir ) {
			$this->doError( 'opendir_error', htmlspecialchars( $this->directory ) );
			return false;
		}

		$ext = '.' . $this->type;
		$extLength = strlen( $ext );
		$numFiles = 0;

		$text = "<div class='scanset_index'><ul>\n";
		while ( ( $file = readdir( $dir ) ) !== false ) {
			if ( substr( $file, -$extLength ) == $ext ) {
				$text .= $this->getPageLinkLI( false, $file, $file, $file ) . "\n";
				++$numFiles;
			}
		}
		closedir( $dir );
		if ( $numFiles == 0 ) {
			$this->doError( 'no_files' );
			return false;
		} else {
			$this->indexText .= "$text</ul></div>\n";
			return true;
		}
	}

	/**
	 * Process an index in the style of Andreas Grosz's EB Scholar's Edition scans
	 */
	function doGroszIndex() {
		// First do volume list
		// We do this by reading the names of the directories
		$dir = opendir( $this->directory );
		if ( !$dir ) {
			$this->doError( 'opendir_error' );
			return false;
		}

		$volumes = array();
		while ( ( $file = readdir( $dir ) ) !== false ) {
			if ( preg_match( '/^VOL([0-9]+) (.*)$/', $file, $m ) ) {
				$volumes[$m[1]] = $m[2];
				// Is this the current volume? Use strcmp to enforce leading zeros
				if ( !strcmp( $m[1], $this->vol ) ) {
					$this->currentVolDir = $file;
				}
			}
		}
		closedir( $dir );
		if ( count($volumes) == 0 ) {
			$this->doError( 'no_volumes' );
			return false;
		}

		ksort( $volumes );
		$this->indexText = "<div class='scanset_vollist'><ol>\n";
		foreach ( $volumes as $index => $description ) {
			$this->indexText .= $this->getVolLink( $index, $description );
		}
		$this->indexText .= "</ol></div>\n";

		// Validate $this->vol
		if ( $this->currentVolDir === false ) {
			return false;
		}

		// Now do the page list, by reading the relevant text file
		// We have to keep in mind that the text file could be user input, it
		// has to be validated carefully.
		$lines = @file( "{$this->directory}/(Indices)/VOL{$this->vol}.txt" );
		if ( $lines === false || count( $lines ) == 0 ) {
			$this->doError( 'missing_index_file', "VOL{$this->vol}.txt" );
		}

		$text = "<div class='scanset_pagelist'><ol>\n";
		$prev = false;
		$next = false;
		$passedCurrent = false;
		for ( $i = 0; $i < count( $lines ); $i++) {
			$line = $lines[$i];
			if ( !preg_match( '/^(\w+)\.(\w+),(.*)$/', trim( $line ), $m ) ) {
				$this->doError( 'index_file_error', $i + 1 );
				return false;
			}
			list( $wholeMatch, $name, $ext, $description ) = $m;

			$text .= $this->getPageLinkLI( $this->vol, $name, $description );

			// Set prev and next links
			if ( $this->page === $name ) {
				$passedCurrent = true;
			} else {
				if ( !$passedCurrent ) {
					$prev = $name;
				} elseif ( $next === false ) {
					$next = $name;
				}
			}
		}
		if ( $prev !== false ) {
			$this->prev = $this->getPageLink( $this->vol, $prev, wfMsg( 'scanset_prev' ) );
		}
		if ( $next !== false ) {
			$this->next = $this->getPageLink( $this->vol, $next, wfMsg( 'scanset_next' ) );
		}
		$this->indexText .= "$text</ol></div>\n";
		return true;
	}

	/**
	 * Output the <img> tag and whatever else goes into displaying a scanned page
	 * In the case of Grosz indexes, this relies on data gathered during the index display
	 */
	function doPage() {
		if ( !preg_match( '/^\w+$/', $this->page ) ) {
			return false;
		}

		if ( $this->currentVolDir ) {
			$url = $this->path . '/' . rawurlencode( $this->currentVolDir );
		} elseif ( $this->vol && preg_match( '/^\w+$/', $this->vol ) ) {
			$url = $this->path . '/' . rawurlencode( $this->vol );
		} elseif ( $this->vol !== false ) {
			$this->doError( 'invalid_volume' );
			return false;
		} else {
			$url = $this->path;
		}
		$url .= '/' . rawurlencode( $this->page ) . '.' . rawurlencode( $this->type );

		$this->text .= "<div class='scanset_image'>\n";
		if ( strtolower( $this->type ) == 'tif' ) {
			$this->text .= "<object width=\"{$this->width}\" height=\"{$this->height}\" " .
				  "classid=\"CLSID:106E49CF-797A-11D2-81A2-00E02C015623\">" .
				"<param name=\"src\" value=\"$url\">" .
				"<embed width=\"{$this->width}\" height=\"{$this->height}\" " .
				  "type=\"image/tiff\" src=\"$url\">" .
				"</object></div>";
		} else {
			$this->text .=
				"<a href=\"$url\">" .
				"<img width=\"{$this->width}\" height=\"{$this->height}\" src=\"$url\" />\n" .
				"</a></div>";
		}
		return true;
	}

	/**
	 * Output an error message, given an unprefixed message name and optionally some parameters
	 */
	function doError( $msg /*, ...*/) {
		$args = func_get_args();
		array_shift( $args );
		$this->text .= "<p>" . wfMsgReal( 'scanset_' . $msg, $args, true ) . "</p>";
	}

	/**
	 * Return a link to the scan container page
	 * If the requested page is the current page, returns the bolded description instead
	 */
	function getPageLink( $vol, $page, $description ) {
		if ( $vol == $this->vol && $page == $this->page ) {
			// Self-link
			return "<strong>$description</strong>";
		} else {
			if ( $vol !== false ) {
				$query = 'vol=' . urlencode( $vol );
				if ( $page !== false ) {
					$query .= '&page=' . urlencode( $page );
				}
			} elseif ( $page !== false ) {
				$query = 'page=' . urlencode( $page );
			} else {
				$query = '';
			}
			return "<a href=\"" .
				$this->parser->getTitle()->escapeLocalUrl( $query ) .
				"\">$description</a>";
		}
	}

	function getPageLinkLI( $vol, $page, $description ) {
		return '<li>' . $this->getPageLink( $vol, $page, $description ) . "</li>\n";
	}

	/**
	 * Return a link to the volume container page, wrapped in an <li>
	 * If the requested volume is the current volume, returns the bolded description instead
	 */
	function getVolLink( $vol, $description ) {
		if ( $vol == $this->vol ) {
			// Self-link
			return "<li><strong>$description</strong></li>\n";
		} else {
			if ( $vol === false ) {
				$query = '';
			} else {
				$query = 'vol=' . urlencode( $vol );
			}
			return "<li><a href=\"" .
				$this->parser->getTitle()->escapeLocalUrl( $query ) .
				"\">$description</a></li>\n";
		}
	}

	/**
	 * Get prev/next links to put above the image
	 */
	function getPrevNextLinks() {
		global $wgLang;

		if ( $wgLang->isRTL() ) {
			$forwards = 'scanset_next_left';
			$backwards = 'scanset_next_right';
		} else {
			$forwards = 'scanset_next_right';
			$backwards = 'scanset_next_left';
		}

		$text = '';
		if ( $this->prev !== false ) {
			$text = "<div class='$backwards'>{$this->prev}</div>\n";
		}
		if ( $this->next !== false ) {
			$text .= "<div class='$forwards'>{$this->next}</div>\n";
		}
		return $text;
	}
}

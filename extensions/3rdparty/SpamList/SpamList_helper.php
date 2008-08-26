<?php

if ( defined( 'MEDIAWIKI' ) ) 
{
	class SpamList_helper
	{
		var $memcache_file = '';
		var $memcache_regexes = '';
		
		var $regexes = false;
		var $previousFilter = false;
		var $files = array();
		var $warningTime = 600;
		var $expiryTime = 900;
		var $warningChance = 100;
		var $title = '';
		var $text = '';
		var $section = '';
		
		function __construct($settings)
		{
			foreach ( $settings as $name => $value ) 
			{
				$this->$name = $value;
			}
		}
		
		public function getRegexes($no_http = 0) 
		{
			global $wgMemc, $wgDBname, $messageMemc;
			$fname = 'SpamList_helper::getRegex';
			wfProfileIn( $fname );
		
			if ( $this->regexes !== false ) 
			{
				return $this->regexes;
			}

			wfDebug( "Loading spam regex..." );

			if ( !is_array( $this->files ) ) 
			{
				$this->files = array( $this->files );
			}
			if ( count( $this->files ) == 0 )
			{
				# No lists
				wfDebug( "no files specified\n" );
				wfProfileOut( $fname );
				return false;
			}

			# Refresh cache if we are saving the spamlist
			$recache = false;
			foreach ( $this->files as $fileName ) 
			{
				if ( preg_match( '/^DB: (\w*) (.*)$/', $fileName, $matches ) ) 
				{
					if ( $wgDBname == $matches[1] && $this->title && $this->title->getPrefixedDBkey() == $matches[2] ) 
					{
						$recache = true;
						break;
					}
				}
			}

			if ( $this->regexes === false || $recache ) 
			{
				if ( !$recache ) 
				{
					$this->regexes = $wgMemc->get($this->memcache_regexes);
				}
				if ( $this->regexes === false || $this->regexes === null ) 
				{
					# Load lists
					$lines = array();
					wfDebug( "Constructing spamlist\n" );
					foreach ( $this->files as $fileName ) 
					{
						if ( preg_match( '/^DB: ([\w-]*) (.*)$/', $fileName, $matches ) ) 
						{
							if ( $wgDBname == $matches[1] && $this->title && $this->title->getPrefixedDBkey() == $matches[2] ) 
							{
								wfDebug ( "Fetching default local spam-list...\n");
								$lines = array_merge( $lines, explode( "\n", $this->text ) );
							} 
							else 
							{
								wfDebug ( "Fetching local spam-list from '{$matches[2]}' on '{$matches[1]}'...\n");
								$lines = array_merge( $lines, $this->getArticleLines( $matches[1], $matches[2] ) );
							}
							wfDebug( "got from DB\n" );
						} 
						elseif ( preg_match( '/^http:\/\//', $fileName ) ) 
						{
							# HTTP request
							# To keep requests to a minimum, we save results into $messageMemc, which is
							# similar to $wgMemc except almost certain to exist. By default, it is stored
							# in the database
							#
							# There are two keys, when the warning key expires, a random thread will refresh
							# the real key. This reduces the chance of multiple requests under high traffic 
							# conditions.
							$key = $this->memcache_file.":".$fileName;
							$warningKey = "$wgDBname:spamfilewarning:$fileName";
							$httpText = $messageMemc->get( $key );
							$warning = $messageMemc->get( $warningKey );

							if ( !is_string( $httpText ) || ( !$warning && !mt_rand( 0, $this->warningChance ) ) ) 
							{
								wfDebug ( "Loading spamlist from $fileName\n" );
								$httpText = $this->getHTTP( $fileName );
								$messageMemc->set( $warningKey, 1, $this->warningTime );
								$messageMemc->set( $key, $httpText, $this->expiryTime );
							} 
							else 
							{
								wfDebug( "got from HTTP cache\n" );
							}
							$lines = array_merge( $lines, explode( "\n", $httpText ) );
						} 
						else 
						{
							if (file_exists($fileName))
							{
								$lines = array_merge( $lines, file( $fileName ) );
								wfDebug( "got from file\n" );
							}
							else
							{
								wfDebug( "file doesn't exist\n" );
							}
						}
					}

					$this->regexes = $this->buildRegexes( $lines, $no_http );
					$wgMemc->set( $this->memcache_regexes, $this->regexes, $this->expiryTime );
				} 
				else 
				{
					wfDebug( "got from cache\n" );
				}
			}
			#---
			if ( $this->regexes !== true && !is_array( $this->regexes ) ) 
			{
				// Corrupt regex
				wfDebug( "Corrupt regex\n" );
				$this->regexes = false;
			}
			wfProfileOut( $fname );
			return $this->regexes;
		}

		public function getWhitelists() 
		{
			#---
			$source = wfMsgForContent( 'spam-whitelist' );
			if( $source && $source != '&lt;spam-whitelist&gt;' ) 
			{
				return $this->buildRegexes( explode( "\n", $source ) );
			}
			
			// if empty - then true
			return true;
		}

		public function buildRegexes( $lines, $no_http = 0 ) 
		{
			# Strip comments and whitespace, then remove blanks
			$lines = array_filter( array_map( 'trim', preg_replace( '/#.*$/', '', $lines ) ) );

			# No lines, don't make a regex which will match everything
			if ( count( $lines ) == 0 ) 
			{
				wfDebug( "No lines\n" );
				return true;
			} 
			else 
			{
				# Make regex
				# It's faster using the S modifier even though it will usually only be run once
				//$regex = 'http://+[a-z0-9_\-.]*(' . implode( '|', $lines ) . ')';
				//return '/' . str_replace( '/', '\/', preg_replace('|\\\*/|', '/', $regex) ) . '/Si';
				$regexes = array();
				$regexStart = ($no_http) ? '/(' : '/http:\/\/+[a-z0-9_\-.]*(';
				$regexEnd = ')/Si';
				$regexMax = 4096;
				$build = false;
				foreach( $lines as $line ) 
				{
					// FIXME: not very robust size check, but should work. :)
					if( $build === false ) 
					{
						$build = $line;
					} 
					elseif( strlen( $build ) + strlen( $line ) > $regexMax ) 
					{
						$regexes[] = $regexStart . str_replace( '/', '\/', preg_replace('|\\\*/|', '/', $build) ) . $regexEnd;
						$build = $line;
					} 
					else 
					{
						$build .= '|';
						$build .= $line;
					}
				}
				
				if ( $build !== false ) 
				{
					$regexes[] = $regexStart . str_replace( '/', '\/', preg_replace('|\\\*/|', '/', $build) ) . $regexEnd;
				}
				
				#---
				return $regexes;
			}
		}
		
		private function getArticleLines( $db, $article ) 
		{
			global $wgDBname;
			$dbr = wfGetDB( DB_READ );
			$dbr->selectDB( $db );
			$text = false;
			#---
			if ( $dbr->tableExists( 'page' ) ) 
			{
				// 1.5 schema
				$dbw =& wfGetDB( DB_READ );
				$dbw->selectDB( $db );
				$revision = Revision::newFromTitle( Title::newFromText( $article ) );
				if ( $revision ) 
				{
					$text = $revision->getText();
				}
				$dbw->selectDB( $wgDBname );
			} 
			else 
			{
				// 1.4 schema
				$cur = $dbr->tableName( 'cur' );
				$title = Title::newFromText( $article );
				$text = $dbr->selectField( 'cur', 'cur_text', array( 'cur_namespace' => $title->getNamespace(),
					'cur_title' => $title->getDBkey() ), 'SpamList::getArticleLines' );
			}
			$dbr->selectDB( $wgDBname );
			if ( $text !== false ) 
			{
				return explode( "\n", $text );
			} 
			else 
			{
				return array();
			}
		}
		
		private function getHTTP( $url ) 
		{
			// Use wfGetHTTP from MW 1.5 if it is available
			include_once( 'HttpFunctions.php' );
			if ( function_exists( 'wfGetHTTP' ) ) 
			{
				$text = wfGetHTTP( $url );
			} 
			else 
			{
				$url_fopen = ini_set( 'allow_url_fopen', 1 );
				$text = file_get_contents( $url );
				ini_set( 'allow_url_fopen', $url_fopen );
			}
			return $text;
		}

		public function getMemcacheFile() { return $this->memcache_file; }
		public function getMemcacheRegex() { return $this->memcache_regexes; }
		public function getVarRegexes() { return $this->regexes; }
		public function getPreviousFilter() { return $this->previousFilter; }
		public function getFiles() { return $this->files; }
		public function getWarningTime() { return $this->warningTime; }
		public function getExpiryTime() { return $this->expiryTime; }
		public function getWarningChance() { return $this->warningChance; }
		public function getTitle() { return $this->title; }
		public function getText() { return $this->text; }
		public function getSection() { return $this->section; }
	}
}
?>

<?php
/**
 * Copyright (C) 2005 Brion Vibber <brion@pobox.com>
 * http://www.mediawiki.org/
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @addtogroup Maintenance
 */

$optionsWithArgs = array( 'report' );

require_once( 'commandLine.inc' );

class BackupReader {
	var $reportingInterval = 100;
	var $reporting = true;
	var $pageCount = 0;
	var $revCount  = 0;
	var $dryRun    = false;
	var $outputBase;
	var $fbase;
	var $frss = false;
	var $indx = array();

	function __construct() {
		$this->stderr = fopen( "php://stderr", "wt" );
	}

	function reportPage( $page ) {
		$this->pageCount++;
	}

	function handleRevision( $rev ) {
		$title = $rev->getTitle();
		if (!$title) {
			fprintf( $this->stderr, "Got bogus revision with null title!" );
			return;
		}
		$display = utf8_decode($title->getPrefixedText());
		$display = str_replace(':',' ',$display);
		$display = str_replace(' ','_',str_replace('  ','_',$display));
		$fname = urlencode($display);
			
		//$sanitized = $this->fbase;
		
		$sanitized = $fname; 
		
		$htmlfilename = sprintf( "%s/html/%s.html",	$this->outputBase, rawurlencode($display));
		fprintf( $this->stderr, "%s\n", $htmlfilename, rawurlencode($display) );
		
		$rssfilename = sprintf( "%s/rss/%s.rss", $this->outputBase,	rawurlencode($display) );
		fprintf( $this->stderr, "%s\n", $rssfilename, rawurlencode($display) );
		
		$specfilename = sprintf( "%s/spec/%s.xml", $this->outputBase, rawurlencode($display) );
		
		// fixme
		$user = new User();
		$parser = new Parser();
		$options = ParserOptions::newFromUser( $user );
		$output = $parser->parse( $rev->getText(), $title, $options );
		
		//clean html from formatting
		$html = $output->getText();
		$html =  preg_replace("'<span class=\"editsection\">(.*?)edit<\/a>\]</span>'si",'',$html); //remove edit tags
		//fix images
		if(file_exists($specfilename)){
		 $media = explode("\n",file_get_contents($specfilename));	
		 
		 foreach( $media as $key => $value){
		 $rep=0;
		   $org = '<a href="/index.php?title=Special:Upload&amp;wpDestFile=' . urlencode(str_replace(' ','_',str_replace('Image:','',$value))) . '" class="new" title="'.$value.'">'.$value.'</a>';
		   
		   $ti = explode(".",str_replace('Image:','',$value));
		   $ti[0] = $this->getGuid();
		   $tistr = implode(".",$ti);		   
		   
		   $img = '<img src="images/'.$tistr.'" width="100" />';
		   $html = str_replace($org,$img,$html,$rep);
		   
		   fprintf( $this->stderr, "found %s\n", $rep);
		   
		   if($rep){
		    fprintf( $this->stderr, "copying %s to %s \n", sprintf( "%s/media/%s",$this->outputBase,str_replace('Image:','',$value)),sprintf( "%s/html/images/%s",$this->outputBase,$tistr));	
		    copy(sprintf( "%s/media/%s",$this->outputBase,str_replace('Image:','',$value)), sprintf( "%s/html/images/%s",$this->outputBase,$tistr) );
		   }
		 } 
		}
		
		$html =  preg_replace("'<a href=\"http:\/\/(.*?)nofollow\">'si",'<a href="AYEXTHREFLINK">',$html); //replace links
		$html =  preg_replace("'<a href=\"http:\/\/\"/index.php(.*?)\">'si",'<a href="AYINTHREFLINK">',$html); //replace links		
		$html =  preg_replace("'<script(.*?)</script>'si",'',$html); //replace links
		
		$html = str_replace('</p><p><br />','',$html);
		
		file_put_contents( $htmlfilename,
			"<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" " .
			"\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n" .
			"<html xmlns=\"http://www.w3.org/1999/xhtml\">\n" .
			"<head>\n" .
			"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n" .
			"<title>" . htmlspecialchars( $display ) . "</title>\n" .
			"</head>\n" . 
			"<body>\n" .
			$html .
			"</body>\n" .
			"</html>" );
			
		 if(empty($this->indx['indexlink'])){	
			$tlink = '<li><a href="'.str_replace($this->outputBase.'/html/','',urlencode($htmlfilename)).'">' . $display . "</a>" . '| <a href="../xml/xml_'.$this->fbase.'.xml">source</a> | <a href="../spec/xml_'.$this->fbase.'.xml">specs</a> | <a href="../xml/xml_'.urlencode($rssfilename).'.xml">rss</a></li><br />' . "\n";
			file_put_contents($this->outputBase.'/html/index.html',$tlink,FILE_APPEND);
			$this->indx['indexlink'] = true;	
		 }	
		if($this->frss){		
			file_put_contents( $rssfilename,
			"<title>" . htmlspecialchars( $display ) . "</title>\n" .
			"<link></link>" .			
			"<body>\n" .
			$output->getText() .
			"</body>\n" .
			"</html>" );	
			}
	}
	
	

	function report( $final = false ) {
		if( $final xor ( $this->pageCount % $this->reportingInterval == 0 ) ) {
			$this->showReport();
		}
	}

	function showReport() {
		if( $this->reporting ) {
			$delta = wfTime() - $this->startTime;
			if( $delta ) {
				$rate = sprintf("%.2f", $this->pageCount / $delta);
				$revrate = sprintf("%.2f", $this->revCount / $delta);
			} else {
				$rate = '-';
				$revrate = '-';
			}
			$this->progress( "$this->pageCount ($rate pages/sec $revrate revs/sec)" );
		}
	}

	function progress( $string ) {
		fwrite( $this->stderr, $string . "\n" );
	}

	function importFromFile( $filename ) {
		if( preg_match( '/\.gz$/', $filename ) ) {
			$filename = 'compress.zlib://' . $filename;
		}
		$file = fopen( $filename, 'rt' );
		return $this->importFromHandle( $file );
	}

	function importFromStdin() {
		$file = fopen( 'php://stdin', 'rt' );
		return $this->importFromHandle( $file );
	}
	
	function my_preg_match ( $pattern, $subject ) {
  		preg_match( $pattern, $subject, $out );
		if( isset( $out[1] ) ) {
			return trim( $out[1] );
		} else {
			return '';
		}
    }
	
	function getGuid(){
      srand((double)microtime()*1000000);
      $r = rand() ;
      $u = uniqid(getmypid() . $r . (double)microtime()*1000000,1);
      $m = md5 ($u);
      return($m);
    }
	
	function importFromHandle( $handle ) {
		$this->startTime = wfTime();

		$source = new ImportStreamSource( $handle );
		$importer = new WikiImporter( $source );

		$importer->setPageCallback( array( &$this, 'reportPage' ) );
		$this->importCallback =  $importer->setRevisionCallback(
			array( &$this, 'handleRevision' ) );

		return $importer->doImport();
	}
}

if( wfReadOnly() ) {
	wfDie( "Wiki is in read-only mode; you'll need to disable it for import to work.\n" );
}

$reader = new BackupReader();

if( isset( $options['fbase'] ) ) {
	$reader->fbase = $options['fbase'];
}

if( isset( $options['frss'] ) ) {
	$reader->frss = $options['frss'];
}

if( isset( $options['output'] ) ) {
	$reader->outputBase = $options['output'];
}  

if( isset( $options['quiet'] ) ) {
	$reader->reporting = false;
}
if( isset( $options['report'] ) ) {
	$reader->reportingInterval = intval( $options['report'] );
}
if( isset( $options['dry-run'] ) ) {
	$reader->dryRun = true;
}

if( isset( $args[0] ) ) {
	$result = $reader->importFromFile( $args[0] );
} else {
	$result = $reader->importFromStdin();
}

if( WikiError::isError( $result ) ) {
	echo $result->getMessage() . "\n";
} else {
	echo "Done!\n";
	echo "You might want to run rebuildrecentchanges.php to regenerate\n";
	echo "the recentchanges page.\n";
}



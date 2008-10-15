#!/usr/bin/php -q
<?php
/*
 * FCKpackager - JavaScript Packager and Compressor - http://www.fckeditor.net
 * Copyright (C) 2003-2008 Frederico Caldeira Knabben
 *
 * == BEGIN LICENSE ==
 *
 * Licensed under the terms of any of the following licenses at your
 * choice:
 *
 *  - GNU General Public License Version 2 or later (the "GPL")
 *    http://www.gnu.org/licenses/gpl.html
 *
 *  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
 *    http://www.gnu.org/licenses/lgpl.html
 *
 *  - Mozilla Public License Version 1.1 or later (the "MPL")
 *    http://www.mozilla.org/MPL/MPL-1.1.html
 *
 * == END LICENSE ==
 *
 * This is the main file of FCKpackager.
 *
 * You can call it through command line with "php fckpackager.php".
 */

echo( "\n" ) ;
echo( 'FCKpackager - JavaScript Packager and Compressor - Version 1.0' . "\n" ) ;
echo( 'Copyright 2004-2008 Frederico Caldeira Knabben - All rights reserved' . "\n" ) ;
echo( "\n" ) ;


// Check the number of arguments passed. The first one is the script name.
if ( count( $argv ) > 2 )
	ExitError( 'Invalid arguments. Operation aborted.' ) ;

// Get the package definition file
$xmlFileName = 'fckpackager.xml' ;

if ( isset( $argv[1] ) )
	$xmlFileName = $argv[1] ;

$packager = new FCKPackager() ;
$packager->LoadDefinitionFile( $xmlFileName ) ;
$packager->Run() ;

?>

﻿<?php


function ExitError( $message, $errorNumber = 1 )
{
	user_error( $message ) ;
	exit( $errorNumber ) ;
}

function StrEndsWith( $str, $sub )
{
	return ( substr( $str, strlen( $str ) - strlen( $sub ) ) == $sub ) ;
}

function GetXmlAttribute( $element, $attName, $defValue = '' )
{
	if ( !isset( $element->Attributes[ $attName ] ) )
		return $defValue ;

	return $element->Attributes[ $attName ] ;
}

function CreateDir($path, $rights = 0777)
{
	$dirParts = explode( '/', $path ) ;

	$currentDir = '' ;

	foreach ( $dirParts as $dirPart )
	{
		$currentDir .= $dirPart . '/' ;

		if ( strlen( $dirPart ) > 0 && !is_dir( $currentDir ) )
			mkdir( $currentDir, $rights ) ;
	}
}

function SaveStringToFile( $strData, $filePath, $includeUtf8Bom = FALSE )
{
	$f = fopen( $filePath, 'wb' ) ;

	if ( !$f )
		return FALSE ;

	if ( $includeUtf8Bom )
		fwrite( $f, "\xEF\xBB\xBF" ) ;	// BOM

	fwrite( $f, StripUtf8Bom( $strData ) ) ;
	fclose( $f ) ;

	return TRUE ;
}

function StripUtf8Bom( $data )
{
	if ( substr( $data, 0, 3 ) == "\xEF\xBB\xBF" )
		return substr_replace( $data, '', 0, 3 ) ;

	return $data ;
}

function GetMicrotime()
{
	$timeParts = explode( ' ', microtime() ) ;

	return $timeParts[0] + $timeParts[1] ;
}

?>
<?php


class FCKConstantProcessor
{
	// Public properties.
	var $RemoveDeclaration ;
	var $HasConstants ;

	// Private properties.
	var $_Constants ;
	var $_ContantsRegexPart ;

	function FCKConstantProcessor()
	{
		$this->RemoveDeclaration = TRUE ;
		$this->HasConstants = FALSE ;

		$this->_Constants = array() ;
		$this->_ContantsRegexPart = '' ;
	}

	function AddConstant( $name, $value )
	{
		if ( strlen( $this->_ContantsRegexPart ) > 0 )
			$this->_ContantsRegexPart .= '|' ;

		$this->_ContantsRegexPart .= $name ;

		$this->_Constants[ $name ] = $value ;

		$this->HasConstants = TRUE ;
	}

	function Process( $script )
	{
		if ( !$this->HasConstants )
			return $script;

		$output = $script ;

		if ( $this->RemoveDeclaration )
		{
			// /var\s+(?:BASIC_COLOR_RED|BASIC_COLOR_BLUE)\s*=.+?;/
			$output = preg_replace(
				'/var\\s+(?:' . $this->_ContantsRegexPart . ')\\s*=.+?;/m',
				'', $output ) ;
		}

		$output = preg_replace_callback(
			'/(?<!(var |...\.))(?:' . $this->_ContantsRegexPart . ')(?!(?:\s*=)|\w)/',
			array( &$this, '_Contant_Replace_Evaluator' ), $output ) ;

		return $output ;
	}

	function _Contant_Replace_Evaluator( $match )
	{
		$constantName = $match[0] ;

		if ( isset( $this->_Constants[ $constantName ] ) )
			return $this->_Constants[ $constantName ] ;
		else
			return $constantName ;
	}
}

?>
<?php


class FCKFunctionProcessor
{
	var $_Function ;
	var $_Parameters ;

	var $_VarChars = array( 'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','w','x','y','z' ) ;
	var $_VarCharsLastIndex ;

	var $_VarPrefix ;
	var $_LastCharIndex ;
	var $_NextPrefixIndex ;

	var $_IsGlobal ;

	function FCKFunctionProcessor( $function, $parameters, $isGlobal )
	{
		$this->_Function		= $function ;
		$this->_Parameters		= $isGlobal ? NULL : $parameters ;

		$this->_VarPrefix		= $isGlobal ? '_' : '' ;

		$this->_IsGlobal		= $isGlobal ;

		$this->_LastCharIndex	= 0;
		$this->_NextPrefixIndex	= 0;

		$this->_VarCharsLastIndex	= count( $this->_VarChars ) - 1 ;
	}

	function Process()
	{
		$processed = $this->_Function ;

		if ( !$this->_IsGlobal )
			$processed = $this->_ProcessVars( $processed, $this->_Parameters ) ;

		// Match "var" declarations.
		$numVarMatches = preg_match_all( '/\bvar\b\s+((?:({(?:(?>[^{}]*)|(?2))*})|[^;])+?)(?=(?:\bin\b)|;)/', $processed, $varsMatches ) ;

		if ( $numVarMatches > 0 )
		{
			$vars = array() ;

			for ( $i = 0 ; $i < $numVarMatches ; $i++ )
			{
				$varsMatch = $varsMatches[1][$i];
				
				// Removed all (...), [...] and {...} blocks from the var
				// statement to avoid problems with commas inside them.
				$varsMatch = preg_replace( '/(\((?:(?>[^\(\)]*)|(?1))*\))+/', '', $varsMatch ) ;
				$varsMatch = preg_replace( '/(\[(?:(?>[^\[\]]*)|(?1))*\])+/', '', $varsMatch ) ;
				$varsMatch = preg_replace( '/({(?:(?>[^{}]*)|(?1))*})+/', '', $varsMatch ) ;
				
				$numVarNameMatches = preg_match_all( '/(?:^|,)\s*([^\s=,]+)/', $varsMatch, $varNameMatches ) ;
				
				for ( $j = 0 ; $j < $numVarNameMatches ; $j++ )
				{
					$vars[] = $varNameMatches[1][$j] ;
				}
			}

			$processed = $this->_ProcessVars( $processed, $vars ) ;
		}

		return $processed ;
	}

	function _ProcessVars( $source, $vars )
	{
		foreach ( $vars as $var )
		{
			if ( strlen( $var) > 1 )
				$source = preg_replace( '/(?<!\w|\d|\.)' . preg_quote( $var ) . '(?!\w|\d)/', $this->_GetVarName(), $source ) ;
		}

		return $source ;
	}

	function _GetVarName()
	{
		if ( $this->_LastCharIndex == $this->_VarCharsLastIndex )
		{
			$this->_RenewPrefix() ;
			$this->_LastCharIndex = 0 ;
		}

		$var = $this->_VarPrefix . $this->_VarChars[ $this->_LastCharIndex++ ] ;

		if ( preg_match( '/(?<!\w|\d|\.)' . preg_quote( $var ) . '(?!\w|\d)/', $this->_Function ) )
			return $this->_GetVarName() ;
		else
			return $var ;
	}

	function _RenewPrefix()
	{
		if ( strlen( $this->_VarPrefix) > 0 && $this->_VarPrefix != "_" )
		{
			if ( $this->_NextPrefixIndex > $this->_VarCharsLastIndex )
				$this->_NextPrefixIndex = 0 ;
			else
				$this->_VarPrefix = substr_replace( $this->_VarPrefix, '', strlen( $this->_VarPrefix ) - 1, 1 ) ;
		}

		$this->_VarPrefix .= $this->_VarChars[ $this->_NextPrefixIndex ] ;

		$this->_NextPrefixIndex++;
	}
}

?>

<?php



class FCKJavaScriptCompressor
{
	function FCKJavaScriptCompressor()
	{}

	// Call it statically. E.g.: FCKJavaScriptCompressor::Compress( ... )
	function Compress( $script, $constantsProcessor )
	{
		// Concatenates all string with escaping new lines strings (ending with \).
		$script = preg_replace(
			'/\\\\[\n\r]+/s',
			'\n', $script ) ;

		$stringsProc = new FCKStringsProcessor() ;

		// Protect the script strings.
		$script = $stringsProc->ProtectStrings( $script ) ;

		// Remove "/* */" comments
		$script = preg_replace(
			'/(?<!\/)\/\*.*?\*\//s',
			'', $script ) ;

		// Remove "//" comments
		$script = preg_replace(
				'/\/\/.*$/m',
				'', $script ) ;
		
		// Remove spaces before the ";" at the end of the lines
		$script = preg_replace(
			'/\s*(?=;\s*$)/m',
			'', $script ) ;

		// Remove spaces next to "="
		$script = preg_replace(
			'/^([^"\'\r\n]*?)\s*=\s*/m',
			'$1=', $script ) ;

		// Remove spaces on "()": "( content )" = "(content)"
		$script = preg_replace(
			'/^([^\r\n""\']*?\()\s+(.*?)\s+(?=\)[^\)]*$)/m',
			'$1$2', $script ) ;

		// Concatenate lines that doesn't end with [;{}] using a space
		$script = preg_replace(
			'/(?<![;{}\n\r\s])\s*[\n\r]+\s*(?![\s\n\r{}])/s',
			' ', $script ) ;

		// Concatenate lines that end with "}" using a ";", except for "else",
		// "while", "catch" and "finally" cases, or when followed by, "'", ";",
		// "}" or ")".
		$script = preg_replace(
			'/\s*}\s*[\n\r]+\s*(?!\s*(else|catch|finally|while|[}\),;]))/s',
			'};', $script ) ;

		// Remove blank lines, spaces at the begining or the at the end and \n\r
		$script = preg_replace(
			'/(^\s*$)|(^\s+)|(\s+$\n)/m',
			'', $script ) ;

		// Remove the spaces between statements.
		$script = FCKJavaScriptCompressor::_RemoveInnerSpaces( $script ) ;

		// Process constants.	// CHECK
		if ( $constantsProcessor->HasConstants )
			$script = $constantsProcessor->Process( $script );

		// Replace "new Object()".
		$script = preg_replace(
			'/new Object\(\)/',
			'{}', $script ) ;

		// Replace "new Array()".
		$script = preg_replace(
			'/new Array\(\)/',
			'[]', $script ) ;

		// Process function contents, renaming parameters and variables.
		$script = FCKJavaScriptCompressor::_ProcessFunctions( $script ) ;

		// Join consecutive string concatened with a "+".
		$script = $stringsProc->ConcatProtectedStrings( $script );

		// Restore the protected script strings.
		$script = $stringsProc->RestoreStrings( $script );

		return $script ;
	}

	function _RemoveInnerSpaces( $script )
	{
		return preg_replace_callback(
			'/(?:\s*[=?:+\-*\/&,;><|!]\s*)|(?:[(\[]\s+)|(?:\s+[)\]])/',
			array( 'FCKJavaScriptCompressor', '_RemoveInnerSpacesMatch' ), $script ) ;
	}

	function _RemoveInnerSpacesMatch( $match )
	{
		return trim( $match[0] ) ;
	}

	function _ProcessFunctions( $script )
	{
		return preg_replace_callback(
			'/function(?:\s+\w+)?\s*\(\s*([^\)]*?)\s*\)\s*({(?:(?>[^{}]*)|(?2))*})+/',
			array( 'FCKJavaScriptCompressor', '_ProcessFunctionMatch' ), $script ) ;
	}

	function _ProcessFunctionMatch( $match )
	{
		// Creates an array with the parameters names ($match[1]).
		if ( strlen( trim( $match[1] ) ) == 0 )
			$parameters = array() ;
		else
			$parameters = preg_split( '/\s*,\s*/', trim( $match[1] ) ) ;

		$hasfuncProcessor = isset( $GLOBALS['funcProcessor'] ) ;

		if ( $hasfuncProcessor != TRUE )
			$GLOBALS['funcProcessor'] = new FCKFunctionProcessor( $match[0], $parameters, false ) ;
		else
		{
			$GLOBALS['funcProcessor']->_Function = $match[0];
			$GLOBALS['funcProcessor']->_Parameters = $parameters;
		}

		$processed = $GLOBALS['funcProcessor']->Process() ;
		
		$processed = substr_replace( $processed, '', 0, 8 ) ;

		$processed = FCKJavaScriptCompressor::_ProcessFunctions( $processed ) ;

		if ( $hasfuncProcessor != TRUE )
			unset( $GLOBALS['funcProcessor'] ) ;
		
		return 'function'. $processed ;
	}
}

?>

<?php



class FCKPackageFile
{
	// Public properties.
	var $CompactJavaScript ;
	var $RenameGlobals ;
	var $Header ;
	var $ConstantsProcessor ;

	// Private properties.
	var $_OutputPath ;
	var $_Files ;

	function FCKPackageFile( $outputPath )
	{
		$this->CompactJavaScript = TRUE ;
		$this->RenameGlobals = FALSE ;
		$this->Header = '' ;

		$this->_OutputPath = $outputPath ;
		$this->_Files = array() ;
	}

	function AddFile( $sourceFilePath )
	{
		$this->_Files[] = $sourceFilePath ;
	}

	function CreateFile()
	{
		echo 'Packaging file ' . basename( $this->_OutputPath ) . "\n" ;

		// Extract the directory from the output file path.
		$destDir = dirname( $this->_OutputPath );

		// Create the directory if it doesn't exist.
		if ( !@is_dir( $destDir ) )
			CreateDir( $destDir ) ;

		// Create the StringBuilder that will hold the output data.
		$outputData = '' ;

		$uncompressedSize = 0 ;

		// Loop through the files.
		foreach ( $this->_Files as $file )
		{
			// Read the file.
			$data = file_get_contents( $file ) ;

			// Strip the UTF-8 BOM, if available.
			$data = StripUtf8Bom( $data ) ;

			$dataSize = strlen( $data ) ;
			$uncompressedSize += $dataSize ;

			echo '    Adding ' . basename( $file ) . "\n" ;

			// Compress (if needed) and process its contents.
			if ( $this->CompactJavaScript )
				$outputData .= FCKJavaScriptCompressor::Compress( FCKPreProcessor::Process( $data ), $this->ConstantsProcessor ) ;
			else
				$outputData .= FCKPreProcessor::Process( $data ) ;

			// Each file terminates with a CRLF, even if compressed.
			$outputData .= "\r\n" ;
		}

		// Replace global vars.
		if ( $this->RenameGlobals )
		{
			$funcProcessor = new FCKFunctionProcessor( $outputData, NULL, true ) ;
			$outputData = $funcProcessor->Process() ;
		}

		// Write the output file.
		if ( strlen( $this->Header ) > 0 )
			$outputData = $this->Header . "\r\n" . $outputData ;

		if ( !SaveStringToFile( $outputData, $this->_OutputPath, TRUE ) )
			ExitError( 'It was not possible to save the file "' . $this->_OutputPath . '".' ) ;

		echo( "\n" );
		echo( '    Number of files processed: ' . count( $this->_Files ) . "\n" ) ;
		echo( '    Original size............: ' . number_format( $uncompressedSize ) . ' bytes' . "\n" ) ;
		echo( '    Output file size.........: ' . number_format( strlen( $outputData ) ) . ' bytes (' . round( strlen( $outputData ) / $uncompressedSize * 100, 2 ) . '% of original)' . "\n" ) ;
		echo( "\n" );
	}
}

?>
<?php



class FCKPackager
{
	var $PackageFiles ;
	var $RemoveDeclaration ;

	var $_ConstantProcessor ;
	var $_TotalFiles ;

	function FCKPackager()
	{
		$this->PackageFiles = array() ;
		$this->RemoveDeclaration = true ;

		$this->_ConstantProcessor = new FCKConstantProcessor() ;
		$this->_TotalFiles = 0 ;
	}

	function LoadDefinitionFile( $packageDefinitionXmlPath )
	{
		$XML = new FCKXmlDocument() ;

		if ( !$XML->LoadFile( $packageDefinitionXmlPath ) )
		   ExitError( 'Could not load XML definition file "' . $packageDefinitionXmlPath . '"' ) ;

		$this->LoadDefinitionFileXmlDocument( $XML ) ;
	}

	function LoadDefinitionXml( $packageDefinitionXml )
	{
		$XML = new FCKXmlDocument() ;

		if ( !$XML->LoadXml( $packageDefinitionXml ) )
		   ExitError( 'Could not load XML data' ) ;

		$this->RunXmlDocument( $XML ) ;
	}

	function LoadDefinitionFileXmlDocument( $packageDefinitionXmlDocument )
	{
		// Get the root "Package" element.
		$packageNode = &$packageDefinitionXmlDocument->Children[ 'PACKAGE' ][0] ;

		// Get the Header text.
		if ( isset( $packageNode->Children[ 'HEADER' ] ) )
			$header = $packageNode->Children[ 'HEADER' ][0]->Value ;
		else
			$header = 0 ;

		// Get the constants (if defined).
		$constantsNode = &$packageNode->Children[ 'CONSTANTS' ][0] ;

		if ( isset( $constantsNode ) )
		{
			$this->_ConstantProcessor->RemoveDeclaration = ( GetXmlAttribute( $constantsNode, 'REMOVEDECLARATION', 'true' ) == 'true' ) ;

			$constantNodes = &$constantsNode->Children[ 'CONSTANT' ] ;

			// Add the constants to the constants processor.
			foreach ( $constantNodes as $constantNode )
			{
				$this->_ConstantProcessor->AddConstant(
					$constantNode->Attributes[ 'NAME' ],
					$constantNode->Attributes[ 'VALUE' ] ) ;
			}
		}

		// Get the Package Files definitions.
		$packageFileNodes = $packageNode->Children[ 'PACKAGEFILE' ] ;

		if ( isset( $packageFileNodes ) )
		{
			$this->_TotalFiles += count( $packageFileNodes ) ;

			// Loop through the package files.
			foreach ( $packageFileNodes as $packageFileNode )
			{
				// Create the package file instance.
				$file = new FCKPackageFile( $packageFileNode->Attributes[ 'PATH' ] ) ;
				$file->CompactJavaScript	= ( GetXmlAttribute( $packageFileNode, 'COMPACTJAVASCRIPT', 'true' ) == 'true' ) ;
				$file->RenameGlobals		= ( GetXmlAttribute( $packageFileNode, 'RENAMEGLOBALS', 'false' ) == 'true' ) ;
				$file->Header				= $header ;
				$file->ConstantsProcessor	= &$this->_ConstantProcessor ;

				// Get all files defined for that package file.
				$fileNodes = $packageFileNode->Children[ 'FILE' ] ;

				if ( isset( $fileNodes ) )
				{
					// Loop throwgh the files.
					foreach ( $fileNodes as $fileNode )
					{
						$file->AddFile( $fileNode->Attributes[ 'PATH' ] ) ;
					}
				}

				$this->PackageFiles[] = $file ;
			}
		}
	}

	function Run()
	{
		$startTime = GetMicrotime() ;

		foreach ( $this->PackageFiles as $packageFile )
		{
			$packageFile->CreateFile() ;
		}

		$execTime = GetMicrotime() - $startTime ;
		$execTime = number_format( $execTime, 10 ) ;

		switch ( $this->_TotalFiles )
		{
			case 0 :
				echo( 'No files defined' ) ;
				break;
			case 1 :
				echo( 'The generation of the package file has been completed in ' . $execTime . ' seconds.' ) ;
				break;
			default :
				echo( 'The generation of ' . $this->_TotalFiles . ' files has been completed in ' . $execTime . ' seconds.' ) ;
				break;
		}
	}
}

?>
<?php


class FCKPreProcessor
{
	function FCKPreProcessor()
	{}

	// Call it statically. E.g.: FCKPreProcessor::ProcessFile( ... )
	function ProcessFile( $sourceFilePath, $destinationFilePath, $onlyHeader = FALSE )
	{
		SaveStringToFile(
			FCKPreProcessor::Process( file_get_contents( $sourceFilePath ), $onlyHeader ),
			$destinationFilePath,
			( StrEndsWith( $sourceFilePath, '.asp' ) || StrEndsWith( $sourceFilePath, '.js' ) ) ) ;	// Only ASP and JavaScript files require the BOM.

		// Set the destination file Last Access and Last Write times.
		// It seams we can't change the creation time with PHP.
		touch( $destinationFilePath, filemtime( $sourceFilePath ), fileatime( $sourceFilePath ) ) ;
	}

	// Call it statically. E.g.: FCKPreProcessor::Process( ... )
	function Process( $data, $onlyHeader = false )
	{
		if ( ! $onlyHeader )
		{
			// Remove everything between the @Packager.Remove.Start and
			// @Packager.Remove.End clauses including the clauses lines.
			$data = preg_replace(
				'/(?m-s:^.*?@Packager\.Remove\.Start).*?(?m-s:@Packager\.Remove\.End.*?$\n?)/is',
				'', $data ) ;

			// Remove all lines containing the @Packager.RemoveLine clause.
			$data = preg_replace(
				'/^.*@Packager\.RemoveLine.*$\n?/im',
				'', $data ) ;
		}

		// Fix invalid line breaks (must be all CRLF).
		$data = preg_replace(
			'/(?:(?<!\r)\n)|(?:\r(?!\n))/im',
			"\r\n", $data ) ;

		return $data ;
	}
}

?>
<?php


class FCKStringsProcessor
{
	var $_ProtectedStrings ;

	function FCKStringsProcessor()
	{
		$_ProtectedStrings = array() ;
	}

	function ProtectStrings( $source )
	{
		// Catches string literals, regular expressions and conditional comments.
		return preg_replace_callback(
			'/(?:("|\').*?(?<!\\\\)\1)|(?:(?<![\*\/\\\\])\/[^\/\*].*?(?<!\\\\)\/(?=([\.\w])|(\s*[,;}\)])))|(?s:\/\*@(?:cc_on|if|elif|else|end).*?@\*\/)/',
			array( &$this, '_ProtectStringsMatch' ), $source ) ;
	}

	function _ProtectStringsMatch( $match )
	{
		$this->_ProtectedStrings[] = $match[0] ;
		return '@' . ( count( $this->_ProtectedStrings ) - 1 ) . '@' ;
	}

	function ConcatProtectedStrings( $source )
	{
		return preg_replace_callback(
			'/@\d+@(?>@\d+@|\+)+@\d+@/',
			array( &$this, '_ConcatProtectedStringsMatch' ), $source ) ;
	}

	function _ConcatProtectedStringsMatch( $match )
	{
		// $match[0] is something like @2@+@3@+@4@+@5@

		$indexes = explode( '@+@', trim( $match[0], '@') ) ;

		$leftIndex	= (int)$indexes[0] ;
		$rightPosition = 1 ;

		$output = '@' . $leftIndex . '@' ;

		while( $rightPosition < count( $indexes ) )
		{
			$rightIndex	= (int)$indexes[ $rightPosition ] ;

			$left	= $this->_ProtectedStrings[ $leftIndex ] ;
			$right	= $this->_ProtectedStrings[ $rightIndex ] ;

			if ( strncmp( $left, $right, 1 ) == 0 )
			{
				$left = substr_replace( $left, '', strlen( $left ) - 1, 1 ) ;
				$right = substr_replace( $right, '', 0, 1 ) ;

				$this->_ProtectedStrings[ $leftIndex ] = $left . $right ;
				$this->_ProtectedStrings[ $rightIndex ] = '' ;
			}
			else
			{
				$leftIndex = $rightIndex ;
				$output .= '+@' . $leftIndex . '@' ;
			}

			$rightPosition++ ;
		}

		return $output ;
	}

	function RestoreStrings( $source )
	{
		return preg_replace_callback(
			'/@(\d+)@/',
			array( &$this, '_RestoreStringsMatch' ), $source ) ;
	}

	function _RestoreStringsMatch( $match )
	{
		return $this->_ProtectedStrings[ (int)$match[1] ] ;
	}
}

?>

<?php


class FCKXmlDocument
{
	// Public properties.
	var $Children ;

	// Private properties.
	var $_XmlParser ;
	var $_CurrentNode ;

	function FCKXmlDocument()
	{
		$this->Children = array() ;
	}

	function LoadFile( $filePath )
	{
		$this->Children = array() ;
		$this->_CurrentNode = &$this ;

		return $this->LoadXml( file_get_contents( $filePath ) ) ;
	}

	function LoadXml( $xml )
	{
		// Create the XML Parser.
		$this->_XmlParser = xml_parser_create( '' ) ;

		// Setup the parser.
		xml_parser_set_option( $this->_XmlParser, XML_OPTION_SKIP_WHITE, 1 ) ;
		xml_set_object( $this->_XmlParser, $this ) ;
		xml_set_element_handler( $this->_XmlParser, '_ElementOpen', '_ElementClosed' ) ;

		xml_set_character_data_handler( $this->_XmlParser, '_ElementData' ) ;

		// Parse it.
		if( !xml_parse( $this->_XmlParser, $xml ) )
		{
		   ExitError( sprintf( "XML error: %s at line %d",
				xml_error_string(xml_get_error_code( $this->_XmlParser ) ),
				xml_get_current_line_number( $this->_XmlParser ) ) ) ;
		}

		// Release the parser.
		xml_parser_free( $this->_XmlParser ) ;

		unset( $this->_XmlParser ) ;
		unset( $this->_CurrentNode ) ;

		// For debug purposes:
		// SaveStringToFile( print_r( $this, TRUE ), 'parsed.txt' ) ;
		// print_r( $this ) ;
		// exit ;

		return TRUE ;
	}

	function _ElementOpen( $parser, $name, $attrs )
	{
		$newNode = (object)array(
			'Parent' => &$this->_CurrentNode,
			'Name' => $name,
			'Attributes' => $attrs,
			'Value' => '',
			'Children' => array() ) ;

		$this->_CurrentNode->Children[ $name ][] = &$newNode ;

		$this->_CurrentNode = &$newNode ;
	}

	function _ElementClosed( $parser, $name )
	{
		$this->_CurrentNode = &$this->_CurrentNode->Parent ;
	}

	function _ElementData( $parser, $data )
	{
		$this->_CurrentNode->Value .= $data ;
	}
}

?>
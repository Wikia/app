<?php
/**
 * Extract data from cldr XML.
 *
 * @author Niklas Laxström
 * @author Ryan Kaldari
 * @copyright Copyright © 2007-2011
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Assuming default location $IP/extensions/cldr
 */
$IP = "../..";
require_once( "$IP/maintenance/commandLine.inc" );

$dir = dirname( __FILE__ );
require_once( "$dir/cldr.php" );

$DATA = "$dir/core/common/main";
$OUTPUT = $dir;

if ( isset( $options['datadir'] ) ) {
	$DATA = $options['datadir'];
}

if ( isset( $options['outputdir'] ) ) {
	$OUTPUT = $options['outputdir'];
}

// Get an array of all MediaWiki languages ( $wgLanguageNames + $wgExtraLanguageNames )
$languages = Language::getLanguageNames( false );
# hack to get pt-pt too
$languages['pt-pt'] = 'Foo';
ksort( $languages );

foreach ( $languages as $code => $name ) {

	// Construct the correct name for the input file
	unset( $codeParts );
	$codeParts = explode( '-', $code );
	if ( count( $codeParts ) > 1 ) {

		// ISO 15924 alpha-4 script code
		if ( strlen( $codeParts[1] ) == 4 ) {
			$codeParts[1] = ucfirst( $codeParts[1] );
		}

		// ISO 3166-1 alpha-2 country code
		if ( strlen( $codeParts[1] ) == 2 ) {
			$codeParts[2] = $codeParts[1];
			unset( $codeParts[1] );
		}
		if ( isset( $codeParts[2] ) ) {
			if ( strlen( $codeParts[2] ) == 2 ) {
				$codeParts[2] = strtoupper( $codeParts[2] );
			}
		}
		$codeCLDR = implode( '_', $codeParts );
	} else {
		$codeCLDR = $code;
	}
	$input = "$DATA/$codeCLDR.xml";

	// If the file exists, parse it, otherwise display an error
	if ( file_exists( $input ) ) {
		$outputFileName = Language::getFileName( "CldrNames", getRealCode ( $code ), '.php' );
		$p = new CLDRParser();
		$p->parse( $input, "$OUTPUT/CldrNames/$outputFileName" );
	} elseif ( isset( $options['verbose'] ) ) {
		echo "File $input not found\n";
	}
}

class CLDRParser {
	private $parseContents = true;
	private $languages = false;
	private $currencies = false;
	private $currency = false;
	private $countries = false;
	private $languageCount = 0;
	private $currencyCount = 0;
	private $countryCount = 0;
	private $languageOutput = '';
	private $currencyOutput = '';
	private $countryOutput = '';
	private $type = '';
	private $output = "<?php\n";

	function langStart( $parser, $name, $attrs ) {
		$this->parseContents = false;
		if ( $name === 'LANGUAGES' ) {
			$this->languages = true;
		}
		if ( $this->languages && $name === 'LANGUAGE' ) {
			if ( !isset( $attrs["ALT"] ) ) { // Exclude names that are alt.
				$this->parseContents = true;
				$this->type = str_replace( '_', '-', strtolower( $attrs['TYPE'] ) );
				$this->languageOutput .= "'$this->type' => '";
			}
		}
	}

	function langEnd( $parser, $name ) {
		if ( $name === 'LANGUAGES' ) {
			$this->languages = false;
			$this->parseContents = false;
			return;
		}
		if ( !$this->parseContents ) return;
		$this->languageOutput .= "',\n";
	}

	function langContents( $parser, $data ) {
		if ( !$this->parseContents ) return;
		if ( trim( $data ) === '' ) return;
		// Trim data and escape quote marks, but don't double escape.
		$this->languageOutput .= preg_replace( "/(?<!\\\\)'/", "\'", trim( $data ) );
		$this->languageCount++;
	}

	function parseLanguages( $input, $output, $fileHandle ) {

		$xml_parser = xml_parser_create(); // Create a new parser

		// Set up the handler functions for the XML parser
		xml_set_element_handler( $xml_parser, array( $this, 'langStart' ), array( $this, 'langEnd' ) );
		xml_set_character_data_handler( $xml_parser, array( $this, 'langContents' ) );

		$this->languageOutput = "\n\$languageNames = array(\n"; // Open the languageNames array

		// Populate the array with the XML data
		while ( $data = fread( $fileHandle, filesize( $input ) ) ) {
			if ( !xml_parse( $xml_parser, $data, feof( $fileHandle ) ) ) {
				die( sprintf( "XML error: %s at line %d",
					xml_error_string( xml_get_error_code( $xml_parser ) ),
					xml_get_current_line_number( $xml_parser ) ) );
			}
		}

		$this->languageOutput .= ");\n"; // Close the languageNames array

		If ( $this->languageCount > 0 ) {
			$this->output .= $this->languageOutput;
			// Give a status update
			if ( $this->languageCount == 1 ) {
				echo "Wrote 1 entry to $output\n";
			} else {
				echo "Wrote $this->languageCount entries to $output\n";
			}
		}

		xml_parser_free( $xml_parser ); // Free the XML parser

	}

	function currencyStart( $parser, $name, $attrs ) {
		$this->parseContents = false;
		if ( $name === 'CURRENCIES' ) {
			$this->currencies = true;
		}
		if ( $this->currencies && $name === 'CURRENCY' ) {
			$this->type = $attrs['TYPE'];
			$this->currency = true;
		}
		if ( $this->currency && $name == 'DISPLAYNAME' ) {
			if ( !isset( $attrs["COUNT"] ) ) { // Exclude plurals.
				$this->currencyOutput .= "'$this->type' => '";
				$this->parseContents = true;
			}
		}
	}

	function currencyEnd( $parser, $name ) {
		if ( $name === 'CURRENCY' ) {
			$this->currency = false;
			$this->parseContents = false;
			return;
		}
		if ( $name === 'CURRENCIES' ) {
			$this->currencies = false;
			$this->parseContents = false;
			return;
		}
		if ( !$this->parseContents ) return; // If we didn't parse the contents, exit
		$this->currencyOutput .= "',\n";
	}

	function currencyContents( $parser, $data ) {
		if ( !$this->parseContents ) return;
		if ( trim( $data ) === '' ) return;
		// Trim data and escape quote marks, but don't double escape.
		$this->currencyOutput .= preg_replace( "/(?<!\\\\)'/", "\'", trim( $data ) );
		$this->currencyCount++;
	}

	function parseCurrencies( $input, $output, $fileHandle ) {

		$xml_parser = xml_parser_create(); // Create a new parser

		// Set up the handler functions for the XML parser
		xml_set_element_handler( $xml_parser, array( $this, 'currencyStart' ), array( $this, 'currencyEnd' ) );
		xml_set_character_data_handler( $xml_parser, array( $this, 'currencyContents' ) );

		$this->currencyOutput = "\n\$currencyNames = array(\n"; // Open the currencyNames array

		// Populate the array with the XML data
		while ( $data = fread( $fileHandle, filesize( $input ) ) ) {
			if ( !xml_parse( $xml_parser, $data, feof( $fileHandle ) ) ) {
				die( sprintf( "XML error: %s at line %d",
					xml_error_string( xml_get_error_code( $xml_parser ) ),
					xml_get_current_line_number( $xml_parser ) ) );
			}
		}

		$this->currencyOutput .= ");\n"; // Close the currencyNames array

		If ( $this->currencyCount > 0 ) {
			$this->output .= $this->currencyOutput;
			// Give a status update
			if ( $this->currencyCount == 1 ) {
				echo "Wrote 1 entry to $output\n";
			} else {
				echo "Wrote $this->currencyCount entries to $output\n";
			}
		}

		xml_parser_free( $xml_parser ); // Free the XML parser

	}

	function countryStart( $parser, $name, $attrs ) {
		$this->parseContents = false;
		if ( $name === 'TERRITORIES' ) {
			$this->countries = true;
		}
		if ( $this->countries && $name === 'TERRITORY' ) {
			// Exclude alt names unless they are short alternatives (which we prefer)
			if ( !isset( $attrs["ALT"] ) || ( isset( $attrs["ALT"] ) && $attrs["ALT"] == 'short' ) ) {
				preg_match( '/[A-Z][A-Z]/', $attrs['TYPE'], $matches );
				if ( $matches && $matches[0] !== 'ZZ' ) { // Exclude ZZ => Unknown Region
					$this->parseContents = true;
					$this->type = $matches[0];
					$this->countryOutput .= "'$this->type' => '";
				}
			}
		}
	}

	function countryEnd( $parser, $name ) {
		if ( $name === 'TERRITORIES' ) {
			$this->countries = false;
			$this->parseContents = false;
			return;
		}
		if ( !$this->parseContents ) return;
		$this->countryOutput .= "',\n";
	}

	function countryContents( $parser, $data ) {
		if ( !$this->parseContents ) return;
		if ( trim( $data ) === '' ) return;
		// Trim data and escape quote marks, but don't double escape.
		$this->countryOutput .= preg_replace( "/(?<!\\\\)'/", "\'", trim( $data ) );
		$this->countryCount++;
	}

	function parseCountries( $input, $output, $fileHandle ) {

		$xml_parser = xml_parser_create(); // Create a new parser

		// Set up the handler functions for the XML parser
		xml_set_element_handler( $xml_parser, array( $this, 'countryStart' ), array( $this, 'countryEnd' ) );
		xml_set_character_data_handler( $xml_parser, array( $this, 'countryContents' ) );

		$this->countryOutput = "\n\$countryNames = array(\n"; // Open the countryNames array

		// Populate the array with the XML data
		while ( $data = fread( $fileHandle, filesize( $input ) ) ) {
			if ( !xml_parse( $xml_parser, $data, feof( $fileHandle ) ) ) {
				die( sprintf( "XML error: %s at line %d",
					xml_error_string( xml_get_error_code( $xml_parser ) ),
					xml_get_current_line_number( $xml_parser ) ) );
			}
		}

		$this->countryOutput .= ");\n"; // Close the countryNames array

		If ( $this->countryCount > 0 ) {
			$this->output .= $this->countryOutput;
			// Give a status update
			if ( $this->countryCount == 1 ) {
				echo "Wrote 1 entry to $output\n";
			} else {
				echo "Wrote $this->countryCount entries to $output\n";
			}
		}

		xml_parser_free( $xml_parser ); // Free the XML parser

	}

	function parse( $input, $output ) {

		// Open the input file for reading
		if ( !( $fileHandle = fopen( $input, "r" ) ) ) {
			die( "could not open XML input" );
		}

		$this->parseLanguages( $input, $output, $fileHandle ); // Parse the language names
		rewind( $fileHandle ); // Reset the position of the file pointer
		$this->parseCurrencies( $input, $output, $fileHandle ); // Parse the currency names
		rewind( $fileHandle ); // Reset the position of the file pointer
		$this->parseCountries( $input, $output, $fileHandle ); // Parse the country names

		fclose( $fileHandle ); // Close the input file

		// If there is nothing to write to the file, end early.
		if ( !$this->languageCount && !$this->currencyCount && !$this->countryCount ) return;

		// Open the output file for writing
		if ( !( $fileHandle = fopen( $output, "w+" ) ) ) {
			die( "could not open output file" );
		}

		// Write the output to the output file
		fwrite( $fileHandle, $this->output );
		fclose( $fileHandle );

	}
}

// Get the code for the MediaWiki localisation,
// these are same as the fallback.
function getRealCode( $code ) {
	$realCode = $code;
	if ( !strcmp( $code, 'kk' ) )
		$realCode = 'kk-cyrl';
	elseif ( !strcmp( $code, 'ku' ) )
		$realCode = 'ku-arab';
	elseif ( !strcmp( $code, 'sr' ) )
		$realCode = 'sr-ec';
	elseif ( !strcmp( $code, 'tg' ) )
		$realCode = 'tg-cyrl';
	elseif ( !strcmp( $code, 'zh' ) )
		$realCode = 'zh-hans';
	elseif ( !strcmp( $code, 'pt' ) )
		$realCode = 'pt-br';
	elseif ( !strcmp( $code, 'pt-pt' ) )
		$realCode = 'pt';
	return $realCode;
}

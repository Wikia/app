<?php
/**
 * Sets up myspell dictionary for search suggestions
 *
 * Run without any arguments to see instructions.
 * 
 * @author Svemir Brkic
 * @file
 * @ingroup extensions
 */

require_once( '../../maintenance/Maintenance.php' );

class SphinxSearch_setup extends Maintenance {

	public function __construct() {
		parent::__construct();

		$this->mDescription = "Sets up myspell dictionary (sphinx.dic and sphinx.aff) ";
		$this->mDescription .= "for search suggestions (suggestWithEnchant method.)\n";
		$this->mDescription .= "Uses Sphinx indexer to create a list ";
		$this->mDescription .= "of all indexed words, sorted by frequency.";
	}
	
	/* Override parameters setup becuase we do not need some of the default ones */
	protected function addDefaultParams() {
		$this->addOption( 'spinxconf', 'Location of Sphinx configuration file', true, true );
		$this->addOption( 'indexer', 'Full path to Sphinx indexer if not in the path', false, true );
		$this->addOption( 'useindex', 'Sphinx index to use (defaults to wiki_main)', false, true );
		$this->addOption( 'maxwords', 'Maximum number of words to extract (defaults to 10000)', false, true );
		$this->addOption( 'help', "Display this help message" );
		$this->addOption( 'quiet', "Whether to supress non-error output" );
	}

	public function execute() {
		$max_words = intval( $this->getOption( 'maxwords', 10000 ) );
		$indexer = wfEscapeShellArg( $this->getOption( 'indexer', 'indexer' ) );
		$index = wfEscapeShellArg( $this->getOption( 'useindex', 'wiki_main' ) );
		$conf = wfEscapeShellArg( $this->getOption( 'spinxconf' ) );

		$cmd = "$indexer  --config $conf $index --buildstops sphinx.dic $max_words";
		$this->output( wfShellExec( $cmd, $retval ) );
		if ( file_exists( 'sphinx.dic' ) ) {
			$words = file('sphinx.dic');
			$cnt = count($words);
			if ($cnt) {
				file_put_contents( 'sphinx.dic',  $cnt . "\n" . join( '', $words ) );
				file_put_contents( 'sphinx.aff', "SET UTF-8\n" );
			}
		}
	}

}

$maintClass = "SphinxSearch_setup";

// Avoid E_ALL notice caused by ob_end_flush() in Maintenance::setup()
ob_start();

require_once( DO_MAINTENANCE );

<?php
/**
 * Sets wiki topics in Wiki Factory
 * Wiki Topics comes from external service -> extensions/wikia/PageClassification/EntityAPIClient.class.php
 *
 * @author jacek@wikia-inc.com
 * @ingroup Maintenance
 */

ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_NOTICE);

require_once( dirname( __FILE__ ) . '/../../../extensions/wikia/PageClassification/EntityAPIClient.class.php' );
require_once( dirname( __FILE__ ) . '/../../../extensions/wikia/PageClassification/CommonPrefix.class.php' );
require_once( dirname( __FILE__ ) . '/../../../extensions/wikia/PageClassification/ImportantArticles.class.php' );
require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );
require_once( dirname( __FILE__ ) . '/../../../includes/HttpFunctions.php' );

class SetWikiTopicsInWF extends Maintenance {

	const WF_VARIABLE_NAME = 'wgWikiVideoSearchTopics';
	protected $wikiDomain = null;
	protected $apiClient = null;
	protected $wikiId = 0;
	protected $wfWikiTopics = null;

	/**
	 * @var string [add|overwrite|remove]
	 */
	protected $mode = "add";
	protected $modeOptions = array( "add", "overwrite", "remove" );

	function __construct() {
		$this->apiClient = new EntityAPIClient();
		$this->wikiId = $_SERVER['SERVER_ID'];

		return parent::__construct();
	}

	protected function getWfWikiTopics() {
		if ( $this->wfWikiTopics === null ) {
			$this->wfWikiTopics = unserialize( WikiFactory::getVarByName( self::WF_VARIABLE_NAME, $this->wikiId )->cv_value );
			if ( $this->wfWikiTopics === null ) {
				$this->wfWikiTopics = array();
			}
		}
		return $this->wfWikiTopics;
	}

	public function execute() {
		$this->mode = $this->getOption("mode", false);
		if ( !in_array( $this->mode, $this->modeOptions ) ) {
			die("\n\n * * * Use param --mode=[".implode("|", $this->modeOptions)."] * * * \n\n");
		}
		echo "\nExecuting SetWikiTopicsInWF for: " . $this->getWikiDomain() . " | MODE: ".$this->mode."\n";

		if ( $this->mode != "remove" ) {
			$important = new ImportantArticles( $this->wikiId );
			$phrases = $important->getImportantPhrasesAsList();

			echo "\nWikiTopics are: " . $phrases . "\n";

			$phrasesArray = explode(", ", $phrases);
			$phrasesArray[] = 'test';
			$this->appendTopicsToWF( $phrasesArray );

		} else {

			WikiFactory::setVarByName( self::WF_VARIABLE_NAME, $this->wikiId, array() );
		}
		echo "\n\nDONE.\n";
	}

	protected function appendTopicsToWF( $phrases ) {

		if ( $this->mode == "add" ) {
			$wfWikiTopics = $this->getWfWikiTopics();
			foreach ( $phrases as $phrase ) {
				if ( !in_array( $phrase, $wfWikiTopics ) ) {
					$wfWikiTopics[] = $phrase;
				}
			}
			WikiFactory::setVarByName( self::WF_VARIABLE_NAME, $this->wikiId, $wfWikiTopics, 'PageClassification' );
		}
		if ( $this->mode == "overwrite" ) {
			WikiFactory::setVarByName( self::WF_VARIABLE_NAME, $this->wikiId, $phrases );
		}
	}


	public function setWikiDomain( $wikiDomain ) {
		$this->wikiDomain = $wikiDomain;
	}

	public function getWikiDomain() {
		global $wgDBname;

		if ( empty( $this->wikiDomain ) ) {
			$this->setWikiDomain( WikiFactory::DBtoDomain( $wgDBname ) );
		}
		return $this->wikiDomain;
	}



}


$maintClass = "SetWikiTopicsInWF";
require_once( RUN_MAINTENANCE_IF_MAIN );

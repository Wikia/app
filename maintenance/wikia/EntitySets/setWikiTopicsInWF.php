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
require_once( dirname( __FILE__ ) . '/../../../extensions/wikia/PageClassification/PageClassificationData.class.php' );
require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );
require_once( dirname( __FILE__ ) . '/../../../includes/HttpFunctions.php' );

class SetWikiTopicsInWF extends Maintenance {

	const WF_VARIABLE_NAME = 'wgWikiVideoSearchTopicsAutomated';
	protected $wikiDomain = null;
	protected $apiClient = null;
	protected $wikiId = 0;

	/**
	 * @var string [add|overwrite|remove]
	 */
	protected $mode = "add";
	protected $modeOptions = array( "add", "overwrite", "remove" );


	/**
	 * @var bool [if true, script apply changes to all categorized wikis]
	 */
	protected $multi = false;


	function __construct() {
		$this->apiClient = new EntityAPIClient();
		$this->wikiId = $_SERVER['SERVER_ID'];
		return parent::__construct();
	}

	public function execute() {
		$this->mode = $this->getOption("mode", false);

		// use param --mode=[add|remove|overwrite]
		if ( !in_array( $this->mode, $this->modeOptions ) ) {
			die("\n\n * * * Use param --mode=[".implode("|", $this->modeOptions)."] * * * \n\n");
		}

		// use param --multi=true for running the script for all categorized wikis
		$this->multi = $this->getOption("multi", false);

		if ( $this->multi === false ) {
			$this->setWikiTopics( $this->wikiId );
		} else {
			$classificationData = new PageClassificationData();
			$wikilist = $classificationData->getWikiList();
			foreach ( $wikilist as $item ) {
				$this->setWikiTopics( $item['wikiId'] );
			}
		}
	}

	protected function getWfWikiTopics( $wikiId ) {
		$topics =  unserialize( WikiFactory::getVarByName( self::WF_VARIABLE_NAME, $wikiId )->cv_value );
		if ( !is_array( $topics ) || $topics == false || empty($topics) ) {
			$topics = array();
		}
		return $topics;
	}

	protected function setWikiTopics( $wikiId ) {
		echo "\nExecuting SetWikiTopicsInWF for: " . $this->getWikiDBName( $wikiId ) . " | MODE: ".$this->mode."\n";

		if ( $this->mode != "remove" ) {
			$important = new ImportantArticles( $wikiId );
			$phrases = $important->getImportantPhrasesAsList();

			echo "\nWikiTopics are: " . $phrases . "\n";

			$phrasesArray = explode(", ", $phrases);
			$this->appendTopicsToWF( $phrasesArray, $wikiId );

		} else {

			WikiFactory::setVarByName( self::WF_VARIABLE_NAME, $wikiId, array() );
		}
		echo "\n\nDONE.\n";
	}

	protected function appendTopicsToWF( $phrases, $wikiId ) {

		if ( $this->mode == "add" ) {
			$wfWikiTopics = $this->getWfWikiTopics( $wikiId );
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

	public function getWikiDBName( $wikiId ) {
			return WikiFactory::IDtoDB( $wikiId );
	}

}


$maintClass = "SetWikiTopicsInWF";
require_once( RUN_MAINTENANCE_IF_MAIN );

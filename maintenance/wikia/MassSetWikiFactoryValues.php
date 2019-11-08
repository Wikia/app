<?php

require_once __DIR__ . '/../Maintenance.php';

# format of the data should follow the 
# https://docs.google.com/spreadsheets/d/1vGuJEZ0ncVQSXTrABM3YYHg2P531sWZosgNsq-uMy5M/edit#gid=2073314697

class MassSetWikiFactoryValues extends Maintenance {
  protected $saveChanges  = false;
  
  public function __construct() {
    parent::__construct();
    $this->mDescription = 'Sets Wiki Factory variable values based on CSV';
    $this->addArg( 'file', 'CSV file with the list of wikis and vars' );
    $this->addOption( 'saveChanges', 'Change the wiki values for real.', false, false, 'd' );
  }
  
  private function readFromCSV() {
    $fileName = $this->getArg( 0 );
    
    $fileHandle = fopen( $fileName, 'r' );
    $index = 0;
    $headers = [];
    $communityData = [];

    while ( ( $data = fgetcsv( $fileHandle ) ) !== false ) {
      if ( is_null( $data[0] ) ) {
        continue;
      }
      
      if ($index === 0) {
        // read headers, we'll use that to get the info
        $headers = $data;
      } else {
        // actually read the vars and add to `communityData`
        $newVariablesData = [];
        foreach( $data as $k => $v ) {
          if ( array_key_exists( $k, $headers ) ) {
            $newVariablesData[$headers[$k]] = $v;
          }
        }

        $communityData[] = $newVariablesData;
      }

      $index++;
    }

    fclose( $fileHandle );
    
    return $communityData;
  }

  private function filterVariables($communityData) {
    $variables = [];

    foreach ( $communityData as $varName => $varValue ) {
      // if key starts with `wg` it's a WikiFactory Variable
      if ( substr_compare( $varName, 'wg', 0, strlen( 'wg' ) ) === 0 ) {
        $variables[$varName] = $varValue;
      }
    }

    return $variables;
  }

  private function setVariable( $wikiId, $varName, $varValue ) {
    $currentVarData = (array) WikiFactory::getVarByName( $varName, $wikiId, true );
    $currentVarValue = array_key_exists( 'cv_value', $currentVarData ) ? $currentVarData['cv_value'] : '';

    $this->output( "Set variable on {$wikiId}: `{$varName}=`` (previously: `{$currentVarValue}`)" );
  }

  private function applyVariables( $wikiId, $variables ) {

  }

  public function execute() {
    $this->saveChanges = $this->hasOption( 'saveChanges' );
    $communities = $this->readFromCSV();

    // read the variables
    foreach ( $communities as $community ) {
      $wikiId = intval( $community['wikiId'], 10 );

      if ( $wikiId > 0) {
        $variables = $this->filterVariables( $community );
        $wikiId = 1575417;

        foreach ( $variables as $varName => $varValue ) {
            $this->setVariable( $wikiId, $varName, $varValue );
        }

        // free cache
        $this->output( "Clearing cache for {$wikiId}" );
        WikiFactory::clearCache( $wikiId );
      }
    }
  }
}

$maintClass = 'MassSetWikiFactoryValues';
require_once RUN_MAINTENANCE_IF_MAIN;

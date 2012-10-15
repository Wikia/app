<?php
/**
 * @package MediaWiki
 * @subpackage Maintenance
 * @subpackage Widgets

  Copyright: Wikia, Inc
  @author Lukasz "Egon" Matysiak; egon@wikia.com

  This script generates array with particular MediaWiki message for all languages
*/

require_once( dirname(__FILE__).'/../commandLine.inc' );

$msg = '';

if ( count( $args ) ) {
    $msg = $args[0];
}

if ( $msg == ''){
    var_dump($args);
    die ('Usage: php generate_lang_array.php  <messsage_name>'."\n");
}

$text = "array (\n";

require_once( '../../languages/Names.php');

$keys = array_keys($wgLanguageNames);

$key = $keys[0];

foreach($keys as $key){
    unset($messages);
    $Key = ucfirst($key);
    if (file_exists ( "../../languages/messages/Messages$Key.php" ) ){
        include( "../../languages/messages/Messages$Key.php" );
        //if (isset ( $messages ) && !$messages[ $msg ] && 
        if ( file_exists ( "../../languages/messages/Wikia/Messages$Key.php" ) ){
            include( "../../languages/messages/Wikia/Messages$Key.php" );
        }
        //$text .= "Key=$Key messages=$messages path=../../languages/messages/Messages$Key.php message={$messages[$msg]}\n";
        if ( isset ( $messages ) && $messages[ $msg ]){
            $message = str_replace ("'", "\\'", $messages[ $msg ]);
            $text .= "'$key' => '$message',\n";
        }else{
            continue;
        }
    }else{
        continue;
    }

}

$text .= ")\n";

echo $text;
?>
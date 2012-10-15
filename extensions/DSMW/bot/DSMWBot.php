<?php
/**
 * Bot that add types to DSMW new semantic properties
 *
 * @copyright INRIA-LORIA-ECOO project
 * @author muller jean-philippe
 */
require_once( 'BasicBot.php' );

/** 	callback addType is almost identical to addTemplate. Pass it an array with this arg:
  *$args['type'] = 'Type_Name';	// you don't need to put brackets around the type name.
  * And don't precede it with "Type:" either. Just the name, please.		*/
function addType( $content, $args ) {
	if ( !is_array( $args ) )
		return $content; // do nothing
	extract( $args );
	if ( '' == $type )
		die( "You didn't pass valid parameters to 'addType()'" );
	$type = '[[has type::' . $type . ']]';
	if ( inString( $content, $type ) )	// don't add the category twice
		return $content;
	$content = trim( $content );
	if ( '' == $content ) // this probably means that we're adding a type to a type page without any text at the top
		$content = $type;
	elseif ( inString( $content, '[[has type:' ) )
		$content = $type; // if there is already a type, let's overwrite it.
	else
		$content .= $type; // if there isn't already a type...
	return $content;
}


$myBot = new BasicBot();
$myBot->wikiServer = $_POST['server'];
$args = array();
// Property array: key=property page and value=type
$propArray = array( "Property:changeSetID" => "String",
                   "Property:hasSemanticQuery" => "String",
                   "Property:patchID" => "String",
                   "Property:pushFeedServer" => "URL",
                   "Property:pushFeedName" => "String"
                   );
         // "Property:hasOperation"=>"String", "String", "String", "String"!!!!!
foreach ( $propArray as $source => $type ) {
$args['type'] = $type;
$result = $myBot->wikiFilter( $source, 'addType', '', $args );
}
// hasOperation is a many-valued property
$source = "Property:hasOperation";
// $args['type'] = "String;String;String;Text";
$args['type'] = "Record]]
[[has fields::String;String;String;Text";
$result = $myBot->wikiFilter( $source, 'addType', '', $args );

echo "Property types are updated!";
echo '<a href="' . $_POST['server'] . '/index.php/Special:DSMWAdmin">back</a>'
?>

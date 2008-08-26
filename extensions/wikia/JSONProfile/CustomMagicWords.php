<?php
#--------------------------------------------------
# Step 1: choose a magic word id
#--------------------------------------------------
 
# storing the chosen id in a constant is not required
# but still good programming practice - it  makes 
# searching for all occurrences of the magic word id a
# bit easier - note that the the name of the constant
# and the value it is assigned don't have to have anthing
# to do with each other.
 
define('PROFILEJSONPATH', 'profilejsonpathvar');
define('BULLETINNAME', 'bulletinnamevar');
 
#---------------------------------------------------
# Step 2: define some words to use in wiki markup
#---------------------------------------------------
 
$wgHooks['LanguageGetMagic'][] = 'wfMyWikiWords';
function wfMyWikiWords(&$aWikiWords, &$langID) {
 
  #tell MediaWiki that all {{NiftyVar}}, {{NIFTYVAR}}, 
  #{{CoolVar}}, {{COOLVAR}} and all case variants found 
  #in wiki text should be mapped to magic id 'mycustomvar1'
  # (0 means case-insensitive)
  $aWikiWords[PROFILEJSONPATH] = array(0, 'PROFILEJSONPATH');
 
  #must do this or you will silence every LanguageGetMagic
  #hook after this!
  return true;
}
 
#---------------------------------------------------
# Step 3: assign a value to our variable
#---------------------------------------------------
 
$wgHooks['ParserGetVariableValueSwitch'][] = 'wfMyAssignAValue';
function wfMyAssignAValue(&$parser, &$cache, &$magicWordId, &$ret) {
	global $wgProfileJSONPath;
  if (PROFILEJSONPATH == $magicWordId) {
     $ret=$wgProfileJSONPath;
 
     #tell MediaWiki it can stop searching - we found a value
     return true;  
  } else {
     #go onto the next hook assigned to ParserGetVariableValueSwitch
     #may be it can assign a value 
     return false;
  }
}
 
#---------------------------------------------------
# Step 4: register the custom variables so that it
#         shows up in Special:Version under the 
#         listing of custom variables
#---------------------------------------------------
 
$wgExtensionCredits['variable'][] = array(
       'name' => 'NiftyVar',
       'author' =>'John Doe', 
       'url' => 'http://www.mediawiki.org/wiki/Extension:NiftyVar', 
       'description' => 'This variable is an example and performs no discernable function'
       );
 
#---------------------------------------------------
# Step 5: register wiki markup words associated with
#         MAG_NIFTYVAR as a variable and not some 
#         other type of magic word
#---------------------------------------------------
 
$wgHooks['MagicWordwgVariableIDs'][] = 'wfMyDeclareVarIds';
function wfMyDeclareVarIds(&$aCustomVariableIds) {
 
  #aCustomVariableIds is where MediaWiki wants to store its
  #list of custom variable ids. We oblige by adding ours:
  $aCustomVariableIds[] = PROFILEJSONPATH;
 
  #must do this or you will silence every MagicWordwgVariableIds
  #registered after this!
  return true;
}


/* ******************* Parser function section ******************* */
# Define a setup function
$wgExtensionFunctions[] = 'efBulletinNameParser_Setup';
# Add a hook to initialise the magic word
$wgHooks['LanguageGetMagic'][]       = 'efBulletinNameParser_Magic';
 
function efBulletinNameParser_Setup() {
        global $wgParser;
        # Set a function hook associating the "example" magic word with our function
        $wgParser->setFunctionHook( 'BULLETINNAME', 'efBulletinNameParser_Render' );
}
 
function efBulletinNameParser_Magic( &$magicWords, $langCode ) {
        # Add the magic word
        # The first array element is case sensitive, in this case it is not case sensitive
        # All remaining elements are synonyms for our parser function
        $magicWords['BULLETINNAME'] = array( 0, 'BULLETINNAME' );
        # unless we return true, other parser functions extensions won't get loaded.
        return true;
}
 
function efBulletinNameParser_Render( &$parser, $param_1='' ) {
        # The parser function itself
        # The input parameters are wikitext with templates expanded
        # The output should be wikitext too
        return  str_replace(" ", "_", $param_1);
}

?>

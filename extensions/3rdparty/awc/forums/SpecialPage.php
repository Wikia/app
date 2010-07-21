<?PHP
/**
* AWC`s Mediawiki Forum Extension
* 
* License: <br />
* Another Web Compnay (AWC) 
* 
* All of Another Web Company's (AWC) MediaWiki Extensions are licensed under<br />
* Creative Commons Attribution-Share Alike 3.0 United States License<br />
* http://creativecommons.org/licenses/by-sa/3.0/us/
* 
* All of AWC's MediaWiki extension's can be freely-distribute, 
*  no profit of any kind is allowed to be made off of or because of the extension itself, this includes Donations.
* 
* All of AWC's MediaWiki extension's can be edited or modified and freely-distribute <br />
*  but these changes must be made public and viewable noting the changes are not original AWC code. <br />
*  A link to http://anotherwebcom.com must be visable in the source code 
*  along with being visable in render code for the public to see.
* 
* You are not allowed to remove the Another Web Company's (AWC) logo, link or name from any source code or rendered code.<br /> 
* You are not allowed to create your own code which will remove or hide Another Web Company's (AWC) logo, link or name.
* 
* This License can and will be change with-out notice. 
* 
* All of Another Web Company's (AWC) software/code/programs are distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
* 
* 4/2008 Another Web Compnay (AWC)<br />
* The above text must stay intact and not edited in any way.
* 
* @filepath /extensions/awc/forums/SpecialPage.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

if($_SERVER['REMOTE_ADDR'] == '192.168.0.111'){
    error_reporting(E_ALL | E_STRICT | E_NOTICE); # testing...
   # error_reporting(E_ALL | E_NOTICE ); # testing...
} else {
    error_reporting(E_ALL & ~E_NOTICE);
}

class AWCforum extends SpecialPage {
     
    public function __construct() {
       // awcs_forum_wfLoadExtensionMessages( 'AWCforum_genral_forum' );
        parent::__construct( 'AWCforum');
    }
    
    public function execute( $par ) {
    global $wgShowSQLErrors, $wgNoFollowLinks, $wgHooks, $wgShowExceptionDetails, $wgAjaxExportList;
   
            // Take alittle conrtol back from wiki
            $wgShowSQLErrors = true;
            $wgNoFollowLinks = false;
            $wgShowExceptionDetails = true;
            
           
            $wgHooks['SkinTemplateContentActions'][] = 'AWC_FORUM_SkinTemplateContentActions';
            
            $wgHooks['ParserAfterTidy'][] = 'AWC_FORUM_ParserAfterTidy';
            
            
            if(!defined('awcsf_wiki_url')){
                global $wgServer, $wgArticlePath;
                define('awcsf_wiki_url', $wgServer . str_replace('$1', '', $wgArticlePath) );
                define('awc_url', awcsf_wiki_url . "Special:AWCforum/" );
            }
            
            require(awc_dir . "includes/load/load_forum.php");
            load_awcs_forum();

    }
    
    
}






function AWC_FORUM_SkinTemplateContentActions(&$content_actions){
    $content_actions = null;
    unset($content_actions);
  return true;
}

function AWC_FORUM_ParserAfterTidy (&$parser, &$text) {
/*
This idea was takin from:
Federico Cargnelutti's Issue Tracking System Extension.

There are a few places in the forum where text being passed should not be phase
so they are base64_encode where needed and then this function will convert them all back in the end.
*/
    $text = preg_replace(
        '/@ENCODED@([0-9a-zA-Z\\+\\/]+=*)@ENCODED@/e',
        'base64_decode("$1")',
        $text
    );
    
    return true;


}

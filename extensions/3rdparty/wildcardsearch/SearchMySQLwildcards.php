<?PHP
#Copyright (C) 2006 Assela Pathirana under the version 2 of the GNU General Public License
#Adds wildcard search functionality to mediawiki
# file : SearchMySQLwildcards.php
 
require_once( 'SearchEngine.php' );
require_once( 'SearchMySQL.php' );
require_once( 'SearchMySQL4.php' );
 
//Register this search type and override the default search set in DefaultSettins.php
$wgSearchType   = 'SearchMySQLwildcards';
 
//Create a new search class based on the parent
class SearchMySQLwildcards extends SearchMySQL4 {
        public static function legalSearchChars() {
                //include + and * as valid characters
                return "A-Za-z_'0-9\\x80-\\xFF\\-+*";
        }
}
$strictMatching=false;
 
$wgExtensionCredits['other'][] = array(
       'name' => 'Wildcard search',
       'version' => '071002',
       'author' => 'Assela Pathirana',
       'description' => 'adds wildcard search capability',
       'url' => 'http://www.mediawiki.org/wiki/Extension:Wildcard_search'
       );
 
?>

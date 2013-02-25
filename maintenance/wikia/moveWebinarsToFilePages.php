<?php
function my_error_handler( $errno, $errstr, $errfile = null, $errline = null, $errcontext = null ) {
        printf( "Error: %d: %s\n", $errno, $errstr );
}

set_error_handler( 'my_error_handler', E_ALL | E_STRICT );
error_reporting(E_ALL | E_STRICT );

/**
 * This script moves pages from namespace How_to (120) to descritpion of file pages of related videos files
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @ingroup Maintenance
 */
require_once( __DIR__ . '/../Maintenance.php' );
class moveWebinarsToFilePages extends Maintenance {

	/**
	 * Used to be GAID_FOR_UPDATE define. Used with getArticleID() and friends
	 * to use the master DB
	 */
	const GAID_FOR_UPDATE = 1;

	public function __construct() {
		parent::__construct();
		$this->reason = 'Moving How-to webinars to video file pages';
	}

	public function execute() {
		global $wgUser, $wgTitle;
		$wgUser = User::newFromName('Wikia');
		$wgUser->load();
		//get list of pages from how-to category
		$aReturn = ApiService::call(
			array(
				'action' => 'query',
				'list' => 'categorymembers',//pages with category
				'cmtitle' => 'Category:How-to',//category name
				'cmnamespace' => '120'
			)
		);
	
	
		//perform update foreach page from category
                foreach ( $aReturn['query']['categorymembers'] as $cm) {

                        $oWebinarTitle = Title::newFromText( $cm['title'] );
			$wgTitle = $oWebinarTitle;
                        $oWebinarArticle = new Article($oWebinarTitle);

			echo "Webinar page: ".$oWebinarTitle->getText()."\n";			

			//get video link
                        $content = $oWebinarArticle->getContent();
			//preq match
			$matches = $this->matchFile( $content );

			if ( !empty($matches) ) {
				//remove params
				$aFileTitWithParams = explode( '|', $matches[1] );
				//get file title
				$oFilePageTitle = Title::newFromText( $aFileTitWithParams[0], NS_FILE );
				echo "video file title: ".$oFilePageTitle->getText()."\n";

				if (WikiaFileHelper::isFileTypeVideo( $oFilePageTitle ) ) {//to test
					echo "=----------- IS VIDEO \n";
					//prepare new content without link to video file
					$newFileContent = str_replace($matches[0], '', $content);
					//article obj
					$oFileArticle = new Article( $oFilePageTitle );
					//set new contnet without file link at the begining
    			                $oFileArticle->doEdit( $newFileContent, 'Moving How-to webinars to video file pages');
					//set redirect
					$oWebinarArticle->doEdit( "#redirect[[".$oFilePageTitle->getPrefixedDBkey()."]]", 'Setting redirect - conent was moveed to video file page' );
				}

                	}
		}


	}

	/**
	 * @return array('[[File:File name.ex|params]]',
	 * 		'File name.ex|params')
	 */
	public function matchFile ( $content ) {
		/* i.e. [[File:File name.ex|params]] */
		$regex = '/\[\[File:([^\]\]]*)\]\]/sm';
		$matches =  array();
		preg_match( $regex, $content, $matches );
		return $matches;
	}
	
}

$maintClass = "moveWebinarsToFilePages";
require_once( RUN_MAINTENANCE_IF_MAIN );

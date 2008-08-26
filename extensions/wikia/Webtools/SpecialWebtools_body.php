<?php
if (!defined('MEDIAWIKI')) {
        echo <<<EOT
To install this extension, put the following line in LocalSettings.php:
require_once( "$IP/extensions/wikia/Webtools/SpecialWebtools.php" );
EOT;
        exit( 1 );
}

class Webtools extends SpecialPage {
	/**
	 * Constructor
	 */
	function Webtools() {
		SpecialPage::SpecialPage( 'Webtools' );
		$this->includable( true );
		wfLoadExtensionMessages( 'Webtools' );
	}

	/**
	 * main()
	 */
	function execute( $par = null ) {
		global $wgRequest, $wgOut;

		$host = $_SERVER['SERVER_NAME'];
		if($wgRequest->getBool('AYDEBUG') == 1){
			$host = "24.wikia.com";
		}
		$out = $this->getSitemapStats( $host );

		//default search params

		$out['param']['search_age'] = '1 week ago';
		$out['param']['search_src'] = 'All searches';
		$out['param']['location_src'] = 'All locations';

		$post_search_src = $wgRequest->getVal('search_src');
		if($post_search_src !='') $out['param']['search_src'] = $post_search_src;

		$post_location_src  = $wgRequest->getVal('location_src');
		if($post_location_src !='') $out['param']['location_src'] = $post_location_src;

		$post_search_age = $wgRequest->getVal('search_age');
		if($post_search_age !='') $out['param']['search_age'] = $post_search_age;

		$html = new WebtoolsHTML;
		$html->outputHTML( $out );
	}

	function getSitemapStats( $host ) {
		global $wgDBserver, $wgDBuser, $wgDBpassword, $wgDBname, $wgHooks,
            $wgSharedDB, $wgDBname, $wgDBservers, $wgDevelEnvironment,
            $wgCityId;

		$out = array();

		$dbr =  wfGetDB(DB_SLAVE);

		$query = "SELECT site_url, sitemap_url, sitemap_format, sitemap_type, last_downloaded, sitemap_status, url_count
				  FROM `sitemaps`.sitemaps
				  WHERE site_url = '" . $host . "'";

		$result = $dbr->query ($query) ;

		$dbs = array();

		while( $row = $dbr->fetchObject( $result ) ) {
			$dbs[] = get_object_vars( $row );
		}

		$dbr->freeResult( $result );

		$out['overview'] = $dbs;

		$query = "SELECT *
				  FROM `sitemaps`.sitemap_stats
				  WHERE site_url = '" . $host . "'";

		$result = $dbr->query ($query) ;

		$dbs = array();
		while( $row = $dbr->fetchObject( $result ) ) {
			$dbs[] = get_object_vars($row);
		}

		$out['details'] = $dbs;
		$dbr->freeResult( $result );

		return $out;

		$dbr =  wfGetDB(DB_SLAVE);
		$dbr->selectDB( $wgDBname);
	}
}

class WebtoolsHTML extends Webtools {
 var $data = array();

	function outputHTML( $data ) {
		global $wgTitle, $wgOut, $wgLang;

		$this->data = $data;
		$this->setHeaders();

		$action = $wgTitle->escapeLocalUrl();
		$searchstats = wfMsgHtml( 'wt_search_stats' );
		$clickstats = wfMsgHtml( 'wt_click_stats' );


		$search_query = array(
						'search_type' => 'search',
						'search_age' => $this->data['param']['search_age'],
						'search_src' => $this->data['param']['search_src'],
						'location_src' => $this->data['param']['location_src'],
						'order_by' => 'serp_position',
						'include' => array( 'search_keyword', 'serp_weight', 'serp_position' )
							);

		$click_query = array(
						'search_type' => 'click',
						'search_age' => $this->data['param']['search_age'],
						'search_src' => $this->data['param']['search_src'],
						'location_src' => $this->data['param']['location_src'],
						'order_by' => 'serp_position',
						'include' => array( 'search_keyword', 'serp_weight', 'serp_position' )
							);


		$out =  "<table >" .
				"<tr><td valign=\"top\">" . $this->getBaseInfo() . "</td>" .
				"<td valign=\"top\">" . $this->getSearchForm() . "</td></tr>\n</table>\n" .

				"<table >" .
				"<tr><td><h1 class=\"mw-headline\">". wfMsgHtml( 'wt_search_stats' ) . "</h1></td>" .
				"<td><h1 class=\"mw-headline\">". wfMsgHtml( 'wt_click_stats' ) . "</h1></td></tr>\n" .
				"<tr><td valign=\"top\">". $this->getSearchStats( $search_query ) . "</h1></td>" .
				"<td valign=\"top\">". $this->getSearchStats( $click_query ) . "</h1></td></tr>\n</table>\n";

		$wgOut->addHTML( $out );
	}

	function getBaseInfo(){
		$out = '<p id="webtools_overview">';

		if( isset( $this->data['overview'] ) && ( count( $this->data['overview'] ) > 0 ) ){
		  foreach( $this->data['overview'][0] as $key => $value ){
			$out .= '<b>' . wfMsgHtml( $key ) . ' : </b>' . htmlspecialchars($value) . "<br/>";
		  }
		}else{
			$out =  wfMsgHtml( 'wt_nodata' ) ;
		}

		$out .= '</p>';
		return $out;
	}

	function getSearchForm( $params = array() ){

	global $wgTitle;

	$search_src = array();
	$location_src = array();
	$search_age = array();

	 	reset($this->data);

	 	if(count($this->data['details'])<10){
	 		$out =  '&nbsp;';
	 		return $out;
	 		exit;
	 	}

		foreach( $this->data['details'] as $key => $value ){
		 $search[$value['search_src']] = 1;
		 $location[$value['location_src']] = 1;
		 $age[$value['search_age']] = 1;
		}


		ksort($search);

		  $str_search = "<select name=\"search_src\" >\n";
			foreach( $search as $key => $value ){
			 $selected = '';
			 if($this->data['param']['search_src'] == $key){
			 	$selected = 'SELECTED';
			 }
			  $str_search .= "<option " . $selected . " value=\"". $key ."\" >" . $key . "</option>\n";
			}
		  $str_search .= "</select>\n";

		krsort($location);

		  $str_location = "<select name=\"location_src\" >\n";
			foreach( $location as $key => $value ){
			 $selected = '';

			 if($this->data['param']['location_src'] == $key){
			 	$selected = 'SELECTED';
			 }
			  $str_location .= "<option " . $selected . " value=\"". $key ."\" >" . $key . "</option>\n";
			}
		  $str_location .= "</select>\n";

		ksort($age);
		  $str_age = "<select name=\"search_age\" >\n";
			foreach( $age as $key => $value ){
			 $selected = '';

			 if($this->data['param']['search_age'] == $key){
			 	$selected = 'SELECTED';
			 }
			  $str_age .= "<option " . $selected . " value=\"". $key ."\" >" . $key . "</option>\n";
			}
		  $str_age .= "</select>\n";

	$out = "<form id=\"webtools\" method=\"post\" action=\"" . $wgTitle->escapeLocalUrl() . "\">\n" .
		   "<b>" . wfMsgHtml( 'wt_search_src' ) . "</b><br/>\n" .
		   "&nbsp;" . $str_search  ."<br/>\n" .
		   "<b>" . wfMsgHtml( 'wt_location_src' ) . "</b><br/>\n" .
		   "&nbsp;" . $str_location  ."<br/>\n" .
		   "<b>" . wfMsgHtml( 'wt_date_range' ) . "</b><br/>\n" .
		   "&nbsp;" . $str_age  ."<br/>\n" .
		   "&nbsp;<br/>\n" .
		   '<input type="submit" value="' . wfMsgHtml( 'wt_update' ) . '"> <input type="reset" value="' . wfMsgHtml( 'wt_cancel' ) . '"><br/>' . "\n" .
		   "</form>";

	return $out;
	}


	function getSearchStats( $params = array() ){
	 $stats = array();
	 $sort = array();
	 $out = '';

	  if( isset( $this->data['details'] ) && ( count( $this->data['details'] ) > 0 ) ){

	  	reset($this->data);

		foreach( $this->data['details'] as $key => $value ){


			if( ( $value['search_type'] == $params['search_type'] ) && ( $value['search_age'] == $params['search_age'] ) && ( $value['search_src'] == $params['search_src'] ) && ( $value['location_src'] == $params['location_src'] ))
			{

			  //only copy values we need
			  $nvalue = array();

			  foreach( $params['include'] as $ukey => $uvalue ){
			    $nvalue[$uvalue] = $value[$uvalue];
			  }

				$stats[] = $nvalue;
				$sort[] = $value[$params['order_by']];
			}
		}


		if( count( $stats ) > 0 ){
		  array_multisort( $sort, SORT_ASC, $stats );
		  //produce table



		  foreach( $stats as $key => $value ){
		  	if( $key == 0 ) {
		  		$out = "<table class=\"mw_metadata\">\n";
		  		$out .= "<tr>\n";
		  		//build header
		  		  foreach ( $value as $hkey => $hvalue ){
		  			$out .= '<th>' . wfMsgHtml( $hkey ) . '</th>' . "\n";
		  		  }
		  		$out .= "</tr>\n";

		  		//build first data row
		  		reset($value);
		  	}

				//build data row
		  		$out .= "<tr>\n";
		  		  foreach ( $value as $hkey => $hvalue ){
		  		    $out .= '<td>' . $hvalue . '</td>' . "\n";
		  		  }
		  		$out .= "</tr>\n";
		  }
		   		$out .= "</table>\n";
		}else{
		  $out =  '<p class="webtools_stats">' . wfMsgHtml( 'wt_nodata' ) . '</p><hr/>';
		}

	  }else{
	  	$out =  '<p id="webtools_stats">' . wfMsgHtml( 'wt_nodata' ) . '</p><hr/>';
	  }

	  return $out;

	}

}//class end

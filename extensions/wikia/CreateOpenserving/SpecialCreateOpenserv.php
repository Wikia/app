<?php
/**
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 */

$wgExtensionFunctions[] = 'wfSpecialCreateOpenservSetup';

$wgAvailableRights[] = 'createopenserv';
$wgGroupPermissions['staff']['createopenserv'] = true;

/**
 *
 */
require_once('UserMailer.php');

/**
 * constructor
 */
function wfSpecialCreateOpenservSetup() {

/**
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 */

class CreateOpenservForm extends SpecialPage {

	var $mName, $mPassword, $mRetype, $mReturnto, $mCookieCheck, $mPosted;
	var $mAction, $mCreateaccount, $mCreateaccountMail, $mMailmypassword;
	var $mLoginattempt, $mRemember, $mEmail, $mImportStarter;

	function CreateOpenservForm() {
		global $wgLang, $wgAllowRealName;
		global $wgRequest;

		UnlistedSpecialPage::UnlistedSpecialPage("CreateOpenserving");
	}

	/**
	 * @access private
	 */

	function clearRequest() {
	  global $wgUser, $wgOut;

	  $this->mID = "";
	  $this->mDomainName = "";
	  $this->mReturnUrl = "";
	  $this->mAdsense = "";
	  $this->mEmail = "";
	  $this->mCategory = "";
	  $this->mSubcategory = "";
	  $this->mSiteName = "";
	  $this->mUsername = "";
	  $this->mColor1 = "";
	  $this->mColor2 = "";
	  $this->mColor3 = "";
	  $this->mBorderColor1 = "";

	  return;
	}

	function execute() {
	  global $wgRequest,$wgUser,$wgOut;

	  $this->mPosted = $wgRequest->wasPosted();
	  $this->setupMessages();

	  $wgOut->setPageTitle( wfMsg( 'createwikipagetitle' ) );
	  $wgOut->setRobotpolicy( 'noindex,nofollow' );
	  $wgOut->setArticleRelated( false );

	  if( $this->mPosted ) {
	      global $wgOut;
	      $retval = null;
	      #fetch the application ids that are in effect
	      $dbw = wfGetDB(DB_MASTER);

	      $this->mMailtext = $wgRequest->getText( "emailtext" );
	      $this->mToolStatus = $wgRequest->getText( "tool_status" );
	      $this->mToolCategory = $wgRequest->getText( "tool_category" );
	      $this->mToolLimit = $wgRequest->getVal( "tool_limit" );
	      $this->mToolOrderBy = $wgRequest->getText( "tool_orderby" );
	      $this->mToolMinId = $wgRequest->getVal( "tool_min_id" );

	      $this->mRebuildOnly = $wgRequest->getText( "tool_rebuildonly" );

	      $dbw->update( '`openserving_reg`.openserv_autocreate_tool',
			    array('tool_mailtext' => "$this->mMailtext",
				  'tool_status' => "$this->mToolStatus",
				  'tool_category' => "$this->mToolCategory",
				  'tool_limit' => $this->mToolLimit,
				  'tool_orderby' => "$this->mToolOrderBy",
				  'tool_min_id' => "$this->mToolMinId",
				  ),
			    array('tool_id' => 1));


	      $condition = array('application_category' => "$this->mToolCategory",
				 'application_status' => "$this->mToolStatus");

	      $res = $dbw->select("`openserving_reg`.openserv_application",
				  array('application_id'),
				  $condition);

	      if($this->mRebuildOnly){
		rebuildApacheConfig();
	      }
	      else{

#iterate through the IDs, checking the values of the fileds for each, and process each request that has a checkbox checked

#	  $this->mWikiIncludeLang = $wgRequest->getCheck( 'wpCreateOpenservIncludeLang' );
#	  $this->mReqID = $wgRequest->getVal( 'req_id' );
	      $this->mMailtext = trim($wgRequest->getText( "emailtext" ));
	      while($obj = $dbw->fetchObject($res)){
		$ID = $obj->application_id;
		$this->mCategory = trim($wgRequest->getText( $ID."_application_category"));
		$action = trim($wgRequest->getText( "a".$ID."_action" ));
#		$wgOut->addHTML("iterating through an id ($ID)...action is $action<br>\n");
		if( $action == 'create' ){
		  $wgOut->addHTML("creating a wiki...<br>\n");
		  $this->mID = $ID;
		  $this->mDomainName = trim($wgRequest->getText( "a".$ID."_application_domain_request"));
		  $this->mReturnUrl = trim($wgRequest->getText( "a".$ID."_application_return_url"));
		  $this->mAdsense = trim($wgRequest->getText( "a".$ID."_application_ad_code_1"));
		  $this->mEmail = trim($wgRequest->getText( "a".$ID."_application_email"));
		  $this->mCategory = trim($wgRequest->getText( "a".$ID."_application_category"));
		  $this->mSubcategory = trim($wgRequest->getText( "a".$ID."_application_subcategory"));
		  $this->mSiteName = trim($wgRequest->getText( "a".$ID."_application_site_name"));
		  $this->mTemplate = trim($wgRequest->getText( "a".$ID."_application_template"));
		  $this->mSiteTagline = trim($wgRequest->getText( "a".$ID."_application_tagline"));
		  $this->mOpenservingType = trim($wgRequest->getText( "a".$ID."_application_openserving_type"));
		  $this->mUsername = trim($wgRequest->getText( "a".$ID."_application_username"));
		  $this->mColor1 = trim($wgRequest->getText( "a".$ID."_application_color_1"));
		  $this->mColor2 = trim($wgRequest->getText( "a".$ID."_application_color_2"));
		  $this->mColor3 = trim($wgRequest->getText( "a".$ID."_application_color_3"));
		  $this->mBorderColor1 = trim($wgRequest->getText( "a".$ID."_application_border_color_1"));
		  $retval = $this->processCreation();
		  if(strlen($retval)>0) {
		    $this->releaseLock();
		    $wgOut->addHTML("<span style=\"color: red;\">Something is wrong: {$retval}.  Creation aborted.</span>  Perhaps you meant to include the language prefix in the URL.  Click your back button and try again.<br><br>\n");
		  }
		  else{
		    $wgOut->addHTML("<span style=\"color: blue;\">processed creation for ".$this->mDomainName."</span><br>\n");
		    $tempmailtext = preg_replace("/%URL%/",
					     "http://{$this->mDomainName}.openserving.com/",$this->mMailtext);
		    $mailtext = preg_replace("/%USER%/",
					     "{$this->mUsername}",$tempmailtext);
		    global $wgPasswordSender;
		    $toaddr = new MailAddress($this->mEmail);
		    $fromaddr = new MailAddress("support@openserving.com");
#		    $toaddr = $this->mEmail;
#		    $toaddr = "jasonr@wikia.com";
#		    $fromaddr = "$wgPasswordSender";
#		    $fromaddr = "support@openserving.com";
		    $error = userMailer( $toaddr,
					 $fromaddr,
					 "Your new site is ready at OpenServing!",
					 $mailtext);
		  }
		  $this->clearRequest();
		}
		else if($action == 'defer'){
		  $wgOut->addHTML("saving changes to request $ID...<br>\n");
		  $this->mID = $ID;
		  $this->mDomainName = trim($wgRequest->getText( "a".$ID."_application_domain_request"));
		  $this->mReturnUrl = trim($wgRequest->getText( "a".$ID."_application_return_url"));
		  $this->mAdsense = trim($wgRequest->getText( "a".$ID."_application_ad_code_1"));
		  $this->mEmail = trim($wgRequest->getText( "a".$ID."_application_email"));
		  $this->mCategory = trim($wgRequest->getText( "a".$ID."_application_category"));
		  $this->mSubcategory = trim($wgRequest->getText( "a".$ID."_application_subcategory"));
		  $this->mSiteName = trim($wgRequest->getText( "a".$ID."_application_site_name"));
		  $this->mUsername = trim($wgRequest->getText( "a".$ID."_application_username"));
		  $this->mColor1 = trim($wgRequest->getText( "a".$ID."_application_color_1"));
		  $this->mColor2 = trim($wgRequest->getText( "a".$ID."_application_color_2"));
		  $this->mColor3 = trim($wgRequest->getText( "a".$ID."_application_color_3"));
		  $this->mBorderColor1 = trim($wgRequest->getText( "a".$ID."_application_border_color_1"));
		  $this->processChange();
		}
		else if($action == 'delete'){
		  $this->mID = $ID;
		  $this->mDomainName = trim($wgRequest->getText( "a".$ID."_application_domain_request"));
		  $retval = $this->processDenial();
		  $this->clearRequest();
                }
		$wgOut->addHTML("<!-- processed ".$this->mDomainName." -->\n");

	      }//end while($obj = ...)
	      }//end if($this->mRebuildOnly){...}else{
	  }
#	  else{ #commented this out so the form prints again after processing
	    $this->mainCreateOpenservForm( '' );
	    return $retval;
#	  }
	}

	function processChange() {
	  global $wgUser, $wgOut;

	  if ( !in_array( 'createopenserv', $wgUser->getRights() ) ) {
	    return;
	  }
	  if(!isset($this->mID) || '' == $this->mID){
	    $wgOut->addHTML("No valid request ID.  Try saving the request as a new request\n");
	    return;
	  }
	  $wgOut->setPageTitle( wfMsg( 'createwikipagetitle' ) );
	  $wgOut->setRobotpolicy( 'noindex,nofollow' );
	  $wgOut->setArticleRelated( false );

	  $wgOut->addHTML(wfMsg( 'createwikichangecomplete' ));
	  $dbw = wfGetDB(DB_MASTER);

	  $dbw->replace( '`openserving_reg`.openserv_application',
			 array('application_id' => $this->mID),
			 array( /* SET */
			       'application_id' => $this->mID,
			       'application_firstname'       => "$this->mFirstName",
			       'application_lastname'       => "$this->mLastName",
			       'application_email'       => "$this->mEmail",
			       'application_return_url' => "$this->mReturnUrl",
			       'application_ad_code_1' => "$this->mAdsenseId",
			       'application_domain_request'        => "$this->mDomainName",
			       'application_category' => "$this->mCategory",
			       'application_subcategory' => "$this->mSubcategory",
			       'application_site_name' => "$this->mSiteName",
			       'application_username' => "$this->mUsername",
			       'application_color_1' => "$this->mColor1",
			       'application_color_2' => "$this->mColor2",
			       'application_color_3' => "$this->mColor3",
			       'application_border_color_1' => "$this->mBorderColor1",
			       ));

	}

	/**
	 * @access private
	 */
	function processDenial() {
	  global $wgUser, $wgOut;

	  if ( !in_array( 'createopenserv', $wgUser->getRights() ) ) {
	    return;
	  }
	  if(!isset($this->mID) || '' == $this->mID){
	    $wgOut->addHTML("No valid request ID.");
	    return;
	  }
	  $wgOut->setPageTitle( wfMsg( 'createwikipagetitle' ) );
	  $wgOut->setRobotpolicy( 'noindex,nofollow' );
	  $wgOut->setArticleRelated( false );

	  $wgOut->addHTML("request {$this->mDomainName} ({$this->mID}) marked as \"Denied\".<br>\n");

	  $wgOut->addHTML(wfMsg( 'createwikichangecomplete' ));
	  $dbw = wfGetDB(DB_MASTER);
	  $dbw->update( '`openserving_reg`.openserv_application',
			array('application_status' => "denied"),
			array('application_id' => $this->mID));

	}

	/**
	 * @access private
	 */

	function loadRequest() {
	  global $wgUser, $wgOut;

	  if ( !in_array( 'createopenserv', $wgUser->getRights() ) ) {
	    return;
	  }
	  $dbw = wfGetDB(DB_MASTER);


	  $obj = $dbw->selectRow("`openserving_reg`.openserv_application",
				 array('application_id',
				       'application_firstname',
				       'application_lastname',
				       'application_email',
				       'application_return_url',
				       'application_ad_code_1',
				       'application_domain_request',
				       'application_category',
				       'application_subcategory',
				       'application_site_name',
				       'application_username',
				       'application_color_1',
				       'application_color_2',
				       'application_color_3',
				       'application_border_color_1'),
				 array('application_id' => $this->mID));

	  $this->mID = $obj->application_id;
	  $this->mFirstName = $obj->application_firstname;
	  $this->mLastName = $obj->application_lastname;
	  $this->mEmail = $obj->application_email;
	  $this->mReturnUrl = $obj->application_return_url;
	  $this->mAdsenseId = $obj->application_ad_code_1;
	  $this->mDomainName = $obj->application_domain_request;
	  $this->mCategory = $obj->application_category;
	  $this->mSubcategory = $obj->application_subcategory;
	  $this->mSiteName = $obj->application_site_name;
	  $this->mUsername = $obj->application_username;
	  $this->mColor1 = $obj->application_color_1;
	  $this->mColor2 = $obj->application_color_2;
	  $this->mColor3 = $obj->application_color_3;
	  $this->mBorderColor1 = $obj->application_border_color_1;

	  $wgOut->setPageTitle( wfMsg( 'createwikipagetitle' ) );
	  $wgOut->setRobotpolicy( 'noindex,nofollow' );
	  $wgOut->setArticleRelated( false );

	  return;
	}

	function getLock($numAttempts = 3){
	  return true;
	  # open a lock file
	  # if it opens , return true.
	  # if it fails, try again $numAttempts times, and return false
	  for ($i=0;$i<$numAttempts;$i++){
	    if(!file_exists("/home/wikia/conf/creation_lockfile.lock")){
	      $file = fopen("/home/wikia/conf/creation_lockfile.lock","x");
	      if($file){
		$i=$numAttempts;
		fwrite($file,"Someone has the creation script locked");
		fclose($file);
		return true;
	      }
	      else{
		sleep(1);
	      }
	    }
	    else{
	      sleep(1);
	    }
	  }
	  return false;
	}


 function releaseLock(){
   if(file_exists("/home/wikia/conf/creation_lockfile.lock")){
     unlink("/home/wikia/conf/creation_lockfile.lock");
     return true;
   }
   return false;
 }

	/**
	 * @access private
	 */
 function processCreation() {
   global $wgUser, $wgOut, $wgSharedDB;

   if (!in_array('createopenserv', $wgUser->getRights())) {
     return;
   }

   if(!$this->getLock()){
     return "couldn't get creation lock";
   }

#We gather all the info about the wiki
   $httpd_config = '/home/openserving/openserv_main.httpd.conf';
   $view_name = trim($this->mSiteName);
   $sub_domain = trim($this->mDomainName);
   $wiki_language = trim($this->mWikiLang);
   $wiki_subdomain = trim($this->mWikiName);
   $wiki_dir_part = $wiki_name;
   $dbname = $wiki_name;

   $this->mPath = $WikiCitiesDir . $wiki_name;
   $this->mImagesPath = $WikiImagesDir . $wiki_name;


   $wgOut->setPageTitle( wfMsg( 'createwikipagetitle'.$wiki_name ) );
   $wgOut->setRobotpolicy( 'noindex,nofollow' );
   $wgOut->setArticleRelated( false );

# if the view already exists (DB,path,etc.) we should abort
   if(viewExists($sub_domain)){
     return "$sub_domain already exists\n";
   }

   if(preg_match("/[^0-9a-zA-Z_\-]+/",$sub_domain)){
	return "name \"$dbname\" contains non-alphanumeric characters";
      }

      if(!is_writable($httpd_config)) {
	return "file {$httpd_config} is not writable";
      }

#We create the view
      global $wgDBname;
      $dbw = wfGetDB(DB_MASTER);
      $obj = $dbw->selectRow("`wikicities`.user",
			  array('user_id'),
			  array('user_name' => "$this->mUsername"));
      $admin_id = $obj->user_id;
      if($admin_id <= 1){
	$wgOut->addHTML("user id is '$admin_id' for $this->mUsername.  That's impossible, assigning ID of 1 (Jasonr)<br>\n");
	$admin_id = 1;
      }
      global $wgOut;
      $wgOut->addHTML("user id is '$admin_id' for $this->mUsername<br>\n");

#determine the DB for the destination site and complain if you can't
      $obj = $dbw->selectRow("`openserving_reg`.destination_list",
			  array('dest_id'),
			  array('dest_category' => "$this->mCategory"));
      $dest_id = $obj->dest_id;
      $wgOut->addHTML("processing request in '$this->mCategory' (id # $dest_id)<br>\n");
      if( "" == $dest_id ){
	$wgOut->addHTML("Failed to find DB for '$this->mCategory' in the destination list table, assuming id #1 (entertainment)<br>\n");
	$dest_id = 1;
      }

#insert the view's entry into the destination's DB
      $dbw->insert( "`openserving_reg`.openserving_sites",
		    array('admin_user_id' => $admin_id,
			  'view_destination_id' => $dest_id,
			  'view_domain_name' => "$this->mDomainName",
			  'view_adsense_id' => "$this->mAdsenseId",
			  'view_analytics_id' => "$this->mAnalyticsId",
			  'view_return_url' => "$this->mReturnUrl",
			  'view_title' => "$this->mSiteName",
			  'view_tagline' => "$this->mSiteTagline",
			  'view_template' => "$this->mTemplate",
			  'view_type' => "$this->mOpenservingType",
			  'view_color_1' => "$this->mColor1",
			  'view_color_2' => "$this->mColor2",
			  'view_color_3' => "$this->mColor3",
			  'view_border_color_1' => "$this->mBorderColor1",
			  'view_categories' => "$this->mSubcategory",));


      if(isset($this->mID) && '' != $this->mID){
	$dbw->update('`openserving_reg`.openserv_application', array('application_status' => "created"), array('application_id' => $this->mID));
      }

      rebuildApacheConfig();

      $track_error = ini_set("track_errors","on");
      $f = fopen("/home/wikia/restart_apache","w");
      if($f) {
	fwrite($f,"restart requested at $timedate");
	fclose($f);
	$wgOut->addHTML("I tried to schedule the webservers to reload...  It may be up to 5 minutes before the wiki is available.<br>\n");
      } else {
	$wgOut->addHTML("For some reason, I couldn't schedule Apache to restart.  New wikis will not work until Apache is restarted.($php_errormsg)<br>\n");
      }
      ini_set("track_errors",$track_error);

		$wgOut->addHTML(wfMsg( 'createwikicreatecomplete' ));
		$this->releaseLock();
		return;
	}

	/**
	 * @access private
	 */
	function mainCreateOpenservForm( $err ) {
		global $wgUser, $wgOut, $wgLang;
		global $wgDBname, $wgAllowRealName;

	  $dbw = wfGetDB(DB_MASTER);

 	  $obj = $dbw->selectRow("`openserving_reg`.openserv_autocreate_tool",
 				 array('tool_mailtext',
 				       'tool_status',
 				       'tool_category',
 				       'tool_limit',
 				       'tool_orderby',
				       'tool_min_id'),
 				 array());

 	  $this->mMailtext = $obj->tool_mailtext;
 	  $this->mToolStatus = $obj->tool_status;
 	  $this->mToolCategory = $obj->tool_category;
 	  $this->mToolLimit = $obj->tool_limit;
 	  $this->mToolOrderBy = $obj->tool_orderby;
 	  $this->mToolMinId = $obj->tool_min_id;


		if(!$wgUser->isAllowed('createopenserv')){
#		  $wgOut->addHTML("sorry, creation disabled for the moment<br/>");
		  $wgOut->addHTML("sorry, you only have ".implode(", ",$wgUser->getRights())." rights<br/>");
		  global $wgGroupPermissions;
		  return false;
		}
		$wgOut->setArticleBodyOnly(true);

	  $dbw = wfGetDB(DB_MASTER);

#Jason added this crazy ugly hack to the condition statement
	  $condition = array('application_category' => "$this->mToolCategory",
			     "application_id >= $this->mToolMinId AND application_status" => "$this->mToolStatus");
	  $select_options = array();

	  if("" != $this->mToolOrderBy){
	    $select_options['ORDER BY'] = "application_$this->mToolOrderBy";
	  }
	  if( $this->mToolLimit > 0 ){
	    $select_options['LIMIT'] = $this->mToolLimit;
	  }

 global $wgOut;
 $wgOut->addHTML("<script language='javascript'>function setAll(newstate,invert){");
 #This query is to build the selectall javascript
  $res = $dbw->select("`openserving_reg`.openserv_application",
		      array('application_id'),
		      $condition,
		      "MainCreateOpenserveForm",
		      $select_options);

 while($obj = $dbw->fetchObject($res)){
   $ID = $obj->application_id;
   $wgOut->addHTML("if(invert){document.forms[0].a${ID}_action[newstate].checked= !document.forms[0].a${ID}_action[newstate].checked;}");
   $wgOut->addHTML("else{document.forms[0].a${ID}_action[newstate].checked=true;}");
 }
$wgOut->addHTML("}</script>\n");
 $wgOut->addHTML("<form method=POST name=bigform>");
 $wgOut->addHTML("Show requests of status: <select name=tool_status>\n");
 $wgOut->addHTML("<option value='new' ".(("new" == $this->mToolStatus)?"SELECTED":"").">New</option>\n");
 $wgOut->addHTML("<option value='denied' ".(("denied" == $this->mToolStatus)?"SELECTED":"").">Denied</option>\n");
 $wgOut->addHTML("<option value='created' ".(("created" == $this->mToolStatus)?"SELECTED":"").">Created</option></select><br>\n");


 $wgOut->addHTML("Show requests in category: <select name=tool_category>\n");

 $res = $dbw->select("`openserving_reg`.openserv_application",
		     array('DISTINCT application_category'),
		     array(),//where clause
		     "MainOpenserveCreateForm",
		     array('ORDER BY' => 'application_category asc')
		     );
 while($obj = $dbw->fetchObject($res)){
   $mycategory = trim($obj->application_category);
   if( "" == $mycategory ){
     next;
   }
   $wgOut->addHTML("<option value='$mycategory' ".(($mycategory == $this->mToolCategory)?"SELECTED":"").">$mycategory</option>\n");
 }
 $wgOut->addHTML("</select><br>\n");

 $wgOut->addHTML("Limit # of requests to: <input type=text name=tool_limit value='$this->mToolLimit'/> 0 for no limit<br>\n");
 $wgOut->addHTML("Include requests with ID at least<input type=text name=tool_min_id value='$this->mToolMinId'/><br>\n");
 $wgOut->addHTML("<input type=checkbox name=tool_rebuildonly> Only rebuild config (for debugging)<br/>\n");
 $wgOut->addHTML("Sort requests by: <select name=tool_orderby>\n");
 foreach(array("id","subcategory","domain_request","username","return_url","email") as $sortcol){
   $wgOut->addHTML("<option value='$sortcol' ".(("$sortcol" == $this->mToolOrderBy)?"SELECTED":"").">$sortcol</option>\n");
 }
$wgOut->addHTML("</select><br>\n");

 $wgOut->addHTML("email text:<br><textarea name=emailtext rows=10 cols=80>$this->mMailtext</textarea><br>");
 $wgOut->addHTML("<input type=submit><table><tr><td><a href='#' onClick='setAll(0,false)' onDblClick='setAll(0,true)'>crt</a>/<a href='#' onClick='setAll(1,false)' onDblClick='setAll(1,true)'>def</a>/<a href='#' onClick='setAll(2,false)' onDblClick='setAll(2,true)'>del</a></td><td>id</td><td>domain</td><td>returnUrl</td><td>adsense</td><td>email</td><td>Category</td><td>subcategory</td><td>Sitename</td><td>Tagline</td><td>Template</td><td>Type</td><td>adminUser</td><td>color1</td><td>color2</td><td>color3</td><td>bordercolor</td></tr>\n");

  $res = $dbw->select("`openserving_reg`.openserv_application JOIN (select application_username as appuser,COUNT(*) as req_count from `openserving_reg`.openserv_application GROUP by application_username) as dt on openserv_application.application_username = dt.appuser",
		      array('application_id',
			    'application_firstname',
			    'application_lastname',
			    'application_email',
			    'application_return_url',
			    'application_ad_code_1',
			    'application_domain_request',
			    'application_category',
			    'application_subcategory',
			    'application_site_name',
			    'application_site_tagline',
			    'application_openserving_type',
			    'application_template',
			    'application_username',
			    'application_color_1',
			    'application_color_2',
			    'application_color_3',
			    'application_border_color_1',
			    'req_count'),
		      $condition,
		      "MainCreateOpenserveForm",
		      $select_options);

 while($obj = $dbw->fetchObject($res)){
   $ID = $obj->application_id;
#   $this->mFirstName = $obj->application_firstname;
#   $this->mLastName = $obj->application_lastname;
   $Email = $obj->application_email;
   $ReturnUrl = $obj->application_return_url;
   $AdsenseId = $obj->application_ad_code_1;
   $DomainName = $obj->application_domain_request;
   $Category = $obj->application_category;
   $Subcategory = $obj->application_subcategory;
   $SiteName = $obj->application_site_name;
   $SiteTagline = $obj->application_site_tagline;
   $Template = $obj->application_template;
   $OpenservingType = $obj->application_openserving_type;
   $Username = ucfirst($obj->application_username);
   $Color1 = $obj->application_color_1;
   $Color2 = $obj->application_color_2;
   $Color3 = $obj->application_color_3;
   $BorderColor1 = $obj->application_border_color_1;

   $reqCount = $obj->req_count;

   if($reqCount > 1){$bgcolor = "red";}
   else{$bgcolor = "white";}

   if($Color1 == ''){$Color1 = "000000";}
   if($Color2 == ''){$Color2 = "cccccc";}
   if($Color3 == ''){$Color3 = "666666";}
   if($BorderColor1 == ''){$BorderColor1 = "666666";}

   $formelid += 1;
   $wgOut->addHTML("<tr style=\"background-color: $bgcolor\"><td nowrap>
<input type=radio id='cr$formelid' name='a".$ID."_action' value='create'>
<input type=radio id='df$formelid' name='a".$ID."_action' value='defer'>
<input type=radio id='dl$formelid' name='a".$ID."_action' value='delete'></td><td>$ID</td>
<td><input type=text name='a".$ID."_application_domain_request' value='$DomainName'></td>
<td><input type=text name='a".$ID."_application_return_url' value='$ReturnUrl'></td>
<td><input type=text name='a".$ID."_application_ad_code_1' value='$AdsenseId'></td>
<td><input type=text name='a".$ID."_application_email' value='$Email'></td>
<td><input type=text name='a".$ID."_application_category' value='$Category'></td>
<td><input type=text name='a".$ID."_application_subcategory' value='$Subcategory'></td>
<td><input type=text name='a".$ID."_application_site_name' value='$SiteName'></td>
<td><input type=text name='a".$ID."_application_site_tagline' value='$SiteTagline'></td>
<td><input type=text name='a".$ID."_application_template' value='$Template'></td>
<td><input type=text name='a".$ID."_application_openserving_type' value='$OpenservingType'></td>
<td><input type=text name='a".$ID."_application_username' value='$Username'></td>
<td><input type=text name='a".$ID."_application_color_1' value='$Color1'></td>
<td><input type=text name='a".$ID."_application_color_2' value='$Color2'></td>
<td><input type=text name='a".$ID."_application_color_3' value='$Color3'></td>
<td><input type=text name='a".$ID."_application_border_color_1' value='$BorderColor1'></td></tr>\n");
 }
 $wgOut->addHTML("<Table>\n");

 $wgOut->addHTML("<input type=submit></form>\n");
		}


	/**
	 * @access private
	 */
	function setupMessages() {
	  global $wgMessageCache;
	  $wgMessageCache->addMessages( array('createwiki' => 'Create a new Openserving view',
					      'createwikipagetitle' => 'create openserving views in bulk',
					      'createwikilogin' => 'Please <a href="/index.php?title=Special:Userlogin&returnto=Special:CreateOpenserv" class="internal" title="create an account or log in">create an account or log in</a> before requesting a wiki.',
					      'createwikistafftext' => 'You are staff, so you can create a new openserving view using this page',
					      'createwikitext' => 'You can request a new wiki be created on this page.  Just fill out the form',
					      'createwikititle' => 'Title for the wiki',
					      'createwikiname' => 'Name for the wiki',
					      'createwikinamevstitle' => 'The name for the wiki differs from the title of the wiki in that the name is what will be used to determine the default url.  For instance, a name of "starwars" would be accessible as http://starwars.wikia.com/. The title of the wiki may contain spaces, the name should only contain letters and numbers.',
					      'createwikidesc' => 'Description of the wiki',
					      'createwikiaddtnl' => 'Additional Information',
					      'createwikimailsub' => 'Wikia request',
					      'requestcreatewiki' => 'Request Wiki',
					      'createwikisubmitcomplete' => 'Your submission is complete.  If you gave an email address, you will be contacted regarding the new Wiki.  Thank you for using {{SITENAME}}.',
					      'createwikicreatecomplete' => 'Your wiki creation is complete.  ',
					      'createwikichangecomplete' => 'Your changes have been saved.',
					      'createwikilang' => 'Default language for this wiki',
					      ) );
	}


	function hasSessionCookie() {
	  global $wgDisableCookieCheck;
	  return ( $wgDisableCookieCheck ) ? true : ( '' != $_COOKIE[session_name()] );
	}

	/**
	 * @access private
	 */
	function cookieRedirectCheck( $type ) {
		global $wgOut, $wgLang;

		$titleObj = Title::makeTitle( NS_SPECIAL, 'Userlogin' );
		$check = $titleObj->getFullURL( 'wpCookieCheck='.$type );

		return $wgOut->redirect( $check );
	}

	/**
	 * @access private
	 */
	function onCookieRedirectCheck( $type ) {
		global $wgUser;

		if ( !$this->hasSessionCookie() ) {
			if ( $type == 'new' ) {
				return $this->mainLoginForm( wfMsg( 'nocookiesnew' ) );
			} else if ( $type == 'login' ) {
				return $this->mainLoginForm( wfMsg( 'nocookieslogin' ) );
			} else {
				# shouldn't happen
				return $this->mainLoginForm( wfMsg( 'error' ) );
			}
		} else {
			return $this->successfulLogin( wfMsg( 'loginsuccess', $wgUser->getName() ) );
		}
	}

	/**
	 * @access private
	 */
	function throttleHit( $limit ) {
		global $wgOut;

		$wgOut->addWikiText( wfMsg( 'acct_creation_throttle_hit', $limit ) );
	}
}
 function rebuildApacheConfig() {
   #get destination list
   $dbw = wfGetDB(DB_MASTER);
   $res = $dbw->select("`openserving_reg`.destination_list",
		       array('dest_id',
			     'dest_dbname',
			     'dest_path',
			     'dest_url',
			     'dest_extra_aliases',
			     'dest_extra_config'
			     ),
		       array('dest_state' => "active"));
   $apache_config = "# vim: syn=apache sts=4 sw=4 autoindent

#THIS FILE IS AUTOGENERATED!!!  Any changes WILL be lost

ServerAdmin technical@wikia.com
RewriteEngine On
RewriteMap ampescape int:ampescape
RewriteRule ^/wiki/(.*) /index.php?title=\${ampescape:\$1} [L,QSA]
<Directory \"/home/openserving/conf/docroots\">
    Options ExecCGI FollowSymLinks
    AllowOverride AuthConfig Options
    DirectoryIndex index.html index.php index.pl
</Directory>

<Directory \"/usr/openserving/docroots\">
	Options ExecCGI FollowSymLinks
	AllowOverride AuthConfig Options
	DirectoryIndex index.html index.php index.pl
</Directory>

";
   while($obj = $dbw->fetchObject( $res )){
     preg_match('/[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-]+/',$obj->dest_url,$matches);
     $host = $matches[0];
     $dbname = trim($obj->dest_dbname);
     $extra_config = $obj->dest_extra_config;
     $extra_aliases = $obj->dest_extra_aliases;
     $dest_id = $obj->dest_id;
     $apache_vhost = "<VirtualHost *:80>\n";
     $apache_vhost .= "\tDocumentRoot $obj->dest_path\n";
     $apache_vhost .= "\tServerName $host\n";
     $apache_vhost .= "\tRewriteEngine On\n";
     $apache_vhost .= "\tRewriteMap ampescape int:ampescape\n";
     $apache_vhost .= "\tRewriteRule ^/wiki/(.*) /index.php?title=\${ampescape:\$1} [L,QSA]\n";
     $dbw2 = wfGetDB(DB_MASTER);
     $res2 = $dbw2->select("`openserving_reg`.openserving_sites",
			   array('view_domain_name'),
			   array('view_destination_id' => "$dest_id") );
     $aliases = array();
     $aliases[] = "www.$host";
     $aliases[] = "$extra_aliases";
     if($dbw2->numRows($res2) >= 1){
       while($obj = $dbw->fetchObject( $res2 )){
	 $aliases[] = " {$obj->view_domain_name}.openserving.com";
       }
     }
     while( count($aliases) >= 1){
       $aliasbits = array_splice(&$aliases,0,200);
       $aliasbitstring = implode(" ",$aliasbits);
       $apache_config .= "$apache_vhost\n";
       $apache_config .= "\tServerAlias $aliasbitstring\n";
       $apache_config .= "\t$extra_config\n";
       $apache_config .= "</VirtualHost>\n\n";
     }

   }

   $file = fopen("/home/openserving/openserv_main.httpd.conf","w");
   if($file){
     fwrite($file,"$apache_config");
     fclose($file);
   }
 }

 function viewExists( $domain_name ){
   #for each destination
   #get the subdomains list for the views into that destination
   #return true if that domain is already used.
   $dbw = wfGetDB(DB_MASTER);
   $res = $dbw->select("`openserving_reg`.destination_list",
		       array('dest_dbname'),
		       array('dest_state' => "active"));

   while($obj = $dbw->fetchObject( $res )){
     $dbname = $obj->dest_dbname;
     $dbw2 = wfGetDB(DB_MASTER);
     $res2 = $dbw2->select("`$dbname`.site_view",
			   array('view_domain_name'),
			   array('view_domain_name' => "$domain_name"));
     $numresults = $dbw2->numRows($res2);
     if($numresults >= 1){
       global $wgOut;
       $wgOut->addHTML("returning as if the $domain_name view already exists in $dbname ($numresults)<br>");
       return true;
     }
   }
   return false;
 }

SpecialPage::addPage( new CreateOpenservForm );
global $wgMessageCache;
$wgMessageCache->addMessage( 'createopenserv', 'Create a new interactive blog' );
}
?>

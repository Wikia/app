<?php

/* Parse CSV file with advertising configuration
   By Tristan Harris
   Copyright Wikia, Inc. 2006
*/

require_once("AdServer.php"); 

global $wgHooks;

$wgHooks['UnknownAction'][] = 'adConfig';
$wgHooks['UnknownAction'][] = 'adUpload';
$wgHooks['UnknownAction'][] = 'adDoUpload';
$wgHooks['UnknownAction'][] = 'adConfDisplay';

function adConfig($action, $article)
{
    if($action != 'adConfig') return true;

    global $wgRequest, $wgTitle, $wgOut;
    
    $wgOut->setPageTitle("Upload Advertising Configuration");
    $wgOut->setHTMLTitle("Upload Advertising Configuration");
    
    $formAction = $wgTitle->escapeLocalURL("action=adUpload");
    $text = "<form enctype='multipart/form-data' action='$formAction' method='POST'>".
    "<input type='hidden' name='MAX_FILE_SIZE' value='1000000'/>
Upload an Advertising Configuration CSV file: <br><input name='uploadedfile' type='file'/><input type='submit' value='Upload File'/>
</form>";
    $wgOut->addHTML( $text );
    
    return false;
}

function adUpload($action, $article)
{
    if ($action != 'adUpload') return true;

    // Where the file is going to be placed 
    global $wgUploadDirectory;
    $target_path = "$wgUploadDirectory/";
    
    /* Add the original filename to our target path.  
    Result is "uploads/filename.extension" */
    $target_path = $target_path . "adConfig.csv";  
    
    global $wgRequest, $wgTitle, $wgOut;
    
    $wgOut->setPageTitle("Upload results");
    $wgOut->setHTMLTitle("Upload results");

    if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
        $wgOut->addHTML( "The file ".  basename( $_FILES['uploadedfile']['name']) . " has been uploaded");
    } else{
        $wgOut->addHTML("There was an error uploading the file, please try again!");
    }
    
    // don't commit to DB, just prompt for errors
    loadAdConfiguration(false);
}

function adConfDisplay($action, $article) 
{
    if ($action != 'adConfDisplay') return true;

    global $wgRequest, $wgTitle, $wgOut;

    $wgOut->setPageTitle("Display Ad Configuration");
    $wgOut->setHTMLTitle("Display Ad Configuration");

    $db =& wfGetDB(DB_MASTER);
    $cityRes = $db->query("SELECT city_id, city_lang, city_url FROM ".
                  " `wikicities`.`city_list`");
    
    $save_path = "/home/wikia/work-http";
    $temp = 'adConfig.tmp'; # define temporary target name
    $dest = 'adConfig.csv'; # define final target path
    $text = ''; 
     
    while (($oCity = $db->fetchObject($cityRes))) {
      $domain = $oCity->city_url;
      /*if ( preg_match("/^http\:\/\/(.*)\.(wikia|wikicities).com\//i", $oCity->city_url, $m ) )
	    $domain = $m[1];
*/

      $adRes = $db->query("SELECT city_id, domain, ad_zone, ad_pos, ad_keywords, ad_lang, ad_skin FROM ".
            " `wikicities`.`city_ads` WHERE city_id=$oCity->city_id");
      
      $lastDomain = '';
      $accumFields = '';
      $lastLang = '';
      $lastKeywords = '';
      $resetFields = false;
      $atLeastOneAd = false;
      while (($oAd=$db->fetchObject($adRes))) 
      {    
            #echo "<p>Found ad for domain $domain, zone=$oAd->ad_zone, pos=$oAd->ad_pos, kw=$oAd->ad_keywords</p>";
            if ( $oAd && !$oAd->domain ) #|| ! $adName )
                continue;
                
            $accumFields = $accumFields . ADSERVER_ZONE_EXPR . "={$oAd->ad_zone}," . ADSERVER_POS_EXPR . "={$oAd->ad_pos},";
            
            $lastDomain = $oAd->domain;
            $lastLang = $oAd->ad_lang;
            $lastKeywords = $oAd->keywords;
            $atLeastOneAd = true;
      }
    
      if ( $lastLang == '' )
        $lastLang = "" . ADSERVER_LANG_DEFAULT;
    
      if ( $atLeastOneAd ) {
        $text = $text. "$lastDomain,[$lastLang],$accumFields$lastKeywords\n";
      }
      else if ( $domain ) {
        $db->insert("`wikicities`.`city_ads`",
              array('city_id' => $oCity->city_id,
                    'ad_zone' => ADSERVER_ZONE_DEFAULT,
                    'ad_pos' => ADSERVER_POS_TOPRIGHT,
                    'domain' => $domain,
                    'ad_keywords' => "",
                    'ad_lang' => $oCity->city_lang));
	$db->insert("`wikicities`.`city_ads`",
              array('city_id' => $oCity->city_id,
                    'ad_zone' => ADSERVER_ZONE_ANALYTICS,
                    'ad_pos' => ADSERVER_POS_JS_BOT1,
                    'domain' => $domain,
                    'ad_keywords' => "",
                    'ad_lang' => $oCity->city_lang));
                    
        $text = $text. "$domain,[".$oCity->city_lang."],zone=".ADSERVER_ZONE_DEFAULT.",pos=tr, zone=".ADSERVER_ZONE_ANALYTICS.",pos=js_bot1 \n";
      }
    }
    
    $fp = fopen($save_path . "/" . $temp, "w", 0); # open for writing
    fputs($fp, $text);
    fclose($fp);

    #rename temp file to final position
    rename($save_path . "/" . $temp, $save_path . "/" . $dest);
    
    # write out link for user to download the ad configuration CSV file
    #$wgOut->addHTML($text);
    $wgOut->addHTML("Generated the ad configuration file.<br><a href='http://www.wikia.com/$dest'>Click here to download</a>");
}

function adCodeForString($str) {
    if ( $str == 'google' ) return ADSERVER_GOOGLE;
     else if ( $str == 'yahoo' ) return ADSERVER_YAHOO;
     else if ( $str == 'ebay' ) return ADSERVER_EBAY;
     
    return '';
}

function stringForAdCode($code) {
    if ( $code == ADSERVER_GOOGLE ) return "google";
    else if ( $code == ADSERVER_YAHOO ) return "yahoo";
    else if ( $code == ADSERVER_EBAY ) return "ebay";
}

function processAdFields($db, $domainName, $adLang, $adKeywords, $fields, $row,  $commitToDB)
{
  global $wgOut;

    if ( strlen($domainName) > ADSERVER_DOMAIN_MAXLEN ) {
        $wgOut->addHTML("<p>Domain name beyond max length allowed " . ADSERVER_DOMAIN_MAXLEN . " on line $row</p>");
        return false;
    }

    $domainURL = $domainName; 
    //"http://$domainName.wikia.com/";
    $res = $db->query(  "SELECT city_id, city_dbname, city_url FROM ".
                        " `wikicities`.`city_list`".
                        " WHERE city_url='$domainURL';");
                
    $cityID = 0;
    if (($o = $db->fetchObject($res)))
        $cityID = $o->city_id;

    if ( $cityID == 0 ) {
        $wgOut->addHTML("<p>Domain URL for community $domainURL did not match in city_list on line $row.  Are you sure this community exists?</p>");
        return false;
    }

    $numAds = count($fields);

    for ( $i = 0; $i < $numAds; $i++ )
    {
        $zoneCode = $fields[$i][ADSERVER_ZONE_EXPR];
        $posCode = $fields[$i][ADSERVER_POS_EXPR];

        if (strlen($zoneCode) > ADSERVER_ZONE_SIGFIGS_LIMIT) 
        {
            $wgOut->addHTML("<p>Zone code beyond maximum allowed significant digits " . ADSERVER_ZONE_SIGFIGS_LIMIT . " on line $row</p>");
            return false;
        }
        
        $zoneCode = (int) $zoneCode;
        if ($zoneCode > ADSERVER_ZONE_LIMIT ) {
            $wgOut->addHTML("<p>Zone code outside limit ". ADSERVER_ZONE_LIMIT . " for community $domainURL on line $row</p>");
            return false;
        }

	    
        if ( strlen($domainName) > 0 )
        {
	   if ( $commitToDB )
            {         
	     # if ( $domainName == 'jasontest30' ) {
	    #$wgOut->addHTML("<p>For jasontest30, inserting zone $zoneCode and pos $posCode</p>");
#	}

	      $db->insert("`wikicities`.`city_ads`", 
                    array('city_id' => $cityID,
                          'domain' => $domainName,
                          'ad_zone' => $zoneCode,
                          'ad_pos' => $posCode,
                          'ad_keywords' => $adKeywords,
                          'ad_lang' => $adLang));
            }
        }
        else {
            $wgOut->addHTML("<p>Couldn't find Wikia community $domainURL in city_list DB on line $row, skipping ad config for this community.  If this community is new, try setting up this community again.</p>");
            #$errors++;
            return false;
        }
    }
    
    return true;
}

function processAdConfiguration($fpath, $commitToDB)
{
    global $wgUploadDirectory;
    global $wgOut;

    if ( $commitToDB ) {
        $db =& wfGetDB(DB_MASTER);
        $db->begin();
    
        # clear the city ads DB
        $db->delete("`wikicities`.`city_ads`", "*");
    }
    else $db =& wfGetDB(DB_SLAVE);

    $row = 0;
    $rowsAffected = 0;
    $errors = 0;
    $numlines = count(file($fpath));
    $maxErrorsAllowed = (1/2) * $numlines; # disallow errors more than  1/2 the number of lines in the file

    $handle = fopen($fpath, "r");
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
    {
       $num = count($data);
       $row++;
        
       $domainName = '';
       $adLang = '';
       if ( $num > 2 ) {
          $domainName = strtolower($data[0]);
          $adLang = strtolower($data[1]);
          if ( strlen($adLang) >= 4 ) {
            $adLang = substr($adLang,1,2); // take [XX] chars
          }
          else {
            $wgOut->addHTML("<p>Error: Line $row had an invalid language code \"$adLang\", skipping this community!</p>");
            $errors++;
            continue;
          }
       }
       else {
          $wgOut->addHTML("<p>Error: Line $row didn't have enough fields, skipping line.</p>");
          $errors++;
          continue;
       }     
       
       $adKeywords = $data[$num-1];
         
        // TAH: $num % 2 used to be == 1 before we added [langCode] field
       if ( $num % 2 == 0 ) 
       { 
          $wgOut->addHTML("<p>Error: Uneven number of ad_zone / ad_pos pairs on line $row.  It's possible there is a comma missing on this line. Skipping this community...</p>");
          $errors++;
          continue;
       }
       else 
       {
          $fields = array();
          $errorInField = false;
          for ( $i = 2; $i < $num-1; $i += 2 )
          {
             $zonePieces = explode('=', strtolower($data[$i]));
             $posPieces = explode('=', strtolower($data[$i+1]));
             
             $posID = '';
             $zoneID = '';

             if ( $zonePieces[0] == 'zone' && count($zonePieces)==2) {
                $zoneID = $zonePieces[1];
             }
             if ( $posPieces[0] == 'pos' && count($posPieces)==2) {
                $posID = $posPieces[1];
             }
             
             if ( !$zoneID || ! isValidAdPos($posID)  )
             {
                $wgOut->addHTML("<p>Invalid zone $zoneID and/or pos identifier $posID for domain $domainName on line $row.</p>");
                $errorInField = true;
                break;
             }
          
             # Add this ad combination to the  configuration
             $fields[] = array(ADSERVER_ZONE_EXPR => $zoneID, ADSERVER_POS_EXPR => $posID);         
          }
        
          if ( $errorInField ) {
            $errors++;
            continue;
          }
       
          if ( ! processAdFields($db, $domainName, $adLang, $adKeywords, $fields, $row, $commitToDB) )
          {
            $errors++;
            continue;
          }
          else $rowsAffected++;
       }

       if ( $errors > $maxErrorsAllowed ) {
         $wgOut->addHTML("<p>Aborting loadAdConfiguration, too many errors encountered!</p>");
         break;
       }
    }

    /*
    if ( $commitToDB ) 
    {
        if ( $rowsAffected > 0 && $errors < $maxErrorsAllowed ) {
          $wgOut->addHTML("<p><b>Committing changes to database! num errors: $errors, rows affected: $rowsAffected, max errors allowed: $maxErrorsAllowed</b></p>");
          $db->commit();
        }
        else {
          $wgOut->addHTML("<p><b>Too many errors $errors, rolling back database to previous state!</b></p>");
          $db->rollback();
        }
	}*/
    fclose($handle);
    
    return array('errors' => $errors, 'rowsAffected' => $rowsAffected, 'db' => $db);
}

function loadAdConfiguration($commitToDB)
{
    global $wgUploadDirectory;
    global $wgOut;
    global $wgTitle;

    $fpath = "$wgUploadDirectory/adConfig.csv";
    $numlines = count(file($fpath));
    $maxErrorsAllowed = (1/4) * $numlines; # disallow errors more than  1/4 the number of lines in the file

    $results = processAdConfiguration($fpath, $commitToDB);
    $errors = $results['errors'];
    $rowsAffected = $results['rowsAffected'];
    
    $wgOut->addHTML("<p>There were $errors errors and out of $numlines lines, meaning this many Wikia communities will not be added/changed/removed.  Keep in mind that uploading this ad configuration completely replaces the existing ad configuration database.</p>");
    
    if ( ! $commitToDB )
    {
        $formAction = $wgTitle->escapeLocalURL("action=adDoUpload");

        $wgOut->addHTML(
            "<form action='$formAction' method='POST'>
                <b>Are you sure you want to upload the file?</b>  
                <input type='submit' id='cancel' value='Cancel'/>
                <input type='submit' id='upload' value='Upload'/>
            </form>");
    }
            
    if ( $commitToDB && $rowsAffected > 0 && $errors < $maxErrorsAllowed ) {
      $wgOut->addHTML("<p><b>Committing changes to database! num errors: $errors, rows affected: $rowsAffected, max errors allowed: $maxErrorsAllowed</b></p>");
      
      $db = $results['db'];
      $db->commit();
    }
}

function adDoUpload($action, $article) 
{
    if ($action != 'adDoUpload') return true;
    
    global $wgOut;

    if ( isset($_POST["cancel"]) )
        $wgOut->addHTML("<p>You clicked Cancel...</p>");
    
    if ( isset($_POST["upload"]) )
        $wgOut->addHTML("<p>You clicked Upload...</p>");

    loadAdConfiguration(true);
}

?>
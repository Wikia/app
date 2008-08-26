<?

//REV 3.3 [ 29-12-2006 ]
//CSV VERSION
/////////////////////////////////////////////////////////////////////////////////////////
//                                                                                     //
//                                                                                     //
//                                                                                     //
//                        YAHOO CONTACT IMPORTING SCRIPT                               //
//                             COPYRIGHT RESERVED                                      //
//                                                                                     //
//            You may not distribute this software without prior permission            //
//                                                                                     //
//                                                                                     //
//                           WWW.GETMYCONTACTS.COM                                     //
//                                                                                     //
/////////////////////////////////////////////////////////////////////////////////////////

//******************************* | SETTING VARIABLES | ***********************************\\


$username = $_POST["username"];

$password = $_POST["password"];

$refering_site = "http://yahoo.com/"; //setting the site for refer

$browser_agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)"; //setting browser type

$path_to_cookie = realpath('yahoocookie.txt');


				$setcookie = fopen($path_to_cookie, 'wb'); //this opens the file and resets it to zero length
				fclose($setcookie);

$form_language = $_REQUEST['language'];

include_once ( dirname( __FILE__ ) . '/getmycontactsbase.php' );


function curl_get($url,$follow, $debug){
global $path_to_cookie, $browser_agent;
$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);              
curl_setopt($ch,CURLOPT_COOKIEJAR,$path_to_cookie);
curl_setopt($ch,CURLOPT_COOKIEFILE,$path_to_cookie);
curl_setopt($ch,CURLOPT_FOLLOWLOCATION,$follow);
curl_setopt($ch,CURLOPT_USERAGENT, $browser_agent);
$result=curl_exec($ch);
curl_close($ch);

if($debug==1){
echo "<textarea rows=30 cols=120>".$result."</textarea>";       
}
if($debug==2){
echo "<textarea rows=30 cols=120>".$result."</textarea>";       
echo $result;
}
return $result;
}

function curl_post($url,$postal_data,$follow, $debug){
global $path_to_cookie, $browser_agent;
$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_POST, 1); 
curl_setopt($ch, CURLOPT_POSTFIELDS,$postal_data);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);              
curl_setopt($ch,CURLOPT_COOKIEJAR,$path_to_cookie);
curl_setopt($ch,CURLOPT_COOKIEFILE,$path_to_cookie);
curl_setopt($ch,CURLOPT_FOLLOWLOCATION,$follow);
curl_setopt($ch,CURLOPT_USERAGENT, $browser_agent);
$result=curl_exec($ch);
curl_close($ch);

if($debug==1){
echo "<textarea rows=30 cols=120>".$result."</textarea>";       
}
if($debug==2){
echo "<textarea rows=30 cols=120>".$result."</textarea>";       
echo $result;
}
return $result;
}


//---------------------------------------------------STEP 1

$url = "https://login.yahoo.com/config/mail?.intl=us";
$page_result =curl_get($url,1,0);
preg_match_all("/name=\".tries\" value=\"(.*?)\"/", $page_result, $tries); 
$tries_found = $tries[1][0];                 
preg_match_all("/name=\".src\" value=\"(.*?)\"/", $page_result, $src); 
$src_found = $src[1][0];                 
preg_match_all("/name=\".u\" value=\"(.*?)\"/", $page_result, $u); 
$u_found = $u[1][0];                 
preg_match_all("/name=\".v\" value=\"(.*?)\"/", $page_result, $v); 
$v_found = $v[1][0];                 
preg_match_all("/name=\".challenge\" value=\"(.*?)\"/", $page_result, $challenge); 
$challenge_found = $challenge[1][0];

//---------------------------------------------------STEP 2 - submit login info

$postal_data ='.tries='.$tries_found.'&.src='.$src_found.'&.md5=&.hash=&.js=&.last=&promo=&.intl=us&.bypass=&.partner=&.u=6bu841h2d7p4o&.v=0&.challenge='.$challenge_found.'&.yplus=&.emailCode=&pkg=&stepid=&.ev=&hasMsgr=1&.chkP=Y&.done=http://mail.yahoo.com&.pd=ym_ver%253d0&login='.$username.'&passwd='.$password;
$url = 'https://login.yahoo.com/config/login?';
$result =curl_post($url,$postal_data,1,0);
preg_match_all("/replace\(\"(.*?)\"/", $result, $matches);	
$matches = $matches[1][0];
	
//---------------------------------------------------STEP 3 - Redirect

$url = $matches;
$result =curl_get($url,1,0);

//---------------------------------------------------STEP 4 - Redirect

$url = 'http://us.rd.yahoo.com/mail_us/pimnav/ab/*http://address.mail.yahoo.com';
$result =curl_get($url,1,0);

//---------------------------------------------------STEP 5 - Open address book

$url = 'http://address.mail.yahoo.com';
$result =curl_get($url,1,0);
preg_match_all("/rand=(.*?)\"/", $result, $array_names);	
$rand_value = str_replace('"', '', $array_names[0][0]);

//---------------------------------------------------STEP 6 - Export address book

$url = 'http://address.mail.yahoo.com/?1&VPC=import_export&A=B&.rand='.$randURL;
$result =curl_get($url,1,0);
preg_match_all("/id=\"crumb1\" value=\"(.*?)\"/", $result, $array_names);	
$crumb = $array_names[1][0];

//---------------------------------------------------STEP 7 - Checking if address book is empty

IF (empty($crumb)){
echo '<p align="center"><font face="Verdana" size="2"><b>'.$messages['no_details_found'].':</b> '.$messages['makesurecorrectlogin'].'.</font></p><p align="center">';
}ELSE{




//---------------------------------------------------STEP 8 - submit login info

$postal_data ='.crumb='.$crumb.'&VPC=import_export&A=B&submit%5Baction_export_yahoo%5D=Export+Now';
$url = 'http://address.mail.yahoo.com/index.php';
$result =curl_post($url,$postal_data,1,0);


//---------------------------------------------------STEP 9 - Start of results

//WRITING OUTPUT TO CSV FILE
				
				$myFile = $username;
				$fh = fopen($myFile, 'w') or die("can't open file");
				fwrite($fh, $result);
				fclose($fh);

// [header section - html]

$header = <<<headertext

<html>
<head>
<title>{$messages['my_contacts']}</title>
<script type="text/javascript"><!--

var formblock;
var forminputs;

function prepare() {
formblock= document.getElementById('form_id');
forminputs = formblock.getElementsByTagName('input');
}

function select_all(name, value) {
for (i = 0; i < forminputs.length; i++) {
// regex here to check name attribute
var regex = new RegExp(name, "i");
if (regex.test(forminputs[i].getAttribute('name'))) {
if (value == '1') {
forminputs[i].checked = true;
} else {
forminputs[i].checked = false;
}
}
}
}

if (window.addEventListener) {
window.addEventListener("load", prepare, false);
} else if (window.attachEvent) {
window.attachEvent("onload", prepare)
} else if (document.getElementById) {
window.onload = prepare;
}

//--></script>
</head>
<body>

headertext;


echo '<form id="form_id" name="myform" method="post" action="">';

	echo '<h1>Your contacts</h1>
		<p class="contacts-message">
			<span class="profile-on">'.$messages['sharewikiafriends'].'.</span>
		</p>
		<p class="contacts-message">
			<input type="submit" class="invite-form-button" value="'.$messages['inviteyourfriends'].'" name="B1" /> <a href="javascript:toggleChecked()">'.$messages['uncheckall'].'</a>
		</p>
			<div class="contacts-title-row">
				<p class="contacts-checkbox"></p>
				<p class="contacts-title">
					'.$messages['friendname'].'
				</p>
				<p class="contacts-title">
					'.$messages['emailtitle'].'
					</p>
					<div class="cleared"></div>
			</div>
			<div class="contacts">';
 
// [RESULTS - START OF FORM]


//OPEING CSV FILE FOR PROCESSING

				$fp = fopen ($username,"r");
				while (!feof($fp)){
					$data = fgetcsv ($fp, 4100, ","); //this uses the fgetcsv function to store the quote info in the array $data
					$dataname = $data[0];

					if (empty($dataname))$dataname = $data[2];                 
					if (empty($dataname))$dataname = $data[3];          
					
					$email = $data[4];
					if(!$dataname)$dataname=$email;
					
					if (!empty($email) && $dataname!="First"){  //Skip table if email is blank
						$addresses[] = array("name"=>$dataname,"email"=>$email);
					}
				}
				if($addresses){
					usort($addresses, 'sortContacts');
					foreach ($addresses as $address){
						echo '<div class="contacts-row">
							<p class="contacts-checkbox">
								<input type="checkbox" name="list[]" value="'.$address["email"].'" checked>
							</p>
							<p class="contacts-cell">
								'.$address["name"].'
							</p>
							<p class="contacts-cell">
								'.$address["email"].'
							</p>
							<input type="hidden" name="sendersemail" size="20" value="'.$username.'">
							<div class="cleared"></div>
						</div>';
					}
				}
				
				
				

	echo '</table></center></div>';

$footer = <<<footertext

<p>
<input type="submit" class="invite-form-button" value="{$messages['inviteyourfriends']}" name="B1" /> <a href="javascript:toggleChecked()">{$messages['uncheckall']}</a>
</p>
</form>

footertext;

	echo $footer;


				unlink($username); //deleting csv file

				}
				
function sortContacts($x, $y){
	if ( strtoupper($x["name"]) == strtoupper($y["name"]) )
	 return 0;
	else if ( strtoupper($x["name"]) < strtoupper($y["name"]) )
	 return -1;
	else
	 return 1;
}


?>

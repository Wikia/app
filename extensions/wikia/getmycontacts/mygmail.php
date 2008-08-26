<?

/////////////////////////////////////////////////////////////////////////////////////////
//                                                                                     //
//                                                                                     //
//                                                                                     //
//                        GMAIL CONTACT IMPORTING SCRIPT                               //
//                             COPYRIGHT RESERVED                                      //
//                                                                                     //
//            You may not distribute this software without prior permission            //
//                                                                                     //
//                                                                                     //
//                           WWW.GETMYCONTACTS.COM                                     //
//                                                                                     //
/////////////////////////////////////////////////////////////////////////////////////////


$username = $_POST["username"];

$password = $_POST["password"];

$refering_site = "http://mail.google.com/mail/"; //setting the site for refer

$browser_agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7"; //setting browser type


$path_to_username = "/tmp/".substr(sha1($username),0,10);
$path_to_cookie = $path_to_username.".cookie";

$form_language = $_REQUEST['language'];

include_once ( dirname( __FILE__ ) . '/getmycontactsbase.php' );

$setcookie = fopen($path_to_cookie, 'wb'); //this opens the file and resets it to zero length
fclose($setcookie);

echo '<body background="loading.gif">';

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

$url = "http://mail.google.com/mail/";
$page_result =curl_get($url,1,0);


//---------------------------------------------------STEP 2

$postal_data ="ltmpl=yj_blanco&ltmplcache=2&continue=http%3A%2F%2Fmail.google.com%2Fmail%3F&service=mail&rm=false&ltmpl=yj_blanco&Email=".$username."&Passwd=".$password."&rmShown=1&null=Sign+in";
$url = 'https://www.google.com/accounts/ServiceLoginAuth';
$result =curl_post($url,$postal_data,1,0);
// [pick up forwarding url]
preg_match_all("/location.replace.\"(.*?)\"/", $result, $matches);
$matches = $matches[1][0];

//---------------------------------------------------STEP 3

$url = $matches;
$result =curl_get($url,1,0);


//---------------------------------------------------STEP 4 - html only

$url = 'http://mail.google.com/mail/?ui=html&zy=n';
$result =curl_get($url,1,0);
preg_match_all('/base href="(.*?)"/', $result, $matches);
if (!empty($matches) && is_array($matches)) {
	if (is_array($matches[1]))
		$matches = $matches[1][0];
}


//---------------------------------------------------STEP 5 - open export contacts page

$url = 'https://mail.google.com/mail/?ik=&view=sec&zx=';
$result =curl_get($url,1,0);

preg_match_all("/value=\"(.*?)\"/", $result, $matches);
$matches = $matches[1][0];


//---------------------------------------------------STEP 6 - download csv

$postal_data ='at='.$matches.'&ecf=o&ac=Export Contacts';
$url = 'https://mail.google.com/mail/?view=fec';

$result = (curl_post($url,$postal_data,1,0));

				IF (empty($result)){

echo '<p align="center"><font face="Verdana" size="2"><b>'.$messages['no_details_found'].':</b> '.$messages['makesurecorrectlogin'].'</font></p><p align="center">';

				}ELSE{
//WRITING OUTPUT TO CSV FILE

				$myFile = $path_to_username;
				$fh = fopen($myFile, 'w') or die("{$myFile} can't open file");
				//echo $result;
				//echo '*******';
				fwrite($fh, $result);
				fclose($fh);

//*********************** | START OF HTML | ***********************************\\

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

//echo $header;

// [RESULTS -TITLE HTML]

$title = <<<titletext

titletext;

	echo $title;

// [RESULTS - START OF FORM]



	echo '<form id="form_id" name="myform" method="post" action="">';

	echo '<h1>Your contacts</h1>
		<p class="contacts-message">
			<span class="profile-on">'.$messages['sharewikiafriends'].'</span>
		</p>
		<p class="contacts-message">
			<input type="submit" value="'.$messages['inviteyourfriends'].'" name="B1" /> <a href="javascript:toggleChecked()">'.$messages['uncheckall'].'</a>
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

			//OPEING CSV FILE FOR PROCESSING
				$fp = fopen ($path_to_username,"r");
				while (!feof($fp)){
					$data = fgetcsv ($fp, 0, ","); //this uses the fgetcsv function to store the quote info in the array $data
					$email = $dataname = "";
					if (!empty($data) && !empty($data[0]))
						$dataname = $data[0];
					if (!empty($data) && !empty($data[1]))
						$email = $data[1];
					if (!$dataname){
						$dataname = $email;
					}
					if (!empty($email) && $dataname!="Name"){  //Skip table if email is blank
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

	echo '</div>';

$footer = <<<footertext

<p>
<input type="submit" value="{$messages['inviteyourfriends']}" name="B1" /> <a href="javascript:toggleChecked()">{$messages['uncheckall']}</a>
</p>
</form>

footertext;

	echo $footer;


				unlink($path_to_username); //deleting csv file

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

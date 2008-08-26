<?

//CSV VERSION

/////////////////////////////////////////////////////////////////////////////////////////
//                                                                                     //
//                                                                                     //
//                                                                                     //
//                        MAIL.COM CONTACT IMPORTING SCRIPT                            //
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

$path_to_cookie = realpath('mailcookie.txt');


				$setcookie = fopen($path_to_cookie, 'wb'); //this opens the file and resets it to zero length
				fclose($setcookie);


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

$url = "http://www.mail.com/scripts/common/index.main?signin=1&lang=us";
$page_result =curl_get($url,1,0);
preg_match_all("/name=\"u\" value=\"(.*?)\"/", $page_result, $matches); 
$u = $matches[1][0];
preg_match_all("/name=\"v\" value=\"(.*?)\"/", $page_result, $matches); 
$v = $matches[1][0];

//---------------------------------------------------STEP 2

$postal_data='show_frame=Enter&action=login&mail_language=us&u='.$u.'v='.$v.'&longlogin=1&domain=mail.com&login='.$username.'&password='.$password.'&siteselected=normal';
$url = 'http://www.mail.com/scripts/common/proxy.main';
$result =curl_post($url,$postal_data,1,0);
preg_match_all("/url=(.*?)\/templates/", $result, $matches); 
$base = $matches[1][0];


//---------------------------------------------------STEP 1

$url = $base.'/scripts/addr/addressbook.cgi?showaddressbook=1';
$page_result =curl_get($url,1,0);
preg_match_all("/ob=(.*?)&gab=1/", $page_result, $matches); 
$ob = $matches[1][0];


//---------------------------------------------------STEP 1

$url = $base.'/scripts/addr/external.cgi?.ob='.$ob.'&gab=1';
$page_result =curl_get($url,1,0);


//---------------------------------------------------STEP 2

$postal_data ='showexport=showexport&action=export&format=csv';
$url = $base.'/scripts/addr/external.cgi?.ob='.$ob.'&gab=1';
$result =curl_post($url,$postal_data,1,0);




//WRITING THE RESULTS TO A CSV FILE ON THE SERVER

				$myFile = $username;
				$fh = fopen($myFile, 'w') or die("can't open file");
				fwrite($fh, $result);
				fclose($fh);


// CHECKING IF LOGIN WAS SUCCESSFUL - by search of the @ sign in the csv

				preg_match_all("/@/", $result, $array_at);	

				$at_sign = $array_at[0];

				IF (empty($at_sign)){

echo '<p align="center"><font face="Verdana" size="2"><b>No Details Found:</b> Please make sure you have entered correct login details and try again.</font></p><p align="center">';

				}ELSE{

//*********************** | START OF HTML | ***********************************\\


// [header section - html]

$header = <<<headertext

<html>
<head>
<title>CONTACTS</title>
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

	echo $header;

// [RESULTS -TITLE HTML] 

$title = <<<titletext
	
<body>
<div align="center">
<center>
<table border="0" width="578"><tr>
<TD width="622"><IMG height=2 alt="" src="images/spacer.gif" width=1 border=0></TD>
</tr><tr><TD align=middle width="622"><TABLE cellSpacing=0 cellPadding=0 width=640 border=0>
<TBODY><TR><TD width=5 height=5><IMG height=5 alt="" src="images/tls.gif" width=5 border=0></TD>
<TD background="images/t.gif" colSpan=2 width="716"><IMG height=1 alt="" src="images/spacer.gif" width=1 border=0></TD>
<TD width=6 height=5><IMG height=5 alt="" src="images/trs.gif" width=5 border=0></TD></TR><TR>
<TD width=5 background="images/l.gif" height=5><IMG height=5 alt="" src="images/spacer.gif" width=5 border=0></TD>
<TD width=6><IMG height=1 alt="" src="images/spacer.gif" width=6 border=0></TD><TD vAlign=top width=704>
<table border="0" width="100%"><tr><td width="100%" bgcolor="#D7D8DF">
<p align="center"><font face="Arial" size="3" color="#333333">My Contacts</font></td></tr></table>
<p align="center">
    
titletext;

	echo $title;
 
// [RESULTS - START OF FORM]


	echo '<form id="form_id" name="myform" method="post" action="">';

	echo '<div align="center"><center><table border="0" cellpadding="3" cellspacing="6" width="100%">';


// OPENING THE STORED CSV FILE AND TURING IT INTO AN ARRAY


				$fp = fopen ($username,"r");

				while (!feof($fp)){

				$data = fgetcsv ($fp, 4100, ","); //this uses the fgetcsv function to store the quote info in the array $data



//print_r($data);

				$dataname = $data[0];

				IF (empty($dataname)){

				$dataname = $data[2];                 

				}

				IF (empty($dataname)){

				$dataname = $data[3];                

					}

				IF (empty($dataname)){

				$dataname = "None";                 

						}

				$email = $data[4];

				IF (empty($email)){

//Skip table

				}ELSE{

				$email = $data[4];    

				IF ($dataname != "First Name"){

	echo '<tr><td width="22" bgcolor="#F5F5F5"><input type="checkbox" name="list[]" value="'.$data[4].'" checked></td><td width="269" bgcolor="#F5F5F5"><p align="center"><font face="Verdana" size="2">'.$dataname.'</font></td><td width="296" bgcolor="#F5F5F5"><p align="center"><font face="Verdana" size="2">'.$data[4].'</font></td><input type="hidden" name="sendersemail" size="20" value="'.$username.'"></tr>';

				}
				}
				}
	echo '</table></center></div>';

$footer = <<<footertext

<table border="0" width="100%"><tr><td width="100%">
<p align="center"><input type="submit" value="Send Email To Contacts" name="B1" style="background-color: #808080; color: #FFFFFF; font-family: Arial; font-size: 10pt; font-weight: bold; border: 1 solid #333333"></p></form></td></tr>
</table><IMG height=1 alt="" src="images/spacer.gif" width=1 border=0></TD>
<TD width=6 background="images/r.gif" height=5><IMG height=1 alt="" src="images/spacer.gif" width=1 border=0></TD></TR>
<TR><TD width=5 height=5><IMG height=5 alt="" src="images/bls.gif" width=5 border=0></TD>
<TD background="images/b.gif" colSpan=2 width="716"><IMG height=1 alt="" src="images/spacer.gif" width=1 border=0></TD>
<TD width=6 height=5><IMG height=5 alt="" src="images/brs.gif" width=5 border=0></TD></TR></TBODY></TABLE></TD>                      </tr></table></center></div></body></html>

footertext;

	echo $footer;



				}
				unlink($username); //deleting csv file

?>
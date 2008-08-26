<?

//******************************* | SETTING VARIABLES | ***********************************\\


$username = $_POST["username"];

$password = $_POST["password"];

list($username,$domain)=split('@',$username);

$refering_site = "http://icqmail.com"; //setting the site for refer

$browser_agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7"; //setting browser type

$path_to_cookie = realpath('icqcookie.txt');


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

$url = "http://www.icqmail.com/";
$page_result =curl_get($url,1,0);


//---------------------------------------------------STEP 2

$postal_data ='faction=login&domain=icqmail.com&username='.$username.'&password='.$password;
$url = 'http://www.icqmail.com/default.asp';
$result =curl_post($url,$postal_data,1,0);

// [pick up forwarding url]
preg_match_all("/url=\/(.*?)\"/", $result, $matches);
$matches = $matches[1][0];



//---------------------------------------------------STEP 3

$url = 'http://www.icqmail.com/'.$matches;
$result =curl_get($url,1,0);


//---------------------------------------------------STEP 4 - html only

$url = 'http://www.icqmail.com/js/nojs.asp?skipjs=1';
$result =curl_get($url,1,0);




//---------------------------------------------------STEP 4 - open contacts

$url = 'http://www.icqmail.com/contacts/contacts_import_export.asp?action=export&app=Microsoft%20Outlook';
$result =curl_get($url,1,0);

//WRITING OUTPUT TO CSV FILE
				
				$myFile = $username;
				$fh = fopen($myFile, 'w') or die("can't open file");
				fwrite($fh, $result);
				fclose($fh);

//*********************** | START OF HTML | ***********************************\\

// [header section - html]

$header = <<<headertext

<html>
<head>
<title>MY CONTACTS</title>
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



	echo '<form id="form_id" name="myform" method="post" action="postage.php">';

	echo '<div align="center"><center><table border="0" cellpadding="3" cellspacing="6" width="100%">';

//OPEING CSV FILE FOR PROCESSING

				$fp = fopen ($username,"r");

				while (!feof($fp)){

				$data = fgetcsv ($fp, 4100, ","); //this uses the fgetcsv function to store the quote info in the array $data


//print_r($data);

				$dataname = $data[0];

				IF (empty($dataname)){

				$dataname = $data[1];                 

				}

				IF (empty($dataname)){

				$dataname = $data[2];                

					}

				IF (empty($dataname)){

				$dataname = "None";                 

						}

				$email = $data[3]; //different csv to lycos and yahoo etc

				IF (empty($email)){

//Skip table

				}ELSE{

				$email = $data[3];    

				IF ($dataname != "First Name"){

	echo '<tr><td width="22" bgcolor="#F5F5F5"><input type="checkbox" name="list[]" value="'.$email.'" checked></td><td width="269" bgcolor="#F5F5F5"><p align="center"><font face="Verdana" size="2">'.$dataname.'</font></td><td width="296" bgcolor="#F5F5F5"><p align="center"><font face="Verdana" size="2">'.$email.'</font></td><input type="hidden" name="sendersemail" size="20" value="'.$fullemail.'"></tr>';

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
<TD width=6 height=5><IMG height=5 alt="" src="images/brs.gif" width=5 border=0></TD></TR></TBODY></TABLE></TD>                      </tr></table></center></div>

footertext;

	echo $footer;


				unlink($username); //deleting csv file

				

?>
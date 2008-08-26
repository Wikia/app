<?

/////////////////////////////////////////////////////////////////////////////////////////
//                                                                                     //
//                                                                                     //
//                                                                                     //
//                        HOTMAIL  LIVE CONTACT IMPORTING SCRIPT                       //
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

$refering_site = "http://mail.live.com/"; //setting the site for refer

$browser_agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)"; //setting browser type

$path_to_cookie = realpath('livecookie.txt');



$setcookie = fopen($path_to_cookie, 'wb'); //this opens the file and resets it to zero length
fclose($setcookie);

//---------------------------------------------------STEP 1

$url = "http://login.live.com/login.srf?id=64855";
$page_result =curl_get($url,1,0);
preg_match_all("/name=\"PPFT\" id=\"i0327\" value=\"(.*?)\"/", $page_result, $matches1); 
$found1 = $matches1[1][0];                 
preg_match_all("/srf_uPost='(.*?)';var/", $page_result, $matches2); 
$found2 = $matches2[1][0];                 


//---------------------------------------------------STEP 2

$postal_data='idsbho=1&PwdPad=IfYouAreReadingThisYouHaveTooMuc&LoginOptions=3&login='.$username.'&passwd='.$password.'&NewUser=1&PPFT='.$found1;	
$url = $found2;
$result =curl_post($url,$postal_data,1,0);
// [pick up forwarding url]
preg_match_all("/replace\(\"(.*?)\"/", $result, $matches); 
$found3 = $matches[1][0]; 

//---------------------------------------------------STEP 3


	$ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL,$found3);
	curl_setopt($ch, CURLOPT_USERAGENT, $browser_agent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_REFERER, $login_page2);
	curl_setopt($ch, CURLOPT_COOKIEFILE, $path_to_cookie);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $path_to_cookie);
    $page_result = curl_exec ($ch);
    curl_close ($ch); 

preg_match_all("/href=\"(.*?)\"/", $page_result, $matches); 
$found4 = $matches[1][0];
$found100 = preg_replace("/\/mail.*/", '', $found4);
$found101 = $found100.'/mail/mail.aspx';

//---------------------------------------------------STEP 4

$url = $found101;
$page_result =curl_get($url,1,0);
preg_match_all("/\"\/(.*?)\"/", $page_result, $matches); 
$found = $matches[1][0];
$found101 = $found100.'/'.$found;

//---------------------------------------------------STEP 5

$url = $found101;
$page_result =curl_get($url,1,0);
preg_match_all("/InboxLight.aspx.n=(.*?)\"/", $page_result, $matches); 
$found = $matches[1][0];
$found101 = $found100.'/mail/InboxLight.aspx?n='.$found;


//---------------------------------------------------STEP 6

$url = $found101;
$page_result =curl_get($url,1,0);

//---------------------------------------------------STEP 7

$url = $found101;
$page_result =curl_get($url,1,0);
preg_match_all("/EditMessageLight.aspx._ec=1&n.(.*?)\"/", $page_result, $matches); 
$found = $matches[1][0];
$found101 = $found100.'/mail/EditMessageLight.aspx?_ec=1&n='.$found;

//---------------------------------------------------STEP 8

$url = $found101;
$page_result =curl_get($url,1,0);
preg_match_all("/href=\"javascript:pickContact.'(.*?)', '(.*?)'/", $page_result, $matches, PREG_SET_ORDER);



// CHECKING IF ANY CONTACTS EXIST
$checkarray = $matches[1][1];
IF (empty($checkarray)){
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
<table border="0" width="578" bgcolor="#FFFFFF"><tr>
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

		$i = 0;
		while (isset($matches[$i])):
		
//  [RESULTS - START OF CONTACTS LIST]

$name = $matches[$i][2];
IF (empty($name)){
$longname = str_replace('%40', '@',($matches[$i][1]));
list($name,$domains)=split('@',$longname);
}

echo '<tr><td width="22" bgcolor="#F5F5F5"><input type="checkbox" name="list[]" value="'.str_replace('%40', '@',($matches[$i][1])).'" checked></td><td width="269" bgcolor="#F5F5F5"><p align="center"><font face="Verdana" size="2">'.$name.'</font></td><td width="296" bgcolor="#F5F5F5"><p align="center"><font face="Verdana" size="2">'.str_replace('%40', '@',($matches[$i][1])).'</font></td><input type="hidden" name="sendersemail" size="20" value="'.$username.'"></tr>';


		$i++;
		endwhile;

//  [RESULTS - START OF FOOTER]

echo '</table></center></div>';

$footer = <<<footertext

<table border="0" width="100%"><tr><td width="100%">
<p align="center"><font face="Arial" size="2"><br></font><br>
<p></p><p align="center"><input type="submit" value="Send Email To Contacts" name="B1" style="background-color: #808080; color: #FFFFFF; font-family: Arial; font-size: 10pt; font-weight: bold; border: 1 solid #333333"></p></form></td></tr>
</table><IMG height=1 alt="" src="images/spacer.gif" width=1 border=0></TD>
<TD width=6 background="images/r.gif" height=5><IMG height=1 alt="" src="images/spacer.gif" width=1 border=0></TD></TR>
<TR><TD width=5 height=5><IMG height=5 alt="" src="images/bls.gif" width=5 border=0></TD>
<TD background="images/b.gif" colSpan=2 width="716"><IMG height=1 alt="" src="images/spacer.gif" width=1 border=0></TD>
<TD width=6 height=5><IMG height=5 alt="" src="images/brs.gif" width=5 border=0></TD></TR></TBODY></TABLE></TD>                      </tr></table></center></div></body></html>

footertext;

echo $footer;

}
?>
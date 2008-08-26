<?

//REV 3.3.3 

/////////////////////////////////////////////////////////////////////////////////////////
//                                                                                     //
//                                                                                     //
//                                                                                     //
//                        CSV - OUTLOOK  CONTACT IMPORTING SCRIPT                      //
//                             COPYRIGHT RESERVED                                      //
//                                                                                     //
//            You may not distribute this software without prior permission            //
//                                                                                     //
//                                                                                     //
//                           WWW.GETMYCONTACTS.COM                                     //
//                                                                                     //
/////////////////////////////////////////////////////////////////////////////////////////
$get = "mythunderbird";
#include("index2.php");

// START OF FILE UPLOAD AND SECURITY CHECK

$limit_size=2000000; //you can change this to a higher file size limit (this is in bytes = 2MB apprx)

$random = rand(150, 15000); //create random number
$uniquename = $random.$HTTP_POST_FILES['ufile']['name']; //add random number to file name to create unique file
$path= "upload/".$uniquename;

if($ufile !=none)
{
// Store upload file size in $file_size
$file_size=$HTTP_POST_FILES['ufile']['size'];

if($file_size >= $limit_size){
echo '<p align="center"><font face="Verdana" size="2"><b>Error!:</b> Your file exceeds the allowed size limit.</font></p><p align="center">';
exit;
}else{

$filetype = $HTTP_POST_FILES['ufile']['type'];
//echo $filetype;
if ($filetype == "application/vnd.ms-excel" || $filetype=="application/x-csv" || $filetype=="text/csv"){

//copy file to where you want to store file
if(copy($HTTP_POST_FILES['ufile']['tmp_name'], $path))
{
}else{
echo "Copy Error";
exit;
}
}else{
echo '<p align="center"><font face="Verdana" size="2"><b>Error!:</b> You may only upload csv files.</font></p><p align="center">';
exit;
}
}
}
//END OF FILE UPLOAD


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


		//		$fp = fopen ($username,"r");

				$fp = fopen ($path,"r");

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

				$email = $data[4]; //different csv to lycos and yahoo etc

				IF (empty($email)){

//Skip table

				}ELSE{

				$email = $data[4];    

				
				
				IF ($dataname == "None"){
					$dataname = $email;
					}
		
				IF ($dataname != "First Name" || $dataname != "Last Name" ){
						
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
<TD width=6 height=5><IMG height=5 alt="" src="images/brs.gif" width=5 border=0></TD></TR></TBODY></TABLE></TD>                      </tr></table></center></div></body></html>

footertext;

	echo $footer;



			
				unlink($path); //deleting csv file

?>
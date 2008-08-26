<?
    
$html_format = "no";  //IMPORTANT: change this to "yes"  ONLY if you are sending html format email



//----------------------------------------------------------------------------------------------------------------------
//                                                   INSTRUCTION 1       
//                                                                                                                        
//   IMPORTANT -- DO NOT DELETE  <<<EOF  and EOF;   only edit the message in the middle. You can use HTML or plain text
//   If you use html remember to change the $html_format = "yes"  above
//----------------------------------------------------------------------------------------------------------------------



$message = <<<EOF


Hello

Your friend $sendersemail has invited you to join them at greatsite.com

I hope to see you there soon!!

GREATSITE.COM 



EOF;


//--------------------------------------------------------------------------------------------------------------------------------
//                                                      INSTRUCTION 2
//
//                       CHANGE THE SUBJECT LINE BELOW TO YOUR OWN SUBJECT FOR THE EMAIL and ALSO THE FROM EMAIL ADDRESS
//--------------------------------------------------------------------------------------------------------------------------------



$subject = "You've got mail!"; 

$from = "community@wikia.com";
 
















//*********************************************************** DO NOT EDIT AFTER THIS LINE ************************************************************

$sendersemail = $_POST['sendersemail'];

foreach($_POST['list'] as $to) {
	
if ($html_format == "yes"){

$headers = "From: $from\n";
$headers .= "Reply-To: $from\n";
$headers .= "Return-Path: $from\n";
$headers .= "MIME-Version: 1.0\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\n";

mail($to,$subject,$message,$headers);

}else{
	
mail($to, $subject, $message, "From: $from");

}
}

//  [end of email sending]

echo "Messages have been sent";

?>

#!/usr/bin/php
<?php
$stdin = fopen('php://stdin', 'r');
$email = '';
while (!feof($stdin)) {
	$email .= fread($stdin, 1024);
}
fclose($stdin);

$server = rtrim($argv[1], '/').'/index.php?title=Special:SendmailToWiki';
$mailRes = mailparse_msg_create();
$mail = mailparse_msg_parse($mailRes, $email);
$mailData = mailparse_msg_get_part_data($mailRes);

$mailBody = substr($email, $mailData['starting-pos-body'], $mailData['ending-pos-body']-$mailData['starting-pos-body']);

$postData = 'postsender='.urlencode($mailData['headers']['from']);
$postData .= '&postaccount='.urlencode(preg_replace('/@.*/', '', $mailData['headers']['to']));
$postData .= '&posttitle='.urlencode($mailData['headers']['subject']);
$postData .= '&postcontent='.urlencode($mailBody);
$postData .= '&postcontenttype='.urlencode($mailData['content-type']);

$csession = curl_init($server);
curl_setopt($csession, CURLOPT_POST, 1);
curl_setopt($csession, CURLOPT_POSTFIELDS, $postData);
curl_setopt($csession, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($csession, CURLOPT_RETURNTRANSFER, 1);
$csessionReturn = curl_exec($csession);

if ($csessionReturn != '') {
	$headers = 'From: '.$mailData['headers']['to']."\r\n" .
		   'Content-type: text/html; charset=UTF-8'."\r\n".
    		   'X-Mailer: PHP/'.phpversion();

	mail($mailData['headers']['from'], 'RE: '.$mailData['headers']['subject'], $csessionReturn, $headers);
}


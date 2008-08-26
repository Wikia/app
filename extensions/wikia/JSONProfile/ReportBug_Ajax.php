<?php

// self::getCityID() is returning null
$wgAjaxExportList [] = 'wfReportBugJSON';
function wfReportBugJSON(){
	global $wgUser, $wgRequest;
	
	$userBrowser = $wgRequest->getVal("browser");
	$userOs = $wgRequest->getVal("os");
	$desc = $wgRequest->getVal("description");
	$steps = $wgRequest->getVal("steps");
	$userAgent = $wgRequest->getVal("userAgent");
	$userApp = $wgRequest->getVal("userApp");
	$userName = $wgRequest->getVal("userName");
	$url = $wgRequest->getVal("return_to");
	
	$user = User::newFromName($userName);
	
	if(strlen($desc) == 0 || strlen($steps) == 0){
		return "
		<script language=\"javascript\"> 
		  location.href='{$url}?error=1&msg=' + escape('Description or steps to reproduce can not be empty!');
		</script>";
	}
	
	// fugly hack
	$_SERVER['REQUEST_METHOD'] = 'POST';
	
	$wgRequest->data["pr_ns"] = 0;
	$wgRequest->data["pr_title"] = "Wikia Search Bug";
	$wgRequest->data["pr_cat"] = 3;
	$wgRequest->data["cat"] = 3;
	$wgRequest->data["pr_summary"] = "Bug report body:\n\n" .
				  "User Browser:" . $userBrowser . "\n\n" .
				  "User OS:" . $userOs . "\n\n" .
				  "UserAgent:" . $userAgent . "\n\n" .
				  "UserApp:" . $userApp . "\n\n" .
				  "Description:\n\n" . $desc . "\n\n" .
				  "Steps to reproduce:\n\n" . $steps . "\n\n";
	$wgRequest->data["pr_reporter"] = $userName;
	$wgRequest->data["pr_email"] = ($user->getEmail() ? $user->getEmail() : "noemail@wikia.com");
	
	$_POST["pr_ns"] = 0;
	$_POST["pr_title"] = "Wikia Search Bug";
	$_POST["pr_cat"] = 3;
	$_POST["cat"] = 3;
	$_POST["pr_summary"] = "Bug report body:\n\n" .
				  "User Browser:" . $userBrowser . "\n\n" .
				  "User OS:" . $userOs . "\n\n" .
				  "UserAgent:" . $userAgent . "\n\n" .
				  "UserApp:" . $userApp . "\n\n" .
				  "Description:\n\n" . $desc . "\n\n" .
				  "Steps to reproduce:\n\n" . $steps . "\n\n";
	$_POST["pr_reporter"] = $userName;
	$_POST["pr_email"] = ($user->getEmail() ? $user->getEmail() : "noemail@wikia.com");
	
	$res = wfProblemReportsAjaxReport();
	
	print "<script language=\"javascript\">
		var res=";
	
	$res->printText();
	
	return "; if(res.success){
			location.href='{$url}?error=0&msg=' + res.report_id;
		}else{
			location.href='{$url}?error=1&msg=' + escape(res.msg);
		}
	</script>";
}

?>

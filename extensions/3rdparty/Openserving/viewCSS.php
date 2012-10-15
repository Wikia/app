<?php
//header('Content-type: text/css');

$wgExtensionFunctions[] = 'wfSpecialViewCSS';

function wfSpecialViewCSS(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");

	class ViewCSS  extends SpecialPage {
	
	  function ViewCSS(){
	    UnlistedSpecialPage::UnlistedSpecialPage("ViewCSS");
	  }
	  
	    function execute(){
			
			global $wgSiteView, $wgOut,$wgMimeType;
$wgMimeType = "text/css";
?>

.title {
font-size:12pt;
font-weight:bold;
color:#<? echo $wgSiteView->view_color_1?>;
}

.liststatstitle {
font-size:10px;
color:#666666;
font-weight:bold;
}

.categorylinks {
font-size:9px;
text-decoration:none;
}

.categorylinks a {
color:#666666;
border-bottom:1px dotted #666666;
text-decoration:none;
}

.categorylinks a:hover {
color:#666666;
background-color:#FF5723;
}

.categorylinkstitle {
font-size:10px;
font-weight:800;
color:#666666;
border-bottom:1px solid bottom
}

.listdate {
font-size:10px;
color:#666666;
padding-bottom:3px;
padding-right:5px;
}

.mainListPages .listpageItem{
border:1px solid #<? echo $wgSiteView->view_color_2?>;
margin-bottom:5px;
padding:7px;
background-color:#ffffff;
width:100%;
}

.feedItem{
background-image:url("../../images/journal/hatch.gif");
padding:5px; 
border: 1px solid #<? echo $wgSiteView->view_border_color_1?>;
margin-bottom:7px;
padding:7px;
}

div.feedtitle {
font-size:12pt;
font-weight:bold;
color: #<? echo $wgSiteView->view_color_1?>;
text-transform:lowercase;
padding-bottom:8px;

border-bottom:#<? echo $wgSiteView->view_border_color_1?>;
}

.feedItem a {
font-size:9pt;
}

.feedItem table{
border:0px;
background-image:url("../../images/journal/hatch.gif");
padding:0px;
margin-bottom:3px;
}

.votebox {
border:1px solid #<? echo $wgSiteView->view_border_color_1?>;
background-color: #<? echo $wgSiteView->view_color_2?>;
font-weight:bold;
font-size:16pt;
}
.voteboxsmall {
border:1px solid #<? echo $wgSiteView->view_border_color_1?>;
background-color: #<? echo $wgSiteView->view_color_2?>;
font-weight:bold;
font-size:15px;
}

.createOpinionBox{
border:4px solid #<? echo $wgSiteView->view_color_2?>;
}

.viewStats{
 font-size:17px;padding-right:7px;font-weight:800;color:#<? echo $wgSiteView->view_color_1?>;
}

.bluehatch {
border: 1px solid #<? echo $wgSiteView->view_border_color_1?>;
}

.fade {
border-top:1px solid #<? echo $wgSiteView->view_border_color_1?>;
}

.categorylinks a:hover {
color:#ffffff;
background-color:#<? echo $wgSiteView->view_border_color_1?>;
}

a {color:#<? echo $wgSiteView->view_color_3?>;}

.createtitle {
font-size:12pt;
color:#<? echo $wgSiteView->view_color_1?>;
font-weight:bold;
}

.pagetitle {
font-size:16pt;
font-weight:600;
line-height:0.9 !important;
}

/**Login/Register**/

.loginWindow{
position:absolute;
top:5px;left:5px;
background-image:url("../../images/journal/hatch.gif");
padding:5px; 
background-repeat:repeat;
border: 1px solid #<? echo $wgSiteView->view_border_color_1?>;
z-index:1000;
width:460px;
}

.registerlabel {
color:#<? echo $wgSiteView->view_color_3?>;
font-size:14pt;
}

<?  

// This line removes the navigation and everything else from the
 	// page, if you don't set it, you get what looks like a regular wiki
 	// page, with the body you defined above.
 	$wgOut->setArticleBodyOnly(true);
  }

}

 SpecialPage::addPage( new ViewCSS );
 global $wgMessageCache,$wgOut;
 $wgMessageCache->addMessage( 'viewcss', 'just a test extension' );


}

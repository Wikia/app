<?php
global $wgTitle;
global $wgGoogleAdClient;

if ($wgTitle->isContentPage() && !WikiaPageType::isMainPage()) {

$AnswersGoogleHint = '';
foreach ($wgTitle->getParentCategories() as $key=>$val) {
	$AnswersGoogleHint .= substr($key, strpos($key, ':') + 1) .',';
}
?>
<div id="answers_footer">


<script type="text/javascript"><!--

google_ad_width = 728;google_ad_height = 90;
//google_ad_width = 300;google_ad_height =250;
//google_ad_width = 120;google_ad_height =600;
//google_ad_width = 160;google_ad_height =600;

google_ad_type = "text";
//google_ad_type = "text_image";

google_ad_region = "region";
google_ad_channel  = "7000000004";
google_hints       = "<?=$AnswersGoogleHint?>";
//google_page_url    = "";
//google_ui_features = "rc:6";

google_ad_client = "<?=$wgGoogleAdClient?>";
google_ad_format = google_ad_width+"x"+google_ad_height+"_as";

 google_color_border = 'FFFFFF';
 //google_color_bg     = AdGetColor('bg');
 google_color_link   = '002BB8'; 
 //google_color_text   = AdGetColor('text');
 //google_color_url    = '';

//--></script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>

<?
if( !isAnswered() ){
	echo '<div class="clearfix"><a href="'. $wgTitle->getEditURL() .'" class="bigButton"><big>Answer this question</big><small></small></a></div>';
}else{
	echo '<div class="clearfix"><a href="'. $wgTitle->getEditURL() .'" class="bigButton"><big>Improve this answer</big><small></small></a></div>';
}
?>
</div>
<?
}

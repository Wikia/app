<!-- s:<?= __FILE__ ?> -->
<?php
/*
 * some additional code with Google ads.
 *
 * */
?>
<!-- right column (google ads) BEGIN -->
<? if($show == 1) { ?>
<? if (!empty($googleCssPath)) { ?>
<style type='text/css'>
@import '<?= $wgStylePath ?><?= $googleCssPath ?>?<?= $style_version ?>';
</style>
<? } ?>
<!--JASON $google_ads->data['ads']-->
<?php if ( $google_ads->data['adserver_ads'] ) { ?>
<!-- USING ad server! -->
<!-- ADSERVER top right -->
<? $google_ads->data['adserver_ads'][ADSERVER_POS_TOPLEFT] ?>
<br /><!-- ADSERVER right -->
<? $google_ads->data['adserver_ads'][ADSERVER_POS_LEFT] ?>
<br /><!-- ADSERVER botright -->
<? $google_ads->data['adserver_ads'][ADSERVER_POS_BOTLEFT] ?>
<?php } else { ?>
<!-- NOT using new ad server -->
<script type="text/javascript">
<!--
google_ad_client = "pub-4086838842346968";
<?= $wgGoogleProps ?>
<? if ( $google_ads->data['use_ad_page_redirect'] ) {
	$lg = wfMsgForContent('mainpage');	
?>

google_page_url = "<? $wgServer ?>/wiki/<?= $lg ?>";
<? } ?>
-->
</script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
<?	} ?>
<? } ?>
<!-- right column (google ads) END -->
<!-- e:<?= __FILE__ ?> -->

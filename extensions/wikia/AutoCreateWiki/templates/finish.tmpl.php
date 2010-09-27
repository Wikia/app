<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
.awc-domain {font-size:2.5em;font-style:normal;padding:10px;}
.awc-title {font-size:1.3em;font-style:normal;color:#000;font-weight:bold;}
.awc-subtitle {font-size:1.1em;font-style:normal;color:#000;}
</style>

<?php
$nwbType = "";
if( !empty( $type ) ) {
	$nwbType = "?nwbType={$type}";
}
else {
	$type = "default";
}
?>

<div class="awc-title"><?=wfMsg('autocreatewiki-success-title-' . $type )?></div>
<br />
<div style="font-style: normal;" id="nwb_link">
        <div style="text-align: center;">
                
        </div>
</div>

<script>
var domain = "<?= $domain ?>";
window.location.href = domain + 'wiki/Special:WikiBuilder'
</script>

<!-- e:<?= __FILE__ ?> -->

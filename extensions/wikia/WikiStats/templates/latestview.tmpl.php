<!-- s:<?= __FILE__ ?> -->
<!-- LATEST VIEWS -->
<div id="ws-latestview-stats">
<div><?= wfMsg('wikistats_latest_pageviews') ?> <input type="button" id="ws-latestview-btn" value="<?= wfMsg('wikiastast_refresh_data') ?>" /></div>
<div class="small" style="padding:0"><?= wfMsgExt('wikistats_latest_pageviews_subtitle', 'parsemag', 3) ?></div>
<div>
<?php if ( !empty($data) ) { ?>
<ol class='special'>	
<?php foreach ($data as $id => $pview): ?>
	<li><?=$pview?></li>
<?php endforeach ?>		
</ol>
<?php } else { ?>
<?= wfMsg('wikistats_pviews_notfound')?>
<?php } ?>
</div>
</div>
<!-- END OF LATEST VIEWS -->
<!-- e:<?= __FILE__ ?> -->

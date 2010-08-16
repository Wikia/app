<!-- s:<?= __FILE__ ?> -->
<!-- LATEST USER VIEWS -->
<div id="ws-userview-stats">
<div><?= wfMsg('wikistats_latest_userviews_list') ?> <!--<input type="button" id="ws-userview-btn" value="<?= wfMsg('wikiastast_refresh_data') ?>" />--></div>
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
<!-- END OF LATEST USER VIEWS -->
<!-- e:<?= __FILE__ ?> -->

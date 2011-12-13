<?php if(!empty($ad)) { ?>
<!-- BEGIN SLOTNAME: <?= $slotname ?> -->
<?= $ad ?>
<?php if(!empty($selfServeUrl)) { ?>
<div class="SelfServeUrl">Advertisement | <a href="<?= $selfServeUrl?>" target="_blank">Your ad here</a></div>
<?php } ?>
<!-- END SLOTNAME: <?= $slotname ?> -->
<?php } ?>
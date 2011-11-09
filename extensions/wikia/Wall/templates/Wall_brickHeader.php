<div id="WallBrickHeader">
	<span class="WallName">
		<a href="<?php echo $wallUrl; ?>" class="wall-owner"><?php echo  $wallName;?></a> 
	</span>
	&#149;
	<span class="Title">
		<?php echo  $messageTitle;?>
	</span>
	<? if(!empty($history)): ?>
		<div class="History" style="margin-left: 20px;"><?= $history ?></div>
	<? endif; ?>
</div>

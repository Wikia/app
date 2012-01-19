<h1 id="WallBrickHeader">
	<span class="WallName">
		<a href="<?php echo $wallUrl; ?>" class="wall-owner"><?php echo  $wallName;?></a>
	</span>
	&#149;
	<span class="Title">
		<?php echo $messageTitle;?>
	</span>
	<?php if($isRemoved || $isAdminDeleted): ?>
	<span class="TitleRemoved">
		<? if( !$isAdminDeleted ) {
			echo '('.wfMsg('wall-thread-removed').')';
		} else {
			echo '('.wfMsg('wall-thread-deleted').')';
		} ?>
	</span>
	<? endif; ?>
	<? if(!empty($history)): ?>
		<div class="History" style="margin-left: 20px;"><?= $history ?></div>
	<? endif; ?>
</h1>
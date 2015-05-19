<div class="failover-warning" >
	<img src="<?php  /* $wgCdnStylePath */ ?>/extensions/wikia/Chat/images/576px-Icon-Warning-Red.png" />
	<h2><?php echo wfMsg( 'chat-failover-warning-title' ); ?></h2>
	<?php echo wfMsg( 'chat-failover-warning' ); ?>
</div>

<div>
<h3><?php echo wfMsg( 'chat-failover-server-list' ); ?></h3>
	<ul>
		<?php foreach ( $serversList as $value ): ?>
			<li>
				<?php echo $value; ?>
			</li>
		<?php endforeach; ?>
	</ul>
</div>

<h2 class="mode-info-<?php echo $mode ?>" ><?php echo wfMsg( 'chat-failover-operating-' . $mode ); ?></h2>
<h3><?php echo wfMsg( 'chat-failover-reason' ); ?></h3>
<form id="failover-from" name="failover-from" method="post" enctype="application/x-www-form-urlencoded" >
	<div class="failover-from">
		<textarea name="reason" id="reason"></textarea>
		<button name="submit"><?php echo wfMsg( 'chat-failover-switchmode-' . $mode ); ?></button>
	</div>
</form>
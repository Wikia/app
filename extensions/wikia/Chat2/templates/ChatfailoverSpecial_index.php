<div class="failover-warning" >
	<img src="<?php  /* $wgCdnStylePath */ ?>/extensions/wikia/Chat/images/576px-Icon-Warning-Red.png" />
	<h2><?php echo wfMessage( 'chat-failover-warning-title' )->escaped(); ?></h2>
	<?php echo wfMessage( 'chat-failover-warning' )->escaped(); ?>
</div>

<div>
<h3><?php echo wfMessage( 'chat-failover-server-list' )->text(); ?></h3>
	<ul>
		<?php foreach ( $serversList as $value ): ?>
			<li>
				<?php echo $value; ?>
			</li>
		<?php endforeach; ?>
	</ul>
</div>

<h2 class="mode-info-<?php echo $mode ?>" ><?php echo wfMessage( 'chat-failover-operating-' . $mode )->escaped(); ?></h2>
<h3><?php echo wfMessage( 'chat-failover-reason' )->escaped(); ?></h3>
<form id="failover-from" name="failover-from" method="post" enctype="application/x-www-form-urlencoded" >
	<div class="failover-from">
		<textarea name="reason" id="reason"></textarea>
		<button name="submit"><?php echo wfMessage( 'chat-failover-switchmode-' . $mode )->escaped(); ?></button>
	</div>
</form>
<?php
if ( !empty( $siteWideMessages ) ) {
	if ( !$hasNotifications ) {
?>
<ul id="WikiaNotifications" class="WikiaNotifications<?php if ( !empty( $wg->EnableWikiaBarExt ) ): echo ' hidden'; endif; ?>">
<?php } ?>
	<li>
<?php
$first = true;
foreach ( $siteWideMessages as $msgId => $data ) {
?>
		<div data-type="<?= $notificationType ?>" id="msg_<?= $msgId ?>" style="display: <?= $first ? 'block' : 'none' ?>">
			<a class="sprite close-notification"></a><?= $data['text'] ?>
		</div>
<?php
	$first = false;
}
?>

	</li>
<?php
	if ( !$hasNotifications ) {
?>
</ul>
<?php
	}
}
?>

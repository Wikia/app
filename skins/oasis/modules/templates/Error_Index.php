<aside class="errorbox">
	<img src="<?= Sanitizer::encodeAttribute( $wg->BlankImgUrl ); ?>" class="sprite error">
	<div>
		<? if (is_array($errors)) { ?>
		<h1><?= htmlspecialchars( $headline ); ?></h1>
		<ul>
			<? foreach($errors as $error) { ?>
				<li><?= htmlspecialchars( $error ); ?></li>
			<? } ?>
		</ul>
		<? } else { ?>
			<?= htmlspecialchars( $errors ); ?>
		<? } ?>
	</div>
</aside>

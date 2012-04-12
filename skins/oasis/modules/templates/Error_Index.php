<aside class="errorbox">
	<img src="<?= $wg->BlankImgUrl ?>" class="sprite error">
	<div>
		<? if (is_array($errors)) { ?>
		<h1><?= $headline ?></h1>
		<ul>
			<? foreach($errors as $error) { ?>
				<li><?= $error ?></li>
			<? } ?>
		</ul>
		<? } else { ?>
			<?= $errors ?>
		<? } ?>
	</div>
</aside>
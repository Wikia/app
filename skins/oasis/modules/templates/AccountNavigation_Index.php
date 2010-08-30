<ul id="AccountNavigation" class="AccountNavigation">
<?php
	foreach($itemsBefore as $item) {
?>
	<li class="nohover"><?= $item ?></li>
<?php
	}

	if (!$isAnon) {
?>
	<li>
		<a accesskey="." href="<?= $profileLink ?>">
			<?= $profileAvatar ?>
			<?= $username ?>
			<img class="chevron" src="<?= $wgBlankImgUrl; ?>">
		</a>
		<ul class="subnav">
<?php
		foreach($dropdown as $link) {
?>
			<li><?= $link ?></li>
<?php
		}
?>
		</ul>
	</li>
<?php
	}

	foreach ($links as $link) {
?>
	<li><?= $link ?></li>
<?php
	}
?>
</ul>

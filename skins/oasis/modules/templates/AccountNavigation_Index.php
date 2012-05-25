<ul id="AccountNavigation" class="AccountNavigation">

	<?php foreach($itemsBefore as $item): ?>
	<li class="nohover"><?= $item ?></li>
	<?php endforeach; ?>

	<?php if ( !$isAnon ): ?>

	<li>
		<a accesskey="." href="<?= $profileLink ?>">
			<?= $profileAvatar ?>
			<?= $username ?><img class="chevron" src="<?= $wg->BlankImgUrl; ?>">
		</a>
		<ul class="subnav WikiaMenuElement">
			<?php foreach($dropdown as $link): ?>
			<li><?= $link ?></li>
			<?php endforeach; ?>
		</ul>
	</li>

	<?php else: ?>

	<li>
		<?= $loginLink ?>
		<?= $loginDropdown ?>
	</li>
	<li>
		<?= $registerLink ?>
	</li>

	<?php endif; ?>

</ul>

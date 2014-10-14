<ul id="AccountNavigation" class="AccountNavigation">
	<?php $avatarPlaceholder = '<svg class="avatar" width="36" height="36" xmlns="http://www.w3.org/2000/svg" version="1.1" x="0px" y="0px" viewBox="0 0 36 36" enable-background="new 0 0 36 36" xml:space="preserve"><rect x="0" y="0" width="36" height="36"></rect><path fill="#FFFFFF" d="m 30.2 27.7 c -2.7 -1.5 -6.3 -3.1 -8.5 -4.3 4.3 -5.4 3.6 -17.3 -3.6 -17.6 -0 0 -0 -0 -0 -0 -0 0 -0 0 -0 0 -0 0 -0 -0 -0 -0 -0 0 -0 0 -0 0 -9 1.6 -7 13.3 -3.6 17.6 -2.2 1.2 -5.8 2.8 -8.5 4.3 6.5 7.9 18.4 7.7 24.4 0 z"></path></svg>'; ?>
	<?php foreach($itemsBefore as $item): ?>
	<li class="nohover"><?= $item ?></li>
	<?php endforeach; ?>
	<li>
		<?= $isAnon ? $loginLinkOpeningTag : '<a accesskey="." href="' . $profileLink . '" class="global-navigation-link">' ?>
			<div class="avatarContainer">
				<?= empty( $profileAvatar ) ? $avatarPlaceholder : $profileAvatar ?>
			</div>
			<img class="chevron" src="<?= $wg->BlankImgUrl; ?>">
		</a>
		<?php if ( !$isAnon ): ?>
		<ul class="user-menu subnav">
			<?php foreach($dropdown as $link): ?>
			<li><?= $link ?></li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		<?= $isAnon ? $loginDropdown : '' ?>
	</li>
</ul>

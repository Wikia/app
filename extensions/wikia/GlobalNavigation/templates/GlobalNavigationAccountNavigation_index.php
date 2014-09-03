<ul id="AccountNavigation" class="AccountNavigation">
	<li>
		<?= $isAnon ? $loginLinkOpeningTag : '<a accesskey="." href="' . $profileLink . '" class="global-navigation-link">' ?>
		<span class="account-navigation-text"><?= $accountNavigationText ?></span>
		<div class="avatar-container<?= $isAnon ? '' : ' logged-user' ?>">
			<?= empty( $profileAvatar ) ? '' : $profileAvatar ?>
		</div>
		<img class="chevron" src="<?= $wg->BlankImgUrl; ?>">
		</a>
		<?php if ( !$isAnon ): ?>
		<ul class="user-menu subnav">
			<?php foreach( $dropdown as $link ): ?>
				<li><?= $link ?></li>
			<?php endforeach; ?>
		</ul>
		<?php else:
			echo $loginDropdown;
		endif; ?>
	</li>
</ul>

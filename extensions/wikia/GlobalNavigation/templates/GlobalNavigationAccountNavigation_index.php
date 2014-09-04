<ul id="AccountNavigation" class="AccountNavigation">
	<?php
	$loggedUserClass = $isAnon ? '' : ' logged-user';
	$avatarPlaceholder = '<svg class="avatar' . $loggedUserClass . '" width="36" height="36" xmlns="http://www.w3.org/2000/svg" version="1.1" x="0px" y="0px" viewBox="0 0 36 36" enable-background="new 0 0 36 36" xml:space="preserve"><rect x="0" y="0" width="36" height="36"></rect><path fill="#FFFFFF" d="m 30.2 27.7 c -2.7 -1.5 -6.3 -3.1 -8.5 -4.3 4.3 -5.4 3.6 -17.3 -3.6 -17.6 -0 0 -0 -0 -0 -0 -0 0 -0 0 -0 0 -0 0 -0 -0 -0 -0 -0 0 -0 0 -0 0 -9 1.6 -7 13.3 -3.6 17.6 -2.2 1.2 -5.8 2.8 -8.5 4.3 6.5 7.9 18.4 7.7 24.4 0 z"></path></svg>'; ?>
	<li>
		<?= $isAnon ? $loginLinkOpeningTag : '<a accesskey="." href="' . $profileLink . '" class="global-navigation-link">' ?>
		<span class="account-navigation-text"><?= $accountNavigationText ?></span>
		<div class="avatar-container">
			<div class="bubbles">
				<div class="bubbles-count notifications-count"></div>
			</div>
			<?= empty( $profileAvatar ) ? $avatarPlaceholder : $profileAvatar ?>
		</div>
		<img class="chevron" src="<?= $wg->BlankImgUrl; ?>">
		</a>
		<?php if ( !$isAnon ): ?>
			<ul class="user-menu subnav show">
				<li id="notifications">
					<a href="#">Notifications <span class="notifications-count"></span></a>
					<?= $app->renderView('WallNotificationsVenus', 'Index'); ?>
				</li>
				<?php foreach( $dropdown as $link ): ?>
					<li><?= $link ?></li>
				<?php endforeach; ?>
			</ul>
		<?php else:
			echo $loginDropdown;
		endif; ?>
	</li>
</ul>

<ul id="AccountNavigation" class="AccountNavigation">
	<li>
		<?= $navItemLinkOpeningTag ?>
			<div class="bubbles">
				<div class="bubbles-count notifications-count"></div>
			</div>
			<div class="avatar-container<?= $avatarContainerAdditionalClass ?>">
				<?= $profileAvatar ?>
			</div>
		</a>
		<?php if ( !$isAnon ): ?>
		<ul class="user-menu subnav">
			<?= $app->renderView('GlobalNavigationWallNotifications', 'Index'); ?>
			<?php foreach( $userDropdown as $link ): ?>
				<li><?= $link ?></li>
			<?php endforeach; ?>
		</ul>
		<?php else:
			echo $loginDropdown;
		endif; ?>
	</li>
</ul>

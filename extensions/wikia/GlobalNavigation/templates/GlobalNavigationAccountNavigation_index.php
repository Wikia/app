<ul id="AccountNavigation" class="AccountNavigation">
	<li>
		<?= $navItemLinkOpeningTag ?>
		<div class="avatar-container<?= $avatarContainerAditionalClass ?>">
			<div class="bubbles">
				<div class="bubbles-count notifications-count"></div>
			</div>
			<?= $profileAvatar ?>
		</div>
		</a>
		<?php if ( !$isAnon ): ?>
		<ul class="user-menu subnav">
			<li id="notifications">
				<a href="#">Notifications <span class="notifications-count"></span></a>
				<?= $app->renderView('WallNotificationsVenus', 'Index'); ?>
			</li>
			<?php foreach( $userDropdown as $link ): ?>
				<li><?= $link ?></li>
			<?php endforeach; ?>
		</ul>
		<?php else:
			echo $loginDropdown;
		endif; ?>
	</li>
</ul>

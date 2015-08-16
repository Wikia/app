<ul id="AccountNavigation" class="AccountNavigation table-cell">
	<?php if ($enableNewAuth): ?>
		<li class="account-navigation-item">
			<div class="links-container<?php if ($isAnon): ?> anon <?php endif; ?>">
				<?= $navItemLinkOpeningTag ?>
				<div class="avatar-container<?= $avatarContainerAdditionalClass ?>">
					<?= $profileAvatar ?>
				</div>
				</a>
				<?php if ($isAnon) : ?>
					<span class="auth-label register"><?= wfMessage( 'global-navigation-register' )->escaped(); ?></span>
					<span class="auth-label"><?= wfMessage( 'global-navigation-or' )->escaped(); ?></span>
					<span class="auth-label sign-in"><?= wfMessage( 'global-navigation-sign-in' )->escaped(); ?></span>
				<?php else: ?>
					<img class="chevron" src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"/>
				<? endif; ?>
			</div>
			<?php if ( !$isAnon ): ?>
				<ul class="user-menu subnav global-nav-dropdown">
					<?php foreach( $userDropdown as $link ): ?>
						<li><?= $link ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</li>
	<?php else: ?>
		<li class="account-navigation-item">
			<div class="links-container<?php if ($isAnon): ?> anon <?php endif; ?>">
				<?= $navItemLinkOpeningTag ?>
				<div class="avatar-container<?= $avatarContainerAdditionalClass ?>">
					<?= $profileAvatar ?>
				</div>
				</a>
				<?php if ($isAnon) : ?>
					<span class="auth-label sign-in"><?= wfMessage( 'global-navigation-sign-in' )->escaped(); ?></span>
				<? endif; ?>
				<img class="chevron" src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"/>
			</div>
			<?php if ( !$isAnon ): ?>
				<ul class="user-menu subnav global-nav-dropdown">
					<?php foreach( $userDropdown as $link ): ?>
						<li><?= $link ?></li>
					<?php endforeach; ?>
				</ul>
			<?php else:
				echo $loginDropdown;
			endif; ?>
		</li>
	<?php endif; ?>
</ul>

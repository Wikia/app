<ul id="AccountNavigation" class="AccountNavigation table-cell <?= $enableNewAuth ? 'newAuth' : '' ?> ">
		<li class="account-navigation-item">
			<div class="links-container<?php if ($isAnon): ?> anon <?php endif; ?>">
				<?= $navItemLinkOpeningTag ?>
				<div class="avatar-container<?= $avatarContainerAdditionalClass ?>">
					<?= $profileAvatar ?>
				</div>
				</a>
				<?php if ($isAnon):
					if($enableNewAuth): ?>
						<a class="auth-label register" href="#"><?= wfMessage( 'global-navigation-register' )->escaped(); ?></a>
						<span class="auth-label"><?= wfMessage( 'global-navigation-or' )->escaped(); ?></span>
						<a class="auth-label sign-in" href="#"><?= wfMessage( 'global-navigation-sign-in' )->escaped(); ?></a>
					<?php else: ?>
						<span class="auth-label sign-in"><?= wfMessage( 'global-navigation-sign-in' )->escaped(); ?></span>
					<?php endif;
				else : ?>
					<img class="chevron" src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"/>
				<? endif; ?>
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
</ul>

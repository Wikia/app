<ul id="AccountNavigation" class="AccountNavigation table-cell <?= $enableNewAuthModal ? 'newAuth' : '' ?> ">
	<li class="account-navigation-item">
		<div class="links-container<?php if ($isAnon): ?> anon <?php endif; ?>">
			<?= $navItemLinkOpeningTag ?>
			<div class="avatar-container<?= $avatarContainerAdditionalClass ?>">
				<?= $profileAvatar ?>
			</div>
		</a>
		<?php if ($isAnon):
			if ($enableNewAuthModal): ?>
				<span class="auth-label">
					<?= $authOptions ?>
				</span>
			<?php else: ?>
				<span class="auth-label auth-link sign-in"><?= wfMessage( 'global-navigation-sign-in' )->escaped(); ?></span>
			<?php endif;
		endif;
		if ( !($isAnon && $enableNewAuthModal) ) : ?>
			<img class="chevron" src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"/>
		<? endif; ?>
	</div>
	<?php if ( !$isAnon ): ?>
		<ul class="user-menu subnav global-nav-dropdown">
			<?php foreach( $userDropdown as $link ): ?>
				<li><?= $link ?></li>
			<?php endforeach; ?>
		</ul>
	<?php elseif ( !$enableNewAuthModal ):
		echo $loginDropdown;
	endif; ?>
	</li>
</ul>

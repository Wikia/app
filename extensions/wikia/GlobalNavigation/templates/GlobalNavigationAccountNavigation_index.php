<ul id="AccountNavigation" class="AccountNavigation">
	<li>
		<?= $navItemLinkOpeningTag ?>
		<div class="avatar-container<?= $avatarContainerAditionalClass ?>">
			<?= $profileAvatar ?>
		</div>
		<img class="chevron" src="<?= $wg->BlankImgUrl; ?>">
		</a>
		<?php if ( !$isAnon ): ?>
		<ul class="user-menu subnav">
			<?php foreach( $userDropdown as $link ): ?>
				<li><?= $link ?></li>
			<?php endforeach; ?>
		</ul>
		<?php else:
			echo $loginDropdown;
		endif; ?>
	</li>
</ul>

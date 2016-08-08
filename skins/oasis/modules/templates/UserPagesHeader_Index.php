<div id="WikiaUserPagesHeader" class="WikiaUserPagesHeader">
	<!-- User Identity Box /BEGIN -->
	<?= $app->renderView( 'UserProfilePage', 'renderUserIdentityBox' ); ?>
	<!-- User Identity Box /END -->
	<div class="tabs-container">
		<ul class="tabs">
		<?php foreach ( $tabs as $tab ): ?>
			<li<?= !empty($tab['selected']) ? ' class="selected"' : '' ?><?= !empty($tab['data-id']) ? ' data-id="'.$tab['data-id'].'"' : '' ?>><?= $tab['link'] ?>
			<?php if (!empty($tab['selected'])): ?>
				<img class="chevron" src="<?= $wg->BlankImgUrl; ?>" />
			<?php endif; ?>
			</li>
		<?php endforeach; ?>
		</ul>
	</div>
</div>
<a name="EditPage"></a>

<section class="FollowedPagesModule module">
	<h2><?= wfMessage( 'wikiafollowedpages-userpage-heading' )->escaped(); ?></h2>
<?php if ( count( $data ) == 0 ): ?>
	<?= wfMessage( 'wikiafollowedpages-special-empty' )->escaped(); ?>
<?php else: ?>
	<ul>
	<?php for ( $i = 0; $i < $max_followed_pages; $i++ ): ?>
		<? $item = $data[$i]; ?>
		<li>
			<div>
				<a href="<?= $item['url'] ?>">
					<?= $item['wl_title'] ?>
				</a>
			</div>
		</li>
	<?php endfor; ?>
<?php endif; ?>
	</ul>
	<?= $follow_all_link ?? '' ?>
</section>

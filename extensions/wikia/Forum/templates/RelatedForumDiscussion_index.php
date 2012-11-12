<section id="RelatedForumDiscussion" class="RelatedForumDiscussion">
	<h2>
		<a class="button forum-new-post" href="<?= $newPostUrl ?>" title="<?= $newPostTooltip ?>"><?= $newPostButton ?></a>
		<?= $sectionHeading ?>
	</h2>
	<div class="forum-content<?= $wg->User->isLoggedIn() ? '' : ' forum-invisible' ?>">
		<?= $content ?>
	</div>
</section>
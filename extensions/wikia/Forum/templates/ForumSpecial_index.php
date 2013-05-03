<section id="Forum" class="Forum">
		<a class="button policies-link" href="#"><?= wfMsg('forum-specialpage-policies') ?></a>
	<!-- Admin Edit here -->
	<?= $app->renderPartial('ForumSpecial', 'boards', array('boards' => $boards, 'lastPostByMsg' => $lastPostByMsg, 'isEditMode' => false ) ) ?>

	<? if($canEdit): ?>
		<a class="button admin-link" href="<?= $editUrl ?>"><?= wfMsg('forum-admin-link-label') ?></a>
	<? endif; ?>
	<h3>
		<?= $blurbHeading ?>
	</h3>
	<section class="blurb">
		<?= $blurb ?>
	</section>
</section>

<? if($showOldForumLink): ?>
	<a href="<?= $oldForumLink ?>"> <?= wfMsg('forum-specialpage-oldforum-link'); ?></a>
<? endif; ?>

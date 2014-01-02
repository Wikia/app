<section id="Forum" class="Forum">
		<a class="button policies-link" href="#"><?= wfMessage( 'forum-specialpage-policies' )->escaped() ?></a>
	<!-- Admin Edit here -->
	<?= $app->renderPartial('ForumSpecial', 'boards', array('boards' => $boards, 'lastPostByMsg' => $lastPostByMsg, 'isEditMode' => false ) ) ?>

	<? if($canEdit): ?>
		<a class="button admin-link" href="<?= $editUrl ?>"><?= wfMessage( 'forum-admin-link-label' )->escaped() ?></a>
	<? endif; ?>
	<h3>
		<?= $blurbHeading ?>
	</h3>
	<section class="blurb">
		<?= $blurb ?>
	</section>
</section>

<? if($showOldForumLink): ?>
	<a href="<?= $oldForumLink ?>"> <?= wfMessage( 'forum-specialpage-oldforum-link' )->escaped(); ?></a>
<? endif; ?>

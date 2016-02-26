<section id="Forum" class="Forum">
		<a class="button policies-link" href="#"><?= wfMessage( 'forum-specialpage-policies' )->escaped() ?></a>
	<!-- Admin Edit here -->
	<?= $app->renderPartial( 'ForumSpecial', 'boards', [ 'boards' => ${ForumConst::boards}, 'lastPostByMsg' => ${ForumConst::lastPostByMsg}, 'isEditMode' => false ] ) ?>

	<? if ( ${ForumConst::canEdit} ): ?>
		<a class="button admin-link" href="<?= ${ForumConst::editUrl} ?>"><?= wfMessage( 'forum-admin-link-label' )->escaped() ?></a>
	<? endif; ?>
	<h3>
		<?= ${ForumConst::blurbHeading} ?>
	</h3>
	<section class="blurb">
		<?= ${ForumConst::blurb} ?>
	</section>
</section>

<? if ( ${ForumConst::showOldForumLink} ): ?>
	<a href="<?= ${ForumConst::oldForumLink} ?>"> <?= wfMessage( 'forum-specialpage-oldforum-link' )->escaped(); ?></a>
<? endif; ?>

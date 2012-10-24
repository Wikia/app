<section id="Forum" class="Forum">
	<!-- Admin Edit here -->
	<h3>
		<?= $blurbHeading ?>
	</h3>
	<section class="blurb">
		<?= $blurb ?>
	</section>
	<?= $app->renderPartial('ForumSpecial', 'boards', array('boards' => $boards, 'lastPostByMsg' => $lastPostByMsg, 'isEditMode' => false ) ) ?>
</section>


<? if($showOldForumLink): ?>
	<a href="<?= $oldForumLink ?>"> <?= wfMsg('forum-specialpage-oldforum-link'); ?></a>
<? endif; ?>

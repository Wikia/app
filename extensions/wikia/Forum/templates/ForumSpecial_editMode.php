<section id="ForumBoardEdit" class="Forum ForumBoardEdit">
	<header>
		<button id="CreateNewBoardButton" class="create-new-board-button">
			<?= wfMsg('forum-admin-create-new-board-label') ?>
		</button>
		<div class="BreadCrumbs">
			<a href="<?= $wg->Title->getLocalUrl() ?>"><?= wfMsg('forum-forum-title') ?></a>
			<span class="separator">&gt;</span>
			<?= wfMsg('forum-admin-page-breadcrumb') ?>
		</div>
	</header>
	<div class="box">For easier editing, you can see included templates in edit mode.</div>
	<?= $app->renderPartial('ForumSpecial', 'boards', array('boards' => $boards, 'isEditMode' => true ) ) ?>
</section>

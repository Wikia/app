<section id="ForumBoardEdit" class="Forum ForumBoardEdit">
	<header>
		<button id="CreateNewBoardButton" class="create-new-board-button">
			<?= $wf->Msg('forum-admin-create-new-board-label') ?>
		</button>
		<div class="BreadCrumbs">
			<a href="<?= $wg->Title->getLocalUrl() ?>"><?= $wf->Msg('forum-forum-title') ?></a>
			<span class="separator">&gt;</span>
			<?= $wf->Msg('forum-admin-page-breadcrumb') ?>
		</div>
	</header>
	<?= $app->renderPartial('ForumSpecial', 'boards', array('boards' => $boards, 'isEditMode' => true ) ) ?>
</section>
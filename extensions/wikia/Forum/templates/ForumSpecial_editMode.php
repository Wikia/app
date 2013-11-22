<section id="ForumBoardEdit" class="Forum ForumBoardEdit">
	<header>
		<button id="CreateNewBoardButton" class="create-new-board-button">
			<?= wfMessage( 'forum-admin-create-new-board-label' )->escaped() ?>
		</button>
		<div class="BreadCrumbs">
			<a href="<?= $wg->Title->getLocalUrl() ?>"><?= wfMessage( 'forum-forum-title' )->escaped() ?></a>
			<span class="separator">&gt;</span>
			<?= wfMessage( 'forum-admin-page-breadcrumb' )->escaped() ?>
		</div>
	</header>
	<?= $app->renderPartial('ForumSpecial', 'boards', array('boards' => $boards, 'isEditMode' => true ) ) ?>
</section>

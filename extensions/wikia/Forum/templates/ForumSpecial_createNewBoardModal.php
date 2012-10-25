<section id="CreateNewBoardModal" class="CreateNewBoardModal">
	<h1><?= $wf->Msg('forum-admin-create-new-board-modal-heading') ?></h1>

<?
	$form = array(
		'inputs' => array(
			array(
				'type' => 'text',
				'name' => 'boardTitle',
				'isRequired' => true,
				'label' => wfMsg('forum-admin-create-new-board-title')
			),
			array(
				'type' => 'text',
				'name' => 'boardDescription',
				'isRequired' => true,
				'label' => wfMsg('forum-admin-create-new-board-description')
			),
		),
		'method' => 'post',
		'action' => '',
	);

	echo $app->renderView('WikiaStyleGuideForm', 'index', array('form' => $form));
?>
	
	<div class="neutral modalToolbar">
		<button class="secondary cancel">
			<?= $wf->Msg('cancel') ?>
		</button>
		<button class="submit">
			<?= $wf->Msg('forum-admin-create-new-board-label') ?>
		</button>
	</div>
</section>
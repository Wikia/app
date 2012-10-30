<section id="EditBoardModal" class="EditBoardModal">
	<h1>
		<?= $wf->Msg('forum-admin-edit-board-modal-heading', $boardTitle) ?>
	</h1>

<?
	$form = array(
		'inputs' => array(
			array(
				'type' => 'text',
				'name' => 'boardTitle',
				'value' => $boardTitle,
				'isRequired' => true,
				'label' => wfMsg('forum-admin-edit-board-title'),
			),
			array(
				'type' => 'text',
				'name' => 'boardDescription',
				'value' => $boardDescription,
				'isRequired' => true,
				'label' => wfMsg('forum-admin-edit-board-description')
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
			<?= $wf->Msg('save') ?>
		</button>
	</div>
</section>
<section id="EditBoardModal" class="EditBoardModal">
	<h1>
		<?= wfMessage( 'forum-admin-create-new-board-modal-heading' )->escaped() ?>
	</h1>

<?
	$form = array(
		'inputs' => array(
			array(
				'type' => 'text',
				'name' => 'boardTitle',
				'isRequired' => true,
				'label' => wfMessage( 'forum-admin-create-new-board-title' )->escaped(),
				'attributes' => array(
					'maxlength' => '40'
				),
			),
			array(
				'type' => 'text',
				'name' => 'boardDescription',
				'isRequired' => true,
				'label' => wfMessage( 'forum-admin-create-new-board-description' )->escaped(),
				'attributes' => array(
					'maxlength' => '255'
				),
			),
		),
		'method' => 'post',
		'action' => '',
	);

	echo $app->renderView('WikiaStyleGuideForm', 'index', array('form' => $form));
?>

	<div class="neutral modalToolbar">
		<button class="secondary cancel">
			<?= wfMessage( 'cancel' )->escaped() ?>
		</button>
		<button class="submit">
			<?= wfMessage( 'forum-admin-create-new-board-label' )->escaped() ?>
		</button>
	</div>
</section>

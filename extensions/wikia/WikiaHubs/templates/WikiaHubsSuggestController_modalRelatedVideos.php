<div class="WikiaHubsModal VideoSuggestModal">
	<h1><?= wfMsg('wikiahubs-suggest-video-header') ?></h1>
<?
	$form = array(
		'class' => 'WikiaHubs',
		'inputs' => array(
			array(
				'class' => 'videourl',
				'type' => 'text',
				'name' => 'videourl',
				'isRequired' => true,
				'label' => wfMsg('wikiahubs-suggest-video-what-video'),
				'attributes' => array(
					'placeholder' => wfMsg('wikiahubs-suggest-video-what-video-default-value')
				)
			),
			array(
				'class' => 'wikiname',
				'type' => 'text',
				'name' => 'wikiname',
				'isRequired' => true,
				'label' => wfMsg('wikiahubs-suggest-video-which-wiki'),
				'attributes' => array(
					'placeholder' => wfMsg('wikiahubs-suggest-video-what-video-default-value')
				)
			),
			array(
				'class' => 'submit-button',
				'type' => 'custom',
				'output' => '<button class="wikia-button secondary cancel" >'.wfMsg('wikiahubs-button-cancel').'</button>'.
							'<button class="wikia-button submit" disabled="disabled" >'.wfMsg('wikiahubs-suggest-video-submit-button').'</button>',
			),
		),
	);

	$form['isInvalid'] = !empty($result) && !empty($msg);
	$form['errorMsg'] = !empty($msg) ? $msg : '';

	echo F::app()->renderView( 'WikiaStyleGuideForm', 'index', array('form' => $form) );

?>

	<div class="close-button">
		<button class="wikia-button close"><?= wfMsg( 'wikiahubs-button-close' ) ?></button>
	</div>
</div>
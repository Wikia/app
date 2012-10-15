<div class="scavenger-clue-text">
	<div><?= $game->getEntryFormText() ?></div>
</div>
<form class="scavenger-entry-form">
<?
	$question = $game->getEntryFormQuestion();
	if ( !empty( $question ) ) { ?>
	<div class="scavenger-clue-question">
		<?= $game->getEntryFormQuestion() ?>
	</div>
	<textarea name="answer"></textarea>
	<? }
	$username = $game->getEntryFormUsername();
	if ( !empty( $username ) ){ ?>
		<label for="name"><?= $username ?></label>
		<input type="text" name="name" />
	<? }
	$email = $game->getEntryFormEmail();
	if ( !empty( $email ) ){ ?>
		<label for="email"><?= $email ?></label>
		<input type="text" name="email" />
	<? } ?>
	<div id="scavenger-form-clue-submit-button" class="scavenger-clue-button">
		<input type="submit" class="wikia-button" value="<?=$game->getEntryFormButtonText(); ?>"/>
	</div>
</form>
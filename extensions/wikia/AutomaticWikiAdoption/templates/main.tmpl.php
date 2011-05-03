<section class="AutomaticWikiAdoption">
	<section class="AutomaticWikiAdoptionInfo">
		<h1><?= wfMsg('wikiadoption-header') ?></h1>
		<p><?= wfMsg('wikiadoption-description', $username) ?></p>
		<section class="AutomaticWikiAdoptionButtonAdopt">
			<form action="<?= $formAction ?>" method="post">
				<button type="submit" id="automatic-wiki-adoption-button-adopt">
					<?= wfMsg('wikiadoption-button-adopt') ?>
				</button>
			</form>
		</section>
	</section>
</section>
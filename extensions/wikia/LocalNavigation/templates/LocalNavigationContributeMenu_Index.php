<section id="contributeEntryPoint" class="contribute-container">
	<div class="contribute-button"><?= wfMessage('oasis-button-contribute-tooltip')->text() ?></div>
	<ul class="dropdown contribute">
<?php foreach( $dropdownItemsRender as $attributes ): ?>
		<li>
			<a <?= $attributes[ 'attributes' ] ?>>
				<span><?= $attributes[ 'text' ] ?></span>
			</a>
		</li>
<?php endforeach; ?>
	</ul>
</section>

<section class="contribute-container">
	<div id="contributeEntryPoint" class="contribute-inner-container">
		<div class="contribute-button"><?= wfMessage('oasis-button-contribute-tooltip')->text() ?></div>
		<ul id="contributeDropdown" class="dropdown">
<?php foreach( $dropdownItemsRender as $attributes ): ?>
			<li>
				<a <?= $attributes[ 'attributes' ] ?>>
					<span><?= $attributes[ 'text' ] ?></span>
				</a>
			</li>
<?php endforeach; ?>
		</ul>
	</div>
</section>

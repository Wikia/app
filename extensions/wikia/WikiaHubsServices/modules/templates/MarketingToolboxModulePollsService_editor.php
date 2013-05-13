<div class="module-polls">
    <div class="grid-4 alpha">
		<?=$form->renderField('pollsTitle')?>
	</div>
    <div class="grid-4 alpha wide">
		<?=$form->renderField('pollsQuestion')?>
    </div>

    <div class="grid-3 alpha wide">
		<? for ($i = 1; $i <= $optionsLimit; $i++): ?>
			<?=$form->renderField('pollsOption' . $i)?>
		<? endfor; ?>
    </div>
</div>

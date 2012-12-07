<div class="grid-4 alpha wide">
	<?=F::app()->renderView(
	'MarketingToolbox',
	'FormField',
	array('inputData' => $fields['boardTitle'])
);
	?>
	<?=F::app()->renderView(
	'MarketingToolbox',
	'FormField',
	array('inputData' => $fields['boardDescription'])
);
	?>
</div>

<div class="grid-4 alpha wide">
	<ol class="alternative">
		<? foreach ($list as $wikiTitle): ?>
			<li><span><?=$wikiTitle?></span></li>
		<? endforeach ?>
	</ol>
</div>
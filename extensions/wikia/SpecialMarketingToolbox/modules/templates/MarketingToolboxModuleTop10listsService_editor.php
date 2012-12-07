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
		<li><span>jeden</span></li>
		<li><span>dwa</span></li>
		<li><span>czy</span></li>
		<li><span>cztery</span></li>
	</ol>
</div>
<noinclude>
<?= wfMessage('portable-infobox-builder-documentation-example-usage')->inContentLanguage()->escaped(); ?>
<pre>
{{<?= $title ?><?php foreach($sources as $source): ?>

|<?= $source ?>=<?= wfMessage('portable-infobox-builder-documentation-example-param')->inContentLanguage()->escaped(); ?><?php endforeach; ?>

}}
</pre>
</noinclude>

<noinclude>
<?= wfMessage('portable-infobox-builder-documentation-example-usage')->escaped(); ?>
<pre>
{{<?= $title ?><?php foreach($sources as $source): ?>

|<?= $source ?>=<?= wfMessage('portable-infobox-builder-documentation-example-param')->escaped(); ?><?php endforeach; ?>

}}
</pre>
</noinclude>

<h1><?php echo $header; ?></h1>
<p>This is an <strong>Example Extension</strong> helloWorld Template!</p>
<br />
Wiki data:<br />
<ul>
	<li><strong>Title:</strong> <?= $wikiData['title']; ?></li>
	<li><strong>Url:</strong> <a href="<?= $wikiData['url']; ?>"><?= $wikiData['url']; ?></a></li>
</ul>

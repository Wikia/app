<h1><?=$header?></h1>
<p>This is the <strong>HelloWorldSpecial_index</strong> Template!</p>
Wiki Data:<br />
<ul>
	<li><strong>Title: </strong><?=$wikiData['title']?></li>
	<li>
	<strong>URL: </strong>
	<a href="<?= $wikiData['url'] ?>" target="_blank"><?=$wikiData['url']?></a>
	</li>
</ul>

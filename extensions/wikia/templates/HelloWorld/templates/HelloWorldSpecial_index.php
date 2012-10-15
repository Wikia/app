<h1><?= $header ?></h1>
<p>This is the <strong>HelloWorld_Hello</strong> Template!</p>
<br>
Helper Controller data:<br>
<ul>
	<li><strong>Title:</strong> <?= $helperData['title'] ?></li>
	<li><strong>Url:</strong> <a href="<?= $helperData['url'] ?>"><?= $helperData['url'] ?></a></li>
</ul>

<div id="HelloWorldAjax" class="HelloWorldAjax">
	<button>Get some Ajax!</button>
</div>
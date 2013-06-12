<div class="css-editor">
	<form>
		<textarea class="css-editor-textarea"><?= $cssContent; ?></textarea>
	</form>
</div>
<aside class="css-side-bar">
	<div class="version-box">
		<?= wfMessage('special-css-current-version')->rawParams(['1.0.17'])->text(); ?>
	</div>
	<div class="community-updates">
		<h3><?= wfMessage('special-css-community-update-headline')->text(); ?></h3>
		<ul>
			<?php foreach( $cssBlogs as $cssUpdatePost ): ?>
			<li class="community-update-item plainlinks">
				<?= $cssUpdatePost['userAvatar']; ?>
				<h4><a href="<?= $cssUpdatePost['url']; ?>"><?= $cssUpdatePost['title']; ?></a></h4>
				<span><?= wfMessage('special-css-community-update-by')->params([$cssUpdatePost['timestamp'], $cssUpdatePost['userUrl'], $cssUpdatePost['userName']])->parse(); ?></span>
				<blockquote><?= $cssUpdatePost['text']; ?></blockquote>
				<p class="read-more"><?= wfMessage('special-css-community-read-more')->params([$cssUpdatePost['url']])->parse(); ?></p>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
</aside>
<footer class="css-footer">
	<input class="big" type="submit" value="<?= wfMessage('special-css-publish-button')->escaped(); ?>" />
</footer>

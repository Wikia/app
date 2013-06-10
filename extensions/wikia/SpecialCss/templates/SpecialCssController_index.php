<div class="css-editor">
	<form>
		<textarea class="css-editor-textarea"><?= $cssContent; ?></textarea>
	</form>
</div>
<aside class="css-side-bar">
	<div class="version-box">
		<?= wfMessage('special-css-current-version')->rawParams(['1.0.17'])->text(); ?>
		<ul>
		<? foreach ( $cssBlogs as $blog ): ?>
			<li><a href="<? echo $blog['blogUrl'] ?>"><? echo $blog['title'] ?></a></li>
		<? endforeach ?>
		</ul>
	</div>
</aside>
<footer class="css-footer">
	<input class="big" type="submit" value="<?= wfMessage('special-css-publish-button')->escaped(); ?>" />
</footer>

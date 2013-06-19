<div class="css-editor">
	<form>
		<textarea class="css-editor-textarea"><?= $cssContent; ?></textarea>
	</form>
</div>
<aside class="css-side-bar">
	<?php if( !empty($cssUpdates) ): ?>
	<div class="community-updates">
		<h3><?= wfMessage('special-css-community-update-headline')->text(); ?></h3>
		<ul class="community-updates-list">
			<?php foreach( $cssUpdates as $cssUpdate ): ?>
			<li class="community-update-item plainlinks">
				<?= $cssUpdate['userAvatar']; ?>
				<h4><a href="<?= $cssUpdate['url']; ?>"><?= $cssUpdate['title']; ?></a></h4>
				<span><?= wfMessage('special-css-community-update-by')->params([$cssUpdate['timestamp'], $cssUpdate['userUrl'], $cssUpdate['userName']])->parse(); ?></span>
				<blockquote><?= $cssUpdate['text']; ?></blockquote>
				<p class="read-more"><?= wfMessage('special-css-community-read-more')->params([$cssUpdate['url']])->parse(); ?></p>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<ul class="education-links">
		<li>
			<h2>
				<a href="" title="<?= wfMessage('special-css-education-item-webinars-header')->text(); ?>">
					<?= wfMessage('special-css-education-item-webinars-header')->text(); ?>
				</a>
			</h2>
			<p><?= wfMessage('special-css-education-item-webinars-paragraph')->text(); ?></p>
		</li>
		<li>
			<h2>
				<a href="" title="<?= wfMessage('special-css-education-item-help-header')->text(); ?>">
					<?= wfMessage('special-css-education-item-help-header')->text(); ?>
				</a>
			</h2>
			<p><?= wfMessage('special-css-education-item-help-paragraph')->text(); ?></p>
		</li>
		<li>
			<h2>
				<a href="" title="<?= wfMessage('special-css-education-item-com-center-header')->text(); ?>">
					<?= wfMessage('special-css-education-item-com-center-header')->text(); ?>
				</a>
			</h2>
			<p><?= wfMessage('special-css-education-item-com-center-paragraph')->text(); ?></p>
		</li>
	</ul>
	<?php endif; ?>
</aside>
<footer class="css-footer">
	<input class="big" type="submit" value="<?= wfMessage('special-css-publish-button')->escaped(); ?>" />
</footer>

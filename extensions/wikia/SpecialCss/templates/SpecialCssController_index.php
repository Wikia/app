<div class="css-editor">
	<form>
		<textarea class="css-editor-textarea"><?= $cssContent; ?></textarea>
	</form>
</div>
<aside class="css-side-bar">
	<?php if( !empty($cssUpdates) ): ?>
	<div class="community-updates widget-box">
		<h2><?= wfMessage('special-css-community-update-headline')->text(); ?></h2>
		<ul class="community-updates-list">
			<?php foreach( $cssUpdates as $cssUpdate ): ?>
			<li class="community-update-item plainlinks">
				<?= $cssUpdate['userAvatar']; ?>
				<h4><a href="<?= $cssUpdate['url']; ?>"><?= $cssUpdate['title']; ?></a></h4>
				<span><?= wfMessage('special-css-community-update-by')->params([$cssUpdate['timestamp'], $cssUpdate['userUrl'], $cssUpdate['userName']])->parse(); ?></span>
				<blockquote><?= $cssUpdate['text']; ?></blockquote>
				<?= wfMessage('special-css-community-read-more')->params([$cssUpdate['url']])->parse(); ?>
			</li>
			<?php endforeach; ?>
		</ul>
		<a href="" title="<?= wfMessage('special-css-community-update-see-all')->text(); ?>" class="see-all-link"><?= wfMessage('special-css-community-update-see-all')->text(); ?></a>
	</div>
	<ul class="education-links">
		<li class="widget-box">
			<h2>
				<a href="http://community.wikia.com/wiki/File:Intro_to_CSS_%26_Your_Wiki_Webinar" title="<?= wfMessage('special-css-education-item-webinars-header')->text(); ?>">
					<?= wfMessage('special-css-education-item-webinars-header')->text(); ?>
				</a>
			</h2>
			<p><?= wfMessage('special-css-education-item-webinars-paragraph')->text(); ?></p>
		</li>
		<li class="widget-box">
			<h2>
				<a href="http://community.wikia.com/wiki/Help:CSS" title="<?= wfMessage('special-css-education-item-help-header')->text(); ?>">
					<?= wfMessage('special-css-education-item-help-header')->text(); ?>
				</a>
			</h2>
			<p><?= wfMessage('special-css-education-item-help-paragraph')->text(); ?></p>
		</li>
		<li class="widget-box">
			<h2>
				<a href="http://community.wikia.com/wiki/Board:Support_Requests_-_Designing_Your_Wiki" title="<?= wfMessage('special-css-education-item-com-center-header')->text(); ?>">
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

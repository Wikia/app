<div class="message-topic input-group">
	<label for="MessageTopicInput"><?= wfMsg('wall-topic-input-heading') ?></label>
	<input type="text" name="message-topic" class="message-topic-input" id="MessageTopicInput" placeholder="<?= wfMsg('wall-topic-input-placeholder') ?>">
	<div class="message-topic-error">
	</div>
	<ul class="message-topic-list">
	</ul>
	<script id="MessageTopicTemplate" type="text/template">
		<li data-article-title="{{articleTitle}}" class="topic">
			{{articleTitle}}
			<span class="remove-swatch sprite close"></span>
		</li>
	</script>
	<script id="MessageTopicErrorTemplate" type="text/template">
		<?= wfMsg('wall-topic-input-error', '{{query}}') ?>
	</script>
	<script id="MessageTopicErrorLimitTemplate" type="text/template">
		<?= wfMsg('wall-topic-input-error-limit', '{{limit}}') ?>
	</script>
</div>
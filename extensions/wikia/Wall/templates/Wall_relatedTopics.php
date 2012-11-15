<h4 class="related-topics-heading"><?= wfMsg('wall-topic-heading') ?></h4>
<ul class="related-topics">
<?php foreach ($relatedTopics as $val): ?>
	<li class="related-topic" data-topic="<?= $val->getText() ?>">
		<a href="<?php echo WallHelper::getTopicPageURL($val); ?>">
			<?= $val->getText() ?>
		</a>
	</li>
<?php endforeach; ?>
	<script id="RelatedTopicTemplate" type="text/template">
		{{#topics}}
			<li class="related-topic" data-topic="{{topic}}">
				<a href="{{url}}">
					{{topic}}
				</a>
			</li>
		{{/topics}}
	</script>
	<li class="edit-topic">
		<a href="#" class="edit-topic-link">
			<img src="<?= $wg->BlankImgUrl ?>" class="sprite edit-pencil">
			<?= wfMsg('wall-topic-edit') ?>
		</a>
	</li>
</ul>
<div class="message-topic-edit">
	<?= F::app()->renderPartial( 'Wall', 'messageTopic') ?>
	<button class="save-button">Save</button>
	<button class="secondary cancel-button">Cancel</button>
</div>
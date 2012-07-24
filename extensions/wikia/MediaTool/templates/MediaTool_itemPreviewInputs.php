{{{itemPreview}}}
<div class="media-item-details">
	<div class="file-details">
		<h4><?= wfMsg('mediatool-file-details'); ?></h4>
		<label><?= wfMsg('mediatool-file-name'); ?></label><br/>
		<input name="{{itemId}}-name" class="media-tool-item-name" value="{{itemName}}" {{#cannotEditName}}readonly="readonly"{{/cannotEditName}}/><br/>
		<label><?= wfMsg('mediatool-file-description'); ?></label><br/>
		<textarea name="{{itemId}}-description" rows="4" class="media-tool-item-description">{{itemDescription}}</textarea><br/>
		{{#canFollow}}<input name="{{itemId}}-follow" class="media-tool-item-follow" type="checkbox" {{#itemIsFollowed}}checked="checked"{{/itemIsFollowed}}/><label><?= wfMsg('mediatool-follow-media'); ?></label>{{/canFollow}}

	</div>
	<div class="article-details">
		<h4><?= wfMsg('mediatool-article-details'); ?></h4>
		<label><?= wfMsg('mediatool-media-caption'); ?></label><br/>
		<input name="{{itemId}}-caption" value="{{itemCaption}}" class="media-tool-item-caption" />
	</div>
</div>

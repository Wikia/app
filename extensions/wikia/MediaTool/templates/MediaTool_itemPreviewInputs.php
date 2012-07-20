{{{itemPreview}}}
<div class="media-item-details">
	<div class="file-details">
		<h4><?= wfMsg('mediatool-file-details'); ?></h4>
		<label><?= wfMsg('mediatool-file-name'); ?></label><br/>
		<input name="{{itemId}}-name" value="{{itemName}}" {{#canEditName}}disabled="disabled"{{/canEditName}}/><br/>
		<label><?= wfMsg('mediatool-file-description'); ?></label><br/>
		<textarea name="{{itemId}}-description" rows="4">{{itemDescription}}</textarea><br/>
		{{#canFollow}}<input name="{{itemId}}-follow" type="checkbox" {{#itemIsFollowed}}checked="checked"{{/itemIsFollowed}}/><label><?= wfMsg('mediatool-follow-media'); ?></label>{{/canFollow}}

	</div>
	<div class="article-details">
		<h4><?= wfMsg('mediatool-article-details'); ?></h4>
		<label><?= wfMsg('mediatool-media-caption'); ?></label><br/>
		<input name="{{itemId}}-caption" value="{{itemCaption}}" />
	</div>
</div>

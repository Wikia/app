<div class="float-title">{{title}}</div>

<ul id="mediaToolItemList" class="mediaToolItemList ui-helper-reset ui-helper-clearfix">
	{{#items}}
	<li class="ui-widget-content{{#video}} video{{/video}}" data-id="{{id}}">
		{{{thumbHtml}}}
	</li>
	{{/items}}
</ul>

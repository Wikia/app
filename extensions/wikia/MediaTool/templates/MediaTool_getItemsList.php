<script id="mediaToolBasketTemplate" type="text/template">
	<div class="float-title">{{title}}</div>

	<ul id="mediaToolItemList" class="media-tool-item-list ui-helper-reset ui-helper-clearfix">
		{{#items}}
		 {{> item }}
		{{/items}}
	</ul>
</script>

<script id="mediaToolBasketItemTemplate" type="text/template">
	<li class="ui-widget-content{{#isVideo}} video{{/isVideo}}" data-id="{{id}}">
		{{{thumbHtml}}}
	</li>
</script>
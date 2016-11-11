define('wikia.toc.mustache', function () {
	'use strict';

	return '{{#sections}}<li class="{{class}}">\
		<a href="#{{id}}" rel="nofollow">{{title}}</a>\
		{{#wrapper}}{{#sections}}\
		<li class="{{class}}">\
			<a href="#{{id}}" rel="nofollow">{{title}}</a>\
			{{#wrapper}}{{#sections}}\
			<li class="{{class}}">\
				<a href="#{{id}}" rel="nofollow">{{title}}</a>\
				{{#wrapper}}{{#sections}}\
				<li class="{{class}}">\
					<a href="#{{id}}" rel="nofollow">{{title}}</a>\
					{{#wrapper}}{{#sections}}\
					<li class="{{class}}">\
						<a href="#{{id}}" rel="nofollow">{{title}}</a>\
						{{#wrapper}}{{#sections}}\
						<li class="{{class}}">\
							<a href="#{{id}}" rel="nofollow">{{title}}</a>\
						</li>\
						{{/sections}}{{/wrapper}}\
					</li>\
					{{/sections}}{{/wrapper}}\
				</li>\
				{{/sections}}{{/wrapper}}\
			</li>\
			{{/sections}}{{/wrapper}}\
		</li>\
		{{/sections}}{{/wrapper}}\
	</li>{{/sections}}';
});

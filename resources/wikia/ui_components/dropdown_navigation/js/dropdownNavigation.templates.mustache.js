define( 'wikia.dropdownNavigation.templates', [], function() { 'use strict'; return {
    "dropdown_navigation" : '<ul id="{{id}}" class="wikia-dropdown-nav {{posX}} {{posY}} {{#scrollX}}scroll-x{{/scrollX}}{{#classes}}{{.}}{{/classes}}" {{#maxHeight}}style="max-height: {{maxHeight}}px;"{{/maxHeight}}>{{#data}}<li><a href="{{id}}" title="{{title}}" rel="nofollow">{{title}} data-unique-id="{{uniqueId}}"</a></li>{{/data}}</ul>',
    "done": "true"
  }; });
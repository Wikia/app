define( 'ext.wikia.recirculation.templates.mustache', [], function() { 'use strict'; return {
    "inContent.client" : '<div class="recirculation-incontent"><h3>{{ title }}:</h3>{{#items}}<div class="item"><a title={{ title }} href="{{ url }}"><div class="thumbnail"><img src="{{ thumbnail }}" /></div><h4>{{ title }}</h4></a></div>{{/items}}</div>',
    "done": "true"
  }; });
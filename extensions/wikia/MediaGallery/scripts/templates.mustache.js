define( 'mediaGallery.templates.mustache', [], function() { 'use strict'; return {
    "MediaGalleryController_gallery" : '<div class="media-gallery-wrapper count-{{count}}" data-count="{{count}}">{{#media}}<div class="media"><img src="{{src}}"></div>{{/media}}</div>',
    "MediaGalleryController_showMore" : '<div class="more"><button class="primary show">{{showMore}}</button><button class="secondary hide">{{showLess}}</button></div>',
    "done": "true"
  }; });
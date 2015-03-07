define( 'mediaGallery.templates.mustache', [], function() { 'use strict'; return {
    "MediaGallery_gallery" : '<div class="media-gallery-wrapper count-{{count}}" data-visible-count="{{visibleCount}}" data-model="{{json}}" data-expanded="{{expanded}}"><button class="add-image">{{addImageButton}}</button><noscript>{{#media}}<a href="{{linkHref}}"><img src="{{thumbUrl}}" alt="{{{caption}}}"></a>{{/media}}</noscript></div>',
    "MediaGallery_media" : '{{{thumbHtml}}}{{#caption}}<div class="media-gallery-caption"><div class="inner">{{{caption}}}</div></div>{{/caption}}',
    "MediaGallery_showMore" : '<button class="primary show">{{showMore}}</button><button class="secondary hide hidden">{{showLess}}</button>',
    "done": "true"
  }; });
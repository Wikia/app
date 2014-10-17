/*!
 * VisualEditor ContentEditable WikiaGalleryNode class.
 */

/**
 * ContentEditable Wikia gallery node.
 *
 * @class
 * @extends ve.ce.MWBlockExtensionNode
 * @mixins ve.ce.FocusableNode
 *
 * @constructor
 * @param {ve.dm.WikiaGalleryNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.WikiaGalleryNode = function VeCeWikiaGalleryNode( model, config ) {
	// Parent constructor
	ve.ce.WikiaGalleryNode.super.call( this, model, config );

	// Mixin constructors
	ve.ce.FocusableNode.call( this );

	// TODO: Add the data-model attribute with the JSON for gallery rendering
	/*
	<div class="media-gallery-wrapper count-1" data-visible-count="8"
	data-model="[{&quot;thumbUrl&quot;:&quot;http:\/\/vignette1.wikia.nocookie.net\/lizlux\/4\/40\/Baby-pandas-looking-cute.jpg\/revision\/latest\/zoom-crop\/width\/480\/height\/480?cb=20140813230640&quot;,&quot;thumbHtml&quot;:&quot;\n&lt;a href=\&quot;\/wiki\/File:Baby-pandas-looking-cute.jpg\&quot;\n\tclass=\&quot;image image-thumbnail\&quot;\n\t\n\t\n\t&gt;\n\n\n\t\n\t\t&lt;picture&gt;\n\n\t\n\t&lt;source\n\t\tmedia=\&quot;(max-width: 1024px)\&quot;\n\t\tsrcset=\&quot;http:\/\/vignette4.wikia.nocookie.net\/lizlux\/4\/40\/Baby-pandas-looking-cute.jpg\/revision\/latest\/zoom-crop\/width\/384\/height\/384?cb=20140813230640&amp;amp;format=webp\&quot;\n\t\ttype=\&quot;image\/webp\&quot;&gt;\n\t&lt;source\n\t\tmedia=\&quot;(max-width: 1024px)\&quot;\n\t\tsrcset=\&quot;http:\/\/vignette2.wikia.nocookie.net\/lizlux\/4\/40\/Baby-pandas-looking-cute.jpg\/revision\/latest\/zoom-crop\/width\/384\/height\/384?cb=20140813230640\&quot;&gt;\n\n\t\n\t&lt;source\n\t\tsrcset=\&quot;http:\/\/vignette3.wikia.nocookie.net\/lizlux\/4\/40\/Baby-pandas-looking-cute.jpg\/revision\/latest\/zoom-crop\/width\/480\/height\/480?cb=20140813230640&amp;amp;format=webp\&quot;\n\t\ttype=\&quot;image\/webp\&quot;&gt;\n\t&lt;source\n\t\tsrcset=\&quot;http:\/\/vignette1.wikia.nocookie.net\/lizlux\/4\/40\/Baby-pandas-looking-cute.jpg\/revision\/latest\/zoom-crop\/width\/480\/height\/480?cb=20140813230640\&quot;&gt;\n\n\t\n\t&lt;img src=\&quot;http:\/\/vignette1.wikia.nocookie.net\/lizlux\/4\/40\/Baby-pandas-looking-cute.jpg\/revision\/latest\/zoom-crop\/width\/480\/height\/480?cb=20140813230640\&quot;\n\t alt=\&quot;Baby-pandas-looking-cute.jpg\&quot; \n\tclass=\&quot;\&quot;\n\t\n\tdata-image-key=\&quot;Baby-pandas-looking-cute.jpg\&quot;\n\tdata-image-name=\&quot;Baby-pandas-looking-cute.jpg\&quot;\n\t\n\t\n\t\n\t\n\t\n\t\n\t&gt;\n\n\n&lt;\/picture&gt;\n\n\t\n\t\n\n\t\n\n\t\n\n\n&lt;\/a&gt;\n\n&quot;,&quot;caption&quot;:&quot;Actually a tiger&quot;,&quot;linkHref&quot;:&quot;\/wiki\/File:Baby-pandas-looking-cute.jpg&quot;,&quot;title&quot;:&quot;Baby-pandas-looking-cute.jpg&quot;,&quot;dbKey&quot;:&quot;Baby-pandas-looking-cute.jpg&quot;}]" data-expanded="0"> 	<button class="add-image">Add an image</button> 	<noscript> 		 			<a href="/wiki/File:Baby-pandas-looking-cute.jpg"><img src="http://vignette1.wikia.nocookie.net/lizlux/4/40/Baby-pandas-looking-cute.jpg/revision/latest/zoom-crop/width/480/height/480?cb=20140813230640" alt="Actually a tiger"></a> 		 	</noscript> </div>
	*/

	this.$element.addClass( 'media-gallery-wrapper' );
	this.$element.html('');
};

/* Inheritance */

OO.inheritClass( ve.ce.WikiaGalleryNode, ve.ce.BranchNode );

OO.mixinClass( ve.ce.WikiaGalleryNode, ve.ce.FocusableNode );

OO.mixinClass( ve.ce.WikiaGalleryNode, ve.ce.GeneratedContentNode );

/* Static Properties */

ve.ce.WikiaGalleryNode.static.name = 'wikiaGallery';

ve.ce.WikiaGalleryNode.static.tagName = 'div';

/* Methods */

/* Registration */

ve.ce.nodeFactory.register( ve.ce.WikiaGalleryNode );

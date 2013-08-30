ve.ce.WikiaBlockVideoNode = function VeCeWikiaBlockVideoNode( model, config ) {
	ve.ce.MWBlockImageNode.call( this, model, config );
	console.log('ve.ce.WikiaBlockVideoNode', this);
	alert(2);
};

/* Inheritance */

ve.inheritClass( ve.ce.WikiaBlockVideoNode, ve.ce.MWBlockImageNode );

/* Static Properties */

ve.ce.WikiaBlockVideoNode.static.name = 'wikiaBlockVideo';

/* Registration */

ve.ce.nodeFactory.register( ve.ce.WikiaBlockVideoNode );

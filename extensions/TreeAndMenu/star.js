window.star_config = {
	img_node: '/img/star-node-sml-gold.png',
	img_leaf: '/img/star-node-sml.png',
	img_disabled: '/img/star-node-sml-gold.png',
	radii: [120,90,40,20],
	duration: 500,
	easing: 'swing',
	out_spin: 2,
	in_spin: 2,
	width: '400px',
	height: '400px'
}

/**
 * Initalise bullet lists with class "tam-star"
 */
window.stars = [];
$( function() {
	$('div.tam-star').each( function() {
		var tree = $(this);
		var root = 'starnode' + window.stars.length;
		tree.html( '<ul><li><a href="/">root</a>' + tree.html() + '</li></ul>' );
		$('ul', tree).css('list-style','none');
		tree.css('width',window.star_config.width).css('height',window.star_config.height);

		// Change all the bullet list li's content into star nodes (divs with an image and the li content)
		$('a', this).each( function() {
			var a = $(this);
			var img = window.tamBaseUrl + window.star_config.img_leaf;
			a.wrap('div').css({
				padding: 0,
				margin: 0,
				background: 'transparent',
				color: 'black',
			});
			var div = a.parent();
			div.attr('class','starnode').html( '<div><img src="' + img + '" /></div>' + div.html() ).css({
				'text-align': 'center',
				position: 'absolute',
				display: 'none'
			});
		});

		// Position all the nodes and add their animation events
		$('div.starnode', this).each( function() {
			var e = $(this);

			// Get the depth of this element
			var li = e.parent();
			var d = 0;
			while( li[0].tagName == 'LI' ) {
				li = li.parent().parent();
				d++;
			}

			// Get the parent <a> or <div> and add item to parents children
			var p = e.parent().parent().parent();
			if( d > 1 ) {
				p = p.children().first();
				$('img', p).attr('src', window.tamBaseUrl + window.star_config.img_node);
				getData(p).children.push(e);
			}

			// Set initial position to parent
			var ox = p.position().left + p.width() / 2;
			var oy = p.position().top + p.height() / 2;
			e.css('left', ox - e.width() / 2).css('top', oy - e.height() / 2);

			// Create a unique ID and persistent data for this element
			e.attr('id', 'starnode' + window.stars.length);
			window.stars.push( {
				children: [],
				parent: p,
				depth: d,
				open: false
			});

			// Set a callback to open or close the node when clicked
			e.click( function() { animateNode(this); });
		});

		// Make the root node visible
		var e = $('#'+root);
		var data = window.stars[0];
		var p = data.parent;
		var ox = p.position().left + p.width() / 2;
		var oy = p.position().top + p.height() / 2;
		e.css('display','block').css('left',tree.left + tree.width()/2).css('top',tree.top + tree.height()/2);
	});
});

// Animate the passed node and its children from it's current state to the opposite state
function animateNode(node) {
	$(node).animate( { t: 100 }, {
		duration: window.star_config.duration,
		easing: window.star_config.easing,
		step: function(now, fx) {
			var t = fx.pos;
			var e = $(fx.elem);
			var data = getData(e);
			var display = 'block';
			var o = t * window.star_config.out_spin;

			// Set origin for the children to this elements center
			var ox = e.position().left + e.width() / 2;
			var oy = e.position().top + e.height() / 2;

			// Hide the labels during animation
			var col = t < 0.9 ? 'white' : 'black';

			// If closing flip t, and hide items at end
			if( data.open ) {
				if( t > 0.9 ) display = 'none';
				o = window.star_config.out_spin + t * window.star_config.in_spin;
				t = 1 - t;
			}

			// Current radius for this elements children
			var d = data.depth;
			var r = window.star_config.radii;
			r = d > r.length ? r[r.length-1] : r[d-1];
			r = r * t;

			// Position the children to their locations around the parent
			var k = Math.PI * 2 / data.children.length;
			for( var i in data.children ) {
				var child = data.children[i];
				var cdata = getData(child);
				var a = k * i + o;
				var x = Math.cos(a) * r;
				var y = Math.sin(a) * r;
				child.css( 'display','block' )
					.css('left', ox + x - child.width() / 2)
					.css('top', oy + y - child.height() / 2)
					.css('color', col)
					.css('display', display);
					
				// If closing, and this is the first iteration, close this child too if open
				if( data.open && fx.pos == 0 && cdata.open ) animateNode(child);
			}
		},

		// Toggle the status on completion
		complete: function() {
			var data = getData($(this));
			data.open = !data.open;
		}
	});
}

/**
 * Return the passed star node elements data array
 */
function getData(e) {
	return window.stars[e.attr('id').substr(8)];
}

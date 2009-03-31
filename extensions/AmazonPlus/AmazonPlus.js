function convertPrices() {
	return; //not yet implemented
}

function toggleReview(more, less, id) {
	var e = document.getElementById( 'shortReviewFrame' + id );
	if( !e ) return;
	var a = document.getElementById( 'shortReviewLink' + id );
	if( !a ) return;
	var b = getElementsByClassName( e, 'div', 'shortReviewBody' );
	if( !b || !b[0] ) return;
	b = b[0];
	d = b.style.display;
	if( d == 'block' ) {
		b.style.display = 'none';
		a.innerHTML = more;
	} else if( d == 'none' ) {
		b.style.display = 'block';
		a.innerHTML = less;
	}
}
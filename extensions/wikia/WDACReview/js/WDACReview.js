$(function() {

	$( '#wdac-approve-all' ).bind( 'click', function() {
		var $radios = $( "#WDACReviewForm input:radio[name^=city-]" );
		$radios.filter( '[value=1]' ).prop( 'checked', true );
	} );
	$( '#wdac-disapprove-all' ).bind( 'click', function() {
		var $radios = $( "#WDACReviewForm input:radio[name^=city-]" );
		$radios.filter( '[value=-1]' ).prop( 'checked', true );
	} );
	$( '#wdac-undetermined-all' ).bind( 'click', function() {
		var $radios = $( "#WDACReviewForm input:radio[name^=city-]" );
		$radios.filter( '[value=0]' ).prop( 'checked', true );
	});

});

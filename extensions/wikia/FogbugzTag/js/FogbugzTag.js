$(function() {
	var fogbugzTicketsNumbers = []; // stores tickets ids
	var spans =  $( 'span[class="fogbugz_tck"]' );
	for ( var i = 0; i < spans.length; i++){
		fogbugzTicketsNumbers.push( $(spans[i]).attr( 'data-id' ) );
	}
	
	$.ajax({
		url: wgScript + '?action=ajax&rs=FogbugzTag::getFogbugzServiceResponse',
		dataType: "json",
		type: "POST",
		data: {
			'IDs': fogbugzTicketsNumbers,
			'cmd': 'getCasesInfo'
			  },
		success: function(data){
			for (var i = 0; i < data.length; i++) {
				$(spans[i]).html( data[i] );
			}
		}
	});
});
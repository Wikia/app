$(function() {
	var deleteElement = function(e) {
        $(e.target).closest('li').remove();
        return false;
    };
    $('#PLBCopyLayout ul li a').click(deleteElement);
	$('#mw-input-cat_select').change(function(e) {
	    var target =  $(e.target);
	    var text = target.find('option:selected').text();    
	    var val = target.val();
	    
	    var emptyElement = $('#emptyElement');
	    emptyElement.find('span').text(text);
	    emptyElement.find('input').val(val);
	    
	    var listElement = emptyElement.clone().attr('id', '').show();
	    listElement.find('a').click(deleteElement);
	    $('#PLBCopyLayout ul').append(listElement);
	});
	
	$('#addCategory').click( function() {
		if(!confirm($('#confirm').text())) {
			return false;
		}
	});
});

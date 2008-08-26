function select_rightNow(e)
{
	selected_array = YAHOO.util.Dom.getElementsByClassName ( 'selected' , 'div' , 'rightNowLinks' );
	if ( selected_array.length > 0 )
	{
		selected_id =  selected_array[0].id;
		YAHOO.util.Dom.removeClass(selected_id , 'selected');
		YAHOO.util.Dom.addClass(this.id , 'selected');

		YAHOO.util.Dom.setStyle(selected_id + '_links', 'display', 'none');
		YAHOO.util.Dom.setStyle(this.id + '_links', 'display', 'block');

		YAHOO.Tools.setCookie('rightNow',  this.id);
	}
	YAHOO.util.Event.preventDefault(e);
}
YAHOO.util.Event.onDOMReady(function() {YAHOO.util.Event.addListener(['reading','editing','discussing','favorites','starting'], 'click', select_rightNow);});

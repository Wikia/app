var popup_number = 0;
var popup_bottom = 0;
function  popup(i__text,i__title,i__seconds){
	l__title = (typeof i__title == 'undefined') ? 'Info' : i__title;
	l__seconds = (typeof i__seconds == 'undefined') ? 5 : i__seconds;
	popup_number += 1;
	var popupid = "popup"+(new Date().getTime());
	$('body').append("<div id='"+popupid+"' class='popup' style='bottom:"+popup_bottom+"px'><h1>"+l__title+"<img popupid='"+popupid+"' class='imgpopup' src='images/cross-small.png'/></h1><p>"+i__text+"</p></div>");
	popup_bottom += parseInt($("#"+popupid).css('height'));
	$('#'+popupid).hide();
	$('#'+popupid).slideDown('normal',function(){
	});
	$('#'+popupid).click(function(){
		delete_popup(popupid);
	});
	setTimeout("delete_popup('"+popupid+"')", l__seconds*1000);
}

function delete_popup(popupid){
	popup_number -= 1;
	var last_height = parseInt($("#"+popupid).css('height'));
	var last_bottom = parseInt($("#"+popupid).css('bottom'));
	popup_bottom -= last_height;
	$('#'+popupid).slideUp('normal',function(){$('#'+popupid).remove();});
	$('.popup').each(function(){
		if(last_bottom < parseInt($(this).css('bottom'))){
			$(this).animate({bottom:'-='+last_height});
		}
	});
}
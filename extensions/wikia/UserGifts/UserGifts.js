var selected_gift = 0;

function selectGift(id){
	//un-select previously selected gift
	if (selected_gift) {
		YAHOO.util.Dom.setStyle('gift_image_' + selected_gift, 'border', "1px solid white");
	}
	
	//select new gift
	YAHOO.util.Dom.setStyle('gift_image_' + id, 'border', "1px solid red");
	
	selected_gift = id;
}

function sendGift(text)
{
	if (!selected_gift) 
	{
		alert(text);
		return false;
	}
	document.gift.gift_id.value = selected_gift;
	document.gift.submit();
}

function chooseFriend(friend){
	window.location = window.location + "&user=" + friend;	
}

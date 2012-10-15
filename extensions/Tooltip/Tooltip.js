function xstooltip_findPosX(obj) {
	var curleft = 0;
	if (obj.offsetParent) {
		while (obj.offsetParent){
			curleft += obj.offsetLeft;
			obj = obj.offsetParent;
		}
	} else if (obj.x)
		curleft += obj.x;
	return curleft - 200;
}

function xstooltip_findPosY(obj) {
	var curtop = 0;
	if (obj.offsetParent) {
		while (obj.offsetParent) {
			curtop += obj.offsetTop;
			obj = obj.offsetParent;
		}
	} else if (obj.y)
		curtop+= obj.y;
	return curtop - 25
}

function xstooltip_show(tooltipId, parentId, posX, posY) {
	it = document.getElementById(tooltipId);
	if (it.style.top == '' || it.style.top == 0) {
		if (it.style.left == '' || it.style.left == 0) {
			it.style.width = it.offsetWidth + 'px';
			it.style.height = it.offsetHeight + 'px';
			img = document.getElementById(parentId);
			x = xstooltip_findPosX(img) + posX;
			y = xstooltip_findPosY(img) + posY;
			if (x < 0 )
				x = 0;
			if (x + it.offsetWidth > img.offsetParent.offsetWidth )
				x = img.offsetParent.offsetWidth - it.offsetWidth - 1;
			it.style.top = y + 'px';
			it.style.left = x + 'px';
		}
	}
	it.style.visibility = 'visible';
}

function xstooltip_hide(id) {
	it = document.getElementById(id);
	it.style.visibility = 'hidden';
}
function getBody( html ){
	var rand = (Math.random() * Math.random() + '').slice(2),
		element = document.createElement('div');

	element.style.width = '1024px';
	element.style.height = '800px';

	if(getBody.id) document.body.removeChild(document.getElementById(getBody.id));

	element.id = rand;
	getBody.id = rand;

	if ( html ) {
		element.innerHTML = html;
	}

	document.body.appendChild(element);

	return document.getElementById(rand);
}

function fireEvent(event, element){
	var evt = document.createEvent("HTMLEvents");
	evt.initEvent(event, true, true); // event type,bubbling,cancelable
	return !element.dispatchEvent(evt);
}

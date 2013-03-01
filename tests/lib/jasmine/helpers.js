function getBody(){
	var rand = (Math.random() * Math.random() + '').slice(2),
		element = document.createElement('div');

	if(getBody.id) document.body.removeChild(document.getElementById(getBody.id));

	element.id = rand;
	getBody.id = rand;

	document.body.appendChild(element);

	return document.getElementById(rand);
}
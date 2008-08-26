function toggleElement(id) 
{
	var elem = document.getElementById(id);

	if(elem.style.display == 'none') 
		elem.style.display = 'block';
    else
		elem.style.display = 'none';
	}
}
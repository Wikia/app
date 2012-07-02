// add a new row for translation or definition
window.addEmptyRow = function (elementId) {
  var element = document.getElementById( elementId );
  var container = element.parentNode ;
	
  // create a clone to work on
  var new_element = element.cloneNode(true);
  // removes the green button for the old row
  element.firstChild.removeChild ( element.firstChild.firstChild );
  // all new textareas field should be set empty
  var textAreaList = new_element.getElementsByTagName('textarea');
  for (i=0; i<textAreaList.length ; i++)
  {
    if (textAreaList[i].type == 'text') textAreaList[i].value = '';
  }

// for the spelling, it is not a textarea but an input type=text.
// (some other input fields, hidden, are needed, so we should not clear all <input> )
  var inputList = new_element.getElementsByTagName('input');
  for (i=0; i<inputList.length ; i++)
  {
    if (inputList[i].type == 'text') inputList[i].value = '' ;
    if (inputList[i].name == 'onUpdate') inputList[i].value = inputList[i].value.replace("add-","add-X-");
  }
  recursiveChangeId(new_element);
  // add the element as the last one (null)
  container.appendChild(new_element );
}

window.recursiveChangeId = function (element) {
  if (element == null) return;
  if (element.hasChildNodes()) {
    var children = element.childNodes ;
    for (var i=0; i<children.length ; i++) recursiveChangeId (children[i]);
  }
  if (element.id) element.id = element.id.replace("add-","add-X-");
  if (element.name) element.name = element.name.replace("add-","add-X-");
  return ;
}

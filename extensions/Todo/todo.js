function todoMoveQueue(id) {
	var selector = document.getElementById( "mwTodoQueue" + id );
	var queue = selector.options[selector.selectedIndex].value;
	if (queue == '') {
		// do nothing
	} else if (queue == '+') {
		queue = prompt("Input a name for a new queue to move this item to:", "");
		if (queue == null || queue == "") {
			// canceling; set back to default
			for(var i = 0; i < selector.options.length; i++) {
				if (selector.options[i].value == "") {
					selector.selectedIndex = i;
				}
			}
		} else {
			selector.options[selector.selectedIndex].value = queue;
			todoDoMoveQueue(id);
		}
	} else {
		todoDoMoveQueue(id);
	}
}

function todoEditTitle(id, enable) {
	var block = document.getElementById( "mwTodoTitle" + id );
	block.style.display = enable ? "none" : "block";

	var form = document.getElementById( "mwTodoTitleUpdate" + id );
	form.style.display = enable ? "block" : "none";
}

function todoEditComment(id, enable) {
	var block = document.getElementById( "mwTodoComment" + id );
	block.style.display = enable ? "none" : "block";

	var form = document.getElementById( "mwTodoCommentUpdate" + id );
	form.style.display = enable ? "block" : "none";
}


function todoDoMoveQueue(id) {
	var form = document.getElementById( "mwTodoQueueUpdate" + id );
	form.submit();
}

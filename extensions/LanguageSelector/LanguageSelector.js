$( function() {
	var i = 1;
	while ( true ) {
		var btn = document.getElementById("languageselector-commit-"+i);
		var sel = document.getElementById("languageselector-select-"+i);
		var idx = i;

		if (!btn) break;

		btn.style.display = "none";
		sel.onchange = function() {
			node = this.parentNode;
			while( true ) {
				if( node.tagName.toLowerCase() == "form" ) {
					node.submit();
					break;
				}
				node = node.parentNode;
			}
		};

		i++;
	}
});

/**
 * @define lazyload
 *
 * Image lazy loading
 */
define('lazyload', ['sections'], function(sections){
	var d = document,
		processed = {};

	function onLoad(){
		this.className = this.className.replace('imgPlcHld', 'fit');
	}

	function load(elements){
			var x = 0,
			y = elements.length,
			elm;

		for(; x < y; x++){
			elm = elements[x];
			elm.className += ' imgPlcHld';

			//load only visible images (i.e. in the article intro),
			//images in sections will be loaded on demand
			if(elm && elm.offsetWidth > 0 && elm.offsetHeight > 0){
				elm.onload = onLoad;
				elm.src = elm.getAttribute('data-src');
			}
		}
	}

	//Image lazy loading
	$(window).on('load', function(){
		load(document.getElementsByClassName('lazy'));
		sections.addEventListener('open', function(){
			var self = this,
			id = self.getAttribute('data-index');

			if(id !== null && id !== undefined && !processed[id]){
				load(self.getElementsByClassName('lazy'));
				processed[id] = true;
			}
		});
	});

	return load;
});
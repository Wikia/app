/*global WikiaMobile*/

//init toc
$(function(){
		//private
		var d = document,
			table = d.getElementById('toc');

		//init only if toc is on a page
		if(table){
			d.getElementById('toctitle').insertAdjacentHTML('afterbegin', '<span class=chev></span>');
			d.body.className += ' hasToc';

			table.addEventListener(WikiaMobile.getClickEvent(), function(ev){
				var node = ev.target.parentNode;

				if(this.className.indexOf('open') > -1){
					this.className = this.className.replace(' open', '');
					WikiaMobile.track('/toc/close');
				}else{
					this.className += ' open';
					WikiaMobile.track('/toc/open');
				}

				if(node.nodeName == 'A'){
					ev.preventDefault();

					var elm = d.getElementById(node.getAttribute('href').substr(1)),
						h2 = elm;

					//find in what section is the header
					while(h2.nodeName != 'H2'){
						h2 = (elm.parentNode.className.indexOf('artSec') > -1) ? h2.parentNode.previousElementSibling : h2.parentNode;
					}

					//open section if necessarry
					if(h2.className.indexOf('open') == -1){
						h2.className += ' open';
						h2.nextElementSibling.className += ' open';
					}

					//scroll header into view
					//if the page is long that is the way I found it reliable
					//without calling it like that android sometimes did not scroll at all
					//and iOS sometimes scrolled to a wrong place
					elm.scrollIntoView();
					setTimeout(function(){
						elm.scrollIntoView();
					}, 50);

				}
			});
		}
});
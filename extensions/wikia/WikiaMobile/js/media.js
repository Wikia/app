/*global define, modal, WikiaMobile */
/**
 * Media handling in Wikia Mobile
 *
 * @author Jakub "Student" Olek
 */

(function(){
	if(define){
		//AMD
		define('media', ['modal'], media);//late binding
	}else{
		window.Media = media(modal);//late binding
	}

	function media(modal){
		/** @private **/

		var	images = [],
			fllScrImg,
			imagesLength,
			current = 0,
			shrImg = WikiaMobile.querystring().getVal('image'),
			clickEvent = WikiaMobile.getClickEvent(),
			touchEvent = WikiaMobile.getTouchEvent(),
			loader = WikiaMobile.loader,
			track = WikiaMobile.track,
			sharePopOver,
			content = '<div id=fllScrImg></div>';

		function processImages(){
			var	number = 0, href = '', name = '', nameMatch = /[^\/]*\.\w*$/,
				i, j, elm,
				elements = $('.infobox .image, .wkImgStk, figure').not('.wkImgStk > figure'),
				l = elements.length,
				img, cap;

			for(j = 0; j < l; j++){
				var element = elements[j],
					className = element.className,
					leng;

				if(className.indexOf('image') > -1){
					href = element.href;
					name = element.attributes['data-image-name'].value.replace('.','-');
					if(name === shrImg) shrImg = number;
					images.push([href, name]);
					element.setAttribute('data-num', number++);
				}else if(className.indexOf('wkImgStk') > -1){
					if(className.indexOf('grp') > -1) {
						var figures = element.getElementsByTagName('figure');

						leng = figures.length;

						element.setAttribute('data-num', number);

						element.getElementsByTagName('footer')[0].insertAdjacentHTML('beforeend', leng);

						for(i=0; i < leng; i++){
							elm = figures[i];
							img = elm.getElementsByClassName('image')[0];
							if(img){
								href = img.href;
								name = img.id;
								images.push([
									href, name,
									(cap = elm.getElementsByClassName('thumbcaption')[0])?cap.innerHTML:'',
									i, leng
								]);

								if(name === shrImg) shrImg = number + i;
							}
						}
					} else {
						leng = parseInt(element.attributes['data-img-count'].value, 10);
						var	lis = element.getElementsByTagName('li');

						element.setAttribute('data-num', number);

						for(i=0; i < leng; i++){
							elm = lis[i];
							href = elm.attributes['data-img'].value;
							name = href.match(nameMatch)[0].replace('.','-');
							images.push([
								href,
								name,
								elm.innerHTML,
								//I need these number to show counter in a modal
								i, leng
							]);

							if(name === shrImg) shrImg = number + i;
						}
					}
					number += leng;
				} else {
					img = element.getElementsByClassName('image')[0];
					if(img){
						href = img.href;
						name = img.id;
						if(name === shrImg) shrImg = number;
						images.push([
							href, name,
							(cap = element.getElementsByClassName('thumbcaption')[0])?cap.innerHTML:''
						]);
						element.setAttribute('data-num', number++);
					}
				}
			}

			imagesLength = images.length;

			if(imagesLength > 1) content = '<div class=chnImg id=prvImg><div></div></div>' + content + '<div class=chnImg id=nxtImg><div></div></div>';


			//if url contains image=imageName - open modal with this image
			if(shrImg) setTimeout(function(){openModal(shrImg);}, 1000);
		}

		function loadImage(){
			var image = images[current],
				img = new Image();

			loader.show(fllScrImg, {center: true});

			img.src = image[0];
			fllScrImg.style.backgroundImage = 'none';
			img.onload =  function() {
				fllScrImg.style.backgroundImage = 'url("' + img.src + '")';
				loader.hide(fllScrImg);
			};

			modal.setCaption(getCaption(current));
		}

		function loadPrevImage(ev){
			ev.stopPropagation();

			current -= 1;

			if(current < 0) {
				current = imagesLength-1;
			}

			track('modal/image/prev');
			loadImage();
		}

		function loadNextImage(ev){
			ev.stopPropagation();

			current += 1;

			if(imagesLength <= current) {
				current = 0;
			}

			track('modal/image/next');
			loadImage();
		}

		function getCaption(num){
			var img = images[num],
				cap = img[2] || '',
				number = img[3],
				length = img[4];

			if(number >= 0 && length >= 0) {
				cap += '<div class=wkStkFtr> ' + (number+1) + ' / ' + length + ' </div>';
			}

			return cap;
		}

		function openModal(num){
			current = Math.round(num);

			modal.open({
				content: content,
				toolbar: '<div class=wkShr id=wkShrImg>',
				classes: 'imgMdl'
			});

			fllScrImg = document.getElementById('fllScrImg');

			loadImage();

			//handling next/previous image
			if(imagesLength > 1){
				$(document.getElementById('nxtImg')).bind('swipeLeft ' + clickEvent, loadNextImage);
				$(document.getElementById('prvImg')).bind('swipeRight ' + clickEvent, loadPrevImage);
				$(fllScrImg).bind('swipeLeft', loadNextImage)
					.bind('swipeRight', loadPrevImage);
			}

			sharePopOver = WikiaMobile.popOver({
				on: document.getElementById('wkShrImg'),
				style: 'left:3px;',
				create: function(cnt){
					$(cnt).delegate('li', 'click', function(){
						track('modal/share/' + this.className.replace('Shr',''));
					});
				},
				open: function(ev){
					ev.stopPropagation();
					sharePopOver.changeContent(WikiaMobile.loadShare);
					track('modal/share/open');
				},
				close: function(){
					track('modal/share/close');
				}
			});
		}

		/** @public **/

		return {
			openModal: openModal,
			getImages: function(){
				return images;
			},
			getCurrentImg: function(){
				return images[current];
			},
			processImages: processImages
		}
	}
})();
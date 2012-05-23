define('suggest', function(){
var reEscape = /(\/|\.|\*|\+|\?|\||\(|\)|\[|\]|\{|\}|\\)/g,
	input,
	list,
	suggestions,
	currentValue,
	cachedResponse = [],
	serviceUrl,
	redirect,
	regExp,
	t, a;

	function getSuggestions() {
		clearTimeout(t);
		var curVal = currentValue,
			cr;

		if(curVal != ''){
			cr = cachedResponse[curVal];

			if (cr && cr[0].length > 0) {
				suggestions = cr[0];
				redirect = cr[1];
				suggest();
			} else {
				t = setTimeout(function(){
					$.ajax({
						url: serviceUrl,
						data: {
							query: curVal
						},
						success: function(resp) {
							suggestions = resp[0];
							redirect = resp[1];
							cachedResponse[curVal] = resp;
							suggest();
						},
						dataType: 'json'
					});
				}, 250);
			}
		}
	};

	function suggest() {
		var len = suggestions.length,
			lis = '',
			red,
			sug;

		list.innerHTML = '';

		if (len > 0) {
			clearInterval(a)
			regExp = new RegExp('(' + currentValue.replace(reEscape, '\\$1') + ')', 'gi')

			for (var i = 0; i < len; i++) {
				sug = suggestions[i];
				red = redirect[sug];

				li = '<li><span title="'+sug+'">' + sug.replace(regExp, '<em>$1</em>') + ((red) ? '<div class=redir>' + $.msg('tog-redirected-from', red) + '</div>': '') + '<span class=copySrh>+</span></span></li>';
				lis = (red) ? li + lis : lis + li;
			}

			list.insertAdjacentHTML('afterbegin', lis);

			var li = list.getElementsByTagName('li'),
				cur = 0,
				l = li.length;

			a = setInterval(function(){
				li[cur++].className = 'show';
				if(cur == l) clearInterval(a);
			}, 70)
		}
	};

	return function (options) {
		input = options.input;
		list = options.list,
		serviceUrl = options.url;

		var clear = options.clear;

		currentValue = input.value.trim();
		getSuggestions();

		input.addEventListener('input', function(){
			currentValue = input.value.trim();

			if(currentValue !== '') {
				if(currentValue.length < 3) {
					list.innerHTML = '';
				} else {
					getSuggestions();
				}
				clear.className = clear.className.replace(' hide', '');
			} else {
				list.innerHTML = '';
				clear.className = 'clsIco hide';
			}

			input.parentElement.scrollIntoView();
		});

		clear.addEventListener('click', function(){
			input.value = '';
			list.innerHTML = '';
			clear.className = 'clsIco hide';
			input.focus();
		})

		list.addEventListener('click', function(ev){
			var target = ev.target,
				title;

			if(target.className == 'copySrh'){
				title  = target.parentElement.title;
				input.value = currentValue = title;
				getSuggestions();
				input.focus();
				input.parentElement.scrollIntoView();
			}else{
				input.value = target.title || target.parentElement.title || target.children[0].title || '';
				input.previousElementSibling.disabled = true;
				input.parentElement.submit();
			}
		});
	}
});
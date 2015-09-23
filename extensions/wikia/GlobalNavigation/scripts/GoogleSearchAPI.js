(function () {
	if ( window.wgGoogleSearchTest ) {
		var searchForm = document.getElementById('searchForm'),
			searchId = window.wgGoogleSearchParam,
			scriptElem1 = document.createElement('script'),
			scriptElem2 = document.getElementsByTagName('script')[0];

		scriptElem1.type = 'text/javascript';
		scriptElem1.async = true;
		scriptElem1.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
				   '//cse.google.com/cse.js?cx=' + searchId;
		scriptElem2.parentNode.insertBefore(scriptElem1, scriptElem2);

		searchForm.addEventListener('submit', function (evt) {
			var contentLang = window.wgContentLanguage || 'en',
				searchQuery = $('#searchInput').val(),
				$googleInput = $('.gsc-input'),
				$googleButton = $('.gsc-search-button'),
				$selectElement = $('#searchSelect'),
				$selectedOption = $selectElement.find('option:selected');

			evt.preventDefault();

			//get info of local or global and modify query scope
			if ($selectedOption.val() === 'local') {
				searchQuery += ' site:' + window.location.hostname;
			} else {
				if ( contentLang === 'en') {
					searchQuery += ' site:*.wikia.com';
				} else {
					searchQuery += ' site:' + contentLang + '.*.wikia.com';
				}
			}

			//Invoke google search
			$googleInput.val(searchQuery);
			$googleButton.trigger('click');
		});
	}
})();

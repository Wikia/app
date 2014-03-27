/**
 * Search results JS code for the WikiaMobile skin
 *
 * @author Artur Klajnerok<arturk(at)wikia-inc.com>
 **/
require(['throbber', 'topbar', 'track', 'wikia.nirvana', 'wikia.window'], function(throbber, topbar, track, nirvana, window){

    var d = window.document,
        wkSrhInp = d.getElementById('wkSrhInp'),
        wkMainCnt = d.getElementById('wkMainCnt'),
        wkResultCount = d.getElementById('wkResultCount'),
        wkResultUl = d.getElementById('wkResultUl'),
        wkResultNext = d.getElementById('wkResultNext'),
        wkResultPrev = d.getElementById('wkResultPrev'),
        clickEvent = 'click',
        firstPage;

    if(wkResultUl){
        var totalPages = ~~wkResultUl.getAttribute('data-total-pages'),
            query = wkResultUl.getAttribute('data-query'),
            currentPage = ~~wkResultUl.getAttribute('data-page'),
            resultsPerPage = ~~wkResultUl.getAttribute('data-results-per-page'),
            totalResults = ~~wkResultUl.getAttribute('data-total-results');

		//lets add some tracking to global search
		wkResultUl.addEventListener(clickEvent, function(ev){
			var t = ev.target,
				className = t.className,
				label = (className.indexOf('url') > -1) ? 'label' :
					(className.indexOf('groupTitle') > -1) ? 'wikiname' :
					(className.indexOf('searchGroup') > -1) ? 'icon' : '';

			if (label) track.event('search', track.CLICK, {
				label: label,
				href: t.href
			},
			ev);
		});
    }

    if(wkSrhInp){
        wkSrhInp.addEventListener(clickEvent, function(){
            topbar.initAutocomplete();
        });
    }

    function clickHandler(event){
        event.preventDefault();

        var elm = this,
            forward = (elm.getAttribute('id') == 'wkResultNext'),
            pageIndex = (forward) ? currentPage + 1 : currentPage - 1,
            condition = (forward) ? (currentPage < totalPages) : (currentPage > 1),
            currentResultFrom,
            currentResultTo;

        if(currentPage === 1) {
            firstPage = wkResultUl.innerHTML;
        }

        if(condition){
            elm.className += ' active';
            throbber.show(elm, {size: '30px'});

			track.event('search', track.PAGINATE, {
				label: forward ? 'next' : 'previous'
			});

            nirvana.sendRequest({
				controller: 'WikiaSearchAjaxController',
				method: 'getNextResults',
				format: 'json',
				type: 'GET',
				data: {
					useskin: skin,
					query: encodeURIComponent(query),
					page: pageIndex
				}
            }).done(
				function(result){
					var finished;

					currentPage = pageIndex;
					finished = (forward) ? (currentPage == totalPages) : (currentPage == 1);

					wkResultUl.innerHTML = result.text;

					currentResultFrom = resultsPerPage*currentPage+1-resultsPerPage;
					currentResultTo = (currentPage == totalPages) ? totalResults :resultsPerPage*currentPage;
					wkResultCount.innerHTML = result.counter;

					elm.className = elm.className.replace(' active', '');
					throbber.hide(elm);

					if(finished) {
						elm.style.display = 'none';
					}

					((forward) ? wkResultPrev : wkResultNext).style.display = 'block';

					window.scrollTo(0, wkMainCnt.offsetTop);
				}
			);
        }
    }

    if(totalPages > 1){
        wkResultNext.addEventListener(clickEvent, clickHandler, true);
        wkResultPrev.addEventListener(clickEvent, clickHandler, true);
    }
});

/**
 * Search results JS code for the WikiaMobile skin
 *
 * @author Artur Klajnerok<arturk(at)wikia-inc.com>
 **/

require(['loader', 'events', 'topbar'], function(loader, events, topbar){

    var d = document,
        wkSrhInp = d.getElementById('wkSrhInp'),
        wkMainCnt = d.getElementById('wkMainCnt'),
        wkResCntAct = d.getElementById('wkResCntAct'),
        wkResultUl = d.getElementById('wkResultUl'),
        wkResultNext = d.getElementById('wkResultNext'),
        wkResultPrev = d.getElementById('wkResultPrev'),
        clickEvent = events.click,
        firstPage;

    if(wkResultUl){
        var totalPages = ~~wkResultUl.getAttribute('data-total-pages'),
            query = wkResultUl.getAttribute('data-query'),
            currentPage = ~~wkResultUl.getAttribute('data-page'),
            resultsPerPage = ~~wkResultUl.getAttribute('data-results-per-page'),
            totalResults = ~~wkResultUl.getAttribute('data-total-results'),
            ajaxUrl = wgServer +
                "/wikia.php?controller=WikiaSearchAjaxController&method=getNextResults&format=json&useskin=" +
                skin +
                "&query=" +
                query;
    }

    if(wkSrhInp){
        wkSrhInp.addEventListener(clickEvent, function(event){
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
            loader.show(elm, {size: '30px'});

            $.getJSON(ajaxUrl + '&page=' + pageIndex, function(result){
                var finished;

                currentPage = pageIndex;
                finished = (forward) ? (currentPage == totalPages) : (currentPage == 1);

                wkResultUl.innerHTML = result.text;

                currentResultFrom = resultsPerPage*currentPage+1-resultsPerPage;
                currentResultTo = (currentPage == totalPages) ? totalResults :resultsPerPage*currentPage;
                wkResCntAct.innerHTML = currentResultFrom+'-'+currentResultTo;

                elm.className = elm.className.replace(' active', '');
                loader.hide(elm);

                if(finished) {
                    elm.style.display = 'none';
                }

                ((forward) ? wkResultPrev : wkResultNext).style.display = 'block';

                window.scrollTo(0, wkMainCnt.offsetTop);
            });
        }
    }

    if(totalPages > 1){
        wkResultNext.addEventListener(clickEvent, clickHandler, true);
        wkResultPrev.addEventListener(clickEvent, clickHandler, true);
    }


});
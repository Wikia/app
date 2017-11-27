require(['wikia.log', 'wikia.window', 'jquery'], function(log, window, $) {
    function __makeParamValue() {
        var f = document.getElementById('lu-form'),
            target = "",
            i;

        if (f.lu_target && f.lu_target.length > 0) {
            for (i = 0; i < f.lu_target.length; i++) {
                if (f.lu_target[i].checked) {
                    target += f.lu_target[i].value + ",";
                }
            }
        }
        return target;
    }

    // set up data table
    // @see https://datatables.net/reference/option/ (jquery.dataTables.min.js v1.8.2)
    var oTable = $('#lu-table').dataTable({
        "oLanguage": listUsersLanguage,
        "sCookiePrefix": "Listusers-wikia",
        "aLengthMenu": [[10, 25, 50], [10, 25, 50]],
        "sDom": '<"dttoolbar"><"top"flip>rt<"bottom"p><"clear">',
        "aoColumns": [
            {"sName": "username", "bSortable": false},
            {"sName": "groups"},
            {"sName": "revcnt"},
            {"sName": "dtedit"}
        ],
        "bProcessing": true,
        "bServerSide": true,
        "bFilter": false,
        "sPaginationType": "full_numbers",
        "sAjaxSource": window.wgScript + "?action=ajax&rs=ListusersAjax::axShowUsers&uselang=" + encodeURIComponent(window.wgUserLanguage),
        /*"fnInitComplete" : function ( oInstance, oSettings, json ) {
            // make CSS buttons
        },*/
        "fnServerData": function (sSource, aoData, fnCallback) {
            var limit = 30,
                offset = 0,
                groups = __makeParamValue(),
                loop = 1,
                order = '',
                sortingCols = 0,
                sortColumns = [],
                sortOrder = [],
                _tmp = [],
                columns = [],
                i;

            for (i in aoData) {
                log(aoData[i], 'listusers');

                switch (aoData[i].name) {
                    case 'iDisplayLength':
                        limit = aoData[i].value;
                        break;
                    case 'iDisplayStart':
                        offset = aoData[i].value;
                        break;
                    case 'sEcho':
                        loop = aoData[i].value;
                        break;
                    case 'sColumns':
                        columns = aoData[i].value.split(',');
                        break;
                    case 'iSortingCols':
                        sortingCols = aoData[i].value;
                        break;
                }

                if (aoData[i].name.indexOf('iSortCol_', 0) !== -1)
                    sortColumns.push(aoData[i].value);

                if (aoData[i].name.indexOf('sSortDir_', 0) !== -1)
                    sortOrder.push(aoData[i].value);
            }

            if (sortingCols > 0) {
                for (i = 0; i < sortingCols; i++) {
                    var info = columns[sortColumns[i]] + ":" + sortOrder[i];
                    _tmp.push(info);
                }
                order = _tmp.join('|');
            }

            var config = window.mw.config.get('listUsers');

            $.ajax({
                "dataType": 'json',
                "type": "GET",
                "url": sSource,
                "data": [
                    {
                        'name': 'groups',
                        'value': groups
                    }, {
                        'name': 'username',
                        'value': ( $('#lu_search').exists() ) ? $('#lu_search').val() : config.searchByUser
                    }, {
                        'name': 'edits',
                        'value': ( $('#lu_contributed').exists() ) ? $('#lu_contributed').val() : config.defContrib
                    }, {
                        'name': 'limit',
                        'value': limit
                    }, {
                        'name': 'offset',
                        'value': offset
                    }, {
                        'name': 'loop',
                        'value': loop
                    }, {
                        'name': 'order',
                        'value': order
                    }
                ],
                "success": fnCallback
            });
        }
    });

    $( 'div.dttoolbar' ).html( listUserToolbar );

    $('#lu-showusers').click(function () {
        oTable.fnDraw();
    });

    // set up auto-suggest for user names
    // @see http://api.jqueryui.com/autocomplete/
    $('#lu_search').autocomplete({
        source: function( request, response ) {
            $.getJSON(
                window.wgScript + "?action=ajax&rs=ListusersAjax::axSuggestUsers",
                {
                    'query': request.term
                },
                function(data) {
                    response(data[1]);
                }
            );
        },
        select: function( event, ui ) {
            // update text field value
            $(this).val(ui.item.value);

            // update the table when a user is selected
            oTable.fnDraw();
        }
    });

	// pressing enter in username field should refresh the list
	$('#lu-form').submit(function(ev) {
	    ev.preventDefault();
	    oTable.fnDraw();
    });
});

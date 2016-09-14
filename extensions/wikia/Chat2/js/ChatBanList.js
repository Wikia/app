require(['wikia.nirvana'], function (nirvana) {

    var loaderIcon = "<img src='" + stylepath + "/common/images/ajax.gif' />";
    var oTable = $( '#lu-table' ).dataTable( {
        "oLanguage": {
            "sLengthMenu": mw.message('table_pager_limit', '_MENU_').escaped(),
            "sZeroRecords": mw.message('table_pager_empty').escaped(),
            "sEmptyTable": mw.message('table_pager_empty').escaped(),
            "sInfo": mw.message('listusersrecordspager','_START_', '_END_', '_TOTAL_').text(),
            "sInfoEmpty": mw.message('listusersrecordspager','0', '0', '0').escaped(),
            "sInfoFiltered": "",
            "sSearch": mw.message('search').escaped(),
            "sProcessing": loaderIcon + mw.message('livepreview-loading').escaped(),
            "oPaginate" : {
                "sFirst": mw.message('table_pager_first').escaped(),
                "sPrevious": mw.message('table_pager_prev').escaped(),
                "sNext": mw.message('table_pager_next').escaped(),
                "sLast": mw.message('table_pager_last').escaped()
            }
        },
        "sCookiePrefix" : "chatbanlist-wikia",
        "aLengthMenu": [[10, 25, 50], [10, 25, 50]],
        "sDom": '<"dttoolbar"><"top"flip>rt<"bottom"p><"clear">',
        "aoColumns": [
            { "sName": "timestamp" },
            { "sName": "target" },
            { "sName": "expires" },
            { "sName": "blockedBy" },
            { "sName": "reason" , "asSorting": false }
        ],
        "aoColumnDefs": [
            {"asSorting": ["desc", "asc"], "aTargets": [0]},
            {"bSortable": false, "aTargets": [-1]},
            {"bSearchable": false, "aTargets": [-1]}
        ],
        "bProcessing": true,
        "bServerSide": true,
        "bFilter" : false,
        "sPaginationType": "full_numbers",
        "sAjaxSource": '',
        "fnServerData": function ( sSource, aoData, fnCallback ) {
            var limit = 30,
                offset = 0,
                loop = 1,
                order = '',
                sortingCols = 0,
                _tmp = [],
                columns = [],
                sortColumns = [],
                sortOrder = [],
                iColumns = 0;

            for ( var i in aoData ) {
                switch ( aoData[i].name ) {
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
                        columns = aoData[i].value.split( ',' );
                        break;
                    case 'iColumns':
                        iColumns = aoData[i].value;
                        break;
                    case 'iSortingCols':
                        sortingCols = aoData[i].value;
                        break;
                }

                if ( aoData[i].name.indexOf( 'iSortCol_', 0 ) !== -1 )
                    sortColumns.push( aoData[i].value );

                if ( aoData[i].name.indexOf( 'sSortDir_', 0 ) !== -1 )
                    sortOrder.push( aoData[i].value );
            }

            if ( sortingCols > 0 ) {
                for ( i = 0; i < sortingCols; i++ ) {
                    var info = columns[sortColumns[i]] + ":" + sortOrder[i];
                    _tmp.push(info);
                }
                order = _tmp.join( '|' );
            }

            var data = [
                {
                    'name': 'username',
                    'value': $('#lu_search').val()
                },
                {
                    'name': 'limit',
                    'value': limit
                },
                {
                    'name': 'offset',
                    'value': offset
                },
                {
                    'name': 'loop',
                    'value': loop
                },
                {
                    'name': 'numOrder',
                    'value': sortingCols
                },
                {
                    'name': 'order',
                    'value': order
                }
            ];

            nirvana.sendRequest({
                controller:'ChatBanListSpecialController',
                method:'axShowUsers',
                format: 'json',
                data: data,
                callback: fnCallback
            });

        }
    } );

    $( '#lu-showusers' ).click( function () {
        oTable.fnDraw();
    } );
} );

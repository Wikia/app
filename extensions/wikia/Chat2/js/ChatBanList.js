require(['wikia.nirvana'], function (nirvana) {

    var loaderIcon = '<img src="' + stylepath + '/common/images/ajax.gif" />';
    var oTable = $('#lu-table').dataTable({
        oLanguage: {
            sLengthMenu: mw.message('table_pager_limit', '_MENU_').escaped(),
            sZeroRecords: mw.message('table_pager_empty').escaped(),
            sEmptyTable: mw.message('table_pager_empty').escaped(),
            sInfo: mw.message('listusersrecordspager', '_START_', '_END_', '_TOTAL_').text(),
            sInfoEmpty: mw.message('listusersrecordspager', '0', '0', '0').escaped(),
            sInfoFiltered: '',
            sSearch: mw.message('search').escaped(),
            sProcessing: loaderIcon + mw.message('livepreview-loading').escaped(),
            oPaginate: {
                sFirst: mw.message('table_pager_first').escaped(),
                sPrevious: mw.message('table_pager_prev').escaped(),
                sNext: mw.message('table_pager_next').escaped(),
                sLast: mw.message('table_pager_last').escaped()
            }
        },
        sCookiePrefix: 'chatbanlist-wikia',
        aLengthMenu: [[10, 25, 50], [10, 25, 50]],
        sDom: '<"dttoolbar"><"top"flip>rt<"bottom"p><"clear">',
        aoColumns: [
            { sName: 'timestamp' },
            { sName: 'target' },
            { sName: 'expires' },
            { sName: 'blockedBy' },
            { sName: 'reason', asSorting: false }
        ],
        aoColumnDefs: [
            { asSorting: ['desc', 'asc'], aTargets: [0] },
            { bSortable: false, aTargets: [-1] },
            { bSearchable: false, aTargets: [-1] }
        ],
        bProcessing: true,
        bServerSide: true,
        bFilter: false,
        sPaginationType: 'full_numbers',
        sAjaxSource: '',
        fnServerData: function (sSource, aoData, fnCallback) {
            var refData = {},
                columns,
                order,
                requestData;

            aoData.forEach(function (el) {
                refData[el.name] = el.value;
            });

            columns = refData['sColumns'].split(',');
            order = columns[refData['iSortCol_0']] + ':' + refData['sSortDir_0'];

            requestData = {
                username: $('#lu_search').val(),
                limit: refData['iDisplayLength'],
                offset: refData['iDisplayStart'],
                order: order,
                lang: wgUserLanguage
            };

            nirvana.sendRequest({
                controller: 'ChatBanListSpecialController',
                method: 'axShowUsers',
                format: 'json',
                type: 'GET',
                data: requestData,
                callback: fnCallback
            });

        }
    });

    $('#lu-showusers').click(function () {
        oTable.fnDraw();
    });
});

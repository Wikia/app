<?php
/*
 * The template for the initial Special:SpamWikis view.
 * 
 * A list of wikis matching the specified criteria, checkboxes to pick wikis to be closed.
 * 
 * The script utilises jQuery DataTables plug-in: http://datatables.net/
 */
?>
<!-- s: <?= __FILE__ ?> -->
<script type="text/javascript" charset="utf-8"> 
 
function __makeParamValue() {
    var f = document.getElementById( 'spamwikis-form' );
    var target = '';
    if ( f.spamwikis_target && f.spamwikis_target.length > 0 ) {
        for ( i = 0; i < f.spamwikis_target.length; i++ ) {
            if ( f.spamwikis_target[i].checked ) {
                target += f.spamwikis_target[i].value + ',';
            }
        }
    }
    return target;
}

$(document).ready(function() {
    var baseurl = '/wikia.php?controller=SpecialSpamWikisController&method=getSpamWikis&format=json';
    
    var oTable = $('#spamwikis-table').dataTable( {
        'oLanguage': {
            'sLengthMenu': '<?= wfMsg( 'table_pager_limit', '_MENU_' ); ?>',
            'sZeroRecords': '<?= wfMsg( 'table_pager_empty' ); ?>',
            'sEmptyTable': '<?= wfMsg( 'table_pager_empty' ); ?>',
            'sInfo': '<?= wfMsgExt( 'specialspamwikis-record-pager',  array( 'parseinline' ), '_START_', '_END_', '_TOTAL_' ); ?>',
            'sInfoEmpty': '<?= wfMsgExt( 'specialspamwikis-record-pager',  array( 'parseinline' ), '0', '0', '0' ); ?>',
            'sInfoFiltered': '',
            'sSearch': '<?= wfMsg( 'search' ); ?>',
            'sProcessing': '<img src="' + stylepath + '/common/images/ajax.gif" /> <?= wfMsg( 'livepreview-loading' ); ?>',
            'oPaginate' : {
                'sFirst': '<?= wfMsg( 'table_pager_first' ); ?>',
                'sPrevious': '<?= wfMsg( 'table_pager_prev' ); ?>',
                'sNext': '<?= wfMsg( 'table_pager_next' ); ?>',
                'sLast': '<?= wfMsg( 'table_pager_last' ); ?>'
            }
        },
        'sCookiePrefix' : '<?= $mTitle->getBaseText(); ?>-wikia',
        'aLengthMenu': [[10, 25, 50, 100], [10, 25, 50, 100]],
        'sDom': '<"dttoolbar"><"top"flip>rt<"bottom"p><"clear">',
        'aoColumns': [
            { 'sName': 'close', 'bSortable' : false   },
            { 'sName': 'wiki' , 'bSortable' : true   },
            { 'sName': 'created', 'bSortable' : true },
            { 'sName': 'founder', 'bSortable' : false },
            { 'sName': 'email', 'bSortable' : false   }
        ],
        'aaSorting': [[2,'desc']],
        'bProcessing': true,
        'bServerSide': true,
        'bFilter' : false,
        'sPaginationType': 'full_numbers',
        'sAjaxSource': baseurl,
        'fnServerData': function ( sSource, aoData, fnCallback ) {
            var limit		= 30;
            var offset 		= 0;
            var criteria 	= __makeParamValue();
            var loop		= 1;
            var order 		= '';
            var sortingCols     = 0;
            var _tmp            = new Array();
            var _tmpDesc        = new Array();
            var columns		= new Array();
            var sortColumns     = new Array();
            var sortOrder	= new Array();
            var iColumns	= 0;
            
            for ( i in aoData ) {
                console.log( aoData[i] );
                switch ( aoData[i].name ) {
                    case 'iDisplayLength'	: limit = aoData[i].value; break;
                    case 'iDisplayStart'	: offset = aoData[i].value; break;
                    case 'sEcho'		: loop = aoData[i].value; break;
                    case 'sColumns'		: columns = aoData[i].value.split(','); break;
                    case 'iColumns'		: iColumns = aoData[i].value; break;
                    case 'iSortingCols'		: sortingCols = aoData[i].value; break;
                }
                if ( aoData[i].name.indexOf( 'iSortCol_', 0) !== -1 ) {
                    sortColumns.push(aoData[i].value);
                }
                if ( aoData[i].name.indexOf( 'sSortDir_', 0) !== -1 ) {
                    sortOrder.push(aoData[i].value);
                }
            }
            
            if ( sortingCols > 0 ) {
                for ( i = 0; i < sortingCols; i++ ) {
                    var info = columns[sortColumns[i]] + ":" + sortOrder[i];
                    _tmp.push(info);
                }
                order = _tmp.join( '|' );
            }
            $.ajax({
                'dataType': 'json',
                'type': 'POST',
                'url': sSource,
                'data': [
                    { 'name' : 'criteria', 	'value' : criteria },
                    { 'name' : 'wiki',  	'value' : ( $( '#spamwikis_search' ).exists() ) ? $( '#spamwikis_search' ).val() : '' },
                    { 'name' : 'limit', 	'value' : limit },
                    { 'name' : 'offset',	'value' : offset },
                    { 'name' : 'loop', 		'value' : loop },
                    { 'name' : 'numOrder',	'value' : sortingCols },
                    { 'name' : 'order',		'value' : order }
                ],
                'success': fnCallback
            });
        }
    });
    $('#spamwikis-show').click( function() { oTable.fnDraw(); } );
});
 
</script>

<section class="SpecialSpamWikis" id="SpecialSpamWikis">
<div> 
<form method="post" action="<?= $mAction ?>" id="spamwikis-form">
    <?php if ( !empty( $mData->criteria ) ) { ?>
    <fieldset class="spamwikis_fieldset">
        <legend><?= wfMsg( 'specialspamwikis-filter-by-name' ); ?></legend>
        <ul>
<?php foreach ( $mData->criteria as $k => $v ): ?>
            <li>
                <span style="vertical-align:middle"><input type="checkbox" name="spamwikis_target" id="spamwikis_target" value="<?= $k ?>" checked="checked" /></span>
                <span style="padding-bottom:5px;"><?= wfMsg( $v['name'] ); ?></span>
            </li>
<?php endforeach; ?>
        </ul>
    </fieldset>
    <div class="spamwikis-filter">
        <fieldset class="spamwikis_fieldset">
            <legend><?= wfMsg( 'specialspamwikis-criteria' ); ?></legend>
            <span class="spamwikis_filter spamwikis_first"> <?= wfMsg( 'specialspamwikis-startingtext' ); ?> </span>
            <span class="spamwikis_filter"><input type="text" name="spamwikis_search" id="spamwikis_search" size="5" value=""></span>
        </fieldset>
        <span class="spamwikis_filter"><input type="button" value="<?= wfMsg( 'specialspamwikis-update-list' ); ?>" id="spamwikis-show"></span>
    </div>
    <hr />
<?php } ?>
</form> 
</div>
<form method="post" action="<?= $mAction ?>" id="spamwikis-form-2">
<table cellpadding="0" cellspacing="0" border="0" class="TablePager" id="spamwikis-table">
    <thead>
        <tr>
            <th><?= wfMsg( 'specialspamwikis-close' ); ?></th>
            <th><?= wfMsg( 'specialspamwikis-wiki' ); ?></th>
            <th><?= wfMsg( 'specialspamwikis-created' ); ?></th>
            <th><?= wfMsg( 'specialspamwikis-founder' ); ?></th>
            <th><?= wfMsg( 'specialspamwikis-email' ); ?></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="5" class="dataTables_empty"><?= wfMsg( 'livepreview-loading' ); ?></td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <th><?= wfMsg( 'specialspamwikis-close' ); ?></th>
            <th><?= wfMsg( 'specialspamwikis-wiki' ); ?></th>
            <th><?= wfMsg( 'specialspamwikis-created' ); ?></th>
            <th><?= wfMsg( 'specialspamwikis-founder' ); ?></th>
            <th><?= wfMsg( 'specialspamwikis-email' ); ?></th>
        </tr>
    </tfoot>
</table><!-- /spamwikis-table -->
<input type="submit" value="<?= wfMsg( 'specialspamwikis-close-selected-wikis' ); ?>" />
</form>
</section><!-- /SpecialSpamWikis -->

<!-- e: <?= __FILE__ ?> -->
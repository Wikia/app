/*global define*/
define('ext.wikia.adEngine.provider.jj', [
    'wikia.log',
    'wikia.document'

], function( log, doc ) {
    'use strict';

    var logGroup = 'ext.wikia.adEngine.provider.jj',
        slotMap,
        canHandleSlot,
        fillInSlot,
        putContentIntoSlot;

    slotMap = {
        'PREFOOTER_LEFT_BOXAD': {'size': '300x250'},
        'PREFOOTER_RIGHT_BOXAD': {'size': '300x250'},
    };

    canHandleSlot = function (slotname) {
        log(['canHandleSlot', slotname], 'debug', logGroup);

        if (slotMap[slotname]) {
            return true;
        }

        return false;
    };

    putContentIntoSlot = function ( slotName ) {
        var container = doc.getElementById( slotName );

        var catApiCode = '<a href="http://thecatapi.com">' +
            '               <img src="http://thecatapi.com/api/images/get?format=src&size=small">' +
                         '</a>';
        if ( container ) {
            container.innerHtml = catApiCode;
            $(container).append(catApiCode);
        }
    };

    fillInSlot = function (slotname, success, hop) {
        var doRandomHop =  Math.floor((Math.random() * 5) + 1) % 5 === 0;

        if ( doRandomHop ) {
            log(['doing hop', slotname], 'debug', logGroup);
            hop();
        } else {
            putContentIntoSlot( slotname );
            success();
        }
    };

    return {
        name: 'jj',
        fillInSlot: fillInSlot,
        canHandleSlot: canHandleSlot
    };

});


function pickDonateButton() {
        var b = {{{templateWeights}}};

        var r = new Array();
        var total = 0;

        for (var button in b) {
                total += b[button];
                for(i=0; i < b[button]; i++) {
                        r[r.length] = button;
                }
        }

        if ( total == 0 )
                return '';

        var random = Math.floor(Math.random()*total);
        return r[random];
}

function setDonateButton( button ) {
        // Store cookie so portal is set for three weeks
        var e = new Date();
        e.setTime( e.getTime() + 21 * 24 * 60 * 60 * 1000 ) ;
        var work = 'donateButton=' + button + '; expires=' + e.toGMTString() + '; path=/';
        document.cookie = work;
}

function getDonateButton() {
        var t = 'donateButton';
        beg = document.cookie.indexOf( t );
        if ( beg != -1 ) {
                beg += t.length+1;
                end = document.cookie.indexOf(';', beg);
                if (end == -1)
                        end = document.cookie.length;
        return( document.cookie.substring(beg,end) );
        }
}

var wgDonateButton = getDonateButton();

if ( ! wgDonateButton ) {
        var wgDonateButton = pickDonateButton();
        setDonateButton( wgDonateButton );
}

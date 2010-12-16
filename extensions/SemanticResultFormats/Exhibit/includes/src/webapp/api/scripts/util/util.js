/*==================================================
 *  Exhibit Utility Functions
 *==================================================
 */
Exhibit.Util = {};

/**
 * Augment an object by replacing its key:value pairs with those
 * from other object(s), and adding pairs from other object(s) that don't
 * exist in you.  Key:value pairs from later objects will
 * overwrite those from earlier objects.
 * 
 * If null is given as the initial object, a new one will be created.
 * 
 * This mutates and returns the object passed as oSelf. The other objects are not changed.
 */
Exhibit.Util.augment = function (oSelf, oOther) {
    if (oSelf == null) {
        oSelf = {};
    }
    for (var i = 1; i < arguments.length; i++) {
        var o = arguments[i];
        if (typeof(o) != 'undefined' && o != null) {
            for (var j in o) {
                if (o.hasOwnProperty(j)) {
                    oSelf[j] = o[j];
                }
            }
        }
    }
    return oSelf;
}

/**
 * Round a number n to the nearest multiple of precision (any positive value),
 * such as 5000, 0.1 (one decimal), 1e-12 (twelve decimals), or 1024 (if you'd
 * want "to the nearest kilobyte" -- so round(66000, 1024) == "65536"). You are
 * also guaranteed to get the precision you ask for, so round(0, 0.1) == "0.0".
 */
Exhibit.Util.round = function(n, precision) {
    precision = precision || 1;
    var lg = Math.floor( Math.log(precision) / Math.log(10) );
    n = (Math.round(n / precision) * precision).toString();
    var d = n.split(".");
    if (lg >= 0) {
        return d[0];
    }

    lg = -lg;
    d[1] = (d[1]||"").substring(0, lg);
    while (d[1].length < lg) {
        d[1] += "0";
    }
    return d.join(".");  
}

if (!Array.prototype.map) {
    Array.prototype.map = function(f, thisp) {
        if (typeof f != "function")
            throw new TypeError();
        if (typeof thisp == "undefined") {
            thisp = this;
        }
        var res = [], length = this.length;
        for (var i = 0; i < length; i++) {
            if (this.hasOwnProperty(i))
                res[i] = f.call(thisp, this[i], i, this);
        }
        return res;
    };
}

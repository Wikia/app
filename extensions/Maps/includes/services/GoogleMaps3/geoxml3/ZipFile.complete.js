// ZipFile.complete.js
//
// 2/17/2012
//
// =======================================================
//

// JSIO.core.js
// ------------------------------------------------------------------
//
// core methods for Javascript IO.
//
// =======================================================
//
// Copyleft (c) 2010, Dino Chiesa via MS-PL
// Copyleft (c) 2012, Brendan Byrd via GPL
//
// This work is licensed under the GPLv3.


(function(){
    if (typeof JSIO == "object"){
        var e1 = new Error("JSIO is already defined");
        e1.source = "JSIO.core.js";
        throw e1;
    }

    JSIO = {};

    JSIO.version = "2.0 2012Feb";

    JSIO.throwError = function(msg, source, sub) {
        var error = new Error("Error: " + msg);
        error.source = (source || this._typename || 'JSIO') + (sub ? '.'+sub : '');
        throw error;
    }

    // Format a number as hex.  Quantities over 7ffffff will be displayed properly.
    JSIO.decimalToHexString = function(number, digits) {
        if (number < 0) {
            number = 0xFFFFFFFF + number + 1;
        }
        var r1 = number.toString(16).toUpperCase();
        if (digits) {
            r1 = "00000000" + r1;
            r1 = r1.substring(r1.length - digits);
        }
        return r1;
    };

    JSIO.FileType = {
        Text    : 0,
        Binary  : 1,
        XML     : 2,
        Unknown : 3
    };


    JSIO.guessFileType = function(name) {
       if (name == "makefile")  { return JSIO.FileType.Text; }

        var lastDot = name.lastIndexOf(".");
        if (lastDot <= 0) { return JSIO.FileType.Unknown; }

        var ext= name.substring(lastDot);
        if (ext == ".zip")   { return JSIO.FileType.Binary; }
        if (ext == ".xlsx")  { return JSIO.FileType.Binary; }
        if (ext == ".docx")  { return JSIO.FileType.Binary; }
        if (ext == ".dll")   { return JSIO.FileType.Binary; }
        if (ext == ".obj")   { return JSIO.FileType.Binary; }
        if (ext == ".pdb")   { return JSIO.FileType.Binary; }
        if (ext == ".exe")   { return JSIO.FileType.Binary; }
        if (ext == ".kmz")   { return JSIO.FileType.Binary; }

        if (ext == ".xml")      { return JSIO.FileType.XML; }
        if (ext == ".xsl")      { return JSIO.FileType.XML; }
        if (ext == ".kml")      { return JSIO.FileType.XML; }
        if (ext == ".csproj")   { return JSIO.FileType.XML; }
        if (ext == ".vbproj")   { return JSIO.FileType.XML; }
        if (ext == ".shfbproj") { return JSIO.FileType.XML; }
        if (ext == ".resx")     { return JSIO.FileType.XML; }
        if (ext == ".xslt")     { return JSIO.FileType.XML; }

        if (ext == ".sln")  { return JSIO.FileType.Text; }
        if (ext == ".htm")  { return JSIO.FileType.Text; }
        if (ext == ".html") { return JSIO.FileType.Text; }
        if (ext == ".js")   { return JSIO.FileType.Text; }
        if (ext == ".vb")   { return JSIO.FileType.Text; }
        if (ext == ".txt")  { return JSIO.FileType.Text; }
        if (ext == ".rels") { return JSIO.FileType.Text; }
        if (ext == ".css")  { return JSIO.FileType.Text; }
        if (ext == ".cs")   { return JSIO.FileType.Text; }
        if (ext == ".asp")  { return JSIO.FileType.Text; }

        return JSIO.FileType.Unknown;
    };

    JSIO.stringOfLength = function (charCode, length) {
        var s3 = "";
        for (var i = 0; i < length; i++) {
            s3 += String.fromCharCode(charCode);
        }
        return s3;
    };

    JSIO.formatByteArray = function(b) {
        var s1 = "0000  ";
        var s2 = "";
        for (var i = 0; i < b.length; i++) {
            if (i !== 0 && i % 16 === 0) {
                s1 += "    " + s2 +"\n" + JSIO.decimalToHexString(i, 4) + "  ";
                s2 = "";
            }
            s1 += JSIO.decimalToHexString(b[i], 2) + " ";
            if (b[i] >=32 && b[i] <= 126) {
                s2 += String.fromCharCode(b[i]);
            } else {
                s2 += ".";
            }
        }
        if (s2.length > 0) {
            s1 += JSIO.stringOfLength(32, ((i%16>0)? ((16 - i%16) * 3) : 0) + 4) + s2;
        }
        return s1;
    };

    JSIO.htmlEscape = function(str) {
        return str
            .replace(new RegExp( "&", "g" ), "&amp;")
            .replace(new RegExp( "<", "g" ), "&lt;")
            .replace(new RegExp( ">", "g" ), "&gt;")
            .replace(new RegExp( "\x13", "g" ), "<br/>")
            .replace(new RegExp( "\x10", "g" ), "<br/>");
    };

    JSIO.massApply = function(func, funcThis, arr, needReturn) {
        var arrayLimit = 99999;  // Chrome has an apply/array limit of 99999; Firefox = 491519
        if (arr.length < arrayLimit) return func.apply(funcThis, arr);
        else {
            var newThis = funcThis;
            var offset = 0;
            var end    = 99999;

            while (offset < arr.length) {
                var arrSlice;
                if      (arr.subarray) arrSlice = arr.subarray(offset, end);
                else if (arr.slice)    arrSlice = arr.slice(offset, end);

                if (needReturn) newThis += func.apply(newThis,  arrSlice);
                else                       func.apply(funcThis, arrSlice);

                offset += arrayLimit;
                end    += arrayLimit;
                end     = Math.min(arr.length, end);
            }
            return newThis;
        }
    }

})();

/// JSIO.core.js ends


// JSIO.BasicByteReaders.js
// ------------------------------------------------------------------
//
// Part of the JSIO library.  Adds a couple basic ByteReaders to JSIO.
// ByteReaders are forward-only byte-wise readers. They read one byte at
// a time from a source.
//
// =======================================================
//
// A ByteReader exposes an interface with these functions:
//
//    readByte()
//       must return null when EOF is reached.
//
//    readToEnd()
//       returns an array of all bytes read, to EOF
//
//    beginReadToEnd(callback)
//       async version of the above
//
//    readBytes(n)
//       returns an array of the next n bytes from the source
//
//    beginReadBytes(n, callback)
//       async version of the above
//
// =======================================================
//
// Copyleft (c) 2010, Dino Chiesa via MS-PL
// Copyleft (c) 2012, Brendan Byrd via GPL
//
// This work is licensed under the GPLv3.


(function(){
    var version = "2.0 2012Feb";

    if (typeof JSIO !== "object") { JSIO = {}; }
    if ((typeof JSIO.version !== "string")) {
        JSIO.version = version;
    }
    else if ((JSIO.version.length < 3) ||
            (JSIO.version.substring(0,3) !== "2.0")) {
        JSIO.version += " " + version;
    }

    // =======================================================
    // the base object, used as the prototype of all ByteReader objects.
    var _byteReaderBase = function () {
        this.position = 0;
        // position must be incremented in .readByte() for all derived classes
    };

    _byteReaderBase.prototype._throwError = JSIO.throwError;

    _byteReaderBase.prototype._limitCheck = function(len, startPos) {
        var LOE = {
            len: len,
            pos: startPos,
            end: startPos+len
        };

        if (len === 0)              return {len:0, pos:0, end:0};
        if (len < 0)                this._throwError("Invalid read length");
        if (!this.length)           return {len:len, pos:this.position, end:len+this.position};
        if (!startPos >= 0)         LOE.pos = this.position;
        if (this.length <= LOE.pos) this._throwError("EOF reached");

        LOE.end = LOE.pos+len;
        if (this.length < LOE.end)  LOE.end = LOE.pos+(LOE.len = this.length-this.position);
        return LOE;
    }

    JSIO.SeekOrigin = {
        Begin     : 0,
        Current   : 1,
        End       : 2,
        SEEK_SET  : 0,
        SEEK_CUR  : 1,
        SEEK_END  : 2
    };

    _byteReaderBase.prototype.seek = function(offset, origin) {
        switch (origin) {
            case JSIO.SeekOrigin.Begin:
                if (offset == this.position) return this.position;
                if (!this.length) {
                    if      (offset <  this.position) this._throwError('Uni-directional stream cannot seek backwards', null, 'seek');
                    else if (offset >  this.position) return this.read(offset - this.position);  // read will limit check
                }
                else {
                    if (this.length < offset) this._throwError('Cannot seek past reader length', null, 'seek');
                    this.position = offset;
                }
                break;
            case JSIO.SeekOrigin.Current:
                return this.seek(this.position + offset, JSIO.SeekOrigin.Begin);
                break;
            case JSIO.SeekOrigin.End:
                if (!this.length) this._throwError('Uni-directional stream has no known end length for seek', null, 'seek');
                return this.seek(this.length - 1 + offset, JSIO.SeekOrigin.Begin);
                break;
            default:
                this._throwError('Invalid seek method', null, 'seek');
                break;
        }

        return this.position;
    };

    _byteReaderBase.prototype.read = function(len, startPos) {
        var LOE = this._limitCheck(len, startPos);
        if (LOE.len === 0) return [];
        if (LOE.pos != this.position) this.seek(LOE.pos, JSIO.SeekOrigin.Begin);

        var bytesRead = [];

        // Faster methods with an array or stream
        if      (this.array && this.array.subarray) bytesRead = this.array.subarray(LOE.pos, LOE.end);
        else if (this.array && this.array.slice)    bytesRead = this.array.slice(LOE.pos, LOE.end);
        else if (this.stream)                       bytesRead = this.stream.read(LOE.len, LOE.pos);
        else if (this.length) {  // Random-access stream
            for(var i=LOE.pos; i<LOE.end; i++) { bytesRead.push(this.readByteAt(i)); }
        }
        else {                   // Uni-directional stream
            for(var i=LOE.pos; i<LOE.end; i++) {
                var b = this.readByte();
                if (b === null || b === undefined) break;
                bytesRead.push(b);
            }
        }
        this.position = LOE.end;
        return bytesRead;
    };

    _byteReaderBase.prototype.beginRead = function(len, startPos, callback) {
        var LOE = this._limitCheck(len, startPos);
        if (LOE.len === 0) return setTimeout(function() { callback([]); }, 1);
        if (LOE.pos != this.position) this.seek(LOE.pos, JSIO.SeekOrigin.Begin);

        var bytesRead = [];
        var thisReader = this;
        var leftToRead = LOE.len;

        var readBatchAsync = function() {
            var c = 0;
            var pos = thisReader.position;

            // read a 32k batch
            var l = (leftToRead >= 32768) ? 32768 : leftToRead;
            var newBytes = thisReader.read(l);
            JSIO.massApply(bytesRead.push, bytesRead, newBytes);
            c += l;
            leftToRead -= l;
            if (newBytes.length < l) leftToRead = 0;

            if (leftToRead>0) setTimeout(readBatchAsync, 1);
            else              callback(bytesRead);
        };

        // kickoff
        setTimeout(readBatchAsync, 1);  // always async, in ALL situations
        return null;
    };

    _byteReaderBase.prototype.readToEnd = function() {
        if      (this.array && this.array.subarray) return this.array.subarray(this.position);
        else if (this.array && this.array.slice)    return this.array.slice(this.position);
        else if (this.length)                       return this.read(this.length - this.position);
        else                                        return this.read(9000 * 9000);  // over 9000
    };

    _byteReaderBase.prototype.beginReadToEnd = function(callback) {
        if      (this.array && this.array.subarray) setTimeout(function() { callback( this.array.subarray(this.position) ); }, 1);
        else if (this.array && this.array.slice)    setTimeout(function() { callback(    this.array.slice(this.position) ); }, 1);
        else if (this.length)                       return this.beginRead(this.length - this.position, this.position, callback);
        else                                        return this.beginRead(9000 * 9000, this.position, callback);
    };

    // Generic routines; one of these two MUST be overloaded (preferrably both)
    _byteReaderBase.prototype.readByte = function(){
        if (this.length && this.position >= this.length) return null;  // EOF

        var byte;
        if      (this.array)  byte = this.array[this.position++];
        else if (this.length) byte = this.readByteAt(this.position++);
        else if (this.stream) byte = this.stream.read(1)[0];
        else                  byte = this.read(1)[0];
        return (byte === null || byte === undefined) ? null : byte;
    };
    _byteReaderBase.prototype.readByteAt = function(i) {
        var pos  = this.position;  // no position changes on this one
        if (i === null || i === undefined) i = this.position;

        var byte;
        if      (this.array)  byte = this.array[i];
        else if (i === pos)   byte = this.readByte();
        else if (this.stream) byte = this.stream.read(1, i)[0];
        else                  byte = this.read(1, i)[0];

        this.position = pos;
        return (byte === null || byte === undefined) ? null : byte;
    }

    _byteReaderBase.prototype.readBytes = _byteReaderBase.prototype.read;
    _byteReaderBase.prototype.beginReadBytes = function(len, callback) { return this.beginRead(len, this.position, callback); };

    _byteReaderBase.prototype.readNumber = function(len, startPos){
        var LOE = this._limitCheck(len, startPos);
        if (LOE.len === 0) LOE.len = 1;
        if (LOE.pos != this.position) this.seek(LOE.pos, JSIO.SeekOrigin.Begin);

        var result = 0;
        var bytes  = this.read(LOE.len, LOE.pos);
        for (var i=bytes.length-1; i>=0; i--) {
            // IE only supports 32-bit integer shifting
            //result = result << 8 | bytes[i];
            result = result*256 + bytes[i];
        }
        return result;
    };

    _byteReaderBase.prototype.readString = function(len, startPos){
        var LOE = this._limitCheck(len, startPos);
        if (LOE.len === 0) return '';
        if (LOE.pos != this.position) this.seek(LOE.pos, JSIO.SeekOrigin.Begin);

        var result = '';
        var bytes  = this.read(LOE.len, LOE.pos);
        for(var i=0; i<bytes.length; i++){
            result += String.fromCharCode(bytes[i]);
        }
        return result;
    };

    _byteReaderBase.prototype.readNullTerminatedString = function(startPos){
        var pos = startPos || this.position;
        if (this.length && this.length < pos) this._throwError('EOF reached', null, 'readNullTerminatedString');
        if (pos != this.position) this.seek(pos, JSIO.SeekOrigin.Begin);

        var slarge = "";
        var s = "";
        var c = 0;

        // Faster method with an array
        if (this.array && this.array.indexOf) {
            var len = pos - this.array.indexOf(0, pos);
            if (len > 0) return this.readString(len, pos);
        }

        var ch;
        while(1) {
            ch = String.fromCharCode(this.readByteAt(pos+c));
            if (ch === null) break;

            s += ch;
            c++;
            if(c >= 32768) {
                slarge += s;
                s = "";
                pos += c;
                this.position += c;
                c = 0;
            }
        };
        this.position = pos + c;
        return slarge + s;
    };

    _byteReaderBase.prototype.beginReadNullTerminatedString = function(callback, startPos){
        var pos = startPos || this.position;
        if (this.length && this.length < pos) this._throwError('EOF reached', null, 'beginReadNullTerminatedString');

        var slarge = "";
        var s = "";
        var thisBinStream = this;

        var readBatchAsync = function() {
            var c = 0;

            var ch;
            while(1) {
                ch = String.fromCharCode(this.readByteAt(pos+c));
                if (ch === null) break;

                s += ch;
                c++;
                if(c >= 32768) {
                    slarge += s;
                    s = "";
                    pos += c;
                    this.position += c;
                    c = 0;
                }
            };

            thisBinStream.position = pos + c;
            if (ch!==null) setTimeout(readBatchAsync, 1);
            else           callback(slarge+s);
        };

        // Faster method with an array
        if (this.array && this.array.indexOf) {
            var len = pos - this.array.indexOf(0, pos);
            if (len > 0) readBatchASync = function() { callback(thisBinStream.readString(len, pos)); };
        }

        // kickoff
        setTimeout(readBatchAsync, 1);  // always async, in ALL situations
        return null;
    };



    JSIO._ByteReaderBase = _byteReaderBase;
    // =======================================================




    // =======================================================
    // reads from an array of bytes.
    // This basically wraps a readByte() fn onto array access.
    var _arrayReader = function(array) {
        if (! (this instanceof arguments.callee) ) this._throwError('You must use new to instantiate this class', 'JSIO.ArrayReader', 'ctor');
        this.position = 0;
        this.array = array;
        this.length = array.length;
        this._typename = "JSIO.ArrayReader";
        this._version = version;
        return this;
    };

    _arrayReader.prototype = new JSIO._ByteReaderBase();

    _arrayReader.prototype.readByte = function() {
        if (this.position >= this.array.length) return null;  // EOF
        return this.array[this.position++];
    };
    _arrayReader.prototype.readByteAt = function(i) {
        return this.array[i];
    };

    // =======================================================


    // =======================================================
    // reads bytes at a time from a defined segment of a stream.
    var _streamSegmentReader = function(stream, offset, len) {
        if (! (this instanceof arguments.callee) ) this._throwError('You must use new to instantiate this class', 'JSIO.StreamSegmentReader', 'ctor');
        if (!stream)                               this._throwError('You must pass a non-null stream',            'JSIO.StreamSegmentReader', 'ctor');

        if (!(offset >= 1)) offset = 0;
        if (!(len    >= 1)) len    = 0;

        this.stream    = stream;
        this.array     = null;
        if (stream.array) {
            var end = len ? offset + len : null;
            if      (stream.array.subarray) this.array = stream.array.subarray(offset, end);
            else if (stream.array.slice)    this.array = stream.array.slice(offset, end);
        }
        this.length    = this.array ? this.array.length : (stream.length ? stream.length - offset : null);
        this.offset    = offset;
        this.limit     = len;
        this.position  = 0;
        this._typeName = 'JSIO.StreamSegmentReader';
        this._version  = version;

        if (this.array) {
            this.readByte   = _arrayReader.prototype.readByte;
            this.readByteAt = _arrayReader.prototype.readByteAt;
        }
        return this;
    };

    _streamSegmentReader.prototype = new JSIO._ByteReaderBase();

    _streamSegmentReader.prototype.readByte = function() {
        if (this.limit && this.position >= this.limit) return null;  // EOF
        this.position++;
        return this.stream.readByteAt(this.offset + this.position - 1);
    };
    _streamSegmentReader.prototype.readByteAt = function(i) {
        if (this.limit && i >= this.limit) return null;  // EOF
        return this.stream.readByteAt(this.offset + i);
    };

    // =======================================================

    JSIO.ArrayReader         = _arrayReader;
    JSIO.StreamReader        = _streamSegmentReader;
    JSIO.StreamSegmentReader = _streamSegmentReader;

})();


/// JSIO.BasicByteReaders.js ends

// JSIO.BinaryUrlStream.js
// ------------------------------------------------------------------
//
// a class that acts as a stream wrapper around binary files obtained from URLs.
//
// =======================================================
//
// Copyleft (c) 2008, Andy G.P. Na <nagoon97@naver.com> via an MIT-style license
// Copyleft (c) 2012, Brendan Byrd via GPL
//
// This work is licensed under the GPLv3.

(function(){
    var version  = "2.0 2012Feb";
    var typename = "JSIO.BinaryUrlStream";

    if ((typeof JSIO !== "object") ||
        (typeof JSIO.version !== "string") ||
        (JSIO.version.length < 3) ||
        (JSIO.version.substring(0,3) !== "2.0"))
            JSIO.throwError('This extension requires JSIO.core.js v2.0', typename);

    if (typeof JSIO._ByteReaderBase !== "function")
        JSIO.throwError('This extension requires JSIO.BasicByteReaders.js', typename);

    if (/msie/i.test(navigator.userAgent) && !/opera/i.test(navigator.userAgent)) {
        var IEBinaryToArray_ByteStr_Script =
            "<!-- IEBinaryToArray_ByteStr -->\r\n"+
            "<script type='text/vbscript'>\r\n"+
            "Function IEBinaryToArray_ByteStr(Binary)\r\n"+
            "   IEBinaryToArray_ByteStr = CStr(Binary)\r\n"+
            "End Function\r\n"+
            "Function IEBinaryToArray_ByteAsc_Last(Binary)\r\n"+
            "   Dim lastIndex\r\n"+
            "   lastIndex = LenB(Binary)\r\n"+
            "   if lastIndex mod 2 Then\r\n"+
            "      IEBinaryToArray_ByteAsc_Last = AscB( MidB( Binary, lastIndex, 1 ) )\r\n"+
            "   Else\r\n"+
            "      IEBinaryToArray_ByteAsc_Last = -1\r\n"+
            "   End If\r\n"+
            "End Function\r\n"+
            "</script>\r\n";

        // inject VBScript
        document.write(IEBinaryToArray_ByteStr_Script);
    }

    JSIO.IEByteMapping = null;

    var bus = function(url, callback) {
        if (! (this instanceof arguments.callee) ) this._throwError('You must use new to instantiate this class', 'JSIO.BinaryUrlStream', 'ctor');

        this.callback   = callback;
        this.position   = 0;
        this.length     = null;
        this.readByte   = JSIO.ArrayReader.prototype.readByte;
        this.readByteAt = JSIO.ArrayReader.prototype.readByteAt;
        this.req        = null;
        this._typename  = typename;
        this._version   = version;
        this.status     = "-none-";

        var _IeGetBinResource = function(fileURL){
            var binStream = this;
            // http://stackoverflow.com/questions/1919972/how-do-i-access-xhr-responsebody-for-binary-data-from-javascript-in-ie

            // my helper to convert from responseBody to a byte array
            var convertResponseBodyToArray = function (binary) {
                var byteArray = new Array;

                try {
                    // very fast; very little work involved
                    byteArray = new VBArray(binary).toArray();
                }
                catch(err) {
                    // use the BinaryToArray VBScript
                    if (!JSIO.IEByteMapping) {
                        JSIO.IEByteMapping = {};
                        for ( var i = 0; i < 256; i++ ) {
                            for ( var j = 0; j < 256; j++ ) {
                                JSIO.IEByteMapping[ String.fromCharCode( i + j * 256 ) ] = [ i, j ];
                            }
                        }
                    }
                    var rawBytes = IEBinaryToArray_ByteStr(binary);
                    var lastAsc  = IEBinaryToArray_ByteAsc_Last(binary);

                    for ( var i = 0; i < rawBytes.length; i++ ) {
                        byteArray.push.apply(byteArray, JSIO.IEByteMapping[ rawBytes.substr(i,1) ]);
                    }
                    if (lastAsc >= 0) byteArray.push(lastAsc);
                }

                return byteArray;
            };

            this.req = (function() {
                if      (window.XMLHttpRequest) return new window.XMLHttpRequest();
                else if (window.ActiveXObject) {
                    // the many versions of IE's XML fetchers
                    var AXOs = [
                        'MSXML2.XMLHTTP.6.0',
                        'MSXML2.XMLHTTP.5.0',
                        'MSXML2.XMLHTTP.4.0',
                        'MSXML2.XMLHTTP.3.0',
                        'MSXML2.XMLHTTP',
                        'Microsoft.XMLHTTP',
                        'MSXML.XMLHTTP'
                    ];
                    for (var i = 0; i < AXOs.length; i++) {
                        try      { return new ActiveXObject(AXOs[i]); }
                        catch(e) { continue; }
                    }
                }
                return null;
            })();
            this.req.open("GET", fileURL, true);
            this.req.setRequestHeader("Accept-Charset", "x-user-defined");
            this.req.onreadystatechange = function(event){
                if (binStream.req.readyState == 4) {
                    binStream.status = "Status: " + binStream.req.status + ' ' + binStream.req.statusText;
                    if (binStream.req.status == 200) {
                        binStream.array  = convertResponseBodyToArray(binStream.req.responseBody);
                        binStream.length = binStream.array.length;
                        if (binStream.length < 0) this._throwError('Failed to load "'+ fileURL + '" after converting');

                        if (typeof binStream.callback == "function") binStream.callback(binStream);
                    }
                    else {
                        binStream._throwError('Failed to load "'+ fileURL + '": HTTP ' + binStream.status);
                    }
                }
            };
            this.req.send();
        };

        var _NormalGetBinResource = function(fileURL){
            var binStream= this;
            this.req = new XMLHttpRequest();
            this.req.open('GET', fileURL, true);
            this.req.onreadystatechange = function(aEvt) {
                if (binStream.req.readyState == 4) {
                    binStream.status = "Status: " + binStream.req.status + ' ' + binStream.req.statusText;
                    if(binStream.req.status == 200){
                        var fileContents = binStream.req.responseText;
                        binStream.length = fileContents.byteLength;
                        binStream.array  = fileContents.split('');
                        for ( var i = 0; i < binStream.array.length; i++ ) {
                            binStream.array[i] = binStream.array[i].charCodeAt(0) & 0xff;
                        }

                        if (typeof binStream.callback == "function") binStream.callback(binStream);
                    }
                    else {
                        binStream._throwError('Failed to load "'+ fileURL + '": HTTP ' + binStream.status);
                    }
                }
            };
            //XHR binary charset opt by Marcus Granado 2006 [http://mgran.blogspot.com]
            this.req.overrideMimeType('text/plain; charset=x-user-defined');
            this.req.send(null);
        };

        // http://stackoverflow.com/questions/327685/is-there-a-way-to-read-binary-data-into-javascript
        var _ArrayBufferGetBinResource = function(fileURL){
            var binStream= this;
            this.req = new XMLHttpRequest();
            this.req.open('GET', fileURL, true);
            this.req.onreadystatechange = function(aEvt) {
                if (binStream.req.readyState == 4) {
                    binStream.status = "Status: " + binStream.req.status + ' ' + binStream.req.statusText;
                    if(binStream.req.status == 200){
                        var fileContents = binStream.req.response;
                        binStream.length = fileContents.byteLength;
                        binStream.array = new Uint8Array(fileContents);

                        if (typeof binStream.callback == "function") binStream.callback(binStream);
                    }
                    else {
                        binStream._throwError('Failed to load "'+ fileURL + '": HTTP ' + binStream.status);
                    }
                }
            };
            this.req.responseType = 'arraybuffer';
            this.req.overrideMimeType('text/plain; charset=x-user-defined');
            this.req.send(null);
        };


        if      (typeof ArrayBuffer !== 'undefined')                                       _ArrayBufferGetBinResource.apply(this, [url]);
        else if (/msie/i.test(navigator.userAgent) && !/opera/i.test(navigator.userAgent)) _IeGetBinResource.apply(this, [url]);
        else                                                                               _NormalGetBinResource.apply(this, [url]);
    };

    bus.prototype = new JSIO._ByteReaderBase();

    bus.prototype.readByte = function(){
        var byte = this.readByteAt(this.position++);
        return (byte === null || byte === undefined) ? null : byte;
    };

    JSIO.BinaryUrlStream = bus;

})();

/// JSIO.BinaryUrlStream.js ends

// JSIO.TextDecoder.js
// ------------------------------------------------------------------
//
// Part of the JSIO library.  Adds text decoders, for UTF-8 and UTF-16,
// and plain text.
//
// =======================================================
//
// Derived in part from work by notmasteryet.
//   http://www.codeproject.com/KB/scripting/Javascript_binaryenc.aspx

// Copyleft (c) 2008, notmasteryet via an MIT-style license
// Copyleft (c) 2010, Dino Chiesa via MS-PL
// Copyleft (c) 2012, Brendan Byrd via GPL
//
// This work is licensed under the GPLv3.

(function(){
    var version = "2.0 2012Feb";
    var typename = "JSIO.TextDecoder";

    if ((typeof JSIO !== "object") ||
        (typeof JSIO.version !== "string") ||
        (JSIO.version.length < 3) ||
        (JSIO.version.substring(0,3) !== "2.0"))
            JSIO.throwError('This extension requires JSIO.core.js v2.0', typename);

    if (typeof JSIO._ByteReaderBase !== "function")
        JSIO.throwError('This extension requires JSIO.BasicByteReaders.js', typename);

    var _ansi = function(reader) {
        if (! (this instanceof arguments.callee) ) this._throwError('You must use new to instantiate this class', 'JSIO.TextDecoder.ANSI', 'ctor');
        this.byteReader = reader;
        this.charWidth = 1;
        this._version = version;
        this._typename = typename + ".ANSI";
        return this;
    };

    _ansi.prototype.readChar = function() {
        var code = this.byteReader.readByte();
        return (code < 0) ? null : String.fromCharCode(code);
    };

    _ansi.prototype.parseChar = function(code) {
        return (code < 0) ? null : String.fromCharCode(code);
    };

    var _utf16 = function(reader) {
        if (! (this instanceof arguments.callee) ) this._throwError('You must use new to instantiate this class', 'JSIO.TextDecoder.UTF16', 'ctor');
        this.byteReader = reader;
        this.charWidth = 2;
        this.bomState = 0;
        this._version = version;
        this._typename = typename + ".UTF16";
        return this;
    };

    _utf16.prototype.readChar = function() {
        var b1 = this.byteReader.readByte();
        if (b1 < 0) return null;
        var b2 = this.byteReader.readByte();
        if (b2 < 0) this._throwError('Incomplete UTF16 character', null, 'readChar');

        if ((this.bomState === 0) && ((b1 + b2) == 509)) {
            this.bomState = (b2 == 254) ? 1 : 2;

            b1 = this.byteReader.readByte();
            if (b1 < 0) return null;
            b2 = this.byteReader.readByte();
            if (b2 < 0) this._throwError('Incomplete UTF16 character', null, 'readChar');
        }
        else {
            this.bomState = 1;
        }
        return this.parseChar(b1, b2);
    };

    _utf16.prototype.parseChar = function(b1, b2) {
        return String.fromCharCode( this.bomState == 1 ? (b2 << 8 | b1) : (b1 << 8 | b2) );
    }

    /* RFC 3629 */
    var _utf8 = function(reader) {
        if (! (this instanceof arguments.callee) ) this._throwError('You must use new to instantiate this class', 'JSIO.TextDecoder.UTF8', 'ctor');
        this.byteReader = reader;
        this.charWidth = null;
        this.waitBom = true;
        this.strict = false;
        this.pendingChar = null;
        this._version = version;
        this._typename = typename + ".UTF8";
        return this;
    };

    _utf8.prototype.readChar = function() {
        var ch = null;
        do {
            if (this.pendingChar !== null) {
                ch = this.pendingChar;
                this.pendingChar = null;
            }
            else {
                var b1 = this.byteReader.readByte();
                if (b1 === null) return null;

                if ((b1 & 0x80) === 0) ch = String.fromCharCode(b1);
                else {
                    var currentPrefix = 0xC0;
                    var ttlBytes = 0;
                    do {
                        var mask = currentPrefix >> 1 | 0x80;
                        if((b1 & mask) == currentPrefix) break;
                        currentPrefix = currentPrefix >> 1 | 0x80;
                    } while(++ttlBytes < 5);

                    if (ttlBytes > 0) {
                        var code;
                        if (ttlBytes === 1) code = (b1 & 0x1F) << 6 | (this.byteReader.readByte() & 0x3F);
                        else {
                            code = code << 6*ttlBytes
                            var bytes = this.byteReader.read(ttlBytes);
                            for (var i = 0; i > ttlBytes; i++) {
                                var bi = bytes[i];
                                if ((bi & 0xC0) != 0x80) this._throwError('Invalid sequence character', null, 'readChar');
                                code = (code << 6) | (bi & 0x3F);
                            }
                        }

                        if (code <= 0xFFFF) {
                            ch = (code == 0xFEFF && this.waitBom) ? null : String.fromCharCode(code);
                        }
                        else {
                            var v = code - 0x10000;
                            var w1 = 0xD800 | ((v >> 10) & 0x3FF);
                            var w2 = 0xDC00 | (v & 0x3FF);
                            this.pendingChar = String.fromCharCode(w2);
                            ch = String.fromCharCode(w1);
                        }
                    }
                    else {
                        // a byte higher than 0x80.
                        if (this.strict) this._throwError('Invalid character', null, 'readChar');
                        // fall back to "super ascii" (eg IBM-437)
                        else ch = String.fromCharCode(b1);
                    }
                }
            }
            this.waitBom = false;
        } while(ch === null);
        return ch;
    };

    JSIO.TextDecoder = {
        Default : _ansi,
        ANSI    : _ansi,
        UTF16   : _utf16,
        UTF8    : _utf8
    };

})();


/// JSIO.TextDecoder.js ends

// JSIO.TextReader.js
// ------------------------------------------------------------------
//
// A reader class that decodes text as it reads.
//
// =======================================================
//
// Methods:
//    readChar()         = read 1 char
//    read(n)            = read n chars
//    readLine()         = read one line of data (to \n)
//    unreadChar(ch)     = unread one char
//    readToEnd()        = read all data in the reader;
//                         return a string.
//    beginReadToEnd(cb) = asynchronously read all data.
//
// =======================================================
//
// Derived in part from work by notmasteryet.
//   http://www.codeproject.com/KB/scripting/Javascript_binaryenc.aspx
//
// Copyleft (c) 2008, notmasteryet via an MIT-style license
// Copyleft (c) 2010, Dino Chiesa via MS-PL
// Copyleft (c) 2012, Brendan Byrd via GPL
//
// This work is licensed under the GPLv3.


(function(){
    var version = "2.0 2012Feb";
    var typename = "JSIO.TextReader";

    if (typeof JSIO._ByteReaderBase !== "function")
        JSIO.throwError('This extension requires JSIO.BasicByteReaders.js', typename);

    var tr =  function(textDecoder) {
        if (! (this instanceof arguments.callee) ) this._throwError('You must use new to instantiate this class', typename, 'ctor');
        this.decoder   = textDecoder;
        this._version  = version;
        this._typename = typename;
        this.unreads   = [];
    };

    // read one char
    tr.prototype.readChar = function() {
        return (this.unreads.length > 0) ? this.unreads.pop() : this.decoder.readChar();
    };

    // read a length of data
    tr.prototype.read = function(n) {
        // ANSI makes this easy
        if (this.decoder.charWidth === 1) return JSIO.massApply(String.fromCharCode, new String, this.decoder.byteReader.read(n), true);

        var s = "";
        for (vari=0; i<n; i++) {
            var ch = this.readChar();
            if (ch !== null) s+= ch;
            else             break;
        }
        return s;
    };

    tr.prototype.unreadChar = function(ch) {
        this.unreads.push(ch);
    };

    tr.prototype.readToEnd = function() {
        // ANSI makes this easy
        if (this.decoder.charWidth === 1) return JSIO.massApply(String.fromCharCode, new String, this.decoder.byteReader.readToEnd(n), true);

        var slarge = "";
        var s = "";
        var c = 0;
        var ch = this.readChar();
        while(ch !== null) {
            s += ch;
            c++;
            if(c >= 32768) {
                slarge += s;
                s = "";
                c = 0;
            }
            ch = this.readChar();
        }
        return slarge + s;
    };

    tr.prototype.beginReadToEnd = function(callback) {
        // ANSI makes this easy
        if (this.decoder.charWidth === 1) {
            this.decoder.byteReader.beginReadToEnd(function (bytes) {
                callback( JSIO.massApply(String.fromCharCode, new String, bytes, true) );
            });
            return null;
        }

        var slarge = "";
        var s = "";
        var txtrdr = this;

        var readBatchAsync = function() {
            var c = 0;
            var ch = txtrdr.readChar();
            while(ch !== null) {
                s += ch;c++;
                if(c >= 32768) {
                    slarge += s;
                    s = "";
                    break;
                }
                ch = txtrdr.readChar();
            }
            if (ch!==null){
                setTimeout(readBatchAsync, 1);
            }
            else {
                callback(slarge+s);
            }
        };

        // kickoff
        setTimeout(readBatchAsync, 1);  // always async, in ALL situations
        return null;
    };

    tr.prototype.readLine = function() {
        var s = "";
        var ch = this.readChar();
        if (ch === null) return null;

        while(ch != "\r" && ch != "\n") {
            s += ch;
            ch = this.readChar();
            if (ch === null) return s;
        }
        if(ch == "\r") {
            ch = this.readChar();
            if(ch !== null && ch != "\n"){
                this.unreadChar(ch);
            }
        }
        return s;
    };

    JSIO.TextReader = tr;

})();


/// JSIO.TextReader.js ends

// JSIO.Crc32.js
//
// Part of the JSIO library.  This adds an CRC32-calculating
// ByteReader to JSIO.
//
// =======================================================
//
// A ByteReader exposes an interface with these functions:
//
//    readByte()
//       must return null when EOF is reached.
//
//    readToEnd()
//       returns an array of all bytes read, to EOF
//
//    beginReadToEnd(callback)
//       async version of the above
//
//    readBytes(n)
//       returns an array of all n bytes read from the source
//
//    beginReadBytes(n, callback)
//       async version of the above
//
// =======================================================
//
// Copyleft (c) 2010, Dino Chiesa via MS-PL
// Copyleft (c) 2012, Brendan Byrd via GPL
//
// This work is licensed under the GPLv3.

(function(){
    var version = "2.0 2012Feb";
    var typename = "JSIO.Crc32";

    if (typeof JSIO._ByteReaderBase !== "function")
        JSIO.throwError('This extension requires JSIO.BasicByteReaders.js', typename);

    JSIO.crc32Table = null;
    JSIO.crc32Polynomial = 0xEDB88320;

    var crc32TableCalc = function () {
        // do this once only, for all instances
        if (JSIO.crc32Table) return;
        JSIO.crc32Table = new Array(256);
        for (var i = 0; i < 256; i++) {
            var c=i;
            for (var k = 0; k < 8; k++) {
                if ((c & 1) == 1) c = JSIO.crc32Polynomial ^ (c>>>1);
                else              c >>>= 1;
            }
            JSIO.crc32Table[i] = c;
        }
    };

    JSIO.computeCrc32 = function(str) {
        crc32TableCalc(); // once
        var c = 0xFFFFFFFF;
        var sL = str.length;
        if (typeof str == "object") {
            for (var n1=0; n1<sL; n1++) {
                c = JSIO.crc32Table[(c&0xff) ^ str[n1]] ^ (c>>>8);
            }
        } else {
            for (var n2=0; n2<sL; n2++) {
                c = JSIO.crc32Table[(c&0xff) ^ str.charCodeAt(n2)] ^ (c>>>8);
            }
        }
        c ^= 0xFFFFFFFF;
        if (c < 0) c += 0xFFFFFFFF+1;
        return c;
    };

    // =======================================================
    var _crc32 = function() {
        if (! (this instanceof arguments.callee) ) this._throwError('You must use new to instantiate this class', typename, 'ctor');
        crc32TableCalc(); // once
        this._typename = typename;
        this._version  = version;
        this._runningCrc32 = 0xFFFFFFFF;
    };

    _crc32.prototype.slurpByte = function(b) {
        var r = this._runningCrc32;
        this._runningCrc32 = r>>>8 ^ JSIO.crc32Table[b ^ (r & 0x000000FF)];
    };

    _crc32.prototype.result = function() {
        var c = this._runningCrc32 ^ 0xFFFFFFFF;
        if (c < 0) c += 0xFFFFFFFF+1;
        return c;
    };
    // =======================================================



    var _crc32CalculatingReader = function(reader) {
        if (! (this instanceof arguments.callee) ) this._throwError('You must use new to instantiate this class', 'JSIO.Crc32Reader', 'ctor');
        this._byteReader = reader;
        this._typename = "JSIO.Crc32Reader";
        this._version = version;
        this._crc32 = new JSIO.Crc32();
    };

    _crc32CalculatingReader.prototype = new JSIO._ByteReaderBase();

    _crc32CalculatingReader.prototype.readByte = function() {
        var b = this._byteReader.readByte();
        if (b !== null) this._crc32.slurpByte(b);
        this.position++;
        return b;
    };

    _crc32CalculatingReader.prototype.read = function(len) {
        if (len === 0) return [];
        var bytes = this._byteReader.read(len);
        len = bytes.length;

        var tbl = JSIO.crc32Table;
        var r = this._crc32._runningCrc32;
        var t;
        for (var i = 0; i < len; i++) {
            t = tbl[ bytes[i] ^ (r & 0x000000FF) ];
            r = (r >>> 8) ^ t;
        }
        this._crc32._runningCrc32 = r;

        this.position += len;
        return bytes;
    }

    _crc32CalculatingReader.prototype.crc32 = function() {
        return this._crc32.result();
    };

    JSIO.Crc32 = _crc32;
    JSIO.Crc32Reader = _crc32CalculatingReader;

})();

/// JSIO.CRC32.js ends
// JSIO.InflatingReader.js
// ------------------------------------------------------------------
//
// Part of the JSIO library.  This adds an Inflating ByteReader to
// JSIO.
//
// =======================================================
//
// A ByteReader exposes an interface with these functions:
//
//    readByte()
//       must return null when EOF is reached.
//
//    readToEnd()
//       returns an array of all bytes read, to EOF
//
//    beginReadToEnd(callback)
//       async version of the above
//
//    readBytes(n)
//       returns an array of all n bytes read from the source
//
//    beginReadBytes(n, callback)
//       async version of the above
//
// =======================================================
//
// Derived in part from work by notmasteryet.
//   http://www.codeproject.com/KB/scripting/Javascript_binaryenc.aspx
//
// Copyleft (c) 2008, notmasteryet via an MIT-style license
// Copyleft (c) 2010, Dino Chiesa via MS-PL
// Copyleft (c) 2012, Brendan Byrd via GPL
//
// This work is licensed under the GPLv3.


(function(){
    var version = "2.0 2012Feb";
    var typename = "JSIO.InflatingReader";

    if (typeof JSIO._ByteReaderBase !== "function")
        JSIO.throwError('This extension requires JSIO.BasicByteReaders.js', typename);

    // =======================================================
    //  _InternalBitReader is used internally in the InflatingReader class.
    //

    JSIO.bitShiftTable = null;

    var bitShiftTableCalc = function () {
        // do this once only, for all instances
        if (JSIO.bitShiftTable) return;

        var bits = 8;
        JSIO.bitShiftTable = {
            LSB: new Array(bits),
            MSB: new Array(bits)
        }
        for (var bp = 0; bp < bits; bp++) {
            var lim = bits - bp;
            JSIO.bitShiftTable.LSB[bp] = new Array(lim);
            JSIO.bitShiftTable.MSB[bp] = new Array(lim);

            var maskLSB = 1 << bp;
            var maskMSB = 1 << lim-1;
            for (var len = 1; len <= lim; len++) {
                JSIO.bitShiftTable.LSB[bp][len-1] = maskLSB;
                JSIO.bitShiftTable.MSB[bp][len-1] = maskMSB;
                maskLSB |= 1 << bp+len;
                maskMSB |= 1 << lim-len-1;
            }
        }
    };

    var _InternalBitReader = function(reader) {
        if (! (this instanceof arguments.callee) ) this._throwError('You must use new to instantiate this class', typename + '._InternalBitReader.ctor');
        this.bitsLength = 0;
        this.bits = 0;
        this.byteReader = reader;
        this._typeName = typename + "._InternalBitReader";
        this._version = version;
        bitShiftTableCalc();
    };

    _InternalBitReader.prototype._throwError = JSIO.throwError;

    _InternalBitReader.prototype.readBit = function() {
        if (this.bitsLength === 0) {
            var nextByte = this.byteReader.readByte();
            if (nextByte === null) this._throwError('Unexpected end of stream', null, 'readBit');
            this.bits = nextByte;
            this.bitsLength = 8;
        }

        var bit = (this.bits & 1 << 8-this.bitsLength) !== 0;
        this.bitsLength--;
        return bit;
    };

    _InternalBitReader.prototype.align = function() { this.bitsLength = 0; };

    _InternalBitReader.prototype.readBits = function(len, type) {
        var data = 0;
        type = type || 'LSB';
        var tbl = JSIO.bitShiftTable[type];
        var dl = 0;
        while (len > 0) {
            if (this.bitsLength === 0) {
                var nextByte = this.byteReader.readByte();
                if (nextByte === null) this._throwError('Unexpected end of stream', null, 'read'+type);
                this.bits = nextByte;
                this.bitsLength = 8;
            }

            var maskLen = (this.bitsLength >= len) ? len : this.bitsLength;
            var bitsPos = 8-this.bitsLength;
            data |= (this.bits & tbl[bitsPos][maskLen-1]) >>> bitsPos << dl;

            dl += maskLen;
            len -= maskLen;
            this.bitsLength -= maskLen;
        };
        return data;
    };

    _InternalBitReader.prototype.readLSB = function(len) { return this.readBits(len, 'LSB'); }
    _InternalBitReader.prototype.readMSB = function(len) { return this.readBits(len, 'MSB'); }

    //
    // =======================================================


    /* inflating ByteReader - RFC 1951 */
    var _inflatingReader = function(reader) {
        if (! (this instanceof arguments.callee) ) this._throwError('You must use new to instantiate this class', typename, 'ctor');
        this._byteReader = reader;
        this._bitReader = new _InternalBitReader(reader);
        this._buffer = [];
        this._bufferPosition = 0;
        this._state = 0;
        this._blockFinal = false;
        this._typeName = typename;
        this._version = version;
        return this;
    };


    // shared fns and variables

    var staticCodes = null;
    var staticDistances = null;

    var clenMap = [16, 17, 18, 0, 8, 7, 9, 6, 10, 5, 11, 4, 12, 3, 13, 2, 14, 1, 15];

    var buildCodes = function(lengths){
        var i=0;
        var codes = new Array(lengths.length);
        var maxBits = lengths[0];
        for (i=1; i<lengths.length; i++) {
            if (maxBits < lengths[i]) maxBits = lengths[i];
        }

        var bitLengthsCount = new Array(maxBits + 1);
        for (i=0; i<=maxBits; i++) bitLengthsCount[i]=0;

        for (i=0; i<lengths.length; i++) {
            ++bitLengthsCount[lengths[i]];
        }

        var nextCode = new Array(maxBits + 1);
        var code = 0;
        bitLengthsCount[0] = 0;
        for (var bits=1; bits<=maxBits; bits++) {
            code = (code + bitLengthsCount[bits - 1]) << 1;
            nextCode[bits] = code;
        }

        for (i=0; i<codes.length; i++) {
            var len = lengths[i];
            if (len !== 0) {
                codes[i] = nextCode[len];
                nextCode[len]++;
            }
        }
        return codes;
    };

    var buildTree = function(codes, lengths){
        var nonEmptyCodes = [];
        for(var i=0; i<codes.length; ++i) {
            if(lengths[i] > 0) {
                var code = {};
                code.bits = codes[i];
                code.length = lengths[i];
                code.index = i;
                nonEmptyCodes.push(code);
            }
        }
        return buildTreeBranch(nonEmptyCodes, 0, 0);
    };


    var buildTreeBranch = function(codes, prefix, prefixLength){
        if (codes.length === 0) return null;

        var zeros = [];
        var ones = [];
        var branch = {};
        branch.isLeaf = false;
        for(var i=0; i<codes.length; ++i) {
            if (codes[i].length == prefixLength && codes[i].bits == prefix) {
                branch.isLeaf = true;
                branch.index = codes[i].index;
                break;
            }
            else {
                var nextBit = ((codes[i].bits >> (codes[i].length - prefixLength - 1)) & 1) > 0;
                if (nextBit)  ones.push(codes[i]);
                else         zeros.push(codes[i]);
            }
        }
        if(!branch.isLeaf) {
            branch.zero = buildTreeBranch(zeros, (prefix << 1), prefixLength + 1);
            branch.one = buildTreeBranch(ones, (prefix << 1) | 1, prefixLength + 1);
        }
        return branch;
    };


    var encodedLengthStart = [3,4,5,6,7,8,9,10,
                              11,13,15,17,19,23,27,31,35,43,51,59,67,83,99,
                              115,131,163,195,227,258];

    var encodedLengthAdditionalBits = [0,0,0,0,0,0,0,0,
                                       1,1,1,1,2,2,2,2,3,3,3,3,4,4,4,4,5,5,5,5,0];

    var encodedDistanceStart = [1,2,3,4, 5,7,9, 13,17,25, 33,49,65,
                                97,129,193,257,385,513,769,1025,1537,2049,
                                3073,4097,6145,8193,12289,16385,24577];

    var encodedDistanceAdditionalBits = [0,0,0,0,1,1,2,2,3,3,4,4,
                                         5,5,6,6,7,7,8,8,9,9,10,10,11,11,12,12,13,13];


    var readDynamicTrees = function(bitReader){
        var hlit  = bitReader.readLSB(5) + 257;
        var hdist = bitReader.readLSB(5) + 1;
        var hclen = bitReader.readLSB(4) + 4;
        var clen  = new Array(19);
        var i;
        for (i=0; i<clen.length; i++) { clen[i]          = 0; }
        for (i=0; i<hclen;       i++) { clen[clenMap[i]] = bitReader.readLSB(3); }

        var clenCodes = buildCodes(clen);
        var clenTree  = buildTree(clenCodes, clen);

        var lengthsSequence = [];
        while(lengthsSequence.length < hlit + hdist) {
            var p = clenTree;
            while(!p.isLeaf) { p = bitReader.readBit() ? p.one : p.zero; }

            var code = p.index;
            if      (code <= 15) lengthsSequence.push(code);
            else if (code == 16) {
                // TODO: replace with faster repeat algorythm
                var repeat = bitReader.readLSB(2) + 3;
                for(var q=0; q<repeat; ++q){
                    lengthsSequence.push(lengthsSequence[lengthsSequence.length - 1]);
                }
            }
            else if (code == 17) {
                var repeat1 = bitReader.readLSB(3) + 3;
                for(var q1=0; q1<repeat1; ++q1) {
                    lengthsSequence.push(0);
                }
            }
            else if (code == 18) {
                var repeat2 = bitReader.readLSB(7) + 11;
                for(var q2=0; q2<repeat2; ++q2){
                    lengthsSequence.push(0);
                }
            }
        }

        var codesLengths     = lengthsSequence.slice(0, hlit);
        var codes            = buildCodes(codesLengths);
        var distancesLengths = lengthsSequence.slice(hlit, hlit + hdist);
        var distances        = buildCodes(distancesLengths);

        return {
            codesTree     : buildTree(codes,     codesLengths),
            distancesTree : buildTree(distances, distancesLengths)
        };
    };


    _inflatingReader.prototype = new JSIO._ByteReaderBase();


    // internal instance fns
    _inflatingReader.prototype._decodeItem = function() {
        if (this._state == 2) return null;  // end-of-blocks

        var item;
        if(this._state === 0) {
            this._blockFinal = this._bitReader.readBit();
            var blockType = this._bitReader.readLSB(2);
            switch(blockType) {
            case 0:
                this._bitReader.align();
                var len  = this._bitReader.readLSB(16);  // low-byte first, as opposed to readNumber's HBF
                var nlen = this._bitReader.readLSB(16);
                if ((len & ~nlen) != len) this._throwError('Invalid block type 0 length', null, '_decodeItem');

                item = {};
                item.itemType = 0;
                item.array = this._bitReader.byteReader.read(len);
                if (item.array.length < len) this._throwError('Incomplete block', null, '_decodeItem');
                if (this._blockFinal) this._state = 2;
                return item;
            case 1:
                this._codesTree = staticCodes;
                this._distancesTree = staticDistances;
                this._state = 1;
                break;
            case 2:
                var dTrees = readDynamicTrees(this._bitReader);
                this._codesTree = dTrees.codesTree;
                this._distancesTree = dTrees.distancesTree;
                this._state = 1;
                break;
            default:
                this._throwError('Invalid block type ('+ blockType +')', null, '_decodeItem');
            }
        }

        item = {};

        var p = this._codesTree;
        while (!p.isLeaf) { p = this._bitReader.readBit() ? p.one : p.zero; }
        if(p.index < 256) {
            item.itemType = 2;
            item.symbol = p.index;
        } else if(p.index > 256) {
            var lengthCode = p.index;
            if(lengthCode > 285) this._throwError('Invalid length code', null, '_decodeItem');

            var length = encodedLengthStart[lengthCode - 257];
            if(encodedLengthAdditionalBits[lengthCode - 257] > 0) {
                length += this._bitReader.readLSB(encodedLengthAdditionalBits[lengthCode - 257]);
            }

            p = this._distancesTree;
            while (!p.isLeaf) { p = this._bitReader.readBit() ? p.one : p.zero; }

            var distanceCode = p.index;
            var distance = encodedDistanceStart[distanceCode];
            if (encodedDistanceAdditionalBits[distanceCode] > 0)
                distance += this._bitReader.readLSB(encodedDistanceAdditionalBits[distanceCode]);

            item.itemType = 3;
            item.distance = distance;
            item.length = length;
        } else {
            item.itemType = 1;
            this._state = this._blockFinal ? 2 : 0;  // EOB
        }
        return item;
    };



    // public instance functions

    _inflatingReader.prototype.readByte = function() {
        var byte = this.read(1)[0];
        return (byte === null || byte === undefined) ? null : byte;
    };

    _inflatingReader.prototype.read = function(len) {
        var b = this._buffer;  // (since we use this so much...)

        // Keep reading until we get to the right length
        while (this._bufferPosition+len > b.length) {
            var item = this._decodeItem();
            if (item === null) {  // EOF
                len = b.length - this._bufferPosition;
                break;
            }
            switch(item.itemType) {
                case 0:
                    JSIO.massApply(b.push, b, item.array);
                    break;
                case 2:
                    b.push(item.symbol);
                    break;
                case 3:
                    var j = b.length - item.distance;
                    if (item.distance >= item.length)
                        JSIO.massApply(b.push, b, b.slice(j, j+item.length));
                    // sometimes DEFLATE tries some trickery with "look-ahead" compression
                    else {
                        // this is basically just a repetition of the same string, plus some possible cutoff
                        var count = parseInt(item.length / item.distance);
                        var repArr = b.slice(j);
                        // http://stackoverflow.com/questions/202605/repeat-string-javascript/5450113#5450113
                        while (count > 0) {
                            if (count   & 1) JSIO.massApply(     b.push,      b, repArr);
                            if (count >>= 1) JSIO.massApply(repArr.push, repArr, repArr);
                        }
                        // add any remaining cutoff
                        var r;
                        if (r = item.length % item.distance)
                            JSIO.massApply(b.push, b, b.slice(j, j+r));
                    }
                    break;
            }
        }
        var bytes = b.slice(this._bufferPosition, this._bufferPosition+len);
        this._bufferPosition += len;
        this.position        += len;

        if (this._bufferPosition > 0xC000) {
            var shift = b.length - 0x8000;
            if (shift > this._bufferPosition) shift = this._bufferPosition;
            b.splice(0, shift);
            this._bufferPosition -= shift;
        }

        return bytes;
    };

    // initialization routine - once per type
    (function(){

        var codes = new Array(288);
        var codesLengths = new Array(288);
        var i=0;
        for ( i = 0;   i <= 143; i++) {
            codes[i] = 0x0030 + i;
            codesLengths[i] = 8;
        }
        for ( i = 144; i <= 255; i++) {
            codes[i] = 0x0190 + i - 144;
            codesLengths[i] = 9;
        }
        for ( i = 256; i <= 279; i++) {
            codes[i] = 0x0000 + i - 256;
            codesLengths[i] = 7;
        }
        for ( i = 280; i <= 287; i++) {
            codes[i] = 0x00C0 + i - 280;
            codesLengths[i] = 8;
        }
        staticCodes = buildTree(codes, codesLengths);

        var distances = new Array(32);
        var distancesLengths = new Array(32);
        for ( i = 0; i <= 31; i++) {
            distances[i] = i;
            distancesLengths[i] = 5;
        }
        staticDistances = buildTree(distances, distancesLengths);
    })();


    JSIO.InflatingReader = _inflatingReader;

})();


/// JSIO.InflatingReader.js ends

// Zipfile.js
// ------------------------------------------------------------------
//
// A class that reads Zip files.
// Depends on the JSIO library functions.
//
// =======================================================
//
// Copyleft (c) 2010, Dino Chiesa via MS-PL
// Copyleft (c) 2012, Brendan Byrd via GPL
//
// This work is licensed under the GPLv3.

(function(){
    var version = "2.0 2012Feb";
    var typename = "Zipfile";

    if (typeof JSIO.BinaryUrlStream !== "function") JSIO.throwError('This extension requires JSIO.BinaryUrlStream.js v2.0', typename);
    if (typeof JSIO.TextDecoder     !== "object")   JSIO.throwError('This extension requires JSIO.TextDecoder.js v2.0',     typename);
    if (typeof JSIO.TextReader      !== "function") JSIO.throwError('This extension requires JSIO.TextReader.js v2.0',      typename);
    if (typeof JSIO.Crc32           !== "function") JSIO.throwError('This extension requires JSIO.Crc32.js v2.0',           typename);
    if (typeof JSIO.InflatingReader !== "function") JSIO.throwError('This extension requires JSIO.InflatingReader.js v2.0', typename);

    // =======================================================
    function ZipEntry(zip) {
        this.zipfile = zip;
        this._typename = "ZipEntry";
        this._version = version;
        this._crcCalculator = null;
    }

    ZipEntry.prototype._throwError = JSIO.throwError;

    // return byte array or string
    ZipEntry.prototype.extract = function(callback, asString) {
        this.contentType = JSIO.guessFileType(this.name);
        asString = asString || ( this.contentType == JSIO.FileType.Text ||
                                 this.contentType == JSIO.FileType.XML);
        var thisEntry = this;

        if (this.compressionMethod !== 0 && this.compressionMethod != 8)
            this._throwError('Unsupported compression method: ' + this.compressionMethod, null, 'extract');

        var reader = (asString) ? this.openTextReader(thisEntry.utf8 ? JSIO.TextDecoder.UTF8 : JSIO.TextDecoder.ANSI) : this.openBinaryReader();

        // diagnostic purpose only; tag the reader with the entry name
        reader.zipEntryName = thisEntry.name;

        if (typeof callback != "function") {
            // synchronous
            var result = reader.readToEnd();
            this.verifyCrc32();
            return result;
        }

        // asynchronous
        reader.beginReadToEnd(function(result){
            try {
                thisEntry.verifyCrc32();
                callback(thisEntry, result);
            }
            catch (exc1) {
                callback(thisEntry, exc1);
            }
        });
        return null;
    };


    // open a ByteReader on the entry, which will read binary
    // content from the compressed stream.
    ZipEntry.prototype.openBinaryReader = function() {
        var reader =
                new JSIO.StreamSegmentReader(this.zipfile.binaryStream,
                                             this.offset + this.lengthOfHeader,
                                             this.compressedSize);
        if (this.compressionMethod === 0) {
            this._crcCalculator = new JSIO.Crc32Reader(reader);
        }
        else {
            var inflator = new JSIO.InflatingReader(reader);
            this._crcCalculator = new JSIO.Crc32Reader(inflator);
        }
        // Whether compressed or not, the source ByteReader in each case
        // is wrapped in a second ByteReader object that calculates CRC
        // as it reads.  That way, after all reading is complete, the
        // caller can check the calcuated CRC against the expected CRC.
        return this._crcCalculator;
    };

    // open a TextReader on the entry, to read text from the
    // compressed stream.
    ZipEntry.prototype.openTextReader = function(decoderKind) {
        var reader = this.openBinaryReader();
        decoderKind = decoderKind || JSIO.TextDecoder.UTF8;
        var d = new decoderKind(reader);
        var textReader = new JSIO.TextReader(d);
        d._parent = textReader;  // store a reference, for diagnostic purposes only
        return textReader;
    };

    // verify the CRC on the entry.
    // call this after all bytes have been read.
    ZipEntry.prototype.verifyCrc32 = function() {
        var computedCrc = this._crcCalculator.crc32();
        var rc = false;  // CRC FAIL
        if (this.crc32 != computedCrc) {
            var msg = "WARNING: CRC check failed: " +
                "entry(" + this.name + ") " +
                "computed(" + JSIO.decimalToHexString(computedCrc,8) + ") " +
                "expected(" + JSIO.decimalToHexString(this.crc32,8) + ") ";
            this.zipfile.status.push(msg);
        } else {
            rc = true;  // OK
            if (this.zipfile.verbose>2) {
                this.zipfile.status.push("INFO: CRC check ok: 0x" +
                                         JSIO.decimalToHexString(this.crc32,8));
            }
        }
        return rc;
    };


    // ctor
    ZipFile = function(fileUrl, callback, verbosity) {
        if (! (this instanceof arguments.callee) ) JSIO.throwError('You must use new to instantiate this class', typename, 'ctor');

        this.verbose     = verbosity || 0;
        this.entries     = [];
        this.entryNames  = [];
        this.status      = [];
        this._version    = version;
        this._typename   = "ZipFile";
        this._throwError = JSIO.throwError;

        var thisZipFile = this;

        // Could use a back-tracking reader for the central directory, but
        // there's no point, since all the zip data is held in memory anyway.

        /* function ReadCentralDirectory(){
            var posn = thisZipFile.binaryStream.length - 64;
            var maxSeekback = Math.Max(s.Length - 0x4000, 10);
            var success = false;
            var nTries = 0;
            do
            {
                thisZipFile.binaryStream.Seek(posn, SeekOrigin.Begin);
                var bytesRead = thisZipFile.binaryStream.findSignature(thisZipFile.Signatures.EndOfCentralDirectory);
                if (bytesRead != -1)
                    success = true;
                else
                {
                    nTries++;
                    // increasingly larger
                    posn -= (32 * (nTries + 1) * nTries);
                    if (posn < 0) posn = 0;  // BOF
                }
            }
            while (!success && posn > maxSeekback);
            if (!success) {
                thisZipFile.status.push("cannot find End of Central Directory");
                return;
            }
        } */


        function DateFromPackedFormat(packed) {
            if (packed == 0xFFFF || packed === 0) return new Date(1995, 0, 1, 0,0,0,0);

            var packedTime = packed & 0x0000ffff;
            var packedDate = ((packed & 0xffff0000) >> 16);

            var year = 1980 + ((packedDate & 0xFE00) >> 9);
            var month = ((packedDate & 0x01E0) >> 5) -1;
            var day = packedDate & 0x001F;

            var hour = (packedTime & 0xF800) >> 11;
            var minute = (packedTime & 0x07E0) >> 5;
            var second = (packedTime & 0x001F) * 2;

            // Validation and error checking.
            // This is not foolproof but will catch most errors.

            // I can't believe how many different ways applications
            // can mess up a simple date format.

            if (second >= 60) { minute++; second = 0; }
            if (minute >= 60) { hour++;   minute = 0; }
            if (hour   >= 24) { day++;    hour   = 0; }
            var success = false;
            var d;
            try {
                d = new Date(year, month, day, hour, minute, second, 0);
                success= true;
            }
            catch (exc1) {
                if (year == 1980 && (month === 0 || day === 0)) {
                    try {
                        d = new Date(1980, 0, 1, hour, minute, second, 0);
                        success= true;
                    }
                    catch (exc2) {
                        try {
                            d = new Date(1980, 0, 1, 0, 0, 0, 0);
                            success= true;
                        }
                        catch (exc3) { }  // how could this fail??
                    }
                }
                else {
                    try {
                        if (year   < 1980) year   = 1980;
                        if (year   > 2030) year   = 2030;
                        if (month  < 1)    month  = 1;
                        if (month  > 12)   month  = 12;
                        if (day    < 1)    day    = 1;
                        if (day    > 31)   day    = 31;
                        if (minute < 0)    minute = 0;
                        if (minute > 59)   minute = 59;
                        if (second < 0)    second = 0;
                        if (second > 59)   second = 59;
                        d = new Date(year, month-1, day, hour, minute, second, 0);
                        success= true;
                    }
                    catch (exc4){}
                }
            }
            if (!success) this._throwError('Bad date/time value in this ZIP file', null, 'DateFromPackedFormat');
            return d;
        }


        function ReadZipEntries () {
            // read only once
            if (thisZipFile.entryNames.length === 0){
                var e;
                while ((e = ReadZipEntry()) !== null) {
                    thisZipFile.entries.push(e);
                    thisZipFile.entryNames.push(e.name);
                }
            }
        }


        function ReadZipEntry () {
            var offset = thisZipFile.binaryStream.position;
            var sig = thisZipFile.binaryStream.readNumber(4);
            if (sig == ZipFile.Signatures.DirEntry) {
                // after all entries, comes the central directory
                if (thisZipFile.verbose > 0) {
                    thisZipFile.status.push("INFO: at offset 0x" +
                                     JSIO.decimalToHexString(offset) +
                                     ", found start of Zip Directory.");
                }
                // all done reading
                return null;
            }
            if (sig != ZipFile.Signatures.Entry) {
                thisZipFile.status.push("WARNING: at offset 0x" +
                                 JSIO.decimalToHexString(offset) +
                                 ", found unexpected signature: 0x" +
                                 JSIO.decimalToHexString(sig));
                return null;
            }

            var entry = new ZipEntry(thisZipFile);
            entry.offset            = offset;
            entry.versionNeeded     = thisZipFile.binaryStream.readNumber(2);
            entry.bitField          = thisZipFile.binaryStream.readNumber(2);
            entry.compressionMethod = thisZipFile.binaryStream.readNumber(2);
            var timeBlob            = thisZipFile.binaryStream.readNumber(4);
            entry.lastModified      = DateFromPackedFormat(timeBlob);
            entry.crc32             = thisZipFile.binaryStream.readNumber(4);
            entry.compressedSize    = thisZipFile.binaryStream.readNumber(4);
            entry.uncompressedSize  = thisZipFile.binaryStream.readNumber(4);

            if ((entry.bitField & 0x01) == 0x01){
                thisZipFile.status.push("This zipfile uses Encryption, which is not supported by ZipFile.js.");
                return null;
            }

            entry.utf8 = ((entry.bitField & 0x0800) == 0x0800);

            if ((entry.bitField & 0x0008) == 0x0008){
                thisZipFile.status.push("This zipfile uses a bit 3 trailing data descriptor, which is not supported by ZipFile.js.");
                return null;
            }

            if (entry.compressedSize == 0xFFFFFFFF ||
                entry.uncompressedSize == 0xFFFFFFFF) {
                thisZipFile.status.push("This zipfile uses ZIP64, which is not supported by ZipFile.js");
                return null;
            }

            var filenameLength   = thisZipFile.binaryStream.readNumber(2);
            var extraFieldLength = thisZipFile.binaryStream.readNumber(2);

            thisZipFile.status.push("INFO: filename length= " + filenameLength);

            // we've read 30 bytes of metadata so far
            var bytesRead = 30 + filenameLength + extraFieldLength;

            if (entry.utf8) {
                thisZipFile.status.push("INFO: before filename, position= 0x" +
                                        JSIO.decimalToHexString( thisZipFile.binaryStream.position ));
                var binReader =
                    new JSIO.StreamSegmentReader(thisZipFile.binaryStream,
                                                 thisZipFile.binaryStream.position,
                                                 filenameLength);
                var utf8Decoder = new JSIO.TextDecoder.UTF8(binReader);
                var textReader  = new JSIO.TextReader(utf8Decoder);
                entry.name = textReader.readToEnd();

                // advance the filepointer:
                thisZipFile.binaryStream.seek(filenameLength,
                                              JSIO.SeekOrigin.Current,
                                              thisZipFile);

                thisZipFile.status.push("INFO: after filename, position= 0x" +
                                        JSIO.decimalToHexString( thisZipFile.binaryStream.position ));
            }
            else {
                entry.name = thisZipFile.binaryStream.readString(filenameLength);
            }

            // There are a bunch of things in the "extra" header, thisZipFile we
            // could parse, like timestamps and other things.  This class
            // only identifies and separates them.

            // More info here: http://www.pkware.com/documents/casestudies/APPNOTE.TXT

            var extraPos = 0;
            entry.extra = [];
            while (extraPos < extraFieldLength) {
                var extraBlock = {
                    type: thisZipFile.binaryStream.readNumber(2),
                    size: thisZipFile.binaryStream.readNumber(2)
                };
                extraBlock.typeDescription = ZipFile.ExtraFieldTypes[extraBlock.type];
                extraBlock.data = thisZipFile.binaryStream.read(extraBlock.size);
                entry.extra.push(extraBlock);
                extraPos += 4 + extraBlock.size;
            }

            if (thisZipFile.verbose > 1) {
                thisZipFile.status.push("INFO: at offset 0x" +
                             JSIO.decimalToHexString(entry.offset) +
                             ", found entry '" + entry.name + "' fnl(" +
                             filenameLength + ") efl(" +
                             extraFieldLength +")");
            }

            if (extraFieldLength > 0) {
                if (thisZipFile.verbose > 0) {
                    thisZipFile.status.push("INFO: entry " + entry.name + " has " +
                                     extraFieldLength + " bytes of " +
                                     "extra metadata (ID'd but ignored)");
                }
            }

            entry.lengthOfHeader = bytesRead;
            entry.totalEntrySize = entry.lengthOfHeader + entry.compressedSize;

            // seek past the data without reading it. We will read on Extract()
            if (thisZipFile.verbose > 1) {
                thisZipFile.status.push("INFO: seek 0x" +
                                 JSIO.decimalToHexString(entry.compressedSize) +
                                 " (" + entry.compressedSize + ") bytes");
            }

            thisZipFile.binaryStream.seek(entry.compressedSize,
                              JSIO.SeekOrigin.Current,
                              thisZipFile);

            return entry;
        }


        var parseZipFile = function(bfr){
            try {
                if (bfr.req.status == 200) {
                    var sig = thisZipFile.binaryStream.readNumber(4);
                    if (sig != ZipFile.Signatures.Entry){
                        thisZipFile.status.push("WARNING: this file does not appear to be a zip file");
                    } else {
                        thisZipFile.binaryStream.seek(0, JSIO.SeekOrigin.Begin);
                        ReadZipEntries();
                        if (thisZipFile.verbose > 0) {
                            thisZipFile.status.push("INFO: read " + thisZipFile.entries.length + " entries");
                        }
                    }
                }
                else {
                    thisZipFile.status.push("ERROR: the URL could not be read (" +
                                     bfr.req.status + " " + bfr.req.statusText + ")");
                }
                callback(thisZipFile);
            }
            catch (exc1)
            {
                thisZipFile.status.push("Exception: " + exc1.message);
                callback(thisZipFile);
            }
        };

        this.binaryStream = new JSIO.BinaryUrlStream(fileUrl, parseZipFile);

        return this;
    };


    ZipFile.Signatures = {
        Entry                 : 0x04034b50,
        EndOfCentralDirectory : 0x06054b50,
        DirEntry              : 0x02014b50
    };

    ZipFile.Version = version;

    ZipFile.EncryptionAlgorithm = {
        None      : 0,
        PkzipWeak : 1,
        WinZipAes : 2
    };

    ZipFile.ExtraFieldTypes = {};
    ZipFile.ExtraFieldTypes[0x0001] = 'Zip64 Extended Info';
    ZipFile.ExtraFieldTypes[0x0007] = 'AV Info';
    ZipFile.ExtraFieldTypes[0x0008] = 'Extended Language Encoding Data (PFS)';
    ZipFile.ExtraFieldTypes[0x0009] = 'OS/2';
    ZipFile.ExtraFieldTypes[0x000a] = 'NTFS ';
    ZipFile.ExtraFieldTypes[0x000c] = 'OpenVMS';
    ZipFile.ExtraFieldTypes[0x000d] = 'UNIX';
    ZipFile.ExtraFieldTypes[0x000e] = 'File Stream and Fork Descriptors';
    ZipFile.ExtraFieldTypes[0x000f] = 'Patch Descriptor';
    ZipFile.ExtraFieldTypes[0x0014] = 'PKCS#7 Store for X.509 Certificates';
    ZipFile.ExtraFieldTypes[0x0015] = 'X.509 Certificate ID and Signature (Individual File)';
    ZipFile.ExtraFieldTypes[0x0016] = 'X.509 Certificate ID (Central Directory)';
    ZipFile.ExtraFieldTypes[0x0017] = 'Strong Encryption Header';
    ZipFile.ExtraFieldTypes[0x0018] = 'Record Management Controls';
    ZipFile.ExtraFieldTypes[0x0019] = 'PKCS#7 Encryption Recipient Certificate List';
    ZipFile.ExtraFieldTypes[0x0065] = 'IBM S/390 (Z390), AS/400 (I400) attributes (uncompressed)';
    ZipFile.ExtraFieldTypes[0x0066] = 'IBM S/390 (Z390), AS/400 (I400) attributes (compressed)';
    ZipFile.ExtraFieldTypes[0x4690] = 'POSZIP 4690 (reserved) ';
    ZipFile.ExtraFieldTypes[0x07c8] = 'Macintosh';
    ZipFile.ExtraFieldTypes[0x2605] = 'ZipIt Macintosh';
    ZipFile.ExtraFieldTypes[0x2705] = 'ZipIt Macintosh 1.3.5+';
    ZipFile.ExtraFieldTypes[0x2805] = 'ZipIt Macintosh 1.3.5+';
    ZipFile.ExtraFieldTypes[0x334d] = 'Info-ZIP Macintosh';
    ZipFile.ExtraFieldTypes[0x4341] = 'Acorn/SparkFS ';
    ZipFile.ExtraFieldTypes[0x4453] = 'Windows NT security descriptor (binary ACL)';
    ZipFile.ExtraFieldTypes[0x4704] = 'VM/CMS';
    ZipFile.ExtraFieldTypes[0x470f] = 'MVS';
    ZipFile.ExtraFieldTypes[0x4b46] = 'FWKCS MD5';
    ZipFile.ExtraFieldTypes[0x4c41] = 'OS/2 access control list (text ACL)';
    ZipFile.ExtraFieldTypes[0x4d49] = 'Info-ZIP OpenVMS';
    ZipFile.ExtraFieldTypes[0x4f4c] = 'Xceed original location extra field';
    ZipFile.ExtraFieldTypes[0x5356] = 'AOS/VS (ACL)';
    ZipFile.ExtraFieldTypes[0x5455] = 'extended timestamp';
    ZipFile.ExtraFieldTypes[0x554e] = 'Xceed unicode extra field';
    ZipFile.ExtraFieldTypes[0x5855] = 'Info-ZIP UNIX (original, also OS/2, NT, etc)';
    ZipFile.ExtraFieldTypes[0x6375] = 'Info-ZIP Unicode Comment Extra Field';
    ZipFile.ExtraFieldTypes[0x6542] = 'BeOS/BeBox';
    ZipFile.ExtraFieldTypes[0x7075] = 'Info-ZIP Unicode Path Extra Field';
    ZipFile.ExtraFieldTypes[0x756e] = 'ASi UNIX';
    ZipFile.ExtraFieldTypes[0x7855] = 'Info-ZIP UNIX (new)';
    ZipFile.ExtraFieldTypes[0xa220] = 'Microsoft Open Packaging Growth Hint';
    ZipFile.ExtraFieldTypes[0xfd4a] = 'SMS/QDOS';

})();

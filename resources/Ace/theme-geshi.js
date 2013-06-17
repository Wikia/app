/* ***** BEGIN LICENSE BLOCK *****
 * Distributed under the BSD license:
 *
 * Copyright (c) 2010, Ajax.org B.V.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of Ajax.org B.V. nor the
 *       names of its contributors may be used to endorse or promote products
 *       derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL AJAX.ORG B.V. BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * ***** END LICENSE BLOCK ***** */

define('ace/theme/geshi', ['require', 'exports', 'module' , 'ace/lib/dom'], function(require, exports) {

	exports.isDark = false;
	exports.cssClass = "ace-geshi";
	exports.cssText = "\
.ace-geshi .ace_gutter {\
overflow : hidden;\
}\
.ace_editor {\
color:inherit;\
}\
.ace-geshi .ace_print-margin {\
width: 1px;\
background: #e8e8e8;\
}\
.ace-geshi {\
font-family: monospace;\
background-color: #f2f2f2;\
}\
.ace-geshi .ace_cursor {\
border-left: 2px solid;\
}\
.ace-geshi .ace_overwrite-cursors .ace_cursor {\
border-left: 0px;\
border-bottom: 1px solid;\
}\
.ace-geshi .ace_invalid {\
background-color: rgb(153, 0, 0);\
color: white;\
}\
.ace-geshi .ace_invisible {\
color: rgb(191, 191, 191);\
}\
.ace-geshi .ace_variable {\
color: #6666FF;\
}\
.ace-geshi .ace_paren {\
color: #00AA00;\
}\
\.ace-geshi .ace_type {\
font-weight: bold;\
}\
\.ace-geshi .ace_keyword {\
color: #cc00cc;\
}\
\.ace-geshi .ace_constant {\
color: #993333;\
}\
\.ace-geshi .ace_comment {\
color: #808080;\
font-style: italic;\
}\
.ace-geshi .ace_markup.ace_heading {\
color: rgb(12, 7, 255);\
}\
.ace-geshi .ace_markup.ace_list {\
color:rgb(185, 6, 144);\
}\
.ace-geshi .ace_marker-layer .ace_selection {\
background: rgb(181, 213, 255);\
}\
.ace-geshi .ace_marker-layer .ace_step {\
background: rgb(252, 255, 0);\
}\
.ace-geshi .ace_marker-layer .ace_stack {\
background: rgb(164, 229, 101);\
}\
.ace-geshi .ace_marker-layer .ace_bracket {\
margin: -1px 0 0 -1px;\
border: 1px solid rgb(192, 192, 192);\
}\
.ace-geshi .ace_marker-layer .ace_active-line {\
background: rgba(0, 0, 0, 0.07);\
}\
.ace-geshi .ace_gutter-active-line {\
background-color : #aaa;\
}\
.ace-geshi .ace_marker-layer .ace_selection {\
background: rgb(181, 213, 255);\
}\
.ace-geshi .ace_marker-layer .ace_selected-word {\
background: rgb(250, 250, 255);\
border: 1px solid rgb(200, 200, 250);\
}\
.ace-geshi .ace_indent-guide {\
background: url(\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAACCAYAAACZgbYnAAAAE0lEQVQImWP4////f4bLly//BwAmVgd1/w11/gAAAABJRU5ErkJggg==\") right repeat-y;\
}\
";

	var dom = require("../lib/dom");
	dom.importCssString(exports.cssText, exports.cssClass);
});

/*
*
*   Copyright (c) Microsoft. 
*
*	This code is licensed under the Apache License, Version 2.0.
*   THIS CODE IS PROVIDED *AS IS* WITHOUT WARRANTY OF
*   ANY KIND, EITHER EXPRESS OR IMPLIED, INCLUDING ANY
*   IMPLIED WARRANTIES OF FITNESS FOR A PARTICULAR
*   PURPOSE, MERCHANTABILITY, OR NON-INFRINGEMENT.
*
*   The apache license details from 
*   ‘http://www.apache.org/licenses/’ are reproduced 
*   in ‘Apache2_license.txt’ 
*
*/

/* 
Available Classes:
1) transliterationServicesInterface   - Includes all the methods to enable or disable transliteration service for given language on application. 
*/

//make sure the namespace exists.
if (typeof (wikiBhasha.extern) === "undefined") {
    wikiBhasha.extern = {};
}

(function() {
    // includes all the methods to enable or disable Microsoft transliteration service for given language on application    
    wikiBhasha.extern.msTransliterationServicesInterface = {        

        //enables transliteration feature on application UI for given language
        enableTransliteration: function(lang) {
            switch (lang) {
                case "hi":
                    // Note to Developers:
                    // The code below shows how an Indic language input tool – Akshara – may be included into the
                    // WikiBhasha.  This code is tested, but is currently commented out.
                    // To use Akshara, the EULA for the same must be shown to and accepted by the user.  An 
                    // appropriate mechanism for this needs to be integrated.  So, anyone interested in making
                    // Akshara, should implement the above, before uncommenting the code below, 
                    // and making the Indic language input mechanism available in WikiBhasha.
//                    var $hiTransliterationElement = $("#MicrosoftILITWebEmbedInfo")
//                    if ($hiTransliterationElement.length > 0) {
//                        $hiTransliterationElement.attr("attachMode", "optout");
//                    } else {
//                        var hiTransliterationHTML = '<input type="hidden" id="MicrosoftILITWebEmbedInfo" attachMode="optout" value="">';
//                        hiTransliterationHTML += '<script type="text/javascript" src="http://ilit.microsoft.com/bookmarklet/script/Hindi.js" defer="defer"></script>';
//                        $("BODY").append(hiTransliterationHTML);
//                    }
                    break;
                case "ar":
                    // FUTURE: Consider Microsoft's Maran input system which works very similar to Askhara.
                    break;
            }
        },

        //disables transliteration feature on application UI for given language
        disableTransliteration: function(lang) {
            switch (lang) {
                case "hi":
//                    var $hiTransliterationElement = $("#MicrosoftILITWebEmbedInfo");
//                    if ($hiTransliterationElement.length > 0) {
//                        $hiTransliterationElement.attr("attachMode", "optin");
//                    }
                    break;
                case "ar":
                    //Get the optin code from Arabic team and update the same here.
                    break;
            }
        }
    };    

})();

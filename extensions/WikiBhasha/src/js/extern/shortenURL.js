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
1) wikipediaLoggerInterface   - Includes functions to log sessions, feature usage information and feedback data.
*/

//make sure the namespace exists.
if (typeof (wikiBhasha.extern) === "undefined") {
    wikiBhasha.extern = {};
}

(function() {

    wikiBhasha.extern.shortenURL = {
        // bit.ly account
        userID: "wikibhasha",
        // bit/ly api key
        apiKey: "R_155afaf714b12bbcf277e228d11d6dac",
        // base url to the share system
        shortenServiceUrl: "http://api.bit.ly/v3/shorten?",
        // query string
        queryAuth: "login={0}&apiKey={1}",
        // query parameters
        queryParam: "&longUrl={2}&format=json",
        //gets the corresponding source language article title for a given target language article
        getShortenURL: function(url, callback) {
            urlData = wbUtil.stringFormat(wbShortenURL.shortenServiceUrl+wbShortenURL.queryAuth+wbShortenURL.queryParam, wbShortenURL.userID, wbShortenURL.apiKey, url);
            $.getJSON(urlData, 'callback=?', function(returnData) {
                if (returnData && returnData.data && returnData.data.url) {
                    callback(returnData.data.url);
                }else{
                    callback(false);
                }
            });
        }
    };
    wbShortenURL = wikiBhasha.extern.shortenURL;
})();
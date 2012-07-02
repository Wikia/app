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
    // includes all the methods to enable or disable transliteration service for given language on application    
    wikiBhasha.extern.wikipediaLoggerInterface = {
        createSession: function(sourceUrl, browserInfo, operatingSystemInfo, callback) {
            // To be implemented. Log these data and return a unique session id in callback
            // sourceUrl: Url of the website where WikiBhasha was invoked.
            // browserInfo: Info on what browser is used, ex: name of browser, version etc.
            // operatingSystemInfo: Info on what operating system was used, such as name & version.
            // callback: Callback function on completion. Returns unique session id as parameter for callback function
            // Do not return sequential session ids to avoid below threats:
            // 1) Information disclosure: returning sequential ids tell users the number of sessions so far
            // 2) Repudiation: Someone can call the feature usage logger APIs with older session id to corrupt our data
        },

        logFeatureUsage: function(sessionId, featureName, param1, param2, callback) {
            // To be implemented.
            // This logs the information that a particular feature was used in given session.
            // This information could be used to improve WikiBhasha's usability, feature discoverablity etc.
            // sessionId: Unique id for this session.
            // featureName: Name of feature used. String value.
            // param1 and param2: Any optional paramters for this feature. For example, "steps" feature has step id as parameter.
            // callback: Callback function to be called on completion. Returns status of call as parameter to callback.
        },

        logUserFeedback: function(sessionId, feedbackText, feedbackRating, callback) {
            // To be implemented.
            // This logs the feedback provided by user in the tool.
            // sessionId: Unique id for this session.
            // feedbackText: Text user typed as feedback.
            // feedbackRating: Rating value the user has selected.
            // callback: Callback function to be called on completion. Returns status of call as parameter to callback.
            if (callback) {
                callback({ status: "success" }); // Currently returns success as dummy stub.
            }
        }
    };

})();

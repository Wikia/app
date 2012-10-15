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
* 
* Available Classes:
* 1) themes     - Includes all the methods and properties to manipulate themes of the application
* 
*/

//make sure the namespace exists.
if (typeof (wikiBhasha.windowManagement) === "undefined") {
    wikiBhasha.windowManagement = {};
}

(function() {
    //includes all the methods and properties to manipulate themes of the application
    wikiBhasha.windowManagement.themes = new function() {
        //supported themes and their respective style sheets
        var colors = ["Black", "Silver", "Blue"],
            fileNames = ["wikiBhasha.black.css", "wikiBhasha.silver.css", "wikiBhasha.blue.css"];

        //describes the current theme, default to 'Blue'
        this.currentTheme = colors[2]; //Blue color        

        //initializes the themes, loads themes for the application
        this.initialize = function() {
            this.bindClickOnThemeButtons();
        };

        //unload themes from the application
        this.unload = function() {
            this.removeThemes();
        };

        //bind the click event on available theme buttons
        this.bindClickOnThemeButtons = function() {
            var buttonIds = ["#wbBlack", "#wbSilver", "#wbBlue"];

            for (var i = 0; i < buttonIds.length; i++) {
                $(buttonIds[i]).click(function(color, fileName) {
                    return function() {
                        //apply themes on application window and other sub windows
                        wbThemes.applyThemes(color, fileName);
                    };
                } (colors[i], fileNames[i]));
            }
        };

        //applies theme on application window
        this.applyThemes = function(themeName, fileName) {
            var id = "wbCSS" + themeName;

            //attach CSS to the DOM as per selected theme
            attachThemeStyle(wbGlobalSettings.baseUrl + wbGlobalSettings.themesFolder + fileName, id);

            //highlight the selected theme icon
            $.each(colors, function(i, color) {
                if (themeName === color) {
                    var $selectedThemeButtonElement = $("#wb" + themeName);
                    $selectedThemeButtonElement.addClass("wb" + themeName + "SelectedIcon");
                    $selectedThemeButtonElement.removeClass("wb" + themeName + "Icon");
                    this.currentTheme = themeName;
                }
                else {
                    var $otherThemeButtonElement = $("#wb" + color);
                    $otherThemeButtonElement.removeClass("wb" + color + "SelectedIcon");
                    $otherThemeButtonElement.addClass("wb" + color + "Icon");
                    removeThemeStyles(color);
                }
            });

            // log user's switching of themes
            wbLoggerService.logFeatureUsage(wbGlobalSettings.sessionId, "ThemeSwitch", themeName);
        };

        //removes the theme(css) files.
        this.removeThemes = function() {
            //read all theme CSS and remove them from DOM
            $.each(colors, function(i, color) {
                removeThemeStyles(color);
            });
        };

        //attaches given theme to DOM
        var attachThemeStyle = function(url, id) {
            wbUIHelper.attachStyle(url, id);
        };

        //removes the given theme style from DOM
        var removeThemeStyles = function(color) {
            var head = document.getElementsByTagName("head")[0],
                link = document.getElementById("wbCSS" + color);

            //themes for windows
            if (link) {
                head.removeChild(link);
            }
        };
    };
})();

//shortcut to call wikiBhasha.windowManagement.themes
wbThemes = wikiBhasha.windowManagement.themes;

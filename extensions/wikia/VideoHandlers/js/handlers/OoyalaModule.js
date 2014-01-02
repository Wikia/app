// Each custom module must be defined using OO.plugin method
// The first parameter is the module name
// The second parameter is a factory function that will be called by
// the player to create an instance of the module. This function must
// return a constructor for the module class (see the end of this example)
OO.plugin("AgeGateModule", function (OO, _, $, W) {
    var AgeGate = {};

    AgeGate.AgeGateModule = function (mb, id) {
        this.identifier = Math.floor(Math.random()*10000000000);
        this.mb = mb; // save message bus reference for later use
        this.id = id;
        this.playing = false;
        this.ageVerified = false;
        this.duration = NaN;
        this.metaData = NaN;
        this.ageGateRoot = NaN;
        this.playerRoot = NaN;
        this.playerElementRoot = NaN;
        this.playerWidth = NaN;
        this.playerHeight = NaN;
        this.isOldIE = false;
        this.isMobile = false;
        this.rootElement = NaN;
        this.embedIdentifier = NaN;
        this.currentPlaybackType = 'content';
        this.content = NaN;
        this.ageRequired = NaN;
        this.ageGateHTML =  '<style> \
                            .ageGate { \
                                display: none; \
                                position: absolute; \
                                z-index: 100000; \
                                background: rgba(0, 0, 0, 0.9); \
                                color: #fff; \
                                font-size: 18px; \
                                font-family: Arial, Helvetica; \
                            } \
                            .ageGate.noFlashTransparency { \
                                background: #000; \
                            } \
                            .ageGate .innerElement { \
                                width: 330px; \
                                height: 160px; \
                            } \
                            .ageGate .innerElement.failed { \
                                display: none; \
                            } \
                            .ageGate .innerElement .title { \
                                color: #A9DE44; \
                                margin-bottom: 15px; \
                            } \
                            .ageGate .innerElement form { \
                                margin-top: 15px; \
                            } \
                            .ageGate .innerElement .ageRequirement { \
                                font-weight: bold; \
                            } \
                            .ageGate button { \
                                -moz-box-shadow:inset 0px 1px 0px 0px #d9fbbe; \
                                -webkit-box-shadow:inset 0px 1px 0px 0px #d9fbbe; \
                                box-shadow:inset 0px 1px 0px 0px #d9fbbe; \
                                background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #b8e356), color-stop(1, #a5cc52)); \
                                background:-moz-linear-gradient(top, #b8e356 5%, #a5cc52 100%); \
                                background:-webkit-linear-gradient(top, #b8e356 5%, #a5cc52 100%); \
                                background:-o-linear-gradient(top, #b8e356 5%, #a5cc52 100%); \
                                background:-ms-linear-gradient(top, #b8e356 5%, #a5cc52 100%); \
                                background:linear-gradient(to bottom, #b8e356 5%, #a5cc52 100%); \
                                filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#b8e356", endColorstr="#a5cc52",GradientType=0); \
                                background-color:#b8e356; \
                                -moz-border-radius:6px; \
                                -webkit-border-radius:6px; \
                                border-radius:6px; \
                                border:1px solid #83c41a; \
                                display:inline-block; \
                                color:#ffffff; \
                                font-family:arial; \
                                font-size:15px; \
                                font-weight:bold; \
                                padding:4px 12px; \
                                text-decoration:none; \
                                text-shadow:0px 1px 0px #86ae47; \
                                height: 31px; \
                            } \
                            .ageGate.noCustomSizing button { \
                                padding: 1px 10px; \
                                font-size: 12px; \
                                margin-left: 5px; \
                            } \
                            .ageGate.fancySelects button { \
                                padding: 6px 24px; \
                            }\
                            .ageGate button:hover { \
                                background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #a5cc52), color-stop(1, #b8e356)); \
                                background:-moz-linear-gradient(top, #a5cc52 5%, #b8e356 100%); \
                                background:-webkit-linear-gradient(top, #a5cc52 5%, #b8e356 100%); \
                                background:-o-linear-gradient(top, #a5cc52 5%, #b8e356 100%); \
                                background:-ms-linear-gradient(top, #a5cc52 5%, #b8e356 100%); \
                                background:linear-gradient(to bottom, #a5cc52 5%, #b8e356 100%); \
                                filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#a5cc52", endColorstr="#b8e356",GradientType=0); \
                                background-color:#a5cc52; \
                            } \
                            .ageGate button:active { \
                                position:relative; \
                                top:1px; \
                            } \
                            .ageGate select { \
                                border-radius: 6px; \
                                -webkit-appearance: none; \
                                font-size: 14px; \
                                padding: 3px 5px; \
                            } \
                            .ageGate.fancySelects select { \
                                background: #fff url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAKCAYAAAC0VX7mAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyRpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoTWFjaW50b3NoKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo5MjdDMjBEQUM5QjExMUUyOTRFNEZBRTUxQTg2NUMwMyIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDo5MjdDMjBEQkM5QjExMUUyOTRFNEZBRTUxQTg2NUMwMyI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjkwMkQxMzdGQzlBQjExRTI5NEU0RkFFNTFBODY1QzAzIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjkwMkQxMzgwQzlBQjExRTI5NEU0RkFFNTFBODY1QzAzIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+z11IHAAAAHBJREFUeNpi/P//PwM1ARMDlQHVDWTBJsjIyGgApJYAsQwQf0aT5gLiT0AcAwyuoxiaQWGIjqEAZNg/kBIsWA2nXjwGggAvEH9AMugvEEvgdQwBA0GAD8lACUK+YyEinEHhZQM1+AUhxYyDPh0CBBgA7wl1RGju+fUAAAAASUVORK5CYII=) no-repeat right center; \
                                padding: 6px 25px 6px 10px; \
                            } \
                            </style> \
                            <div class="ageGate"> \
                                <div class="innerElement validate"> \
                                    <div class="title"></div> \
                                    <div class="verbiage">This content is restricted.  Please enter your birthday month and year below.</div> \
                                    <form> \
                                        <select id="month"></select>  \
                                        <select id="year"></select> \
                                        <button>Continue</button> \
                                    </form> \
                                </div> \
                                <div class="innerElement failed"> \
                                    <div class="title"></div> \
                                    <div class="verbiage">Sorry!  You must be at least <span class="ageRequirement"></span> years old to watch this content.</div> \
                                </div> \
                            </div>';

        if(!window.ooyalaAgeGateModule) {
            window.ooyalaAgeGateModule = [];
        }

        window.ooyalaAgeGateModule.push(this);

        this.init(); // subscribe to relevant events
    };

    // public functions of the module object
    AgeGate.AgeGateModule.prototype = {
        init: function () {
            // subscribe to relevant player events
            this.mb.subscribe(OO.EVENTS.PLAYER_CREATED, 'customerUi',
            _.bind(this.onPlayerCreate, this));
            /*this.mb.subscribe(OO.EVENTS.PLAYHEAD_TIME_CHANGED,
                'customerUi', _.bind(this.onTimeUpdate, this));*/
            this.mb.subscribe(OO.EVENTS.CONTENT_TREE_FETCHED,
                'customerUi', _.bind(this.onContentReady, this));
            this.mb.subscribe(OO.EVENTS.PLAYING,
                'customerUi', _.bind(this.onPlay, this));
            this.mb.subscribe(OO.EVENTS.METADATA_FETCHED,
                'customerUi', _.bind(this.onMetadataFetched, this));
            this.mb.subscribe(OO.EVENTS.WILL_PLAY_ADS,
                'customerUi', _.bind(this.onWillPlayAds, this));
            this.mb.subscribe(OO.EVENTS.ADS_PLAYED,
                'customerUi', _.bind(this.onAdsPlayed, this));

        },

        consoleLog: function (what) {
            if(typeof console != 'undefined') {
                console.log(what);
            }
        },

        // Handles the PLAYER_CREATED event
        // First parameter is the event name
        // Second parameter is the elementId of player container
        // Third parameter is the list of parameters which were passed into
        // player upon creation.
        // In this section, we use this opportunity to create the custom UI
        onPlayerCreate: function (event, elementId, params) {
            this.playerRoot = $("#" + elementId);
            this.rootElement = this.playerRoot.parent();
            this.playerWidth = this.playerRoot.children('.innerWrapper').width();
            this.playerHeight = this.playerRoot.children('.innerWrapper').height();

            this.buildAgeGateUI();

            this.adjustForBrowser();

            this.isMobile = this.playerRoot.find('video').size() > 0;

            this.consoleLog("EVENT: onPlayerCreate");
        },

        buildAgeGateUI: function () {
            var ag = NaN;
            var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            this.playerRoot.prepend(this.ageGateHTML);
            this.playerElementRoot = this.playerRoot.children('.innerWrapper');
            ag = this.ageGateRoot = this.playerRoot.children('.ageGate');

            ag.css('width', this.playerWidth);
            ag.css('height', this.playerHeight);
            ag.css('position', 'absolute');
            ag.css('z-index', '100000');
            // wikia change begin
            ag.children('.innerElement').css('margin', ((this.playerHeight - ag.children('.innerElement').height()) / 2) + 'px ' + ((this.playerWidth - ag.children('.innerElement').width()) / 2) + 'px');
            // wikia change end

            $.each(months, function (index, value){
                ag.find('#month').append('<option value="' + (index + 1) + '">' + value + '</option>');
            });

            for (var i=1940; i<2010; i++) {
                ag.find('#year').prepend('<option>' + i + '</option>');
            }

            ag.find('button').click(_.bind(this.validateAgeEntry, this));
        },

        // Handles CONTENT_TREE_FETCHED event
        // Second parameter is a content object with details about the
        // content that was loaded into the player
        // In this example, we use the parameter to update duration
        onContentReady: function (event, content) {
            this.content = content;
            this.embedIdentifier = this.content.embed_code || this.content.embedCode;
            this.duration = content.duration / 1000;

            this.ageGateRoot.find('.title').html(this.content.title);

            this.consoleLog("EVENT: onContentReady (" + this.duration + ")");
        },

        // Handles PLAYHEAD_TIME_CHANGED event
        // In this example, we use it to move the slider as content is played
        /*onTimeUpdate: function (event, time, duration, buffer) {
            // update scrubber bar.
            if (duration > 0) {
                this.duration = duration;
            }

            this.consoleLog("EVENT: onTimeUpdate (" + this.duration + ")");
        },*/

        onWillPlayAds: function(funcLabel, data) {
            this.currentPlaybackType = 'ad';

            this.onPlay();

            this.consoleLog("EVENT: onWillPlayAds");
        },

        onAdsPlayed: function(funcLabel, data) {
            this.currentPlaybackType = 'content';

            this.consoleLog("EVENT: onAdsPlayed");
        },

        onPlay: function () {
            this.consoleLog("EVENT: onPlay");

            if(this.ageRequired && !this.ageVerified) {
                var action = this.readCookies();

                if(action != 'pass') {
                    this.seek(0);
                    this.pause();
                    this.ageGateRoot.show();

                    // If this is the HTML5 player, it may well be in full-screen (e.g. iPhone),
                    // and we have to exit
                    if(this.isMobile) {
                        this.playerRoot.find('video')[0].webkitExitFullScreen();
                    }

                    if(this.isOldIE) {
                        this.playerElementRoot.hide();
                    }

                    if(action == 'fail') {
                        this.failAgeValidation();

                        return false;
                    } else if(action == 'check') {

                        return false;
                    }
                }
            }

            this.playing = true;
        },

        onPause: function () {
            this.pause();
            this.playing = false;

            this.consoleLog("EVENT: onPause");
        },

        onMetadataFetched: function (funcLabel, data) {
            this.consoleLog('EVENT: onMetadataFetched');
            this.metaData = data;
            this.ageRequired = data.base.age_required;

            // Look at the content's modules, to see if an ad manager is loaded
            for(var m in data.modules) {
                if(m.indexOf('ads') > -1) {
                    this.currentPlaybackType = 'ad';
                }
            }

            this.ageGateRoot.find('.ageRequirement').html(this.ageRequired);
        },

        // Sends PLAY event to start playing the video
        play: function () {
            this.mb.publish(OO.EVENTS.PLAY);
        },

        // Sends PAUSE event to pause the video
        pause: function () {
            this.mb.publish(OO.EVENTS.PAUSE);
        },

        // Sends SEEK event to seek to specified position
        seek: function (seconds) {
            this.mb.publish(OO.EVENTS.SEEK, seconds);
        },

        adjustForBrowser: function() {
            if(navigator.userAgent.indexOf("MSIE") != -1 && $.browser.version < 11) {
                this.isOldIE = true;
                this.ageGateRoot.addClass('noFlashTransparency');
            }

            if(navigator.userAgent.indexOf("MSIE") != -1 && $.browser.version < 10) {
                this.ageGateRoot.addClass('noCustomSizing');
            }

            if($.browser.webkit) {
                this.ageGateRoot.addClass('fancySelects');
            }
        },

        validateAgeEntry: function () {
            var ag = this.ageGateRoot;
            var date = new Date();
            var month = date.getMonth();
            var year = date.getFullYear();
            var requiredDate = (year + (month / 100)) - this.ageRequired; // 1996.05 format
            var actualDate = parseFloat(ag.find('#year').val()) + (ag.find('#month').val() / 100);

            if(actualDate <= requiredDate) {
                this.passAgeValidation();

                // Set a cookie that lasts one day, allowing continued access to this content
                date.setDate(date.getDate() + 1);
                document.cookie = 'ooyalaAgeGate-' + this.embedIdentifier + '=passed; expires=' + date.toUTCString();
            } else {
                this.failAgeValidation();

                // Set a cookie that lasts one day, forbidding access to this content
                date.setDate(date.getDate() + 1);
                document.cookie = 'ooyalaAgeGate-' + this.embedIdentifier + '=failed; expires=' + date.toUTCString();
            }

            return false;
        },

        failAgeValidation: function () {
            this.ageVerified = false;

            if(this.isOldIE) {
                this.playerElementRoot.hide();
            }
            this.ageGateRoot.find('.innerElement.validate').hide();
            this.ageGateRoot.find('.innerElement.failed').show();
        },

        passAgeValidation: function () {
            this.ageVerified = true;

            this.playerElementRoot.show();
            this.ageGateRoot.hide();

            this.play();
        },

        readCookies: function () {
            if(document.cookie.indexOf('ooyalaAgeGate-' + this.embedIdentifier + '=failed') > -1) {
                this.ageVerified = false;

                return 'fail';
            } else if(document.cookie.indexOf('ooyalaAgeGate-' + this.embedIdentifier + '=passed') > -1) {
                this.ageVerified = true;

                return 'pass';
            }

            return 'check';
        },

        __end_marker: true
    };

    // Return the constructor of the module class.
    // This is required so that Ooyala’s player can instantiate the custom
    // module correctly.
    return AgeGate.AgeGateModule;
});

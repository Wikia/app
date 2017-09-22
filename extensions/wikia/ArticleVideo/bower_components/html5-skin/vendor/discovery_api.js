OO.plugin("DiscoveryApi", function (OO, _, $, W) {
  var MAX_VIDEOS = 20;
  OO.EVENTS.DISCOVERY_API = {
    RELATED_VIDEOS_FETCHED: "relatedVideosFetched",
    SEND_DISPLAY_EVENT: "sendDisplayEvent",
    DISPLAY_EVENT_SUCCESS: "displayEventSuccess",
    SEND_CLICK_EVENT: "sendClickEvent",
    CLICK_EVENT_SUCCESS: "clickEventSuccess",
    // If sending a display or click event results in an error, an error event will be published to the
    // message bus. The event will have a DISPLAY_EVENT_ERROR or CLICK_EVENT_ERROR type and a data object
    // with 3 keys: xhr, status, error.
    // The values for these keys are the 3 parameters that are given to the error callback by
    // $.ajax(...) in case of a failure.
    DISPLAY_EVENT_ERROR: "displayEventError",
    CLICK_EVENT_ERROR: "clickEventError"
  };
  var recentEmbedCodes = [];
  OO.exposeStaticApi('EVENTS', OO.EVENTS);
  var DiscoveryApi = function (mb, id) {
    if (!OO.requiredInEnvironment('html5-playback')) {
      return;
    }
    this.id = id;
    this.mb = mb;
    this.error = false;
    this.relatedVideos = [];
    this.guid = "";
    this.apiHost = OO.playerParams.backlot_api_write_server || 'api.ooyala.com';
    // WIKIA CHANGE - START
    this.playerParams = {};
    // WIKIA CHANGE - END

    OO.StateMachine.create({
      initial: 'Init',
      messageBus: this.mb,
      moduleName: 'DiscoveryApi',
      target: this,
      events: [
        // WIKIA CHANGE - START
        {name: OO.EVENTS.PLAYER_CREATED, from: '*'},
        // WIKIA CHANGE - END
        {name: OO.EVENTS.EMBED_CODE_CHANGED, from: '*'},
        {name: OO.EVENTS.ASSET_CHANGED, from: '*'},
        {name: OO.EVENTS.ASSET_UPDATED, from: '*'},
        {name: OO.EVENTS.DISCOVERY_API.SEND_DISPLAY_EVENT, from: '*'},
        {name: OO.EVENTS.DISCOVERY_API.SEND_CLICK_EVENT, from: '*'},
        {name: OO.EVENTS.GUID_SET, from: '*'}
      ]
    });
  };

  _.extend(DiscoveryApi.prototype, {
    // WIKIA CHANGE - START
    onPlayerCreated: function (event, type, playerParams) {
      this.playerParams = playerParams;
    },
    // WIKIA CHANGE - END
    onEmbedCodeChanged: function (event, embedCode) {
      //Keep the order of the most recently viewed embed codes so we can reorder the related videos
      recentEmbedCodes = _.filter(recentEmbedCodes, function (recentEmbedCode) {
        return recentEmbedCode != embedCode;
      });
      recentEmbedCodes.push(embedCode);
      //No need to keep a list of recent embeds greater than the list of possible related videos
      if (recentEmbedCodes.length >= MAX_VIDEOS) {
        recentEmbedCodes.shift();
      }

      if (this.guid === "") {
        // wait a little bit before calling fetch related videos to give a little bit of time for the guid
        // to be set. Its possible that even after 500 milliseconds, it won't be set but such is life.
        var fetchRelatedDelayed = _.bind(function () {
          this._fetchRelatedVideos(embedCode);
        }, this);
        setTimeout(fetchRelatedDelayed, 500);
      } else {
        this._fetchRelatedVideos(embedCode);
      }
    },

    onAssetUpdated: function (event, asset) {
      this._setRelatedMedia(asset);
    },

    onAssetChanged: function (event, asset) {
      this._setRelatedMedia(asset);
    },

    _setRelatedMedia: function (asset) {
      if (asset.relatedVideos) {
        this.relatedVideos = asset.relatedVideos;
        this.mb.publish(OO.EVENTS.DISCOVERY_API.RELATED_VIDEOS_FETCHED, {videos: this.relatedVideos});
      }
    },

    onGuidSet: function (event, guid) {
      this.guid = guid;
    },

    /**
     * Sends an impression feedback event to the backend discovery APIs. An impression is when
     * recommendations are shown to the user.
     *
     * Params:
     * event - is always OO.EVENTS.DISCOVERY_API.SEND_DISPLAY_EVENT.
     * eventData - should have the fields "bucket_info" and "custom".
     * eventData.bucket_info - should be the discovery bucket info object that was returned as part of
     *    the response to fetch recommendations.
     * eventData.custom.source - should be one of "endScreen" or "pauseScreen".
     */
    onSendDisplayEvent: function (event, eventData) {
      if (!eventData) {
        return;
      }
      var relatedVideos = eventData.relatedVideos;
      if (!relatedVideos || !_.isArray(relatedVideos) || _.size(relatedVideos) < 1) {
        return;
      }
      var bucketInfo = relatedVideos[0].bucket_info;
      if (!bucketInfo) {
        return;
      }
      if (bucketInfo.charAt(0) == "2") {  // Version 2 bucket info can be handled by reporter.js
        this.mb.publish(OO.EVENTS.REPORT_DISCOVERY_IMPRESSION, eventData);
        return;
      }
      // Version 1 bucket info can't be handled by reporter.js (no zlib to decompress the encoded string)
      // and must go through the discovery feedback APIs.
      eventData = {"bucket_info": bucketInfo, "custom": eventData.custom};
      var url = "http://" + this.apiHost + "/v2/discover/feedback/impression";
      eventData["device_id"] = this.guid;
      eventData["discovery_profile_id"] = OO.playerParams.playerBrandingId;
      // Note: "system" must be set to "OOYALA" for all feedback originating from Ooyala players.
      eventData["system"] = "OOYALA";
      $.ajax({
        url: url,
        data: JSON.stringify(eventData),
        type: 'POST',
        dataType: 'json',
        crossDomain: true,
        cache: true,
        success: _.bind(this._displayEventSuccess, this),
        error: _.bind(this._displayEventError, this)
      });
    },

    _displayEventSuccess: function () {
      this.mb.publish(OO.EVENTS.DISCOVERY_API.DISPLAY_EVENT_SUCCESS);
    },

    _displayEventError: function (xhr, status, error) {
      this.mb.publish(OO.EVENTS.DISCOVERY_API.DISPLAY_EVENT_ERROR, {xhr: xhr, status: status, error: error});
    },

    /**
     * Sends an click feedback event to the backend discovery APIs. A click is when a displayed
     * recommendations is clicked by the user. If the countdown timer expires and the first recommendation
     * plays automatically, this event should still be sent, but the value of the countdown timer
     * should be set to 0.
     *
     * Params:
     * event - is always OO.EVENTS.DISCOVERY_API.SEND_CLICK_EVENT.
     * eventData - should have the fields "bucket_info" and "custom".
     * eventData.bucket_info - should be the discovery bucket info object that was returned as part of
     *     the response to fetch recommendations.
     * eventData.custom.source - should be one of "endScreen" or "pauseScreen".
     * eventData.custom.countdown - should have the remaining value of the countdown timer, in seconds
     *     ('endScreen' source only).
     * eventData.custom.autoplay - should be true if the video played automatically because the countdown
     *     timer expired ('endScreen' source only).
     */
    onSendClickEvent: function (event, eventData) {
      if (!eventData) {
        return;
      }
      var clickedVideo = eventData.clickedVideo;
      if (!clickedVideo) {
        return;
      }
      var bucketInfo = clickedVideo.bucket_info;
      if (!bucketInfo) {
        return;
      }
      if (bucketInfo.charAt(0) == "2") {  // Version 2 bucket info can be handled by reporter.js
        this.mb.publish(OO.EVENTS.REPORT_DISCOVERY_CLICK, eventData);
        return;
      }
      // Version 1 bucket info can't be handled by reporter.js (no zlib to decompress the encoded string)
      // and must go through the discovery feedback APIs.
      eventData = {"bucket_info": bucketInfo, "custom": eventData.custom};
      var url = "http://" + this.apiHost + "/v2/discover/feedback/play";
      eventData["device_id"] = this.guid;
      eventData["discovery_profile_id"] = OO.playerParams.playerBrandingId;
      // Note: "system" must be set to "OOYALA" for all feedback originating from Ooyala players.
      eventData["system"] = "OOYALA";
      $.ajax({
        url: url,
        data: JSON.stringify(eventData),
        type: 'POST',
        dataType: 'json',
        crossDomain: true,
        cache: true,
        success: _.bind(this._clickEventSuccess, this),
        error: _.bind(this._clickEventError, this)
      });
    },

    _clickEventSuccess: function () {
      this.mb.publish(OO.EVENTS.DISCOVERY_API.CLICK_EVENT_SUCCESS);
    },

    _clickEventError: function (xhr, status, error) {
      this.mb.publish(OO.EVENTS.DISCOVERY_API.CLICK_EVENT_ERROR, {xhr: xhr, status: status, error: error});
    },

    _fetchRelatedVideos: function (embedCode) {
      this.error = false;
      this.relatedVideos = [];
      var params = {
        sign_version: 'player',
        pcode: OO.playerParams.pcode,
        discovery_profile_id: OO.playerParams.playerBrandingId,
        video_pcode: OO.playerParams.pcode,
        limit: MAX_VIDEOS,
        device_id: this.guid,
        expected_bucket_info_version: 2,
        expires: Math.floor((new Date().getTime() / 1000) + 3600)
      };

      // WIKIA CHANGE - START
      if (this.playerParams.discoveryApiAdditionalParams) {
        _.extend(params, this.playerParams.discoveryApiAdditionalParams);
      }
      // WIKIA CHANGE - END

      var signature = encodeURIComponent(this._generateSignature(params));
      // Note(manish) nov-14, 2012: encode the device_id which may have special characters (+,?) etc that
      // may need to be uri-encoded. its important that this is done *after* the signature is calculated.
      params.device_id = encodeURIComponent(params.device_id);

      // WIKIA CHANGE - START
      if (params.where) {
        params.where = encodeURIComponent(params.where);
      }
      // WIKIA CHANGE - END

      var url = "//" + this.apiHost + "/v2/discover/similar/assets/" + embedCode + "?" +
        this._generateParamString(params, signature);
      $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        crossDomain: true,
        cache: true,
        success: _.bind(this._onRelatedVideosFetched, this),
        error: _.bind(this._onApiError, this)
      });
    },

    _onRelatedVideosFetched: function (response) {
      var safe_response = OO.HM.safeObject("discovery.relatedVideos", response, {});
      if (safe_response.errors === undefined || (safe_response.errors && safe_response.errors.code === 0)) {
        this.relatedVideos = safe_response.results || [];
        this.variationIds = safe_response.variation_ids;
      } else {
        this.relatedVideos = [];
        this.variationIds = [];
      }

      //Reorder the related videos so that the user gets recommended videos that haven't been recently played
      this._reorderRelatedVideos();

      this.mb.publish(OO.EVENTS.REPORT_EXPERIMENT_VARIATIONS, {variationIds: this.variationIds});
      this.mb.publish(OO.EVENTS.DISCOVERY_API.RELATED_VIDEOS_FETCHED, {videos: this.relatedVideos});
    },

    _onApiError: function (xhr, status, error) {
      this.error = true;
      this.mb.publish(OO.EVENTS.DISCOVERY_API.RELATED_VIDEOS_FETCHED, {error: true});
    },

    _generateSignature: function (params) {
      // signature format:
      // pcodeparamName=paramValue...
      var pcode = params.pcode;
      var shaParams = _.reject(_.keys(params), function (key) {
        return key === 'pcode';
      });
      var sha = new jsSHA(pcode + this._hashToString(params, '', shaParams), 'ASCII');
      return sha.getHash('SHA-256', 'B64').substring(0, 43);
    },

    _hashToString: function (hash, delimiter, keys) {
      var string = "";
      var myKeys = keys || _.keys(hash);
      _.each(_.sortBy(myKeys, function (val) {
        return val;
      }), function (key) {
        string += delimiter + key + "=" + hash[key];
      });
      return string;
    },

    _generateParamString: function (params, signature) {
      var string = "signature=" + signature + this._hashToString(params, '&');
      return string;
    },

    _reorderRelatedVideos: function () {
      for (var i = 0; i < recentEmbedCodes.length; i++) {
        var asset = _.find(this.relatedVideos, function (relatedVideo) {
          return relatedVideo.embed_code == recentEmbedCodes[i];
        });
        if (asset) {
          this.relatedVideos = _.filter(this.relatedVideos, function (relatedVideo) {
            return relatedVideo.embed_code != recentEmbedCodes[i];
          });
          this.relatedVideos.push(asset);
        }
      }
    }
  });

  // Return class definition
  return DiscoveryApi;
});

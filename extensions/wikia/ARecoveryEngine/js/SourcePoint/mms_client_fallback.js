(function() {

    window._sp_ = window._sp_ || {};

    // Init MMS client cmd queue
    window._sp_.mms = window._sp_.mms || {};
    window._sp_.mms.cmd = window._sp_.mms.cmd || [];
    window._sp_.mms._internal = window._sp_.mms._internal || {};

    // Init MMS API
    var targetingParams = {};
    window._sp_.mms.setTargeting = function(key, value) {
        targetingParams[key] = value;
    };

    window._sp_.mms.startMsg = function() {
        window._sp_.isAdblocking(loadMessage);
    };

    window._sp_.mms._internal.cdc1 = function() {
        if (typeof window._sp_.config.mms_client_data_callback === 'function') {
            try {
                window._sp_.config.mms_client_data_callback.apply(
                    window._sp_.config.mms_client_data_callback,
                    arguments
                );
            } catch(e) {
                console.log("mms_client_data_callback failed", e);
            }
        }
    };

    window._sp_.msg = window._sp_.msg || {};
    window._sp_.msg.cmd = window._sp_.msg.cmd || [];
    window._sp_.msg.cmd.push(function() {
        for (var i = 0; i < window._sp_.mms.cmd.length; i++) {
            try {
                window._sp_.mms.cmd[i]();
            } catch(e) {
                console.error('Failed to execute cmd', e);
            }
        }

        var queue = [];
        queue.push = function(cmd) { try { cmd() } catch(e) { console.error('Failed to execute cmd queue', e); } };
        window._sp_.mms.cmd = queue;
    });

    // MMS client 
    function loadMessage(isBlocking) {
        var targetingQueryParams = '';
        for (var key in targetingParams) {
            targetingQueryParams += '&' + encodeURIComponent('t[' + key + ']') + '=' + encodeURIComponent(targetingParams[key]);
        }

        var params = '?v=1&account_id=' + encodeURIComponent(window._sp_.config.account_id) +
            '&abp=' + encodeURIComponent(isBlocking) +
            '&referrer=' + encodeURIComponent(document.referrer) +
            '&jv=' + encodeURIComponent(window._sp_.version) +
            targetingQueryParams +
            '&cdc=window._sp_.mms._internal.cdc1';

        // TODO remove when we settle on protocol
        var date = new Date();
        date.setTime(date.getTime() + 60000); // 1 hour from now

        var expires = "expires=" + date.toUTCString() + ';',
            mmsDomainSplit = window._sp_.config.mms_domain.split('.'),
            hostnameSplit = window.location.hostname.split('.'),
            mmsBaseDomain = '.' + hostnameSplit.slice(hostnameSplit.length - 2, hostnameSplit.length).join('.');
        pageBaseDomain = '.' + hostnameSplit.slice(hostnameSplit.length - 2, hostnameSplit.length).join('.');

        document.cookie = 'sp_cmd=/mms/get_site_js' + params + ';path=/;' + expires + 'domain=' + mmsBaseDomain;

        if (mmsBaseDomain !== pageBaseDomain) {
            console.error('mms_domain must be a subdomain of site root domain ' + pageBaseDomain);
        }

        var msgScriptUrl = '//' + window._sp_.config.mms_domain + '/';
        if (isBlocking) {
            window._sp_.bootstrap(msgScriptUrl);
        } else {
            var script = document.createElement('script');
            script.src = msgScriptUrl;
            document.head.appendChild(script);
        }
    }
})();

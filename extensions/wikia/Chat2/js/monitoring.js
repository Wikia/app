var config = require("./server_config.js"); // our node-chat config
var http = require("http");
var urlUtil = require('url');
var logger = require('./logger').logger;

/**
 * get cpu % usege
 */

function execCMD(com, callback) {
	var sys = require('sys');
	var exec = require('child_process').exec;
	var puts = function(error, stdout, stderr) { callback(parseFloat(stdout)) };	
	exec(com, puts);
}

/**
 * Returns some JSON of stats about the server (to help judge the usage-level for making scaling estimations).
 */
function getStats(storage, successCallback, errorCallback){
	var out = {};
	out.node_heapTotal = process.memoryUsage().heapTotal;
	out.node_heapUsed = process.memoryUsage().heapUsed;

	getRedisStats(storage, function(data){
		var redis_pid = data.process_id;
		out.redis_used_memory = data.used_memory;
		out.redis_used_memory_rss = data.used_memory_rss;
		out.redis_mem_fragmentation_ratio = parseFloat(data.mem_fragmentation_ratio);
		out.redis_uptime_in_days = data.uptime_in_days;
		out.redis_used_cpu_sys = data.used_cpu_sys;
		out.redis_used_cpu_user = data.used_cpu_user;
		out.redis_used_cpu_by_days = (out.redis_used_cpu_sys + out.redis_used_cpu_user)/out.redis_uptime_in_days;
		
		out = getEventsStats(out);
		
		storage.getRuntimeStats(function(data) {
			out.runtime = (parseInt(new Date().getTime()) - parseInt(data.laststart) + parseInt(data.runtime) );
			out.avg_runtime = out.runtime/(parseInt(data.startcount) + 1);
			storage.getUserCount(function(data) {
				out.usercount = data;
				execCMD("ps -opcpu -p " + process.pid + " | grep -v CPU", function(cpu) {
					out.node_cpup = cpu;
					execCMD( "ps -opcpu -p " + redis_pid + " | grep -v CPU", function(cpu) {
						out.redis_cpup = cpu;
						successCallback(out);
					});
				});				
			}, errorCallback);
		}, errorCallback);
	}, errorCallback);
} // end api_getStats()

function getRedisStats(storage, callback, errorCallback) {
    var stats = [];
    storage.info(function(storagedata) {
        var data = storagedata.split("\r\n");
        for(var i = 0; i < data.length; i++){
            var temp = data[i].split(":");
            if(temp.length == 2){
                stats[temp[0]] = temp[1];
            }
        }
        // Holy log-spam batman! :)
        //logger.debug(stats);
        if(data.indexOf('allocation_stats')) {
            callback(stats);
        }    	
    },
    errorCallback);
}

exports.startMonitoring = startMonitoring = function(interval, storage) {   
	    logger.info('startMonitoring...');
        setInterval(function(){
            getStats(storage, function(out){
                    for( var i in out) {
                            var CMDstring = 'gmetric --name="' + i + '_' + config.INSTANCE + '" --value='+ out[i] +' --type=float --unit=n --dmax=90 --group=Chat';
                            execCMD(CMDstring, function() {});
                            //logger.info(CMDstring);   
                    }
            });
        }, interval);
};

/**
 * Redis data model:
 * 
 * score: timestamp
 * value: timestamp:value
 * http://redis.io/commands#sorted_set
 * 
 *  4 time periods needed
 *  - removing samples from redis db (24h)
 *  - sampling rate (10 secs)
 *  - sum_range (10 minutes)
 *  - flusing from memory to db (30 seconds)
 */

var eventSamples = {};
var resultCache = {};

var SAMPLING_RATE = 10000;		// internal sampling ratio
var SUM_RANGE = 600000;			// calculate the sum for the last 10 minutes

function cleanUpSamples(eventName, tsLimit) {
	while ((eventSamples[eventName].length > 0) && (eventSamples[eventName][0].ts < tsLimit)) {
		resultCache[eventName] -= eventSamples[eventName][0].count;
		eventSamples[eventName].shift();
	} 	
};

function getEventsStats(data) {
	var tsLimit = new Date().getTime() - SUM_RANGE;

	for(eventName in eventSamples) {
		cleanUpSamples(eventName, tsLimit);
		data['event_' + eventName] = resultCache[eventName];
	}
	return data;
};

exports.incrEventCounter = incrEventCounter = function(eventName) {
	if (!(eventName in eventSamples)) {
		eventSamples[eventName] = [];
		resultCache[eventName] = 0;
	}
	var ts = new Date().getTime(), length = eventSamples[eventName].length;
	ts -= ts % SAMPLING_RATE;
	if ((length === 0) || (eventSamples[eventName][length-1].ts !== ts)) {
		eventSamples[eventName].push({ts: ts, count: 1});
	} else {
		eventSamples[eventName][length-1].count += 1;
	}
	resultCache[eventName]++;
	
	
	/**
	 * Samples should be cleaned up in getEventsStats,
	 * but we remove the very old samples here just in case
	 * someone removes calls to getEventsStats and we end up
	 * eating all the memory
	 */
	cleanUpSamples(eventName, new Date().getTime() - 3 * SUM_RANGE);
};

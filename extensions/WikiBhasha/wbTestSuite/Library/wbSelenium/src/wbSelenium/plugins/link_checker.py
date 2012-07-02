#######################################################################
#
#   Copyright (c) Microsoft. 
#
#	This code is licensed under the Apache License, Version 2.0.
#   THIS CODE IS PROVIDED *AS IS* WITHOUT WARRANTY OF
#   ANY KIND, EITHER EXPRESS OR IMPLIED, INCLUDING ANY
#   IMPLIED WARRANTIES OF FITNESS FOR A PARTICULAR
#   PURPOSE, MERCHANTABILITY, OR NON-INFRINGEMENT.
#
#   The apache license details from 
#   'http://www.apache.org/licenses/' are reproduced 
#   in 'Apache2_license.txt'
#
#######################################################################

"""wbSelenium Link Checker plugin which provides basic link verification on
the currently loaded page. 

This plugin adds the `check links` keyword that scans all the `<a href=x` tags
on the currently loaded page and prints all links that have a http response 
greater than 400 to the robot logs."""
from __future__ import with_statement
from threading import Thread, Lock, Condition 
from Queue import Queue, Empty as EmptyQueue 
from wbSelenium.utils.logging import log, info, debug, warn, html
from urlparse import urlparse, urljoin, urlsplit
from socket import gaierror
import httplib

NUM_WORKER_THREADS = 20 

class _WorkerTimer(object):
    """Helper class for LinkChecker that provides basic synchronization
    and timing support for LinkChecker threads.

    Worker threads check a condition variable to see if they can be started
    or if they can continue doing work. In addition an employer can wait
    until the worker threads are done or have timed out before stalling.
    
    Employeer is the thread which is starting workers, workers are threads
    which complete `num_urls` tasks within `timeout`."""

    def __init__(self, num_urls, timeout):
        """Construct a worker timer used to process `num_urls` within 
        `timeout`"""
        self._timeout = timeout # how long we have to finish tasks
        self._mutex = Lock()
        self._wait_condition = Condition(self._mutex)  # stall employeer
        self._start_condition = Condition(self._mutex) # stall worker
        self._num_urls = num_urls # num tasks to complete
        self._has_started = False
        self._work_has_finished = False

    def worker_task_done(self):
        """Completed one worker task. If no more tasks then wake up
        employer"""
        with self._mutex:
            self._num_urls -= 1
            if self._num_urls == 0:
                self._wait_condition.notify()

    def worker_wait(self):
        """Stall worker until work is ready"""
        with self._mutex:
            if not self._has_started:
                self._start_condition.wait()
 
    def work_has_finished(self):
        """Return True if there are no more urls to process or we timeout
        was exceeded"""
        with self._mutex:
            return self._work_has_finished
               
    def start_workers_and_wait(self):
        """Called by employeer to wait until workers have finished urls
        or timeout has exceeded"""
        with self._mutex:
            self._has_started = True
            self._start_condition.notifyAll() # and they're off
            self._wait_condition.wait(self._timeout)
            self._work_has_finished = True

class LinkChecker(object):
    """Primitive link checker which grabs all links on the current page
    and verifies their status codes."""

    def __init__(self):
        # add handlers here to retrieve different links to process
        self.url_source_handlers = [('a_hrefs',
                      lambda: self.get_string_array('getAllLinkHrefs', []))]

    def check_links(self, timeout=10):
        """Check all the links on the current page to see if valid"""
        unprocessed_links = []
        for name, handler in self.url_source_handlers:
            debug('getting links from %s handler' % name)     
            unprocessed_links += handler()
        # check links
        normalized_links = LinkChecker._normalize_links(unprocessed_links)
        link_hash = LinkChecker._check_links_threaded(normalized_links,
                                                            timeout)
        invalid_link_hash = LinkChecker._error_links(link_hash)
        html(self, LinkChecker._link_hash_to_string(invalid_link_hash))

    @staticmethod
    def _error_links(link_hash):
        """Filter `link_hash` and return a new hash of only invalid links."""
        return dict([(link, value) for (link, value) in link_hash.items()
                     if not(value['url']=='http://') and value['status'] and int(value['status']) >= 400])

    @staticmethod
    def _link_hash_to_string(link_hash):
        """Print a dictionary containing urls as keys with dictionary values
        with `url`, `status`, `reason` keys."""
        html = '<tr><td colspan="3">Invalid Links:</td></tr>'
        if not link_hash:
            html += '<tr><td colspan="3">None</td></tr>'
        for link in link_hash.values():
            html += '<tr><td>%s</td><td>%s</td><td>%s</td></tr>' % (
                 link['url'], link['status'], link['reason'])
        return html

    @staticmethod
    def _normalize_links(url_list):
        """Return a normalized list of links from a list that may be improperly 
        formatted."""
        normalized_links = url_list[:]
        for i in xrange(len(normalized_links)):
            url = normalized_links[i]
            # add `http://` if missing
            if not urlparse(url).scheme:
                normalized_links[i] = urljoin("http://", "//" + url)
        return normalized_links

    @staticmethod
    def _wait_for_validation(url):
        """Return the status of a url as dict {`url`, `status`, `reason`}"""
        host, path = urlsplit(url)[1:3]
        connection = httplib.HTTPConnection(host)
        status, reason = None, None
        try:
            connection.request("HEAD", path) 
        except gaierror: # bad host
            pass
        else:   
            response = connection.getresponse() # wait for response
            status, reason = response.status, response.reason
        return {'url': url, 'status': status, 'reason': reason}

    @staticmethod
    def _check_links_threaded(url_list, timeout):
        """Employeer which starts worker threads to check urls."""
        url_queue = Queue()
        result_hash = {} 
        map(url_queue.put_nowait, url_list)
        num_urls = len(url_list)
        timer = _WorkerTimer(num_urls, timeout)
        num_threads = max(min(NUM_WORKER_THREADS, num_urls), 1)
        for _ in xrange(num_threads):
            LinkChecker._start_link_worker(url_queue, result_hash, timer)
        timer.start_workers_and_wait()
        for url in set(url_list).difference(result_hash.keys()):
            # if the url timedout then give None for `status` and `reason`
            result_hash[url] = result_hash.get(url, {'url': url, 
                                                     'status': None,
                                                     'reason':None })
        return result_hash 

    @staticmethod
    def _start_link_worker(url_queue, result_hash, timer):
        """Worker thread which does work on elements of `url_queue` and places
        results on `done_queue` using `timer` for synchronization and timing."""
        def hard_worker():
            """Contionusly waits for work and performs work if available and
            time left."""
            timer.worker_wait()
            while True:
                try:
                    url = url_queue.get_nowait()
                except EmptyQueue: 
                    break 
                ret_val = LinkChecker._wait_for_validation(url)
                if not timer.work_has_finished(): 
                    timer.worker_task_done()
                    result_hash[ret_val['url']] = ret_val
                else: 
                    break
        thread = Thread(target=hard_worker)
        thread.setDaemon(True)
        thread.start()

if __name__ == '__main__':
    from time import time as now
    lc = LinkChecker()
    # short list
    url_list = ["http://thinkgeek.com", "http://sonothere.com", "http://gmail.com"]
    print "testing list of length %s" % len(url_list)
    before = now()
    result = lc._check_links_threaded(url_list, 10)
    print result
    print "duration: %s, num_processed: %s" % (str(now() - before), len(result))
    # long list
    url_list = ["http://www.google.com", "http://www.sonotthere.com", "http://www.yahoo.com", "www.popurls.com", "gmail.com", "skype.com", "reddit.com", "facebook.com", "digg.com", "cnet.com", "msr.com", "fluidnetworking.net", "myspace.com", "whitehouse.gov", "fark.com", "delicious.com", "wordpress.com", "geoffkim.com", "everquest.com", "sony.com", "woot.com", "app2you.com", "python.org", "rapidshare.com", "ymail.com" ]
    print "testing list of length %s" % len(url_list)
    before = now()
    result = lc._check_links_threaded(url_list, 60)
    print result
    print "duration: %s, num_processed: %s" % (str(now() - before), len(result))

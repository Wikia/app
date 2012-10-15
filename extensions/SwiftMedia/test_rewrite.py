#!/usr/bin/python

import unittest

import webob

from wmf import rewrite
from wmf.client import ClientException

class FakeApp(object):
    def __init__(self, status, headers):
        self.status = status
        self.headers = headers

    def __call__(self, env, start_response):
        start_response(self.status, self.headers)
        return "FAKE APP"

def start_response(*args):
    pass

class TestRewrite(unittest.TestCase):

    def setUp(self):
        pass

    account="AUTH_..."
    urlbig = 'http://alsted.wikimedia.org/wikipedia/commons/a/aa/'\
            'Dzimbo_u_Beogradu_19.jpeg'
    urlorig = '/v1/' + account + \
            '/wikipedia%2Fcommons/a/aa/Dzimbo_u_Beogradu_19.jpeg'
    thumbbig = 'http://alsted.wikimedia.org/wikipedia/commons/thumb/a/aa/'\
            'Dzimbo_u_Beogradu_19.jpeg/448px-Dzimbo_u_Beogradu_19.jpeg'
    url448 = '/v1/' + account + \
            '/wikipedia%2Fcommons%2Fthumb/a/aa/'\
            'Dzimbo_u_Beogradu_19.jpeg/448px-Dzimbo_u_Beogradu_19.jpeg'
    urlaccount = 'http://alsted.wikimedia.org/' + account
    contname = '/wikipedia/commons/thumb'
    objname = '/a/aa/Dzimbo_u_Beogradu_19.jpeg/91px-Dzimbo_u_Beogradu_19.jpeg'
    a = dict(account=account,
            url="https://127.0.0.1:11000/v1.0",
            login="yourlogin",
            thumbhost='localhost',
            user_agent='Mozilla/5.0',
            key="yourkey")

    def test_01(self):
        """#01 Cur controller can snarf its args."""
        controller = rewrite.ObjectController()
        controller.do_start_response("200 Good", {"test": "testy"})
        self.assertEquals(controller.response_args[0], "200 Good")
        self.assertEquals(controller.response_args[1], {"test": "testy"})

    def test_01a(self):
        """#01a Our app calls into the FakeApp; returns its results if 200 """
        app = rewrite.WMFRewrite(FakeApp("200 Good", {}),self.a)
        req = webob.Request.blank(self.urlbig,
                environ={'REQUEST_METHOD': 'GET'})
        controller = rewrite.ObjectController()
        resp = app(req.environ, controller.do_start_response)
        self.assertEquals(resp, 'FAKE APP')

    def test_02(self):
        """#02 Test URL rewriting for originals. """
        app = rewrite.WMFRewrite(FakeApp("200 Good", {}),self.a)
        req = webob.Request.blank(self.urlbig,
                environ={'REQUEST_METHOD': 'GET'})
        resp = app(req.environ, start_response)
        self.assertEquals(req.environ['PATH_INFO'], self.urlorig)

    def test_03(self):
        """#03 Test URL rewriting for thumbs. """
        app = rewrite.WMFRewrite(FakeApp("200 Good", {}),self.a)
        req = webob.Request.blank(self.thumbbig,
                environ={'REQUEST_METHOD': 'GET'})
        resp = app(req.environ, start_response)
        self.assertEquals(req.environ['PATH_INFO'], self.url448)

    def test_04(self):
        """#04 Test a write. Could fail if our token has gone stale"""
        app = rewrite.WMFRewrite(FakeApp("404 Bad", {}),self.a)
        req = webob.Request.blank(self.thumbbig,
                environ={'REQUEST_METHOD': 'GET'})
        resp = app(req.environ, start_response)
        self.assertEquals(req.environ['PATH_INFO'], self.url448)
        # note that we PUT this file onto the server here, even if it's already there.
        datalen = 0
        for data in resp:
            datalen += len(data)
        self.assertEquals(datalen, 51543)

    def test_05(self):
        """#05 Report 401 (authorization) errors"""
        app = rewrite.WMFRewrite(FakeApp("401 Bad", {}),self.a)
        req = webob.Request.blank(self.thumbbig,
                environ={'REQUEST_METHOD': 'GET'})
        resp = app(req.environ, start_response)
        self.assertEquals(req.environ['PATH_INFO'], self.url448)
        self.assertEquals(resp,
            ['401 Unauthorized\n\nThis server could not verify that you are '\
             'authorized to access the document you requested. Either you '\
             'supplied the wrong credentials (e.g., bad password), or your '\
             'browser does not understand how to supply the credentials '\
             'required.\n\n Token may have timed out  '])

    def test_06(self):
        """#06 Give them a bad token so that the PUT fails."""
        app = rewrite.WMFRewrite(FakeApp("404 Bad", {}),self.a)
        app.token = "HaHaYeahRight"
        req = webob.Request.blank(self.thumbbig,
            environ={'REQUEST_METHOD': 'GET'})
        resp = app(req.environ, start_response)
        self.assertEquals(req.environ['PATH_INFO'], self.url448)
        # the PUT fails because we give them a bad token, but ... we should
        # really silently just hand back the file.
        try:
            datalen = 0
            for data in resp:
                datalen += len(data)
        except ClientException, x:
            self.assertEquals(datalen, 51543)
            y = "ClientException('Object PUT failed',)"
            self.assertEquals(`x`, y)

    def test_07(self):
        """#07 Make sure that an already-authorized path goes unchanged."""
        app = rewrite.WMFRewrite(FakeApp("200 Good", {}),self.a)
        url = self.urlaccount + self.contname + self.objname
        req = webob.Request.blank(url, environ={'REQUEST_METHOD': 'GET'})
        resp = app(req.environ, start_response)
        self.assertEquals(req.url, url) # should remain unchanged
        #self.assertTrue(len(app.response_args) == 0) # no args either.

    def test_08(self):
        """#08 Don't let them read the container"""
        app = rewrite.WMFRewrite(FakeApp("200 Good", {}),self.a)
        req = webob.Request.blank(
            'http://alsted.wikimedia.org/wikipedia/commons/',
            environ={'REQUEST_METHOD': 'GET'})
        resp = app(req.environ, start_response)
        self.assertEquals(resp,
            ['403 Forbidden\n\nAccess was denied to this resource.\n\n '\
                    'No container listing  '])

    # test_09 became obsolete

    def test_10(self):
        """#10 Trap weird-ass errors"""
        app = rewrite.WMFRewrite(FakeApp("999 Unrecognized", {}),self.a)
        req = webob.Request.blank("http://localhost/a/b/c",
                environ={'REQUEST_METHOD': 'GET'})
        resp = app(req.environ, start_response)
        self.assertEquals(resp,
            ['501 Not Implemented\n\nThe server has either erred or is '\
             'incapable of performing the requested operation.\n\n Unknown '\
             'Status: 999  '])

    def test_11(self):
        """#11 Trap URLs that don't match the regexp"""
        app = rewrite.WMFRewrite(FakeApp("404 TryRegexp", {}),self.a)
        req = webob.Request.blank("http://localhost/a",
                environ={'REQUEST_METHOD': 'GET'})
        resp = app(req.environ, start_response)
        self.assertEquals(resp,
                ['400 Bad Request\n\nThe server could not comply with the '\
                 'request since it is either malformed or otherwise '\
                 'incorrect.\n\n Regexp failed: "/a"  '])

if __name__ == '__main__':
    unittest.main()


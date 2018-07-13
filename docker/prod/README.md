## MW on Kubernetes
To test MW on Kubernetes you can:
- visit [mediawiki119.wikia.com](http://mediawiki119.wikia.com) — whole wiki is served from k8s
- add X-Mw-Kubernetes header to your test request (e.g. via cURL or browser extension)

cURL example: `curl -svo/dev/null -H "X-Mw-Kubernetes: 1" -L http://de.god-of-war.wikia.com/wiki/God_of_War_Wiki?foo=bar`

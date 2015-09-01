#!/bin/bash -eu

# This script builds a new gh-pages branch from latest master

cd "$(dirname $0)/.."
git fetch origin
git checkout -B gh-pages origin/master
git reset --hard origin/master

git clean -dffx
# Run npm-install to fetch qunitjs and build dist/
npm install

html='<!DOCTYPE html>
<meta charset="utf-8">
<title>VisualEditor</title>
<link rel=stylesheet href="lib/oojs-ui/oojs-ui-apex.vector.css">
<link rel=stylesheet href="demos/ve/demo.css">
<style>
	article {
		margin: 1em auto;
		width: 45em;
		max-width: 80%;
		text-align: center;
	}
	article img {
		max-width: 100%;
	}
</style>
<article>
	<img src="demos/ve/VisualEditor-logo.svg" alt="VisualEditor logo">
	<div class="oo-ui-widget oo-ui-widget-enabled oo-ui-buttonElement oo-ui-buttonElement-framed oo-ui-labelElement oo-ui-buttonWidget"><a role="button" href="demos/ve/desktop-dist.html" tabindex="0" class="oo-ui-buttonElement-button"><span class="oo-ui-labelElement-label">Demo</span></a></div></a>
	<div class="oo-ui-widget oo-ui-widget-enabled oo-ui-buttonElement oo-ui-buttonElement-framed oo-ui-labelElement oo-ui-buttonWidget"><a role="button" href="tests/" tabindex="0" class="oo-ui-buttonElement-button"><span class="oo-ui-labelElement-label">Test suite</span></a></div>
</article>'
echo "$html" > index.html

git add index.html
git add -f node_modules/qunitjs dist/

git commit -m "Create gh-pages branch"
git push origin -f HEAD

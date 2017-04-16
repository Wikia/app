Wikia Style Guide
===========

1. [Using the Style Guide in your projects](#using-the-style-guide-in-your-projects)
2. [Development Workflow](#development-workflow)
3. [Contributing](#contributing)

## Using the Style Guide in your projects
This style guide has been built to easily integrate into your applications through [bower](http://bower.io/) or manually as a compiled package of all the components, individual components or as SCSS source files. We recommend using bower, as then your application will gain access to easy dependency management, versioning and future upgrades will be predictable and easy to integrate.

### Installing using bower
To add this package as a bower dependency, simply run `$ bower install --save Wikia/style-guide` and this will fetch the latest from our development branch. If you prefer a simple version, run something like `$ bower install --save Wikia/style-guide#v0.2.0` or for a specific branch `$ bower install --save Wikia/style-guide#feature-branch`.

After installation, you’ll find the style guide in the `wikia-style-guide/` folder of your `bower_components` (this is the default bower components destination) folder. At that point, how you use the style guide is up to your specific application.

## Development Workflow
Development for the style guide is comprised of two main activities:
* Writing the source for your components and modules
* Updating the living documentation. To reduce the cognitive load on the developer, we’ve added a few tools to aid in this process.

Development involves the following:
* [Living Documentation](#living-documentation)
* [Watching and updating the living documentation automatically](#watching-and-updating-the-living-documentation-automatically)
* [Updating the remote living documentation](#updating-the-remote-living-documentation)
* [Bumping Versions](#bumping-versions)

### Living Documentation
The living documentation can be found in the `gh-pages/` folder of the project. To get started with development, you can start the server by:
* install jekyll (http://jekyllrb.com/) e.g. by running `gem jekyll`
* (from project root) `npm install` to install dependencies
* `$ cd gh-pages/`
* `$ jekyll serve --baseUrl=''`
This will start the Jekyll server on the default port of 4000. If you need a different port, use the `--port XXXX` flag when running `jekyll serve`. You can then visit [localhost:4000](http://localhost:4000) to view the living documentation.

#### Troubleshooting
If you're having trouble with your global version of Jekyll, you can try using the version that is local to the style guide project: `bundle exec jekyll serve`

### Watching and updating the living documentation automatically
Always start your development by running `$ gulp watch`. With this task running, anytime you edit a file in the `src/` directory of the project, gulp will automatically compile your styles, icons and also update the static assets in the `gh-pages` subfolder, where the living documentation lives.

### Updating the remote living documentation
Your local `gh-pages` subfolder **is the source** for [http://wikia.github.io/style-guide](http://wikia.github.io/style-guide). GitHub uses the gh-pages *branch* of this repo as a deployment target for it’s GitHub Pages feature. As developers, you will **not** be updating this branch manually. That is to say, when adding to the living documentation, you will be modifying the contents of the `gh-pages` folder, not the branch and previewing your changes locally.

In order to update the remote, we’ve created a convenient script that will handle this for you. To update the remote living documentation, please run:
`$ bash update-gh-pages.sh`
For more information on what this script does, check out the [source](https://github.com/Wikia/style-guide/blob/dev/update-gh-pages.sh).

### Bumping Versions
Bumping the version of package is important to making sure users of the style guide can anticipate breaking changes and security updates to their package. In order to make this easier, please use the following commands to bump the version.
* `$ npm run bump-major` major changes introduce breaking changes
* `$ npm run bump-minor` minor changes should **never** introduce breaking changes, but may contain new features or changed underlying implementations
* `$ npm run bump-patch` patches should **not introduce breaking changes or introduce new features**, but may include bug fixes for the current version

## Contributing
If you’re thinking of contributing to the style guide (which you totally absolutely should!), then check out our handy [contribution guidelines](https://github.com/Wikia/style-guide/blob/dev/CONTRIBUTING.md)!

# wikia.github.io/style-guide
Welcome! If you are unfamiliar with [jekyll](http://jekyllrb.com/) or [GitHub pages](https://pages.github.com/), the basics are:
* We use GitHub’s Pages feature to host the living documentation for the style guide
* GitHub allows you to host static *or* Jekyll-powered sites for each one of your repositories, under the condition that the code for this site is in the **gh-pages** branch of your repo.
* The gh-pages branch of your repo is not based off your master conventionally

To update this branch, run `$ bash update-gh-pages.sh` from your dev branch, or whatever feature branch you’re developing from. Consider the gh-pages branch perishable as it gets deleted and recreated on each run of the update script.

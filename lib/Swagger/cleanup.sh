# this should be run from lib/Swagger/ AFTER generating code

rm -rf test/ docs/Api/ docs/Model/ LICENSE ../LICENSE .travis.yml git_push.sh;
git co README.md composer.json autoload.php src/ApiClient.php src/Configuration.php

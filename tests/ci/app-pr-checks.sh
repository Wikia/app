#!/usr/bin/env bash

# $1 - context
# $2 - state
# $3 - description
updateGit() {
curl -s \
	-X POST  \
	-H "Authorization: token $GITHUB_TOKEN" \
	-d "{ \"state\": \"$2\", \"description\": \"$3\", \"context\": \"$1\", \"target_url\": \"${BUILD_URL}testReport\" }" \
	https://api.github.com/repos/Wikia/app/statuses/$GIT_COMMIT
}

cd $WORKSPACE/app/tests

make prepare

updateGit "PHP unit tests" pending pending
make phpunit || unitTestsFailed=true
if [[ $unitTestsFailed ]]
then
    updateGit "PHP unit tests" failure "Unit tests failed"
else
    updateGit "PHP unit tests" success success
fi

updateGit "PHP integration tests" pending pending
make phpunit-infrastructure || integrationTestsFailed=true
if [[ $integrationTestsFailed ]]
then
    updateGit "PHP integration tests" failure "Integration tests failed"
else
    updateGit "PHP integration tests" success success
fi






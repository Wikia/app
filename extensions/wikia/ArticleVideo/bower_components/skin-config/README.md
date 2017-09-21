# Skin Config
A series of JSON files that can be used to configure Ooyala's new cross-platform Skin UI.. These files define:

1. *skin.json:* A configuration that is applied to the OoyalaSkinSDK, which outlines the desired look and feel of the user interface.  You can modify this file to suit the needs of your application
2. *skin-schema.json:* A JSON schema that defines all of the possible options for the skin.json
3. *[language].json:* A series of files that represent the localization of all strings used in our Skin UI (i.e. en.json, zh.json)

See [http://apidocs.ooyala.com/player_v4_skin_config/index.html](http://apidocs.ooyala.com/player_v4_skin_config/index.html) for user-friendly skin-schema documentation.

## Installing and Running the node Validator
You can use the JSON Schema to validate the correctness of your skin.json configuration. To validate your configuration against the JSON schema:

    npm install
    node ./validate.js <schema> <data>


To add the git hook in order to automatically verify the skin when committing, run
```
./add-githook-validate
```

You can use the following command to validate all json files in the folder against the schema

    find . -type f -name "*skin.json" | xargs -I REPL node validate.js skin-schema.json REPL

## Online validator
This on-line Java based version gives more-better debug information
when the data fails to pass validation:
http://json-schema-validator.herokuapp.com/

## Schema notes
We support comments in our schema and skin files using
`//` or `/* */`. These are technically not legal and will cause some validators to report
invalid data. Our local vlidator strips out comments. If you need to strip them out
e.g. so you can send the file over to the on-line Java validator mentioned above,
then you have to "npm install -g [strip-json-comments](https://www.npmjs.com/package/strip-json-comments)"
and use it on the command line. On Mac OS X you can pipe the results to pbcopy and then
paste the results into the on-line validator.

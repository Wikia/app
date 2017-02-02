# Swagger
A collection of clients for microservices annotated with [Swagger](http://swagger.io/), auto-generated using [swagger-codegen](https://github.com/swagger-api/swagger-codegen). *DO NOT* manually edit PHP classes here.

## Code Generation Settings
The currently generated shared files (ApiClient, Configuration, etc) are compatible with swagger-codegen-2.2.0.

Each service should have a `settings.json` file associated with it indicating parameters to the code generation, ex:
```json
{
  "packagePath": "Swagger",
  "srcBasePath": "src",
  "modelPackage": "Swagger\\Client\\User\\Preferences\\Models",
  "apiPackage": "Swagger\\Client\\User\\Preferences\\Api"
}
```

The `packagePath`, `srcBasePath`, and prefix `Swagger\Client\` should be consistent across all settings files so code will end up in this directory.

## Generating Code
Follow the instructions on the [swagger-codegen](https://github.com/swagger-api/swagger-codegen) repo to get a local generator compiled, then run
(from `lib/Swagger`):

```bash
java -jar modules/swagger-codegen-cli/target/swagger-codegen-cli.jar generate \
  -i <swagger-json> \
  -l php \
  -o <path/to/lib/dir> \
  -c <path/to/settings>
```

For example, if my code was located at `/Users/nelson/code/wikia/app` and I wanted to generate code for user-preferences, I would run:

```bash
java -jar modules/swagger-codegen-cli/target/swagger-codegen-cli.jar generate \
  -i https://services.wikia.com/user-preference/swagger.json \
  -l php \
  -o /Users/nelson/code/wikia/app/lib \
  -c /Users/nelson/code/wikia/app/lib/Swagger/src/User/Preferences/settings.json
```

Afterwards, run ./cleanup.sh from `lib/Swagger` to remove unneeded generated files.

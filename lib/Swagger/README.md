# Swagger
A collection of clients for microservices annotated with [Swagger](http://swagger.io/), auto-generated using [swagger-codegen](https://github.com/swagger-api/swagger-codegen). *DO NOT* manually edit PHP classes here.

## Code Generation Settings
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
Follow the instructions on the [swagger-codegen](https://github.com/swagger-api/swagger-codegen) repo to get a local generator compiled, then run:

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

After code was generated copy `lib/Swagger/README.md` to appropriate file (i.e. `lib/Swagger/README_user-preference.md`) and update list below.

## Documentation
Below you find API documentation for each service:
* [User Preference](README_user-preference.md)
* [User Avatar](README_user-avatar.md)
* [User Attribute](README_user-attribute.md]
* [Template Classification Storage](README_template-classification.md]

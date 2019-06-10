## PHP unit and integration tests
### Preparing the environment on macOS
PHP unit and integration tests for Wikia app are automatically executed for each pull request
by the [Travis CI continuous integration system](https://travis-ci.org/Wikia/app/builds).
If you'd like to run them locally, the following steps should help you get started on macOS:
1. Make sure you have PHP 7.0 installed. On macOS, this is easiest to do via [Homebrew](https://brew.sh/):
	```
	$ brew install php@7.0 && brew link php@7.0 --force
	```
2. Install at least the [uopz](https://github.com/krakjoe/uopz) and [xdebug](https://xdebug.org/) extensions from [PECL](https://pecl.php.net/).:
	```
	$ pecl install uopz xdebug
	```
3. Set up a local MySQL 5.7 server. This is again easiest to do via Homebrew:
	```
	$ brew install mysql@5.7 && brew link mysql@5.7 --force && mysql.server start && mysql_secure_installation
	```
	`mysql_secure_installation` will prompt you several questions, the only thing we care about is setting the root password. Since the database will be exclusive to localhost (your laptop) and only used for tests, any sensible value is good here.
4. Make sure that the parent directory of your app clone does **NOT** contain a config subdirectory
with anything of value. The tests will write to this directory and destroy everything there!

### Setup notes for non-macOS environments
On certain Linux distributions, you might need to install PHP's `mysqli` extension independently of PHP itself. Here is how to do that for Debian and derivatives:
```
# apt-get install php-mysql
```

You may also need to set up MySQL account permissions:

```sql
GRANT ALL ON firefly.* TO 'your_username'@'localhost';
GRANT SUPER ON *.* TO 'your_username'@'localhost';
```

### Running tests
Once you got your environment setup, you can run the tests. Set the `MYSQL_USER` and `MYSQL_PASSWORD` to the credentials you configured during installation (on macOS, you can use the provided `root` user):
```
$ MYSQL_USER=root MYSQL_PASSWORD=my_pw ./php-tests.sh
```
In order to run only a subset of all tests, pass a directory or file to the test runner as an argument:
```
$ MYSQL_USER=root MYSQL_PASSWORD=my_pw ./php-tests.sh ../extensions/wikia/Example # run tests for Example only
$ MYSQL_USER=root MYSQL_PASSWORD=my_pw ./php-tests.sh ../extensions/wikia/Example/tests/MyTest.php # run only MyTest
```

### Running a single unit test
If you simply want to run  subset of unit tests that do not depend on db, you can use the `run-test.php` script directly:
```
x@dev-x:/usr/wikia/source/app/tests$ SERVER_DBNAME=firefly php run-test.php ../extensions/wikia/CreateNewWiki/tests/
```

### Best practices
If you add a test which relies on PHP extensions to function (e.g. a test that involves rendering mustache templates),
check if the extension is loaded in the test setup phase.
```php
use PHPUnit\Framework\TestCase;

class MyTest extends TestCase {
	protected function setUp() {
		parent::setUp();

		if ( !extension_loaded( 'mustache' ) ) {
			$this->markTestSkipped( '"mustache" PHP extension needs to be loaded!' );
		}
	}
}
```
This way, the test will be gracefully skipped if the required extension is not available locally.

## JS tests
First fetch the dependencies from [NPM](https://www.npmjs.com/):
```
$ npm install
```
Then you can run the tests with:
```
$ ./js-all
```



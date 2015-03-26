## Email Framework

This extension allows emails to be constructed using standard Wikia headers and footers

## Testing an Email

To test an email you must know:
 
* The name of the email controller
* What parameters that email requires
* Be logged in as a staff user

To find the controller name, look in the `Controller` folder and find the file defining the email
you'd like to test.  For example the `Email\Controller\ForgotPasswordController` class (in the `UserLogin.class.php` file)
handles the password reset email.  The 'Controller' suffix of this name can be left off when calling this
controller, so just `Email\Controller\ForgotPassword`

The parameters required by the email should be listed in the class documentation just above the class
definition.  For example the ForgotPassword email requires a `username` parameter.  FYI, for this
framework, the `method` is always `handle`

Finally, you need to be logged in under a staff member account otherwise you will not be able to 
access this controller for security reasons.

For the ForgotPassword email, the URL is then:

  http://garth.garth.wikia-dev.com/wikia.php?controller=Email\Controller\ForgotPassword&method=handle&username=GarthTest400
  
## Adding New Emails

### Create a New Controller

First add a new class file in the `Controller` directory for the feature responsible for this email
or use an existing file if that feature already has some emails defined in this framework.  There can
be multiple classes per file, one per email for that feature.

These classes should inherit from `Email\EmailController`.  The methods this controller can
override/implement are:

* assertCanAccessController : This determines who can access this controller.  The defaults, staff and internal
requests should be sufficient for almost all cases.
* assertCanEmail : Determines whether the email should be sent given current business logic.
* initEmail : Any initialization should be done here.  This includes error checking and/or loading request values.
* getToAddress : Supplies the `To` address.  Default is current user.
* getFromAddress : Supplies the `From` address.  Defaults to `$wgPasswordSender` and `$wgPasswordSenderName`
* getReplyToAddress : Supplies the `Reply-To` address.  Defaults to `$wgNoReplyAddress`
* getSubject : [REQUIRED] Supplies the subject for the email.  There is no default.
* body : A controller method that builds the email body via the view.

### Creating a New Template

When defining the `body` method in the controller, give the template name via the `@template` annotation.
This gives the name of the template, minus the directory and templating suffix.

There are special `Email_footer` and `Email_header` templates that should be used to define a consistent
look for the email.

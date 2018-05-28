## Email Framework

This extension allows emails to be constructed using standard Wikia headers and footers

## Testing an Email

### Special:SendEmail

Special:SendEmail (e.g. http://garth.wikia.com/wiki/Special:SendEmail) is a special page which presents a list of forms you can use to send off any of our emails. You must
be logged in with a staff account to access the page, and each form contains fields which correspond to the required
parameters for each of the emails.

### Testing Email Via an HTTP Request

In addition to sending an email through Special:SendEmail, you can also send an email by making a request to wikia.php.
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

The `main.mustache` template is the main layout for all emails and includes the header and footer. 

### Images

To add a new image, upload it to the [WikiaNewsletter wiki](http://wikianewsletter.wikia.com) and put it in the "Html_Emails" category so we can keep track of all the images used in emails. We'll generate those images dynamically with https://wikia-inc.atlassian.net/browse/SOC-622 but in the mean time the URLs are hard-coded in the templates. 

Note that email client support for SVGs is not great, so be sure to use JPG, GIF, or PNG files. 

### CSS

We're not using SCSS for the HTML emails, although we could theoretically add support for that in the future. For now, we're using plain CSS and [CssToInlineStyles](https://github.com/tijsverkoyen/CssToInlineStyles/) for inlining CSS into the templates. 

There's one `common.css` that gets included in every template automatically. For template-specific styles, add them via `\Email\EmailController::inlineStyles` in the child class' `getContent` method.

See [campaignmonitor.com's](https://www.campaignmonitor.com/css/) cheat sheet for understanding which css properties are supported in major email clients. 

## Tools

### CssToInlineStyles

[CssToInlineStyles](https://github.com/tijsverkoyen/CssToInlineStyles/) is a PHP library that will inline CSS properties into the `style` attribute. It's installed via Composer and can be found in `/lib/composer/tijsverkoyen/`.

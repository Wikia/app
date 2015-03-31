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

The `main.mustache` template is the main layout for all emails and includes the header and footer. 

### Images

To add a new image, upload it to the [WikiaNewsletter wiki](http://wikianewsletter.wikia.com). Copy and paste the URI's for these images into your template. Also please include new images inside the Email extension's `images` folder just for reference. 

To be sure that [`web-resource-inliner`](https://github.com/jrit/web-resource-inliner) plugin doesn't base64 encode the images and inline them into the template, add the `data-inline-ignore` attribute to all `img` tags. 

Note that email client support for SVGs is not great, so be sure to use JPG, GIF, or PNG files. 

### CSS

We're not using SCSS for the HTML emails, although we could theoretically add support for that in the future. For now, we're using plain CSS and [Juice](https://github.com/Automattic/juice#juice) for inlining CSS into the templates. 

Please add a new css file for every new template and make sure it's included at the top of the template file via `link` tag. There's also a `common.css` file that you'll want to include in every template as well. 

See [campaignmonitor.com's](https://www.campaignmonitor.com/css/) cheat sheet for understanding which css properties are supported in major email clients. 

## Tools

### Juice

[Juice](https://github.com/Automattic/juice#juice) is a library that will inline CSS properties into the `style` attribute. See Juice dependencies [here](https://github.com/Automattic/juice/blob/master/package.json). 

### Grunt

We're using [Grunt](http://gruntjs.com/) along with [Grunt Watch](https://github.com/gruntjs/grunt-contrib-watch) to manage the task of inlining CSS. 

First, make sure you have [NodeJS](https://nodejs.org/download/) and [Grunt](http://gruntjs.com/getting-started) installed. Then, when you begin development, `cd` into the `Email/scripts` folder, then: 

* `npm install` (generally only needed once)
* `grunt watch`

This will ensure that when you make changes to a template inside `Email/templates/src`, it will be compiled with inline styles and copied into `Email/templates/compiled`. Note that if you're not working directly on your devbox, you'll have to make sure that files changed on your disk get uploaded to your devbox for them to work. 

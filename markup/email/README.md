# Email Process

* See if you can find an example or recent email to use as a starting point
* Try to reference other content blocks for best practices; document any new ones
* Don't forget to create the text version of the email; be sure it and the html are using UTF-8 encoding
* Run your markup through a validator to catch any non-custom-tag issues

## Running Campaigns

* If not using a system that will inline your styles
	* Run the markup through an inliner tool; verify the inliner did not corrupt any markup; save as a separate inlined version
	* (Optional for some systems) Remove style code blocks from the head, typically leaving just meta and title tags unless the email is responsive or has needs beyond basic styles
* If using Campaign Monitor
	* Zip up your /images folder or any other resources when importing the design; CM will walk you through this
	* CM will give you the option to inline your styles and such so you don't have to make it part of your workflow
	* CM has good documentation on using custom and build in variables (http://help.campaignmonitor.com/topic.aspx?t=33#custom-fields)
	* For custom/system variable areas
		* The sending lists know have custom variable names, they will be used in this format: [firstname, fallback=valued customer] and [email]
		* An example unstyled "This email was sent to:":
			* This email was sent to: <a href="mailto:[email]">[email]</a>
		* An example unstyled "Trouble reading this email?":
			* <webversion>Trouble reading this email?</webversion>
		* An example  unstyled "Unsubscribe" link:
			* <unsubscribe>Unsubscribe</unsubscribe>
* If using Silverpop
	* Run the markup through an inliner tool; verify the inliner did not corrupt any markup; save as a separate inlined version
	* Remove style code blocks from the head, typically leaving just meta and title tags unless the email is responsive or has needs beyond basic styles
	* For custom/system variable areas
		* Although we may not know exact custom variable names, they will be used in this format: %%FIRST_NAME%% and %%EMAIL%%
			* Please make Silverpop aware of custom variables, locations, and for them to double-check naming
		* An example unstyled "This email was sent to:":
			* This email was sent to: <a name="_EMAIL_" href="mailto:%%EMAIL%%">%%EMAIL%%</a>
		* An example unstyled "Trouble reading this email?":
			* <a name="C2V" href="#SPCLICKTOVIEW" xt="SPCLICKTOVIEW">Trouble reading this email?</a>
		* An example  unstyled "Unsubscribe" link:
			* <a name="Unsubscribe" href="http://www.example.com/unsubscribe?stype=LISTNAME&gnum={GUID}&fullsite=true">Unsubscribe</a>

# Email Resources

## Email Markup Resources

* http://htmlemailboilerplate.com/ (https://github.com/seanpowell/Email-Boilerplate)
* Campaign Monitor
	* https://www.campaignmonitor.com/css/
	* http://www.campaignmonitor.com/resources/will-it-work/
	* http://www.campaignmonitor.com/guides/
	* http://www.campaignmonitor.com/templates/
	* Campaign Monitor is partnered with Litmus
		* https://www.campaignmonitor.com/integrations/litmus
* MailChimp
	* http://kb.mailchimp.com/article/how-to-code-html-emails/
	* http://mailchimp.com/resources/html-email-templates/
	* http://kb.mailchimp.com/article/top-html-email-coding-mistakes/
	* http://mailchimp.blogs.com/blog/2006/01/im_a_web_design.html
* http://www.sitepoint.com/code-html-email-newsletters/
* http://24ways.org/2009/rock-solid-html-emails
* http://emailframe.work/
* Gmail App on Android issues
	* https://www.campaignmonitor.com/forums/topic/7733/android-gmail-image-resizing-issues/
	* https://litmus.com/community/discussions/257-gmail-app-android-how-to-stop-text-from-auto-resizing

## Responsive Email Markup Resources

* https://www.campaignmonitor.com/dev-resources/guides/mobile/
* https://litmus.com/blog/the-how-to-guide-to-responsive-email-design-infographic

## CSS Inliners

* https://inliner.cm/
* http://templates.mailchimp.com/resources/inline-css/
* http://foundation.zurb.com/emails/inliner.html

## Markup Validators

* http://validator.w3.org/
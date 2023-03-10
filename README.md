# Show how to import and retrieve a contact with SendGrid's API

This is a small project to support an upcoming tutorial on the SendGrid blog, that shows how to import a contact into a SendGrid account, and to then retrieve that contact's details, after it's been successfully imported.

## Usage

To use the project, first clone it locally, change into the newly created project directory, and install PHP's dependencies, by running the following commands.

```bash
git clone git@github.com:settermjd/sendgrid-import-retrieve-with-php.git
cd sendgrid-import-retrieve-with-php
composer update
```

After Composer installs PHP's dependencies, it creates a new _.env_ file, where the application's environment variables are stored.
There's only one, `SENDGRID_API_KEY`. 
You need to set this to your SendGrid API key.
To create one, open https://app.sendgrid.com/settings/api_keys in your preferred browser, click **Create API Key**, and follow the prompts.
More information is available [in the documentation](https://docs.sendgrid.com/ui/account-and-settings/api-keys). 
A concise guide will be available in the tutorial, when it's available.

After setting your SendGrid API key, in the terminal, in the top-level directory of the project, run the following commands:

```bash
# Import a contact
php import-contact.php

# Retrieve the contact's details, if it has been successfully imported.
php retrieve-contact.php
```
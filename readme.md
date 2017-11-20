# Chatbot PHP
## Requirements

* .>= PHP 7
* Composer

## Supported messenger platform

* Facebook Messenger

## Covered

* Create a FB Messenger app
* Create a FB Page
* Setup the FBChatbot
* Create a webhook
* Connect the Facebook app to the Facebook page

## Installation

### Create a FB page

First login to Facebook and [create a Facebook page](https://www.facebook.com/pages/create). The page doesn't need to be 
public. Choose the settings that fits best your bot, but for testing it is not important.

### Create a FB Messenger app

Go to the [developer's app page](https://developers.facebook.com/apps/). Click "Add a New App" and
 fill the basic app fields.

![Image of Facebook app creation](https://github.com/macphilips/fbchatbot/blob/master/screenshoots/img1.png)

On the "App Dashboard" page click on Add Product. Now select `Messenger > setup` from the Product setup page. 

![Image of the app product setup](https://github.com/macphilips/fbchatbot/blob/master/screenshoots/img3.png)

Now we need to create a token to give our app access to our Facebook page. Select the created page, grant permissions and copy the generated token. We need that one later.

![Image of the token creation](http://screenshots.nomoreencore.com/chatbot_fb_app_create_page_token.png)

### Setup the Chatbot

Clone the repository and remove the existing git folder.
``` bash
git clone https://github.com/macphilips/fbchatbot.git fbchatbot
```

``` bash
cd chatbot
rm -rf .git
```

Now install the Composer dependencies:

``` bash
composer install
```

Chatbot works with an `.env` file (environment). All sensible data like keys are stored there.
 
Rename `.env.example` to `.env`.

``` bash
mv .env.example .env
```

Open `.env`.

First one is the `WEBHOOK_VERIFY_TOKEN`. Note the value, we will need it later. The second value is the `PAGE_ACCESS_TOKEN` which we already got from our messenger app. Fill it in here.

## Create a webhook for the messenger app

On our PHP application we need to have a webhook. This means a public URL that Facebook can talk to. Every time the user
 writes a message insi
 de the FB chat, FB will send it to this URL which is the entrance point to our PHP application. In this boilerplate it is the index.php file.

So we need a public URL to the index.php file and there are two options here for you.


Because facebook messenger webhook needs a public URL to send webhook events to, push the code onto a public server or you need to setup a public url for your local server.

### Make it live

If you got a server you can push your code there where you have public access to it. The URL then maybe looks like `https://yourserver.com/fbchatbot/` which point to the index.php.

### Do it locally

There are multiple services out there that generate a public URL to your local server. Checkout out [ngrok](https://www.sitepoint.com/use-ngrok-test-local-site/) 

It doesn't matter how you do it, but you just need a public secured URL to the `index.php` file. (https!). 

### Connect the Facebook app to your application

Now that we got the URL we need to setup the webhook. Go back to you Facebook app settings and click `Setup Webhooks` 
inside the Webhooks part.

![Image of Facebook app webhook setup](http://screenshots.nomoreencore.com/chatbot_fb_app_setup_webhook.png)

Fill in in the public URL, the `WEBHOOK_VERIFY_TOKEN` from the `.env` file, check all the subscription fields and click 
`Verify and Save`.

![Image of Facebook app webhook infos](http://screenshots.nomoreencore.com/chatbot_fb_app_setup_webhook_info.png)

If you did everything right you have a working webhook now. If not you will see an error icon at the webhook URL field. This happens if the URL or the token is not correct.

### Connect the Facebook app to the Facebook page

Now the last step of the installation will make sure that our Facebook app is connected to the Facebook page. For this purpose there is a dropdown within your `Webhooks` setting page. Choose you page here and click `Subscribe`. 

![Image of Facebook app webhook select page to subscribe to](http://screenshots.nomoreencore.com/chatbot_webhook_page_selection.png)

# Local Database of FBChatbot

Create database and database table for FBChatbot by running db.sql on you MySQL database.

Oopen `.env` file and filling `DSN` and your MySQL username and password. For example
```angular2html
DSN=mysql:dbname=<DATABASE_NAME>;host=127.0.0.1
DB_USERNAME=root
DB_PASSWORD=
```

# Usage

##Admin View 
Link to the admin url
``http://hostname:port/fbchatbot/home``

##REST API

To get list of Users
``http://hostname:port/fbchatbot/users/``

To get Message history 
``http://hostname:port/fbchatbot/user/<user_id>/messages``



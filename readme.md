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


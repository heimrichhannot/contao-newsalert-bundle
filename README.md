# Contao Newsalert Bundle
[![Latest Stable Version](https://poser.pugx.org/heimrichhannot/contao-newsalert-bundle/v/stable)](https://packagist.org/packages/heimrichhannot/contao-newsalert-bundle)
[![Total Downloads](https://poser.pugx.org/heimrichhannot/contao-newsalert-bundle/downloads)](https://packagist.org/packages/heimrichhannot/contao-newsalert-bundle)

A contao bundle, to let website visitor subscribe to a news topic.

The bundle comes with an interface to add custom news topic, for example categories, tags, authors.

## Features
* subscribe form module
* add custom topic sources
* send notifications to user subscribed to topics with notification center
* trigger send event via cronjob, poormancron or callback
* security features
    * captcha in form field
    * opt-in process after subscribe
    * token secured opt-out links
* dublicate entry check
    * when dublicate entry is not confirmed, resend activation link instead of showing error message
* archive informations about sent messages
* bundled topic source for news archives


## Requirements

* Contao 4.4
* PHP7
* [Contao Notification Center](https://github.com/terminal42/contao-notification_center)
* [Formhybrid](https://github.com/heimrichhannot/contao-formhybrid)

## Installation

Install via composer

```
composer require heimrichhannot/contao-newsalert-bundle
```

Afterwards call the Contao install procedure to update the database.

## Setup

* add topic sources
* set up notification center notifications
    * `hh_newsalert` for newsalert messages
    * `formhybrid-opt-in` for opt-in mails
* add frontend registration module and configure it
* activate newsalert in news archive you want newsalert for
* optional: setup cronjob

## Usage

The bundle adds a checkbox to news archive to activate (or deactivate) newsalert for archives. It also add a checkbox to the news articles form to set (or unset) an article sent (by setting unsent newsalert will be triggered again for said article).

The management of the receivers is placed within the news section (News -> Newsalert).
The overview about sent messages is fount withing the newsalert section (News -> Newsalert -> Sent Newsalerts)

## Developers

### Add topic source

To add a topic source, your topics class needs to implement the `NewsTopicInterface` and has to be registered as service with the `huh.newsalert.topic_source` tag.

### Notification center tokens
ContaoNewsalertBundle uses Notification Center for e-mail sending. Following tokens are added to `news_posted` type (in addition to the default ones): 

Tag                                   | Description
--------------------------------------|-----------
##huh_newsalert_topic_recipient##      | Emailaddress of the subscriber
##huh_newsalert_news_headline##        | Title of the news for which newsalert is triggered
##huh_newsalert_news_subheadline##     | SUbheadline of the news for which newsalert is triggered
##huh_newsalert_news_teaser##          | Teaser text of the news article
##huh_newsalert_news_content##         | Article content
##huh_newsalert_news_url##             | Relative url to the article
##huh_newsalert_recipient_topics##     | The intersection of news topics and subscribed topics of the receiver
##huh_newsalert_recipient_topic_count##| The the number of topics from ##hh_newsalert_recipient_topics##
##huh_newsalert_opt_out_html##         | A list of all recipients topics and the corresponding unsubscribe links in html format (Topic: Link)
##huh_newsalert_opt_out_text##         | Same list as above, but textonly
##huh_newsalert_year##                 | The current year
##huh_newsalert_root_url##             | Root url

### Hooks

Name                     | Arguments                                            | Expected return value | Description
-------------------------|------------------------------------------------------|-----------------------|------------
huh_newsalert_customToken |NewsModel $objArticle, array $arrTokens, DC_Table $dc | $arrTokens            | Hook to add custom tokens or manipulate existing ones. Don't forget to register them via your config.php file.

### Frontend autocompletion
We recommend [Chosen](https://harvesthq.github.io/chosen/) to add a search field to the topic select element. It's already used by Contao in the backend.

### Commands

Name              | Options                              | Description 
------------------|--------------------------------------|-------------
huh:newsalert:send|--limit=0: Max number of news articles|Checks for unsend newsalert.

### Setup triggger

You have 3 options:

Option | Description
-------|------------
poorManCron|Poor man cron is the contao own cronjob system. You can choose the intervall in the module settings.
cronJob|You can setup your own cronjob. Just trigger the send command (see Commands)
onSubmit|Trigger newsalert for a news, which is saved. This is **not** recommend, because the onsubmit event is triggered before saving! So the article may not be finished when event is triggered!

## Todo
* use caching for speed improvements?
* serverside topic validation
* cleanup function
    * find duplicated
    * find non-available topics
* Module selection for newsalert onsubmit

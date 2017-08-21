# Contao Newsalert Bundle

A contao bundle, to let website visitor subscribe to a news topic.

The bundle comes with an interface to add custom news topic, for example categories, tags, authors.

## Features
* subscribe form module
* add custom topic sources
* send notifications to user subscribed to topics with notification center
* security features
    * captcha in form field
    * opt-in process after subscribe
    * token secured opt-out links
* dublicate entry check
    * when dublicate entry is not confirmed, resend activation link instead of showing error message
* archive informations about sent messages


## Requirements

* Contao 4.4
* PHP7
* [Contao Notification Center](https://github.com/terminal42/contao-notification_center)

## Installation

Install via composer

```
composer require heimrichhannot/contao-newsalert-bundle
```

Afterwards call the Contao install procedure to update the database.

## Setup

* set up notification center notification (`hh_newsalert`) for newsalert and opt-in mails.
* add frontend module and configure it

## Usage

The bundle adds two checkboxes to the news form (at the bottom). You can enable or disable sending a newsalert for each article and you can undo marking an article as already send (so it will be send again).

The management of the receivers is placed within the news section (News -> Newsalert).
The overview about sent messages is fount withing the newsalert section (News -> Newsalert -> )

## Developers

### Add topic source

To add a topic source, your topics class needs to implement the `NewsTopicInterface` and has to be registered as service with the `hh.newsalert.topic_source` tag.

### Notification center tokens
ContaoNewsalertBundle uses Notification Center for e-mail sending. Following tokens are added to `news_posted` type (in addition to the default ones): 

|Tag                              |Description|
|---------------------------------|-----------|
|##hh_newsalert_topic_recipient## |E-Mailadress of the subscriber|
|##hh_newsalert_news_title##      |Title of the news for which newsalert is triggered|
|##hh_newsalert_recipient_topics##|The intersection of news topics and subscribed topics of the receiver|
|##hh_newsalert_opt_out_html##    |A list of topics (same as above) and the corresponding unsubscribe links in html format (Topic: Link)|
|##hh_newsalert_opt_out_text      |Same list as above, but textonly| 

### Frontend autocompletion
We recommend [Chosen](https://harvesthq.github.io/chosen/) to add a search field to the topic select element. It's already used by Contao in the backend.

## Todo
<<<<<<< Updated upstream

* bundled topic source?
* translation (currently only german)
* evaluate the best callback for calling the listener
* use caching for speed improvement?
=======
* evaluate the best callback for calling the listener (currently called by onsubmit_callback)
* use caching for speed improvements?
* serverside validation
* cleanup function
    * find duplicated
    * find non-available topics
* Module selection for newsalert onsubmit
>>>>>>> Stashed changes

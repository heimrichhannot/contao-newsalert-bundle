# Contao Newsalert Bundle

> Bundle is in active development and not ready yet!

A contao bundle, to let website visitor subscribe to a news topic.

The bundle comes with an interface to add custom news topic, for example categories, tags, authors.

## Requirements

* Contao 4.4
* PHP7
* [Contao Notification Center](https://github.com/terminal42/contao-notification_center)

## Installation

Install via composer

```
composer require heimrichhannot/contao-newsalert-bundle
```

## Usage

The bundle adds two checkboxes to the news form (at the bottom). You can enable or disable sending a newsalert for each article and you can undo marking an article as already send (so it will send again).

## Developers

### Add topic source

To add a topic source, your topics class needs to implement the `NewsTopicInterface` and has to be registered as service with the `hh.newsalert.topic_source` tag.

## Todo

* Let users register to topic
* Autocomple form element with availiable topics
* set article as already send
* bundled topic source?
* translation (currently only german)
* evaluate the best callback for calling the listener
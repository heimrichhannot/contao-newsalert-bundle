# Changelog

## [5.0.0-dev] - 2018-02-28

#### TODO
* rename `hh.newsalert.topic_source` tag to `huh.newsalert.topic_source`
* remove deprecated services
* rename translation strings
* move config from module to custom config
* remove onSubmit callback

## [4.1.0-dev] - 2018-02-28

#### Added
* `huh_newsalert_news_enclosure_html` and `huh_newsalert_news_enclosure_text` notification center tokens

#### Changed
* renamed service `hh.contao-newsalert.listener.newspostedlistener` to `huh.newsalert.listener.newsposted`. Old service name kept as alias and marked deprecated.
* renamed service `hh.contao-newsalert.newstopiccollection` to `huh.newsalert.topiccollection`. Old service name kept as alias and marked deprecated.
* moved modules to own modules group
* marked onsubmit callback deprecated
* add newsalert subscribers from the backend

#### Fixed
* translations
* contao cronjob config
* doublicate newsalert log

## [4.0.0] - 2018-02-06

#### Changed
* `heimrichhannot/contao-formhybrid` 3.x dependency
* licence `LGPL-3.0+`to `LGPL-3.0-or-later`

## [3.1-dev] - 2018-01-12

#### Changed
* more decoubling
* added more unit tests
* updated min requirements to php 7.1
* added contao test case dependency

## [3.0.6] - 2018-01-04

#### Fixed
* composer error

## [3.0.5] - 2018-01-04

### Fixed
* base url generation
* news url generation

### Changed 
* moved module search in command to own method to decouble code

## [3.0.4] - 2017-11-23

### Fixed
* called unexisting database row in NewsModel

## [3.0.3] - 2017-11-23

### Changed
* updated readme

## [3.0.2] - 2017-09-13

### Fix
* use correct model and model function

## [3.0.1] - 2017-09-13

### Fix
* forget renaming nc tokens in config.php

## [3.0.0] - 2017-09-13

### Changed
* moved activate newsalert from news to archive
* renamed command and tokens to the new prefix

### Added 
* option to limit number of news (Console command)
* option to select newsalert module in news archive
* huh_newsalert_news_subheadline token
* color to console output

You need to call the contao install tools due database changes!

## [2.0.6] - 2017-09-05

### Fixed
* NewsModel

## [2.0.5] - 2017-09-04

### Fixed
* missing german author translation
* visible button to add news entries to newsalert_sent (results in also removing backlink due contao core bug (already reported as [issue](https://github.com/contao/core-bundle/issues/1035)))


## [2.0.4] - 2017-08-24

### Fixed
* token hh_newsalert_news_content working again

## [2.0.3] - 2017-08-24

### Fixed
* news article url generation

### Changed
* renamed tl_news row newsalert_send to newsalert_sent (including corresponding language strings)

## [2.0.2] - 2017-08-22

### Fixed
* composer.json formhybrid dependency from dev-master to 2.9

## [2.0.1] - 2017-08-22

###Added
* multiple language strings
* complete english translation

## [2.0.0] - 2017-08-22

### Added
* `hh:newsalert:send` console command to check for unsend news alerts
* newsalert trigger select in module
* added sendtype and poormanhookIntervall to tl_module (**update database needed**)
* redirect after opt in and opt out
* module for redirect page

### Changed
* set tl_news sql default newsalert_sent value to 1 (to avoid all send newsalert for all existing news)
* set dca default value for newsalert_sent to 0 (to send newsalert for new news entries)
* removed $dc from Hook (**api change!**)
* onSubmitEvent only triggered if onSubmit is selected as newsalertSendType (**breaking change**)

## [1.1.0] - 2017-08-18

### Added 
* hh_newsalert_customToken Hook to manipulte notification center tokens
* new notification center tokens

### Changed
* unsubscribe link list contains now all subscribed topics
* content token don't include teaser anymore

### Fixed
* dateAdded not set

## [1.0.3] - 2017-08-16

### Added
* nc tokens now added to file name and file content
* translation for notification center types

### Fixed
* recipient topics token array instead of string

## [1.0.2] - 2017-08-16

### Added 
* bundles topic source for news archive

### Changed
* removed unused service
* fixed NewsTopicSourceInterface file name not resampled class name (renamed file)

## [1.0.1] - 2017-08-16

### Added
* english translation
* updated readme

## [1.0.0] - 2017-08-15

### Added
* log sent mails to tl_newsalert_sent
    * new backend module listing sent alerts
* topic options callback
* check if dublicate entry
* set article sent

### Changed
* newstopics now sorted alphabetical
* renamed namespace Listener to EventListener

## [0.4.0] - 2017-08-14

### Added
* opt-out handling

## [0.3.0] - 2017-08-11

### Added
* Captcha

## [0.2.0] - 2017-08-11

### Added
* Recipients table (dca)
* Backend module for recipients (placed as global operation under news)
* Frontend form module
* opt in handling

### Fixed
* content element illegal offset

## [0.1.0] - 2017-08-04

### Added
* NewsTopicCollection Service
* Interface for NewsTopicSources
* NewsPostedListener
* Notification Center Notification Type
* NewsAlertPass to find tagged services

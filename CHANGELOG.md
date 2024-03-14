# Changelog

## [4.5.1] - 2024-03-14
- Fixed: some checkbox types where not char (run migration after update!)

## [4.5.0] - 2024-03-01
- Added: autoconfiguration support for topic sources
- Added: topic source selection to frontend module (migrated from newsalert module)
- Added: disable topic selection to frontend module (migrated from newsalert module)
- Added: github configuration
- Added: license file
- Changed: require at least php 8
- Changed: require at least contao 4.13
- Changed: partly refactoring
- Changed: adjust newsalert sent field database type (**run migration after update!**)
- Deprecated: class NewsTopicChoice
- Removed: outdated test setup

## [4.4.2] - 2024-01-30
- Fixed: PHP8 warning

## [4.4.1] - 2022-10-13
- Changed: allow php 8
- Fixed: non public services

## [4.4.0] - 2021-10-01
- allow higher notification center versions ([#3])

## [4.3.4] - 2021-03-18
- fixed missing placeholder in deprecation message

## [4.3.3] - 2021-02-09
- fixed topics with space lead to error in frontend

## [4.3.2] - 2019-03-28

#### Fixed
* `heimrichhannot/contao-formhybrid` 3.2 compatibility fix 

## [4.3.1] - 2018-10-18

#### Fixed
* `NewsAlertSubscriptionForm::afterActivationCallback` to be conform to `HeimrichHannot\FormHybrid\Form::afterActivationCallback` 

## [4.3.0] - 2018-06-15

#### Changed
* Added `huh.newsalert.choice.newstopic` for better topic choice performance

## [4.2.0] - 2018-05-05

#### Changed
* refactored Modules backend class as service
* URL must be selected for Cronjob in Module
* updated style for command

#### Fixed
* backend error when no Newsaleret module exist
* no root url when send from cronjob
* backend description for cron
* no token if user created from backend

## [4.1.0] - 2018-02-28

#### Added
* `huh_newsalert_news_enclosure_html` and `huh_newsalert_news_enclosure_text` notification center tokens

#### Changed
* renamed service `hh.contao-newsalert.listener.newspostedlistener` to `huh.newsalert.listener.newsposted`. Old service name kept as alias and marked deprecated.
* renamed service `hh.contao-newsalert.newstopiccollection` to `huh.newsalert.topiccollection`. Old service name kept as alias and marked deprecated.
* moved modules to own modules group
* marked onsubmit callback deprecated
* add newsalert subscribers from the backend
* removed author from sent list

#### Fixed
* Newsalert Opt-In not correctly checked
* errors in german and english translations
* Contao Cronjob timing error
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

[#3]: https://github.com/heimrichhannot/contao-newsalert-bundle/pull/3

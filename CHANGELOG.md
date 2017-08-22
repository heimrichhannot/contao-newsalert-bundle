# Changelog

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
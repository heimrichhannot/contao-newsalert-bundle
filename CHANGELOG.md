# Changelog



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
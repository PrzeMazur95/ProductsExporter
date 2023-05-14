# ProductsExporter
Magento 2 module

# Installation Guide

## 1. Clone repository to app/code/YellowCard folder.


## 2. You have to create in your /pub path new folder named : 

 ### "exportedProducts"

![img.png](docs/img/img.png)

#### in this folder will be stored all exported files with purchased products.

 ## 3. Turn on the module, generate classes, upgrade database, and clear the cache
  * bin/magento module:enable YellowCard_ProductsExporter
  * bin/magento setup:di:compile
  * bin/magento setup:upgrade
  * bin/magento cache:clear


 # Configuration Guide
 ### Go to stores -> configuration -> Yellowcard -> Products Exporter
 ![img.png](docs/img/configuration.png)
 ## We have 5 sections : 
 #### - Enable Products Exporter  
 basically for turn on/off extension
 #### - Status 
 Here we have all available statuses in Magento system. we need to select one, so that orders having this status will be processed
 #### - Cron schedule
 Here we can set the time, when the export will be manually triggered by the system. It is in cron format. To know how it works, please see https://crontab.guru/
 #### - Orders quantity 
 here we can set maximum quantity of orders that we want to process in export
 #### - Delete Export file 
 here we can set, if after download of exported csv, we want to delete this file on the server

 .
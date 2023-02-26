<?php

 declare(strict_types=1);

 namespace YellowCard\ProductsExporter\Enum;

 enum LoggerMessages: string
 {
     case DB_FAILED = 'Something went wrong when trying to interact with the database';
 }
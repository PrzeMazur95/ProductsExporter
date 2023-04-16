<?php

 declare(strict_types=1);

 namespace YellowCard\ProductsExporter\Enum;

 enum ReprocessEnum: string
 {
     case NAME = 'name';
     case ID = 'id';
     case REPROCESS = 'reprocess';
     case ORIGINAL_RAPORT_ID = 'raport_id';
 }
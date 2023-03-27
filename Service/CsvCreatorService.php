<?php

declare(strict_types=1);

namespace YellowCard\ProductsExporter\Service;

class CsvCreatorService
{
    const PATH = 'exportedProducts/';
    const FILE_NAME = 'Exported_Products';
    const EXTENSION = '.csv';

    const SKU = 'sku';
    const QTY = 'qty_ordered';
    const ORDER_ID = 'order_id';

    private array $csv_column_names = ['SKU', 'QUANTITY', 'ORDER_ID'];

    public function createCsvFromGivenExportedProducts(array $exportedProducts): void
    {

        $arrayOfProducts = $this->getFromArrayOfProductObjectsRequiredInformation($exportedProducts);

        $currentExportName = self::PATH.self::FILE_NAME.$this->setDateForCurrentExport().self::EXTENSION;

        $csvFile = fopen($currentExportName, 'w+');

        //Adds column names to be first row
        fputcsv($csvFile, $this->csv_column_names);

        foreach ($arrayOfProducts as $row)
        {
            fputcsv($csvFile, $row);
        }

        fclose($csvFile);
    }

    private function getFromArrayOfProductObjectsRequiredInformation(array $exportedProducts): array
    {
        $productsArray = [];

        foreach ($exportedProducts as $product) {
            foreach ($product as $item) {
                $productsArray[] = [
                    $item[self::SKU],
                    number_format((float)$item[self::QTY], 2),
                    $item[self::ORDER_ID]];
            }
        }

        return $productsArray;
    }

    private function setDateForCurrentExport(): string
    {
        return date('Y-m-d', time());
    }
}
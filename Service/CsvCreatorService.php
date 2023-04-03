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

     /**
     * Creates a csv file from provided purchased products from orders. Will be stored in above path.
     *
     * @param array $exportedProducts
     * @param bool|string  $reprocess
     *
     * @return void
     */
    public function createCsvFromGivenExportedProducts(array $exportedProducts, bool|string $reprocess = false): void
    {

        $arrayOfProducts = $this->getFromArrayOfProductObjectsRequiredInformation($exportedProducts);

        $currentExportName = $this->setNameForExportFile($reprocess);
        
        $csvFile = fopen($currentExportName, 'w+');

        //Adds column names to be first row
        fputcsv($csvFile, $this->csv_column_names);

        foreach ($arrayOfProducts as $row)
        {
            fputcsv($csvFile, $row);
        }

        fclose($csvFile);
    }

     /**
     * Return array which in rows contains information about purchased product - sku, qty, order id
     *
     * @param array $exportedProducts
     *
     * @return array
     */
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

     /**
     * Return readable current data string
     *
     * @return string
     */
    private function setDateForCurrentExport(): string
    {
        return date('Y-m-d-h-i', time());
    }

     /**
      * @param bool|string $reprocess
      *
      * @return string
      */
      private function setNameForExportFile(bool|string $reprocess): string
      {
          return ($reprocess === false) ?
              self::PATH.self::FILE_NAME.$this->setDateForCurrentExport().self::EXTENSION :
              self::PATH.$reprocess.'_'.self::FILE_NAME.$this->setDateForCurrentExport().self::EXTENSION;
      }
}
<?php

/**
 * Created by PhpStorm.
 * User: Craig
 * Date: 2/9/2017
 * Time: 1:02 PM
 */
class Highlights extends \Magento\ImportExport\Model\Import\Entity\AbstractEntity
{
    protected $_productRepository;
    protected function _importData()
    {
        while ($bunch = $this->_dataSourceModel->getNextBunch()) {
            foreach ($bunch as $rowNum => $rowData) {
                {
                    if (!isset($productData[$rowData[2]])) {
                        $productData[$rowData[2]] = array();
                    }
                    $productData[$rowData[2]][$rowData[3]] = $rowData[4];
                }
            }
        }
        $feats = array();
        foreach ($productData as $sku => $highlights)
            $prod = $this->_productRepository->get($sku);
        foreach ($highlights as $seq => $highlight) {
            $feats[$sku][] = $highlight;
        }
    }

    public function getEntityTypeCode()
    {
        return 'catalog_product';
    }

    public function validateRow(array $rowData, $rowNum)
    {
        return true;
    }
}
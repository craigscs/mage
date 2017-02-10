<?php

/**
 * Created by PhpStorm.
 * User: Craig
 * Date: 2/9/2017
 * Time: 1:02 PM
 */
class Features extends \Magento\ImportExport\Model\Import\Entity\AbstractEntity
{
    protected $_productRepository;
    protected function _importData()
    {
        while ($bunch = $this->_dataSourceModel->getNextBunch()) {
            foreach ($bunch as $rowNum => $rowData) {
                if (!isset($productData[$rowData[2]])) {
                    $productData[$rowData[2]] = array();
                }
                $productData[$rowData[2]][$rowData[3]] = array(
                    "label" => $rowData[4] ?: "",
                    "value" => $rowData[6]
                );
            }
        }
        $feats = array();
        foreach($productData as $sku => $features) {
            $prod = $this->_productRepository->get($sku);
            $feats[$sku][]['name'] = $features['label'];
            $feats[$sku][]['desc'] = $features['value'];
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
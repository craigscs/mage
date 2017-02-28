<?php
use Magento\Framework\App\Bootstrap;
require __DIR__ . '/../../app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);

$obj = $bootstrap->getObjectManager();
// Set the state (not sure if this is neccessary)
$state = $obj->get('Magento\Framework\App\State');
$state->setAreaCode('adminhtml');

$pr = $obj->create('Magento\Catalog\Model\ProductRepository');
$file = fopen('shell/import/overview.csv', 'r');
$c = 0;
while (($rowData = fgetcsv($file, 4096)) !== false)
{
    if ($c ==0) {
        $c++;
        continue;
    }
    {   if(!isset($productData[$row['2']]))
    {
        $productData[$row['2']] = array();
    }
        $productData[$row['2']] = array(
            'header' => array(
                (empty($row['7'] ? '' :'header_name' => $row[7],
                array(
                    "name" => $row['4'],
                    "desc" => $row['5']
                )
            )
        );
    }
}
fclose($file);
foreach ($productData as $sku => $value) {
    $p = $pr->get($sku);
    $product->setData("techspecs", json_encode($productData));
    echo "SKU ".$sku." saved.";
}
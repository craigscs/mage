<?php
namespace Ibnab\Tutie\Model\Import;

use Ibnab\Tutie\Model\Import\CustomerGroup\RowValidatorInterface as ValidatorInterface;
use Magento\ImportExport\Model\Import\ErrorProcessing\ProcessingErrorAggregatorInterface;
use Magento\Framework\App\ResourceConnection;

class CustomerGroup extends \Magento\ImportExport\Model\Import\Entity\AbstractEntity
{

    const TITLE = 'customer_group_code';
    const TAX = 'tax_class_id';

    const TABLE_Entity = 'customer_group';

    /**
     * Validation failure message template definitions
     *
     * @var array
     */
    protected $_messageTemplates = [
        ValidatorInterface::ERROR_TITLE_IS_EMPTY => 'TITLE is empty',
    ];

     protected $_permanentAttributes = [];
    /**
     * If we should check column names
     *
     * @var bool
     */
    protected $needColumnCheck = false;
    protected $groupFactory;
    /**
     * Valid column names
     *
     * @array
     */
    protected $validColumnNames = [
        'BRAND',
        'DNLA',
        'SKU_NO',
        'SEQNUM',
        'FEATURE_NAME',
        'FEATURE_DESCRIPTION',
        'FEATURES_RAW',
        'LINE_TYPE',
    ];

    /**
     * Need to log in import history
     *
     * @var bool
     */
    protected $logInHistory = true;

    protected $_validators = [];
    protected $productRepository;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_connection;
    protected $_resource;

    protected $log;
    /**
     * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
     */
    public function __construct(
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\ImportExport\Helper\Data $importExportData,
        \Magento\ImportExport\Model\ResourceModel\Import\Data $importData,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\ImportExport\Model\ResourceModel\Helper $resourceHelper,
        \Magento\Framework\Stdlib\StringUtils $string,
        ProcessingErrorAggregatorInterface $errorAggregator,
        \Magento\Customer\Model\GroupFactory $groupFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Catalog\Model\ProductRepository $pr
    ) {
        $this->jsonHelper = $jsonHelper;
        $this->_importExportData = $importExportData;
        $this->_resourceHelper = $resourceHelper;
        $this->_dataSourceModel = $importData;
        $this->_resource = $resource;
        $this->_connection = $resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);
        $this->errorAggregator = $errorAggregator;
        $this->groupFactory = $groupFactory;
        $this->productRepository = $pr;
    }
    public function getValidColumnNames()
    {
        return $this->validColumnNames;
    }

    /**
     * Entity type code getter.
     *
     * @return string
     */
    public function getEntityTypeCode()
    {
        return 'features';
    }

    /**
     * Row validation.
     *
     * @param array $rowData
     * @param int $rowNum
     * @return bool
     */
    public function validateRow(array $rowData, $rowNum)
    {
        return true;
    }


    /**
     * Create Advanced price data from raw data.
     *
     * @throws \Exception
     * @return bool Result of operation.
     */
    protected function _importData()
    {
        $this->saveEntity();
        return true;
    }
    /**
     * Save newsletter subscriber
     *
     * @return $this
     */
    public function saveEntity()
    {
        $this->saveAndReplaceEntity();
        return $this;
    }
    /**
     * Replace newsletter subscriber
     *
     * @return $this
     */
    public function replaceEntity()
    {
        $this->saveAndReplaceEntity();
        return $this;
    }
    /**
     * Deletes newsletter subscriber data from raw data.
     *
     * @return $this
     */
    public function deleteEntity()
    {
        return $this;
    }
 /**
     * Save and replace newsletter subscriber
     *
     * @return $this
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function saveAndReplaceEntity()
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
        return $this;
    }
    /**
     * Save product prices.
     *
     * @param array $priceData
     * @param string $table
     * @return $this
     */
    protected function saveEntityFinish(array $entityData, $table)
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
        return $this;
    }
    protected function deleteEntityFinish(array $listTitle, $table)
    {
        if ($table && $listTitle) {
                try {
                    $this->countItemsDeleted += $this->_connection->delete(
                        $this->_connection->getTableName($table),
                        $this->_connection->quoteInto('customer_group_code IN (?)', $listTitle)
                    );
                    return true;
                } catch (\Exception $e) {
                    return false;
                }

        } else {
            return false;
        }
    }
}

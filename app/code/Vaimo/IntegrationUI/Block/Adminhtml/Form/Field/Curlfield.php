<?php
/**
 * Copyright (c) 2009-2013 Vaimo AB
 *
 * Vaimo reserves all rights in the Program as delivered. The Program
 * or any portion thereof may not be reproduced in any form whatsoever without
 * the written consent of Vaimo, except as provided by licence. A licence
 * under Vaimo's rights in the Program may be available directly from
 * Vaimo.
 *
 * Disclaimer:
 * THIS NOTICE MAY NOT BE REMOVED FROM THE PROGRAM BY ANY USER THEREOF.
 * THE PROGRAM IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE PROGRAM OR THE USE OR OTHER DEALINGS
 * IN THE PROGRAM.
 *
 * @category    Vaimo
 * @package     Vaimo_IntegrationUI
 * @copyright   Copyright (c) 2009-2013 Vaimo AB
 * @author      Raivo Balins
 */

namespace Mageplaza\Helloworld\Block\Adminhtml\Form\Field;

class CurlField extends \Magento\Framework\View\Element\Html\Select
{
    public function setInputName($value)
    {
        return $this->setName($value);
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    public function _toHtml()
    {
        if (!$this->getOptions()) {
            $curlOptions = array(
                'CURLOPT_RETURNTRANSFER' => 'CURLOPT_RETURNTRANSFER',
                'CURLOPT_URL' => 'CURLOPT_URL',
                'CURLOPT_SSL_VERIFYPEER' => 'CURLOPT_SSL_VERIFYPEER',
                'CURLOPT_SSL_VERIFYHOST' => 'CURLOPT_SSL_VERIFYHOST',
                'CURLOPT_POST' => 'CURLOPT_POST',
                'CURLOPT_POSTFIELDS' => 'CURLOPT_POSTFIELDS',
                //*** If you add any new field here, please add it also in Model/Import.php
                //'CURLOPT_HTTPHEADER' => 'CURLOPT_HTTPHEADER', *** Header field is additional configuration
            );

            foreach ($curlOptions as $value => $label) {
                $options['cURL']['cURL.' . $value] = $label;
            }

            foreach ($options as $label => $values) {
                $this->addOption($values, $label);
            }
        }
        return parent::_toHtml();
    }
}

<?php
/**
<<<<<<< HEAD
 * Copyright © 2016 Magento. All rights reserved.
=======
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
>>>>>>> 229eaabfb4fced7adf5a1b09486de2a513239a60
 * See COPYING.txt for license details.
 */

/**
 * Create value-object \Magento\Framework\Phrase
 *
 * @return \Magento\Framework\Phrase
 */
function __()
{
    $argc = func_get_args();

    $text = array_shift($argc);
    if (!empty($argc) && is_array($argc[0])) {
        $argc = $argc[0];
    }

    return new \Magento\Framework\Phrase($text, $argc);
}

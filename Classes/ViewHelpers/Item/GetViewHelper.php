<?php

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * A View Helper which returns a "tag" of a SimplePie item.
 */
class Tx_RssDisplay_ViewHelpers_Item_GetViewHelper extends AbstractViewHelper
{

    /**
     * Retrieve the SimplePie item from the context and return its "tag".
     *
     * @param string $value
     * @return string
     */
    public function render($value)
    {

        /** @var SimplePie_Item $item */
        $item = $this->templateVariableContainer->get('item');
        $method = 'get_' . $value;
        return $item->$method();
    }
}

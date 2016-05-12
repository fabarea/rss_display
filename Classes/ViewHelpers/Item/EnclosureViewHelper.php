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
 * A View Helper which returns the enclosure of a SimplePie item.
 */
class Tx_RssDisplay_ViewHelpers_Item_EnclosureViewHelper extends AbstractViewHelper
{

    /**
     * Retrieve the SimplePie item from the context and return its enclosure data.
     *
     * @param string $attribute The attribute to retrieve. Must be either "url", "length" or "type".
     * @return null|string Returns null, if no enclosure can be found or the attribute data requested.
     */
    public function render($attribute)
    {
        if (!in_array($attribute, array('url', 'length', 'type'))) {
            $message = sprintf('Attribute "%s" is no valid enclosure attribute.', $attribute);
            throw new \Exception($message, 1463069269);
        }
        
        /** @var SimplePie_Item $item */
        $item = $this->templateVariableContainer->get('item');
        $data = null;
        
        if ($simplePieEnclosure = $item->get_enclosure()) {
            $enclosure = array(
                'url' => $simplePieEnclosure->get_link(),
                'length' => $simplePieEnclosure->get_length(),
                'type' => $simplePieEnclosure->get_type()
            );
            
            $data = $enclosure[$attribute];
        }

        return $data;
    }

}

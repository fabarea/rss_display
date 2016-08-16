<?php

/*
 * This file is part of the Fab/RssDisplay project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;


/**
 * A View Helper which returns a "tag" of a SimplePie item.
 */
class Tx_RssDisplay_ViewHelpers_Item_TagViewHelper extends AbstractViewHelper
{

    /**
     * Retrieve the SimplePie item from the context and return its "tag".
     * Example of namespace: http://purl.org/dc/elements/1.1/
     *
     * @param string $namespace
     * @param string $tag
     * @return string
     */
    public function render($namespace, $tag)
    {

        /** @var SimplePie_Item $item */
        $item = $this->templateVariableContainer->get('item');
        $values = $item->get_item_tags($namespace, $tag);

        $result = '';
        if (!empty($values)) {
            $result = $values[0]['data'];
        }

        return $result;
    }

}

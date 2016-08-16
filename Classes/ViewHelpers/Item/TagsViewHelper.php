<?php
namespace Fab\RssDisplay\ViewHelpers\Item;

/*
 * This file is part of the Fab/RssDisplay project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use SimplePie_Item;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * A View Helper which returns multiple "tags" of a SimplePie item.
 */
class TagsViewHelper extends AbstractViewHelper
{

    /**
     * Retrieve the SimplePie item from the context and return its "tags".
     * Example of namespace: http://purl.org/dc/elements/1.1/
     *
     * @param string $namespace
     * @param string $tag
     * @return array
     * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception\InvalidVariableException
     */
    public function render($namespace, $tag)
    {

        /** @var SimplePie_Item $item */
        $item = $this->templateVariableContainer->get('item');
        $values = $item->get_item_tags($namespace, $tag);

        $result = array();
        if (is_array($values)) {
            foreach ($values as $value) {
                $result[] = $value['data'];
            }
        }

        return $result;
    }

}

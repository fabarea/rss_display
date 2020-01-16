<?php
namespace Fab\RssDisplay\ViewHelpers\Item;

/*
 * This file is part of the Fab/RssDisplay project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use SimplePie_Item;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * A View Helper which returns the "link" of a SimplePie item.
 */
class LinkViewHelper extends AbstractViewHelper
{

    /**
     * Retrieve the SimplePie item from the context and return its "link".
     *
     * @return string
     * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception\InvalidVariableException
     */
    public function render()
    {

        /** @var SimplePie_Item $item */
        $item = $this->templateVariableContainer->get('item');
        return $item->get_link();
    }

}

<?php

/*
 * This file is part of the Fab/RssDisplay project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * A View Helper which returns the "title" of a SimplePie item.
 */
class Tx_RssDisplay_ViewHelpers_Item_TitleViewHelper extends AbstractViewHelper
{

    /**
     * Retrieve the SimplePie item from the context and return its "title".
     *
     * @return string
     */
    public function render()
    {

        /** @var SimplePie_Item $item */
        $item = $this->templateVariableContainer->get('item');
        return $item->get_title();
    }

}

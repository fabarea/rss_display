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
 * A View Helper which returns a "tag" of a SimplePie item.
 */
class GetViewHelper extends AbstractViewHelper
{

    /**
     * @return void
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('value', 'string', 'Name of value to return', true);
    }

    /**
     * Retrieve the SimplePie item from the context and return its "tag".
     *
     * @return string
     * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception\InvalidVariableException
     */
    public function render()
    {
        $value = $this->arguments['value'];

        /** @var SimplePie_Item $item */
        $item = $this->templateVariableContainer->get('item');
        $method = 'get_' . $value;
        return $item->$method();
    }
}

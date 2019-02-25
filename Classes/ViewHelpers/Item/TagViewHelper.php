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
 * A View Helper which returns a "tag" of a SimplePie item.
 */
class TagViewHelper extends AbstractViewHelper
{

    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('namespace', 'string', 'RSS element namespace', true);
        $this->registerArgument('tag', 'string', 'RSS element name', true);
    }

    /**
     * Retrieve the SimplePie item from the context and return its "tag".
     * Example of namespace: http://purl.org/dc/elements/1.1/
     *
     * @param string $namespace
     * @param string $tag
     * @return string
     * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception\InvalidVariableException
     */
    public function render()
    {

        /** @var SimplePie_Item $item */
        $item = $this->templateVariableContainer->get('item');
        $values = $item->get_item_tags($this->arguments['namespace'], $this->arguments['tag']);

        $result = '';
        if (is_array($values)) {
            $result = $values[0]['data'];
        }

        return $result;
    }

}

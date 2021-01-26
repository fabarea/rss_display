<?php
namespace Fab\RssDisplay\ViewHelpers\Item;

/*
 * This file is part of the Fab/RssDisplay project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * A View Helper which returns the enclosure of a SimplePie item.
 */
class EnclosureViewHelper extends AbstractViewHelper
{

    public function initializeArguments()
    {
        $this->registerArgument('attribute', 'string', 'The attribute to be obtained', true, 'url');
        $this->registerArgument('key', 'int', 'The enclosure item key. Starts with 0.', false, 0);
    }

    public function render() {
        $attribute = $this->arguments['attribute'];
        if (!in_array($attribute, ['url', 'length', 'type'], true)) {
            $message = sprintf('Attribute "%s" is no valid enclosure attribute.', $attribute);
            throw new \InvalidArgumentException($message, 1500032671);
        }
        /** @var SimplePie_Item $item */
        $item = $this->templateVariableContainer->get('item');
        /** @var SimplePie_Enclosure $enclosure */
        $enclosure = $item->get_enclosure($this->arguments['key']);
        if ($enclosure) {
            switch ($this->arguments['attribute']) {
                case 'url':
                    return $enclosure->get_link();
                case 'length':
                    return $enclosure->get_length();
                case 'type':
                    return $enclosure->get_type();
                default:
                    return '';
            }
        }
        return '';
    }
}

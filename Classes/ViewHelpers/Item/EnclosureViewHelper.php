<?php
namespace Fab\RssDisplay\ViewHelpers\Item;

/*
 * This file is part of the Fab/RssDisplay project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * A View Helper which returns the enclosure of a SimplePie item.
 */
class EnclosureViewHelper extends AbstractViewHelper
{
    /**
     * Retrieve the SimplePie item from the context and return its enclosure data.
     *
     * @param string $attribute The attribute to retrieve. Must be either "url", "length" or "type".
     * @param int $key The enclosure that you want to return. Remember that arrays begin with 0, not 1.
     * @return null|string Returns null, if no enclosure can be found or the attribute data requested.
     * @throws \InvalidArgumentException
     */
    public function render($attribute, $key = 0)
    {
        if (!in_array($attribute, ['url', 'length', 'type'], true)) {
            $message = sprintf('Attribute "%s" is no valid enclosure attribute.', $attribute);
            throw new \InvalidArgumentException($message, 1500032671);
        }

        /** @var SimplePie_Item $item */
        $item = $this->templateVariableContainer->get('item');
        /** @var SimplePie_Enclosure $enclosure */
        $enclosure = $item->get_enclosure($key);

        if ($enclosure) {
            switch ($attribute) {
                case 'url':
                    return $enclosure->get_link();
                case 'length':
                    return $enclosure->get_length();
                case 'type':
                    return $enclosure->get_type();
                default:
                    return null;
            }
        }

        return null;
    }
}

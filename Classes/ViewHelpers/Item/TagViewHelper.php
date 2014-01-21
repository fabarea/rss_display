<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Fabien Udriot <fabien.udriot@ecodev.ch>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * A View Helper which returns a "tag" of a SimplePie item.
 */
class Tx_RssDisplay_ViewHelpers_Item_TagViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * Retrieve the SimplePie item from the context and return its "tag".
	 * Example of namespace: http://purl.org/dc/elements/1.1/
	 *
	 * @param string $namespace
	 * @param string $tag
	 * @return string
	 */
	public function render($namespace, $tag) {

		/** @var SimplePie_Item $item */
		$item = $this->templateVariableContainer->get('item');
		return $item->get_item_tags($namespace, $tag);
	}
}

?>
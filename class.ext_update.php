<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Fabien Udriot <fabien.udriot@ecodev.ch>
 *
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
 * ************************************************************* */

/**
 * Updater Script for rss_display
 */
class ext_update {

	public function access() {
		return TRUE;
	}

	public function main() {
		$output[] = $this->updateNewIdentity();

		return sprintf('<ul><li>%s</li></ul>', implode('</li><li>', $output));
	}

	/**
	 * Update new identity.
	 *
	 * @return string
	 */
	public function updateNewIdentity() {

		$condition = "list_type='rss_display_pi1'";
		$rows = $this->getDatabaseConnection()->exec_SELECTgetRows('*', 'tt_content', $condition);
		foreach ($rows as $row) {

			$flexForm = sprintf('<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="sDEF">
            <language index="lDEF">
                <field index="settings.feedUrl">
                    <value index="vDEF">%s</value>
                </field>
                <field index="settings.numberOfItems">
                    <value index="vDEF">%s</value>
                </field>
                <field index="settings.template">
                    <value index="vDEF">%s</value>
                </field>
                <field index="settings.descriptionLength">
                    <value index="vDEF">%s</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>',
				$row['tx_rssdisplay_feed'],
				$row['tx_rssdisplay_quantity'],
				$row['tx_rssdisplay_descriptiondisplay'] == 1 ? 'EXT:rss_display/Resources/Private/Templates/Feed/Show.html' : 'EXT:rss_display/Resources/Private/Templates/Feed/ShowWithoutDescription.html',
				$row['tx_rssdisplay_descriptionlength']
			);

			$values = array(
				'list_type' => 'rssdisplay_pi1',
				'pi_flexform' => $flexForm,
			);

			$this->getDatabaseConnection()->exec_UPDATEquery('tt_content', 'uid=' . intval($row['uid']), $values);
		}

		$result = '<strong>Update plugin signature "rssdisplay_pi1"</strong><br/>';
		$result .= count($rows) . ' row(s) have been updated';
		return $result;
	}

	/**
	 * Return a pointer to the database.
	 *
	 * @return t3lib_DB
	 */
	protected function getDatabaseConnection() {
		return $GLOBALS['TYPO3_DB'];
	}
}

<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package Banner_statistic_export
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'BugBuster',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Export
	'BannerStatExportcsv'                          => 'system/modules/banner_statistic_export/export/BannerStatExportcsv.php',
	'BannerStatExportexcel95'                      => 'system/modules/banner_statistic_export/export/BannerStatExportexcel95.php',
	'BannerStatExport'                             => 'system/modules/banner_statistic_export/export/BannerStatExport.php',

	// Classes
	'BugBuster\Banner\Stat\Export\BannerStatPanel' => 'system/modules/banner_statistic_export/classes/BannerStatPanel.php',
));

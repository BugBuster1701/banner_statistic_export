<?php 
/**
 * Contao Open Source CMS, Copyright (C) 2005-2014 Leo Feyer
 * 
 * Modul Banner Statistic Export Config - Backend
 *
 *
 * @copyright	Glen Langer 2014 <http://www.contao.glen-langer.de>
 * @author      Glen Langer (BugBuster)
 * @package     BannerStatisticExport 
 * @license     LGPL 
 * @filesource
 */

define('BANNER_STAT_EXPORT_VERSION', '1.0');
define('BANNER_STAT_EXPORT_BUILD'  , '0');

/**
 * -------------------------------------------------------------------------
 * BANNER HOOKS
 * -------------------------------------------------------------------------
 */
$GLOBALS['TL_BANNER_HOOKS']['addStatisticPanelLine'][] = array('Banner\Stat\Export\BannerStatPanel', 'getPanelLine');



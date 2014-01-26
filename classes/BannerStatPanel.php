<?php

/**
 * Contao Open Source CMS, Copyright (C) 2005-2014 Leo Feyer
 * 
 * Modul Banner Statistic Export - Panel Hook 
 * 
 * @copyright	Glen Langer 2014 <http://www.contao.glen-langer.de>
 * @author      Glen Langer (BugBuster)
 * @package     BannerStatisticExport 
 * @license     LGPL 
 * @filesource
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace BugBuster\Banner\Stat\Export; 

/**
 * Class BannerStatPanel
 *
 * @copyright  Glen Langer 2012
 * @author     Glen Langer
 * @package    Banner
 */
class BannerStatPanel extends \System
{
   /**
    * Current object instance
    * @var object
    */
    protected static $instance = null;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        \System::loadLanguageFile('tl_banner_stat_export');
    }
    
    /**
     * Return the current object instance (Singleton)
     * @return BannerStatPanel
     */
    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new BannerStatPanel();
        }
    
        return self::$instance;
    }

    /**
     * Hook: addStatisticPanelLine 
     * 
     * @param insteger    Category ID
     * @return string
     */
    public function getPanelLine($intCatID)
    {
        if ($intCatID > 0  || $intCatID == -1)
        {
            return sprintf('
<div class="tl_panel">
    <div class="tl_subpanel">
        <strong>%s %s:</strong>
        <a class="button tl_submit" style="padding: 2px 12px 2px 13px;" target="_new" title="%s CSV ,   " href="system/modules/banner_statistic_export/export/BannerStatExport.php?tl_field=csvc&amp;tl_katid='.$intCatID.'">CSV ,</a>
        <a class="button tl_submit" style="padding: 2px 12px 2px 13px;" target="_new" title="%s CSV ;   " href="system/modules/banner_statistic_export/export/BannerStatExport.php?tl_field=csvs&amp;tl_katid='.$intCatID.'">CSV ;</a>
        <a class="button tl_submit" style="padding: 2px 12px 2px 13px;" target="_new" title="%s Excel ; " href="system/modules/banner_statistic_export/export/BannerStatExport.php?tl_field=excel&amp;tl_katid='.$intCatID.'">Excel</a>
    </div>
    <div class="clear"></div>
</div>
'           ,$GLOBALS['TL_LANG']['tl_banner_stat']['kat']
            ,$GLOBALS['TL_LANG']['tl_banner_stat_export']['export']
            ,$GLOBALS['TL_LANG']['tl_banner_stat_export']['export']
            ,$GLOBALS['TL_LANG']['tl_banner_stat_export']['export']
            ,$GLOBALS['TL_LANG']['tl_banner_stat_export']['export']
            );
        }
        return '';
    } // getPanelLine
    
} // class

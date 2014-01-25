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
     *
     * @return string
     */
    public function getPanelLine()
    {
        $strContent = '<div class="tl_panel">Hallo Export</div>';

        return $strContent;
    } // getPanelLine
    
} // class

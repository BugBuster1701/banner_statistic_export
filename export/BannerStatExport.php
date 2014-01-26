<?php
/**
 * Contao Open Source CMS, Copyright (C) 2005-2014 Leo Feyer
 * 
 * Banner Statistik Export
 *
 * wird per export button direkt aufgerufen
 * 
 * @copyright	Glen Langer 2007..2014 <http://www.contao.glen-langer.de>
 * @author      Glen Langer (BugBuster)
 * @package     BannerStatisticExport 
 * @license     LGPL 
 * @filesource
 */

/**
 * Initialize the system
 */
define('TL_MODE', 'BE');
require('../../../initialize.php');

/**
 * Class BannerStatExport
 *
 * @copyright	Glen Langer 2007..2014 <http://www.contao.glen-langer.de>
 * @author      Glen Langer (BugBuster)
 * @package    BannerStatisticExport
 */
class BannerStatExport extends Backend 
{
    /**
	 * Export Type
	 */
	protected $strExportType ='';
	
	/**
	 * Export Delimiter
	 */
    protected $strExportDelimiter ='';
    
    /**
	 * Set the current file
	 */
	public function __construct()
	{
		$this->import('BackendUser', 'User');
		parent::__construct(); 
		$this->User->authenticate(); 
	    System::loadLanguageFile('default');
		System::loadLanguageFile('modules');
		System::loadLanguageFile('tl_banner_stat'); 
		System::loadLanguageFile('tl_banner_stat_export');
	}
	
    // Die parametrisierte Factorymethode
    public function factory($type)
    {
        $classname = 'BannerStatExport' . $type;
        return new $classname;
    }

    public function run()
	{
   	    if ( (!Input::get('tl_field',true)=='csvc') && 
   	         (!Input::get('tl_field',true)=='csvs') && 
   	         (!Input::get('tl_field',true)=='excel') 
   	       ) 
   	    {
   	        echo "<html><body>Missing Parameter(s)!</body></html>";
            return ;
	    }
	    if ((int)Input::get('tl_katid',true) < -1 || (int)Input::get('tl_katid',true) == 0) 
	    {
	    	echo "<html><body>Wrong Parameter(s)!</body></html>";
            return ;
	    }
	    $intBannerKatId = (int)Input::get('tl_katid',true);
	    switch (Input::get('tl_field',true)) 
	    {
	    	case "csvc":
                $this->strExportType = 'csv';
	    	    $this->strExportDelimiter = ',';
	    		break;
	    	case "csvs":
                $this->strExportType = 'csv';
	    	    $this->strExportDelimiter = ';';
	    		break;
	    	case "excel":
                $this->strExportType = 'excel95';
	    	    $this->strExportDelimiter = ',';
	    		break;
	    	default:
	    		break;
	    }
	    $objExport = BannerStatExport::factory($this->strExportType);
	    if ($objExport===false) 
	    {
            echo "<html><body>Driver ".$this->strExportType." not found!</body></html>";
	    	return ;
	    }
	    if ($intBannerKatId == -1) 
	    {
	   	    $objBanners = Database::getInstance()
	   	                    ->prepare("SELECT 
	   	                                    tbc.title
	   	                                  , tb.id
	   	                                  , tb.banner_type
	   	                                  , tb.banner_name
	   	                                  , tb.banner_url
	   	                                  , tb.banner_image
	   	                                  , tb.banner_image_extern
	   	                                  , tb.banner_weighting
	   	                                  , tb.banner_start
	   	                                  , tb.banner_stop
	   	                                  , tb.banner_published
	   	                                  , tbs.banner_views
	   	                                  , tbs.banner_clicks
	   	                                FROM 
	   	                                    tl_banner AS tb
	   	                                LEFT JOIN 
	   	                                    tl_banner_stat AS tbs ON (tbs.id=tb.id)
	   	                                LEFT JOIN 
	   	                                    tl_banner_category AS tbc ON (tbc.id=tb.pid)
	   	                                ORDER BY 
	   	                                    tbc.id
	   	                                  , tbc.title
	   	                                  , tb.id"
	   	                            )
                            ->execute();
	    } 
	    else 
	    {
	   	    $objBanners = Database::getInstance()
	   	                    ->prepare("SELECT 
                                            tbc.title
	   	                                  , tb.id
	   	                                  , tb.banner_type
	   	                                  , tb.banner_name
	   	                                  , tb.banner_url
	   	                                  , tb.banner_image
	   	                                  , tb.banner_image_extern
	   	                                  , tb.banner_weighting
	   	                                  , tb.banner_start
	   	                                  , tb.banner_stop
	   	                                  , tb.banner_published
	   	                                  , tbs.banner_views
	   	                                  , tbs.banner_clicks
	   	                                FROM 
	   	                                    tl_banner AS tb
	   	                                LEFT JOIN 
	   	                                    tl_banner_stat AS tbs ON (tbs.id=tb.id)
	   	                                LEFT JOIN 
	   	                                    tl_banner_category AS tbc ON (tbc.id=tb.pid)
	   	                                WHERE 
	   	                                    tbc.id =?
	   	                                ORDER BY 
	   	                                    tbc.title, tb.id"
	   	                            )
                            ->execute($intBannerKatId);
	    }
	    $objExport->export($objBanners,$this->strExportDelimiter,$intBannerKatId);
	}
}

/**
 * Instantiate
 */
$objBannerStatExport = new BannerStatExport();
$objBannerStatExport->run();

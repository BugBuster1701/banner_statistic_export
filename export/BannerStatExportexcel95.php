<?php
use Contao\Idna;

/**
 * Contao Open Source CMS, Copyright (C) 2005-2014 Leo Feyer
 * 
 * Banner Statistik Export - Excel Variante
 * 
 * 
 * @copyright	Glen Langer 2007..2014 <http://www.contao.glen-langer.de>
 * @author      Glen Langer (BugBuster)
 * @package     BannerStatisticExport 
 * @license     LGPL 
 * @filesource
 */


/**
 * Class BannerStatExportexcel
 *
 * @copyright	Glen Langer 2007..2014 <http://www.contao.glen-langer.de>
 * @author      Glen Langer (BugBuster)
 * @package     BannerStatisticExport 
 */
class BannerStatExportexcel95
{
    protected $BannerExportLib = 'excel95';
    protected $BrowserAgent ='NOIE';
    
    /**
	 * Constructor
	 */
	public function __construct()
	{
	    //IE or other?
	    $ua = Environment::get('agent')->shorty;
	    if ($ua == 'ie')
	    {
	        $this->BrowserAgent = 'IE';
	    }
	}
	
    public function getLibName() 
    {
        return $this->BannerExportLib;
    }
    
    public function export($objBanners,$csv_delimiter,$intBannerKatId) 
    {
        // Download
        if ($intBannerKatId == -1) 
        {
        	$intBannerKatId = 'all';
        }
        if (file_exists(TL_ROOT . "/system/modules/xls_export/vendor/xls_export.php")) 
    	{
	    	include(TL_ROOT . "/system/modules/xls_export/vendor/xls_export.php");
			$xls = new xlsexport();
			$sheet = 'BannerStatExport-'.$intBannerKatId.'';
			$xls->addworksheet($sheet);
			//Kopfdaten
	        $arrBannersStatHeader = explode(",",html_entity_decode($GLOBALS['TL_LANG']['tl_banner_stat_export']['export_headline'],ENT_NOQUOTES,'UTF-8'));
	        
	        $intRowCounter = 1;
			for ($c = 1; $c <= 11; $c++)
			{
				$xls->setcolwidth ($sheet,$c-1,0x1000);
				$xls->setcell(array("sheetname" => $sheet,"row" => 0, "col" => $c-1, 'fontweight' => XLSFONT_BOLD, 'hallign' => XLSXF_HALLIGN_CENTER, "data" => utf8_decode($arrBannersStatHeader[$c-1])));
			}
			
			while ($objBanners->next())
	        {
	        	if ($objBanners->banner_type == 'banner_image')
	        	{
	        	    $objFile = FilesModel::findByPk($objBanners->banner_image);
	        	    $objBanners->banner_image = $objFile->path;
	        	}
	        	else
	        	{
	        	    $objBanners->banner_image = Idna::decode($objBanners->banner_image_extern); // #7
	        	}
	        	$arrBannersStat[0] = utf8_decode($objBanners->title);
	            $arrBannersStat[1] = $objBanners->id;
	    		$arrBannersStat[2] = utf8_decode($objBanners->banner_name);
	    		$arrBannersStat[3] = Idna::decode($objBanners->banner_url); // #7
	    		$arrBannersStat[4] = $objBanners->banner_image; // #7
	    		$arrBannersStat[5] = $objBanners->banner_weighting;
	    		$arrBannersStat[6] = $objBanners->banner_start=='' ? 'NULL' : date($GLOBALS['TL_CONFIG']['datimFormat'], $objBanners->banner_start);
	    		$arrBannersStat[7] = $objBanners->banner_stop==''  ? 'NULL' : date($GLOBALS['TL_CONFIG']['datimFormat'], $objBanners->banner_stop);
	    		$arrBannersStat[8] = $objBanners->banner_published=='' ? $GLOBALS['TL_LANG']['tl_banner_stat']['pub_no'] : $GLOBALS['TL_LANG']['tl_banner_stat']['pub_yes'];
	    		$arrBannersStat[9] = $objBanners->banner_views=='' ? '0' : $objBanners->banner_views;
	    		$arrBannersStat[10] = $objBanners->banner_clicks=='' ? '0' : $objBanners->banner_clicks;
	    		
	    		for ($c = 1; $c <= 11; $c++) 
	    		{
	    			if ($c==3 || $c==4 || $c==5) 
	    			{
	    				$xls->setcell(array("sheetname" => $sheet,"row" => $intRowCounter, "col" => $c-1, 'hallign' => XLSXF_HALLIGN_LEFT, "data" => $arrBannersStat[$c-1]));
	    			} 
	    			else 
	    			{
	        			$xls->setcell(array("sheetname" => $sheet,"row" => $intRowCounter, "col" => $c-1, 'hallign' => XLSXF_HALLIGN_CENTER, "data" => $arrBannersStat[$c-1]));
	    			}
	        	}
	        	$intRowCounter++;
	        } // while
	        $xls->sendFile($sheet . ".xls");
        } 
        else 
        {
			echo "<html><head><meta charset='utf-8'><title>Need extension xls_export</title></head><body>"
			    ."Please install the extension 'xls_export'.<br /><br />"
			    ."Bitte die Erweiterung 'xls_export' installieren.<br /><br />"
			    ."Installer l'extension 'xls_export' s'il vous plaît."
			    ."</body></html>";
		}
    } // function
}

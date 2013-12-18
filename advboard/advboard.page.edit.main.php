<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.edit.main
[END_COT_EXT]
==================== */
/**
 * Plugin AN Advertisement Board
 * @package Advertisement board plugin for Cotonti Siena
 * @author Alex - Studio Portal30
 * @copyright Portal30 2011-2012 http://portal30.ru
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('advboard', 'plug');
require_once cot_langfile('advboard');

if(ab_inBoardCat(ab_getCurrCategory())){


    if($usr['id'] == 0){
        // Права незарега на редактирование объявлений
        cot_block(!empty($_SESSION['advboard']) && in_array($id, $_SESSION['advboard']));
    }

    if ($pag['page_expire'] > 0){
        $diff = $pag['page_expire'] - $sys['now_offset'];
    }
    $expDays = (floor($diff/86400));
    $pItems = ab_periodItems();

    if (!in_array($expDays, $pItems) && $expDays > 0){
        $pItems[] = $expDays;
        if ($cfg['plugin']['advboard']['periodOrder'] == 'desc'){
            rsort($pItems);
        }else{
            sort($pItems);
        }
    }
    $expireAdv = false;
	if ($cfg['plugin']['advboard']['expNotifyPeriod'] > 0 && $pag['page_expire'] > 0){
		if ($diff < (86400 * $cfg['plugin']['advboard']['expNotifyPeriod']) && $diff > 0){
            if ($expDays >= 1) {
                $msg = sprintf($L['advboard']['exp_soon'], cot_declension($expDays, $Ls['Days'], false, true));
            }else{
                $msg = $L['advboard']['exp_today'];
            }
            $expireAdv = 'soon';
            cot_message($msg, 'warning', 'default');
		}elseif ($diff <= 0){
            $expireAdv = 'already';
            cot_message($L['advboard']['expired'], 'warning');
		}
	}
}
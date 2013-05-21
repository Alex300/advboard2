<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.tags
Order=8
[END_COT_EXT]
==================== */
/**
 * Plugin AN Advertisement Board
 * @package Advertisement board plugin for Cotonti Siena
 * @author Alex - Studio Portal30
 * @copyright Portal30 2011-2012 http://portal30.ru
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('advboard', 'plug');
require_once cot_langfile('advboard');

if (ab_inBoardCat($pag['page_cat'])){

    // Незарег не может смотреть чужие черновики
    if ($usr['id'] == 0){
        if (empty($_SESSION['advboard']) || !in_array($pag['page_id'], $_SESSION['advboard'])){
            if ($pag['page_state'] == 1 || ($pag['page_state'] == 2) || ($pag['page_begin'] > $sys['now'])
                || ($pag['page_expire'] > 0 && $sys['now'] > $pag['page_expire'])) {
                cot_log("Attempt to directly access an un-validated or future/expired page", 'sec');
                cot_die_message(403, TRUE);
            }
        }
        // Если незарег может редактировать объявление, не кешировать эту страницу
        if (!empty($_SESSION['advboard']) && in_array($pag['page_id'], $_SESSION['advboard'])){
            $cfg['cache_page'] = $cfg['cache_index'] = false;
        }
    }

    if ($pag['page_expire'] > 0){
        $diff = $pag['page_expire'] - $sys['now'];

        $expDays = (floor($diff/86400));

        if ( ($pag['page_ownerid'] == $usr['id']) || $usr['isadmin']){
            if ($cfg['plugin']['advboard']['expNotifyPeriod'] > 0){
                if ($diff < (86400 * $cfg['plugin']['advboard']['expNotifyPeriod']) && $diff > 0){
                    if ($expDays >= 1) {
                        cot_message(sprintf($L['advboard']['exp_soon'], $expDays), 'warning');
                    }else{
                        cot_message($L['advboard']['exp_today'], 'warning');
                    }
                }elseif ($diff <= 0){
                    cot_message($L['advboard']['expired'], 'warning');
                }
            }
        }
    }

	cot_display_messages($t);

}

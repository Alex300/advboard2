<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=pagetags.main
[END_COT_EXT]
==================== */
/**
 * Plugin Advertisement Board
 * @package Advertisement board plugin for Cotonti Siena
 * @author Alex - Studio Portal30
 * @copyright Portal30 2011-2012 http://portal30.ru
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('advboard', 'plug');
require_once cot_langfile('advboard');

if (ab_inBoardCat($page_data['page_cat'])){
    global $sys, $usr, $cfg;

    $adv_msg = '';

    if ($page_data['page_expire'] > 0){
        $diff = $page_data['page_expire'] - $sys['now'];
        if ( ($page_data['page_ownerid'] == $usr['id']) || $admin_rights){
            if ($cfg['plugin']['advboard']['expNotifyPeriod'] > 0){

                if ($diff < (86400 * $cfg['plugin']['advboard']['expNotifyPeriod']) && $diff > 0){
                    $adv_msg .= $L['advboard']['expiring'];
                }elseif ($diff <= 0){
                    $adv_msg .= $L['advboard']['expired'];
                }
            }
         }
    }
    $temp_array['ADV_STATUS_LOCAL'] = $adv_msg;

    // Незареги могут править объявы те которые добавили сами
    if ($usr['id'] == 0){
        if (empty($_SESSION['advboard']) || !in_array($page_data['page_id'], $_SESSION['advboard'])){
            if(isset($temp_array['ADMIN_EDIT'])) unset($temp_array['ADMIN_EDIT'], $temp_array['ADMIN_EDIT_URL']);
        }
    }

    // Автор объявления может его удалить
    if ($usr['id'] > 0 && $usr['id'] == $page_data['page_ownerid']){
        $delete_confirm_url = cot_confirm_url($delete_url, 'page', 'page_confirm_delete');

        $temp_array['ADMIN_DELETE'] = cot_rc_link($delete_confirm_url, $L['Delete'], 'class="confirmLink"');
        $temp_array['ADMIN_DELETE_URL'] = $delete_confirm_url;
    }
}
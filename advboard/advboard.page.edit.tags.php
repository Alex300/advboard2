<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.edit.tags
Tags=page.add.tpl:{PAGEADD_FORM_PERIOD},{PAGEADD_FORM_VERIFYIMG},{PAGEADD_FORM_VERIFYINPUT}
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

    if ($cfg['page']['autovalidate'] && cot_auth('page', $pag['page_cat'], '2')) $usr_can_publish = TRUE;

    $tmp = $expDays;
    if($tmp <= 0) $tmp = $cfg['plugin']['advboard']['maxPeriod'];

	$t->assign(array(
		"ADV_PAGEEDIT_FORM_DATE"	=> cot_date('datetime_text', $pag['page_date']) ." ".$usr['timetext'],
		"ADV_PAGEEDIT_FORM_BEGIN"   => cot_date('datetime_text', $pag['page_begin'] ) ." ".$usr['timetext'],
		"ADV_PAGEEDIT_FORM_EXPIRE"  => cot_date('datetime_text', $pag['page_expire'] ) ." ".
            $usr['timetext'],
		'PAGEEDIT_PAGETITLE' => $L['advboard']['edit_page'],
        'PAGEEDIT_FORM_PERIOD' => cot_selectbox($tmp, 'rperiod_exp', $pItems, array(), false),
        'PAGEEDIT_EXP_MSG' => ($expireAdv)
	));
    if ($expireAdv == 'soon'){
        $t->assign(array(
            'PAGEEDIT_EXP_MSG' => $L['advboard']['expiring']
        ));
    }elseif($expireAdv == 'already'){
        $t->assign(array(
            'PAGEEDIT_EXP_MSG' => $L['advboard']['expired']
        ));
    }

}
<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.add.tags
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

   if ($cfg['page']['autovalidate'] && cot_auth('page', $c, '2')) $usr_can_publish = TRUE;


	$t->assign(array(
			'PAGEADD_PAGETITLE' => $L['advboard']['add_new_adv'],
            'PAGEADD_FORM_PERIOD' => cot_selectbox('', 'rperiod_exp', ab_periodItems(), array(), false),
		));


	if ($usr['id'] < 1 && $cfg['plugin']['advboard']['gUseCaptcha'] == 1){
		$t->assign(array(
            "PAGEADD_FORM_VERIFYIMG" => cot_captcha_generate(),
            "PAGEADD_FORM_VERIFYINPUT" => cot_inputbox('text', 'rverify', '', 'size="10" maxlength="20"'),
		));
	}
}

<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.add.add.error
[END_COT_EXT]
==================== */
/**
 * Plugin AN Advertisement Board
 *    Checking Adv for errors
 * @package Advertisement board plugin for Cotonti Siena
 * @author Alex - Studio Portal30
 * @copyright Portal30 2011-2012 http://portal30.ru
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('advboard', 'plug');
require_once cot_langfile('advboard');

if (ab_inBoardCat(ab_getCurrCategory())){

    if ($usr['id'] < 1 && $cfg['plugin']['advboard']['gUseCaptcha'] == 1){
        $rverify  = cot_import('rverify','P','TXT');
        if (!cot_captcha_validate($rverify)){
            cot_error($L['captcha_verification_failed'], 'rverify');
        }
    }
    if ($usr['id'] < 1 && $cfg['plugin']['advboard']['guestEmailRequire'] == 1 ){
        $uMailExf = 'page_'.$cfg['plugin']['advboard']['gEmailExtraField'];

        if(empty($rpage[$uMailExf])) cot_error($L['advboard']['err_noemail'], $uMailExf );
        if (!ab_checkEmail($rpage[$uMailExf])){
            cot_error( $mlt["msg"], $uMailExf);
        }
    }
}
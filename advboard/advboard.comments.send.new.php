<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=comments.send.new
[END_COT_EXT]
==================== */
/**
 * Plugin AN Advertisement Board
 *      New comment notice
 * @package Advertisement board plugin for Cotonti Siena
 * @author Alex - Studio Portal30
 * @copyright Portal30 2011-2012 http://portal30.ru
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('advboard', 'plug');
require_once cot_langfile('advboard');

$adv_cat = '';
if ($comarray['com_area'] == 'page' ){
    if (!empty($url_params['c'])){
        $adv_cat = $url_params['c'];
    }elseif(!empty($cat)){
        $adv_cat = $cat;
    }else{
        // получить категорию по id страницы:
        //$comarray["com_code"]
    }
}

// Очистить кеш
// todo очистка кеша в одном файле с мультихуком
if (ab_inBoardCat($adv_cat) && $cache && $cfg['plugin']['advboard']['recentAdvCacheTime'] > 0) {
    /** @var Memcache_driver $ab_CacheDrv  */
    $ab_CacheDrv = ab_getCacheDrv();
    $cache_key = 'RECENT_ADVS';
    $advRealm = COT_DEFAULT_REALM;
    $ab_CacheDrv->remove($cache_key, $advRealm);
}
// /Очистить кеш

if (ab_inBoardCat($adv_cat) && $cfg['plugin']['advboard']['notifyUserNewComment'] == 1){

    // Получить страницу:
    $adv_pag = $db->query("SELECT * FROM $db_pages WHERE page_id=?", array($comarray["com_code"]))->fetch();

    if (empty($adv_pag)) return;
    // Если незарег
    $advUser = array('user_email' => false, 'user_name' => '');

    if (!empty($cfg['plugin']['advboard']['gEmailExtraField']) &&
                    !empty($adv_pag['page_'.$cfg['plugin']['advboard']['gEmailExtraField']])){
        $advUser['user_email'] = $adv_pag['page_'.$cfg['plugin']['advboard']['gEmailExtraField']];
    }

    if ($adv_pag['page_ownerid'] > 0){
        // Получить пользователя
        $advUser = $db->query("SELECT user_email, user_name FROM $db_users WHERE user_id=?" ,array($adv_pag["page_ownerid"]))
            ->fetch();
    }
    if (empty($advUser['user_email'])) return;

    $advUrlParams = $url_params;
    if(isset($advUrlParams['e'])) unset($advUrlParams['e']);

    $advCommUrl = cot_url($url_area, $advUrlParams, '#c' . $id, true);
    if (!cot_url_check($advCommUrl)) $advCommUrl = COT_ABSOLUTE_URL . $advCommUrl;
//    $email_url = $email_url . $sep . 'comments=1#c' . $id;

	// Выдержка с поста
	$len_cut = 500;  // Длина выдержки с поста (символов)
    $advComText = cot_parse($comarray['com_text'], $cfg['plugin']['comments']['markup']);
    $advComText = cot_string_truncate($advComText, $len_cut, true, false, '...');
    // /Выдержка с поста

	$advEmailTitle = $L['advboard']['new_comment'].' - '.$cfg['mainurl'];
	$advEmailBody = $L['advboard']['userComNotify'];

	$advCommenterName = '';
	if (!empty($usr['name']) && $usr['name'] != ''){
		$advCommenterName = $usr['name'];
		$advCommenterUrl = '';
		if ($usr['id'] != ''){
			$advCommenterUrl = cot_url('users', 'm=details&id='.$usr['id'].'&u='.$usr['name']);
			if (!cot_url_check($advCommenterUrl)) $advCommenterUrl = COT_ABSOLUTE_URL . $advCommenterUrl;
            $advCommenterName = cot_rc_link($advCommenterUrl, $usr['name']);
		}
	}else{
		$advCommenterName = $L['advboard']['anonimus'];
	}

    $advUrl = cot_url($url_area, $advUrlParams, '', true);
    if (!cot_url_check($advUrl)) $advUrl = COT_ABSOLUTE_URL . $advUrl;

    $advMyAdvs = cot_url('advboard');
    if (!cot_url_check($advMyAdvs)) $advMyAdvs = COT_ABSOLUTE_URL . $advMyAdvs;

    $advEmailBody = str_replace('{USER_NAME}', $advUser['user_name'], $advEmailBody);
    $advEmailBody = str_replace('{COMMENTER_NAME}', $advCommenterName, $advEmailBody);
    $advEmailBody = str_replace('{SITE_TITLE}', $cfg["maintitle"], $advEmailBody);
    $advEmailBody = str_replace('{SITE_URL}', $cfg["mainurl"], $advEmailBody);
    $advEmailBody = str_replace('{ADV_TITLE}', $adv_pag['page_title'], $advEmailBody);
    $advEmailBody = str_replace('{COM_TEXT}', $advComText, $advEmailBody);
    $advEmailBody = str_replace('{ADV_URL}', $advUrl, $advEmailBody);
    $advEmailBody = str_replace('{ADV_COM_URL}', $advCommUrl, $advEmailBody);
    $advEmailBody = str_replace('{MY_ADVS}', $advMyAdvs, $advEmailBody);

	cot_mail($advUser['user_email'], $advEmailTitle, $advEmailBody, '', false, null, true);
}

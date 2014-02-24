<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.add.add.done
[END_COT_EXT]
==================== */
/**
 * Plugin AN Advertisement Board
 * @package Advertisement board plugin for Cotonti Siena
 * @author Alex - Studio Portal30
 * @copyright Portal30 2011-2012 http://portal30.ru
 */
defined('COT_CODE') or die('Wrong URL');

if (ab_inBoardCat(ab_getCurrCategory())){
    global $db_users, $usr;

    // Очистить кеш
    // todo очистка кеша в одном файле с мультихуком
    if ($cache && $cfg['plugin']['advboard']['recentAdvCacheTime'] > 0) {
        /** @var Memcache_driver $ab_CacheDrv  */
        $ab_CacheDrv = ab_getCacheDrv();
        $cache_key = 'RECENT_ADVS';
        $advRealm = COT_DEFAULT_REALM;
        $ab_CacheDrv->remove($cache_key, $advRealm);
    }
    // /Очистить кеш

    // Для незарега запомним id страницы для чтого, чтобы он мог ее отредактировать в пределах сесии
    if($usr['id'] == 0){
        if(empty($_SESSION['advboard'])) $_SESSION['advboard'] = array();
        if (!in_array($id, $_SESSION['advboard'])) $_SESSION['advboard'][] = $id;
    }

    $urlparams = empty($rpage['page_alias']) ?
        array('c' => $rpage['page_cat'], 'id' => $id) :
        array('c' => $rpage['page_cat'], 'al' => $rpage['page_alias']);
    $pUrl = cot_url('page', $urlparams, '', true);

    if ($rpage['page_state'] == 0){
        $tmp = str_replace('{PAGE_TITLE}', $rpage['page_title'], $L['advboard']['msg_page_create_success']);
        cot_message($tmp);
    }elseif($rpage['page_state'] == 1){
        $r_url = cot_url('message', "msg=300&do=advpageadded&c=".$rpage['page_cat'], '', true);
    }

    // Лог, добавлена новая запись.
    cot_log($L['advboard']['plu_title'].'. '.$L['advboard']['page_created_log'].': «'.$rpage['page_title'].
        '» ( '.$pUrl.' )    ', 'plg');

    if (!cot_url_check($pUrl)) $pUrl = COT_ABSOLUTE_URL . $pUrl;

    // Если необходимо отправляем письмо админу о добавлении новой страницы
    if ($cfg['plugin']['advboard']['notifyAdminNewAdv'] == 1){
        $admEmails = $db->query("SELECT user_email FROM $db_users WHERE user_maingrp=5")
            ->fetchAll(PDO::FETCH_COLUMN);
        $tmp = trim($cfg['adminemail']);
        if ($tmp != '') $admEmails[] = $tmp;
        $admEmails = array_unique($admEmails);

        $usr_url = cot_url('users', 'm=details&id='.$usr['id'].'&u='.$usr['name'], '', true);
        if (!cot_url_check($usr_url)) $usr_url = COT_ABSOLUTE_URL . $usr_url;

        $email_subject = $L['advboard']['page_created'].' - '.$cfg['mainurl'];
        $email_body  = $L['User'] .' ' . $usr['name'] .' ( '.$usr_url.' ), ' . $L['advboard']['page_created2'].": ".$rpage['page_title']."\n\n";
        $email_body .= $L['advboard']['desc'].":\n";
        $email_body .= "================================\n";
        $email_body .= $rpage['page_desc']."\n";
        $email_body .= "================================\n\n";
        $email_body .= $L['advboard']['page_created3'].":\n";
        $email_body .= $pUrl;

        $tmp = array();
        foreach ($admEmails as $adm){
            if (!in_array($adm, $tmp)){
                cot_mail($adm, $email_subject, $email_body);
                $tmp[] = $adm;
            }
        }

    }
}
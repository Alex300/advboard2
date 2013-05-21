<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=users.details.tags
Tags=users.details.tpl:{USERS_DETAILS_ADV_SUBMITNEW}, {USERS_DETAILS_ADV_SUBMITNEW_URL}, {USERS_DETAILS_ADV_COUNT}, {USERS_DETAILS_ADV_URL}, {USERS_DETAILS_ADV}
[END_COT_EXT]
==================== */
/**
 * Plugin Advertisement Board
 * @package Advertisement board plugin for Cotonti Siena
 * @author Alex - Studio Portal30
 * @copyright Portal30 2011-2012 http://portal30.ru
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('advboard', 'plug');
require_once cot_langfile('advboard');

$advcats = ab_readBoardCats();

$submitNewAdv = '';
$submitNewAdvUrl = '';
foreach($advcats as $advCat){
    if (cot_auth('page', $advCat, 'W') || $usr["isadmin"]){
        $submitNewAdv = cot_rc_link(cot_url('page', 'm=add&c='.$advCat), $L['advboard']['add_new_adv']);
        $submitNewAdvUrl = cot_url('page', 'm=add&c='.$advCat);
        break;
    }
}

$advUnValidated = ($urr['user_id'] == $usr['id'] || $usr["isadmin"] );

$advCond = array();

if (!$advUnValidated){
    $advCond['date'] = "page_begin <= {$sys['now']} AND (page_expire = 0 OR page_expire > {$sys['now']})";
    $advCond['state'] = "(page_state=0)";
}
$advCond['ownerid'] = 'page_ownerid = ' . $urr['user_id'];

$advUrlParams = array('m'=>'details', 'id'=>$urr['user_id'],'u'=>$urr['user_name']);

$advAjaxPParams = array('a'=>'userDetailsAdvList', 'uid'=>$urr['user_id']);

$t->assign(array(
    "USERS_DETAILS_ADV_SUBMITNEW" => $submitNewAdv,
    "USERS_DETAILS_ADV_SUBMITNEW_URL" => $submitNewAdvUrl,
    "USERS_DETAILS_ADV_COUNT" => ab_userAdvCount($urr['user_id'], $advUnValidated),
    "USERS_DETAILS_ADV_URL" => cot_url('plug', 'e=advboard&uid='.$urr['user_id']),
    "USERS_DETAILS_ADVS" => ab_advList('advboard.ud_advlist', 10, 'page_begin DESC', $advCond, '', '', '', true, 'ad',
        false, $advUrlParams, $cfg["turnajax"], $advAjaxPParams),
));
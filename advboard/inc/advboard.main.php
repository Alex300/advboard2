<?php
defined('COT_CODE') or die('Wrong URL');

/**
 * Main Controller class for the AN Advertisement Board
 * 
 * @package Advertisement board plugin for Cotonti Siena
 * @author Alex - Studio Portal30
 * @copyright Portal30 2011-2012 http://portal30.ru
 */
class MainController{

    /**
     * Main (index) Action.
     * Объявления пользователя
     */
    public function indexAction(){
        global $t, $L, $cfg, $usr, $sys, $out, $db_users, $db;

        $uid = cot_import('uid', 'G', 'INT');
        if (!$uid){
            $uid = $usr['id'];
            $urr = array(
                'user_id' => $usr['id'],
                'user_name' => $usr['name']
            );
        }else{
            $sql = $db->query("SELECT user_id, user_name  FROM $db_users WHERE user_id=$uid LIMIT 1");
            cot_die($sql->rowCount()==0, true);
            $urr = $sql->fetch();
        }

        $advcats = ab_readBoardCats();
        // Незарегов, если они не смотрят объявления другого пользователя перенаправляем
        if (!$uid) cot_redirect(cot_url('page', "c={$advcats[0]}"));


        $out['canonical_uri'] = cot_url('plug', 'e=advboard&uid='.$uid);

        $advUrlParams = array('e'=>'advboard');

        $crumbs = array(array(cot_url("users"), $L['Users']));
        if ($uid != $usr['id']){
            $out['subtitle'] = "{$L['advboard']['user_advs']}: {$urr['user_name']}";
            $crumbs[] = array(cot_url("users", "m=details&id=".$urr["user_id"]."&u=".$urr["user_name"] ), $urr['user_name']);
            $crumbs[] = $L['advboard']['user_advs'];
            $advUrlParams['uid'] = $urr['user_id'];
        }else{
            $out['subtitle'] = $L['anadvboard']['my_advs'];
            $crumbs[] = array(cot_url('users', array('m'=>'details')), $L['pro_title']);
            $crumbs[] = $L['advboard']['my_advs'];
        }
        $breadcrumbs = cot_breadcrumbs($crumbs, $cfg['homebreadcrumb'], true);

        $advUnValidated = ($urr['user_id'] == $usr['id'] || $usr["isadmin"] );

        $advCond = array();

        if (!$advUnValidated){
            $advCond['date'] = "page_begin <= {$sys['now']} AND (page_expire = 0 OR page_expire > {$sys['now']})";
            $advCond['state'] = "(page_state=0)";
        }
        $advCond['ownerid'] = 'page_ownerid = ' . $urr['user_id'];

        $submitNewAdv = '';
        $submitNewAdvUrl = '';
        foreach($advcats as $advCat){
            if (cot_auth('page', $advCat, 'W') || $usr["isadmin"]){
                $submitNewAdv = cot_rc_link(cot_url('page', 'm=add&c='.$advCat), $L['advboard']['add_new_adv']);
                $submitNewAdvUrl = cot_url('page', 'm=add&c='.$advCat);
                break;
            }
        }

        $t->assign(array(
            'PAGE_TITLE' => ($uid != $usr['id']) ? "{$L['advboard']['user_advs']}: {$urr['user_name']}" :
                    $L['advboard']['my_advs'],
            'BREADCRUMBS' => $breadcrumbs,
			'USER_ID' => $uid,
            'USER_ADV_COUNT' => ab_userAdvCount($urr['user_id'], $advUnValidated),
            'USER_ADVS' => ab_advList('advboard.user_advlist', $cfg['page']['cat___default']['maxrowsperpage'],
                    'page_begin DESC', $advCond, '', '', '', true, 'd',
                false, $advUrlParams),
            'USER_ADV_SUBMITNEW' => $submitNewAdv,
            'USER_ADV_SUBMITNEW_URL' => $submitNewAdvUrl,
        ));
//        $t->parse('EDIT');
//        return $t->text('EDIT');
        return 'sdfsdfsd';
    }

    /**
     * Ajax
     */
    public function userDetailsAdvListAction(){
        global $db,  $db_users, $usr, $sys;

        $uid = cot_import('uid', 'G', 'INT');
        if (!$uid) exit;

        $sql = $db->query("SELECT user_id, user_name  FROM $db_users WHERE user_id=$uid LIMIT 1");
        cot_die($sql->rowCount()==0, true);
        $urr = $sql->fetch();

        $advcats = ab_readBoardCats();
        $advUnValidated = ($urr['user_id'] == $usr['id'] || $usr["isadmin"] );

        $advCond = array();

        if (!$advUnValidated){
            $advCond['date'] = "page_begin <= {$sys['now']} AND (page_expire = 0 OR page_expire > {$sys['now']})";
            $advCond['state'] = "(page_state=0)";
        }
        $advCond['ownerid'] = 'page_ownerid = ' . $urr['user_id'];
//        $advCond['cat'] = "page_cat IN (".implode(", ", ab_quoteDbData($advcats)).")";
//
//        $advCond = implode(' AND ', $advCond);

        $advUrlParams = array('m'=>'details', 'id'=>$urr['user_id'],'u'=>$urr['user_name']);

        $advAjaxPParams = array('a'=>'userDetailsAdvList', 'uid'=>$urr['user_id']);

        echo ab_advList('advboard.ud_advlist', 10, 'page_begin DESC', $advCond, '', '', '', true, 'ad',
            false, $advUrlParams, true, $advAjaxPParams),

        exit;
    }

}
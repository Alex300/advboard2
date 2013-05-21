<?php
/* ====================
[BEGIN_COT_EXT]
Code=advboard
Name=Advertisement Board
Description=Advertisement board plugin for Cotonti CMF.
Version=2.0.0
Date=29 Oct 2012
Author=Alex
Copyright=&copy; 2011-2012 http://portal30.ru (Portal30 studio)
Notes=
Auth_guests=R
Lock_guests=12345A
Auth_members=RW
Lock_members=A
Requires_modules=page,users
Recommends_plugins=
[END_COT_EXT]

[BEGIN_COT_EXT_CONFIG]
rootCats=10:string::adv:Root categories (comma separated)
allowSticky=12:radio::1:Allow Sticky Adv?
stickyExtraField=13:string::sticky:Page Extra Field for Stiky Flag
maxPeriod=14:string::30:Max Adv publication period
periodOrder=15:select:asc,desc:desc:Period order
notifyAdminNewAdv=16:radio::1:New adv admin notify?
notifyUserNewComment=17:radio::1:New comment user notify?
expNotifyPeriod=18:select:0,1,5,6,7,8,9,10,15,20,25,30:5:Expire notification for days
guestEmailRequire=20:radio::1:Guest e-mail required?
gUseCaptcha=21:radio::0:Use captcha?
gEmailExtraField=22:string::email:Page Extra Field for guest e-mail
recentAdvOn=23:radio::1:Show recent advs in the adv board root category?
recentAdvNum=24:select:1,5,6,7,8,9,10,15,20,25,30,35,40,45,50,60:10:Recent adv num
recentAdvStick=25:radio::0:Recent adv sticky only?
recentAdvGlobalOn=26:radio::0:Add recent advs to global array? {PHP.recent_advs}
recentAdvGlobalNum=27:select:1,5,6,7,8,9,10,15,20,25,30,35,40,45,50,60:10:Recent adv num
recentAdvGlobalStick=28:radio::0:Global recent adv sticky only?
recentAdvCacheTime=29:string::12:Recent adv cache life time
rssToHeader=35:radio::1:Add Adv Board rss in site header?
[END_COT_EXT_CONFIG]
==================== */

/**
 * Plugin Advertisement Board
 * @package Advertisement board plugin for Cotonti Siena
 * @author Alex - Studio Portal30
 * @copyright Portal30 2011-2012 http://portal30.ru
 */
defined('COT_CODE') or die('Wrong URL');

// no closing tag )))
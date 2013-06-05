<?php
/**
 * Plugin AN Advertisement Board
 * Advertisement board plugin for Cotonti Siena
 *     Russian Lang file
 *
 * http://portal30.ru
 * (c) Studio Portal 30 2011-2012
 */
defined('COT_CODE') or die('Wrong URL');

/**
 * Plugin Title & Subtitle
 */

$L['info_desc'] = 'Доска объявлений.';
$L['advboard']['plu_title'] = 'Доска объявлений';

//$L['an_adv_board']['plu_subtitle'] = 'Доска объявлений - для CMS Cotonti.';
//$L['an_adv_board']['plu_meta_keywords'] = "Доска объявлений, реклама, интернет, реклама в интернете";
//if ($e == 'an_adv_board') $L['plu_title'] = $L['an_adv_board']['plu_title'];
/**
 * Plugin Body
 */
$L['advboard']['add_new_adv'] = 'Подать объявление';
$L['advboard']['period'] = 'Срок публикации';
$L['advboard']['days'] = 'дней.';
$L['advboard']['captcha'] = "* Введите код с изображения";
$L['advboard']['your_email'] = 'Ваш e-mail';
$L['advboard']['page_created_log'] = 'Добавлено новое объявление';
$L['advboard']['desc'] = 'Краткое описание';
$L['advboard']['page_created'] = 'Добавлено новое объявление';
$L['advboard']['page_created2'] = "добавил новое объявление.";
$L['advboard']['page_created3'] = "Объявление находится по адресу";
$L['advboard']['expiring'] = 'Истекает';
$L['advboard']['exp_soon'] = 'Публикация истекает через %1$s дней';
$L['advboard']['exp_today'] = 'Публикация истекает сегодня!';
$L['advboard']['expired'] = 'Срок публикации истек';
$L['advboard']['edit_page'] = 'Редактировать объявление';
$L['advboard']['from_now'] = 'С сегодняшнего дня.';
$L['advboard']['date_begin'] = 'Дата размещения';
$L['advboard']['set_period'] = 'Установить срок публикации';
$L['advboard']['sticky'] = 'Срочное';
$L['advboard']['new_comment'] = "Новый комментарий к Вашему объявлению.";
$L['advboard']['anonimus'] = "Анонимный";
$L['advboard']['RSS_feed'] = 'Последние объявления - ';
$L['advboard']['user_advs'] = 'Объявления пользователя';
$L['advboard']['avd_count'] = 'Количество объявлений';
$L['advboard']['read_more'] = 'Подробнее';
$L['advboard']['my_advs'] = 'Мои объявления';
$L['advboard']['recent_advs'] = 'Последние объявления';
$L['advboard']['read_more'] = 'Читать полностью';
$L['advboard']['userExpNotifyTitle'] = "Истечение срока публикации Вашего объявления.";

//$L['an_adv_board']['wait_validation'] = 'ожидает модерации';
//$L['an_adv_board']['hits'] = 'Просмотров';

/**
 * E-mails
 */
$L['advboard']['userExpNotify'] = "Добрый день {USER_NAME}!
<p>
Вы получили это письмо потому, что {EXP_DATE} истекает срок публикации Вашего объявления на сайте
«<a href=\"{SITE_URL}\" target=\"_blank\">{SITE_TITLE}</a>».
</p>
<p>«<a href=\"{ADV_URL}\" target=\"_blank\">{ADV_TITLE}</a>»</p>
<p>
Описание:
<hr />
{ADV_DESCRIPION}.
<hr />
</p>
<p>Просмотреть и продлить Ваше объявление Вы можете по адресу: <a href=\"{ADV_URL}\" target=\"_blank\">{ADV_URL}</a> .</p>
<p>Все Ваши объявления: <a href=\"{MY_ADVS}\" target=\"_blank\">{MY_ADVS}</a>.</p>
<p>Отвечать на это письмо не нужно.</p>";

$L['advboard']['userComNotify'] = "Добрый день {USER_NAME}!
<p>Пользователь {COMMENTER_NAME} ответил на Ваше объявление на сайте «<a href=\"{SITE_URL}\" target=\"_blank\">{SITE_TITLE}</a>»</p>
<p>«<a href=\"{ADV_URL}\" target=\"_blank\">{ADV_TITLE}</a>»</p>
<p>
Ответ на объявление:
<hr />
{COM_TEXT}
<hr />
</p>
<p>Просмотреть ответ на Ваше объявление Вы можете по адресу: <a href=\"{ADV_COM_URL}\" target=\"_blank\">{ADV_COM_URL}</a>.</p>
<p>Все Ваши объявления: <a href=\"{MY_ADVS}\" target=\"_blank\">{MY_ADVS}</a>.</p>
<p>Отвечать на это письмо не нужно.</p>";

/**
 * Errors and messages
 */
$L['advboard']['err_noemail'] = "Вы должны ввести e-mail";
$L['advboard']['err_wrongmail'] = "Ошибочный e-mail";
$L['advboard']['msg_page_create_success'] = 'Новое объявление &laquo;{PAGE_TITLE}&raquo; добавлено.';

/**
 * Admin Part
 */

/**
 * Plugin Config
 */
$L['cfg_rootCats'] = array('Корневые категории доски объявлений', '(коды категорий через запятую)<br />Объявления будут создаваться в этих и вложенных в эти категориях.');
$L['cfg_allowRootCatsAdv'] = array('Разрешить добавление объявлений в корневые категории?');
$L['cfg_allowSticky'] = array('Разрешить срочные объявления?', 'Те объявления, у которых отмечено поле, указанное ниже,
    отображаются в первую очередь');
$L['cfg_stickyExtraField'] = array('Екстра поле для отметки срочных?', 'Экстра поле страницы типа &laquo;checkbox&raquo;
    Значение поля по-умолчанию <b>0</b>.<br />Рекомендую пользователям не давать возможность использовать его напрямую');
$L['cfg_maxPeriod'] = array('Максимальный срок размещения объявления', 'Срок в днях. Например: 30');
$L['cfg_periodOrder'] = array('Порядок заполнения &laquo;Период&raquo;', 'При подаче объявления выпадающий список
    &laquo;Период&raquo; заполнен');
$L['cfg_periodOrder_params'] = array(
    'desc' => 'По убыванию',
    'asc' => 'По возрастанию'
);
$L['cfg_notifyAdminNewAdv'] = array('Уведомлять администратора о новых объявлениях?');
$L['cfg_notifyUserNewComment'] = array('Уведомлять пользователя о новых комментариях на его объявления?');
//$L['cfg_notifyUserAdvExpire'] = array('Уведомлять пользователя об истечении срока публикации объявления?');
$L['cfg_expNotifyPeriod'] = array("Уведомлять пользователя об истечении срока публикации объявления за", 'дней. 0 - не уведомлять.');
$L['cfg_allowGuestAddAdv'] = array('Разрешить гостям подавать объявление?');
$L['cfg_guestEmailRequire'] = array('Гостям обязательно указывать e-mail при подаче объявления?');
$L['cfg_gEmailExtraField'] = array("Экстраполе для хранения e-mail'а гостя", 'Экстра поле страницы типа &laquo;input&raquo;.
    <br />Установить, если для подачи объявления гостям сайта обязательно указывать e-mail');
$L['cfg_recentAdvOn'] = array('Включить &laquo;Последние объявления&raquo;?', 'Отображать последние объявления в
    корневой категории доски объявления');
$L['cfg_recentAdvStick'] = array('&laquo;Последние объявления&raquo; только из срочных?', 'Если включено, то
    последние объявления будут выводиться только из числа &laquo;срочных&raquo;');
$L['cfg_recentAdvNum'] = array('Количество &laquo;Последних объявлений&raquo;?');
$L['cfg_recentAdvGlobalOn'] = array('Включить &laquo;Последние объявления&raquo; глобально?', 'Вы можете вывести
    &laquo;Последние объявления&raquo; в любой .tpl файл тегом <strong>{PHP.RECENT_ADVS}</strong>');
$L['cfg_recentAdvGlobalStick'] = array('Глобальные &laquo;Последние объявления&raquo; только из срочных?', 
    'Если включено, то последние объявления будут выводиться только из числа &laquo;срочных&raquo;');
$L['cfg_recentAdvGlobalNum'] = array('Количество глобальных &laquo;Последних объявлений&raquo;?');
$L['cfg_recentAdvCacheTime'] = array('Время жизни кеша последних объявлений', 'В часах. 0 - не кешировать');
$L['cfg_rssToHeader'] = array('Вывести ссылку на RSS ленту &laquo;Последних объявлений&raquo; в header.tpl?');

$L['cfg_gUseCaptcha'] = array('Использовать капчу для подачи объявлений гостями?', "Будет использована только для
    незарегистрированных пользователей.<br />Капча должна быть установлена на сайте.");

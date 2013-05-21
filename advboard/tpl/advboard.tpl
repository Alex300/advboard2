<!-- BEGIN: MAIN -->
<div id="breadcrumb">
    <a href="{PHP|cot_url('index')}"><img src="{PHP.cfg.mainurl}/{PHP.cfg.themes_dir}/{PHP.usr.theme}/img/icon-home.gif"
                                          width="16" height="16" alt="{PHP.cfg.maintitle}" /></a>
    {PHP.cfg.separator} {BREADCRUMBS}
</div>


<h1 class="grey-header">{PAGE_TITLE}</h1>
{PAGE_SUBTITLE}

<p><em>{PHP.L.advboard.avd_count}</em>: {USER_ADV_COUNT}</p>
<div>
	{USER_ADVS}
</div>
<!-- IF {USER_ADV_SUBMITNEW} -->
<p>
    <a href="{USER_ADV_SUBMITNEW_URL}" class="btn btn-mini"><span class="icon-plus"></span> {PHP.L.advboard.add_new_adv}</a>
</p>
<!-- ENDIF -->

<!-- END: MAIN -->
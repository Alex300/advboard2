<!-- BEGIN: MAIN -->

    <!-- BEGIN: PAGE_ROW -->
    <div class="row-fluid margintop10 marginbottom10">
        <div class="red">{PAGE_ROW_BEGIN}</div>
        <h2 class="margin0"><a href="{PAGE_ROW_URL}">{PAGE_ROW_SHORTTITLE}</a> {PAGE_ROW_FILEICON}</h2>
        <div class="textjustify">
            <!-- IF {PAGE_ROW_DESC} -->
        {PAGE_ROW_DESC}
            <!-- ELSE -->
        {PAGE_ROW_TEXT_CUT}
            <!-- ENDIF -->
        </div>

        <!-- IF {PHP.usr.id} > 0 AND ( {PAGE_ROW_OWNERID} == {PHP.usr.id} OR  {PHP.usr.isadmin} == 1 ) -->
        <div class="textright">
            <!-- IF {PAGE_ROW_ADV_STATUS_LOCAL} != '' OR {PAGE_ROW_STATUS} != 'published' -->
            <div>
                <!-- IF {PAGE_ROW_ADV_STATUS_LOCAL} != '' -->
                <span class="italic small" style="color:#F00; font-weight: bold">* {PAGE_ROW_ADV_STATUS_LOCAL}.</span>
                <!-- ENDIF -->

                <!-- IF {PAGE_ROW_STATUS} != 'published' -->
                <span class="italic small" style="color:#F00; font-weight: bold">{PAGE_ROW_LOCALSTATUS}</span>
                <!-- ENDIF -->
            </div>
            <!-- ENDIF -->

            <a href="{PAGE_ROW_ADMIN_EDIT_URL}" class="btn btn-mini">
                <span class="icon-edit"></span> {PHP.L.Edit}</a>

            <a href="{PAGE_ROW_ADMIN_CLONE_URL}" class="btn btn-mini">
                <i class="icon-share"></i> Клонировать</a>

            <!-- IF {PHP.usr.isadmin} -->
            <a href="{PAGE_ROW_ADMIN_UNVALIDATE_URL}" class="btn btn-mini confirmLink">
                <!-- IF {PAGE_ROW_STATE} == 1 -->
                <span class="icon-check"></span> {PHP.L.Validate}
                <!-- ELSE -->
                <span class="icon-time"></span> {PHP.L.Putinvalidationqueue}
                <!-- ENDIF --></a>

            <a href="{PAGE_ROW_ADMIN_DELETE_URL}" class="btn btn-mini confirmLink">
                <span class="icon-trash"></span> {PHP.L.Delete}</a>

            <!-- <span class="italic desc">({PHP.L.Hits}: {PAGE_ROW_COUNT})</span>-->
            <!-- ENDIF -->
        </div>
        <!-- ENDIF -->
    </div>
    <!-- END: PAGE_ROW -->

    <!-- IF {PAGE_TOP_PAGINATION} -->
    <div class="pagination">
        {PAGE_TOP_PAGEPREV} {PAGE_TOP_PAGINATION} {PAGE_TOP_PAGENEXT}
    </div>
    <!-- ENDIF -->

<!-- END: MAIN -->
<!-- BEGIN: MAIN -->

    <!-- BEGIN: PAGE_ROW -->
    <div class="row-fluid margin10">
        <div class="red">{LIST_ROW_BEGIN}</div>

        <table width="100%">
            <tr>
                <td align="center" width="60px">
                    <!-- IF {LIST_ROW_OWNER_ID} > 0 -->
                    <b>{LIST_ROW_OWNER_NAME}</b><br/>
                    <!-- ELSE -->
                    <b>{PHP.L.Guest}</b><br/>
                    <!-- ENDIF -->
                    <div class="comment_avatar" style="float: none; margin: 0">
                        {LIST_ROW_OWNER_AVATAR}
                    </div>
                </td>
                <td class="paddingleft10">
                    <h2 class="margin0"><a href="{LIST_ROW_URL}">{LIST_ROW_SHORTTITLE}</a> {LIST_ROW_FILEICON}</h2>
                    <div class="textjustify">
                        <!-- IF {LIST_ROW_DESC} -->
                            {LIST_ROW_DESC}
                        <!-- ELSE -->
                            {LIST_ROW_TEXT_CUT}
                        <!-- ENDIF -->
                    </div>

                    <div class="textright small">
                        <a class="red" href="{LIST_ROW_URL}">{PHP.L.advboard.read_more}...</a>
                    </div>
                </td>
            </tr>
        </table>

        <!-- IF {PHP.usr.id} > 0 AND ( {LIST_ROW_OWNERID} == {PHP.usr.id} OR  {PHP.usr.isadmin} == 1 ) -->
        <div class="textright">
            <!-- IF {LIST_ROW_ADV_STATUS_LOCAL} != '' OR {LIST_ROW_STATUS} != 'published' -->
            <div>
                <!-- IF {LIST_ROW_ADV_STATUS_LOCAL} != '' -->
                <span class="italic small" style="color:#F00; font-weight: bold">* {LIST_ROW_ADV_STATUS_LOCAL}.</span>
                <!-- ENDIF -->

                <!-- IF {LIST_ROW_STATUS} != 'published' -->
                <span class="italic small" style="color:#F00; font-weight: bold">{LIST_ROW_LOCALSTATUS}</span>
                <!-- ENDIF -->
            </div>
            <!-- ENDIF -->

            <a href="{LIST_ROW_ADMIN_EDIT_URL}" class="btn btn-mini">
                <span class="icon-edit"></span> {PHP.L.Edit}</a>

            <!-- IF {PHP.usr.isadmin} -->
            <a href="{LIST_ROW_ADMIN_UNVALIDATE_URL}" class="btn btn-mini confirmLink">
                <!-- IF {LIST_ROW_STATE} == 1 -->
                <span class="icon-check"></span> {PHP.L.Validate}
                <!-- ELSE -->
                <span class="icon-time"></span> {PHP.L.Putinvalidationqueue}
                <!-- ENDIF --></a>

            <a href="{LIST_ROW_ADMIN_DELETE_URL}" class="btn btn-mini confirmLink">
                <span class="icon-trash"></span> {PHP.L.Delete}</a>

            <!--При кешировании это бессмысленно <span class="italic desc">({PHP.L.Hits}: {LIST_ROW_COUNT})</span>-->
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

<!--You can remove the following line. If you want to do this, please donate.-->
<!--Вы можете удалить следующую строку. Если Вы хотите сделать это, пожалуйста поддержите проект.-->
<!--{PHP.advboard_copyr}-->
<!-- END: MAIN -->
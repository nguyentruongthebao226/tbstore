function changeStatus(url){
    $.get(url, function(data){
        /* $xhtml     = '<a id="status-'.$id.'" href="javascript:changeStatus(\''.$link.'\');" class="label label-'.$strStatus.'"><i class="fa fa-fw fa-check"></i></a>';
        */
        var element     = 'a#status-' + data['id'];
        var classRemove = 'fa-unlock text-info';
        var classAdd    = 'fa-lock text-danger';
        if(data['status'] == 1){
            classRemove = 'fa-lock text-danger';
            classAdd    = 'fa-unlock text-info';
        }

        $(element).attr('href', "javascript:changeStatus('"+data['link']+"')");
        $(element).removeClass(classRemove).addClass(classAdd);
       
    }, 'json');
}

function changeSpecial(url){
    $.get(url, function(data){
        /* $xhtml     = '<a id="status-'.$id.'" href="javascript:changeStatus(\''.$link.'\');" class="label label-'.$strStatus.'"><i class="fa fa-fw fa-check"></i></a>';
        */
        var element     = 'a#special-' + data['id'];
        var classRemove = 'fa-unlock text-info';
        var classAdd    = 'fa-lock text-danger';
        if(data['special'] == 1){
            classRemove = 'fa-lock text-danger';
            classAdd    = 'fa-unlock text-info';
        }

        $(element).attr('href', "javascript:changeSpecial('"+data['link']+"')");
        $(element).removeClass(classRemove).addClass(classAdd);
       
    }, 'json');
}

function submitForm(url){
    $('#adminForm').attr('action', url);
    $('#adminForm').submit();
}

function sortList(column, order){
    $('input[name=filter_column]').val(column);
    $('input[name=filter_column_dir]').val(order);
    $('#adminForm').submit();
}

function changePage(page){
    $('input[name=filter_page]').val(page);
    $('#adminForm').submit();
}

function changeGroupACP(url){
    $.get(url, function(data){
        /* $xhtml     = '<a id="status-'.$id.'" href="javascript:changeStatus(\''.$link.'\');" class="label label-'.$strStatus.'"><i class="fa fa-fw fa-check"></i></a>';
        */
        var id          = data[0];
        var group_acp   = data[1];
        var link        = data[2];
        var element     = 'a#group-acp-' + data['id'];
        var classRemove = 'fa-unlock text-info';
        var classAdd    = 'fa-lock text-danger';
        if(data['group_acp'] == 1){
            classRemove = 'fa-lock text-danger';
            classAdd    = 'fa-unlock text-info';
        }

        $(element).attr('href', "javascript:changeGroupACP('"+data['link']+"')");
        $(element).removeClass(classRemove).addClass(classAdd);
       
    }, 'json');
}

$(document).ready(function(){
    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $('#filter-bar button[name=submit-keyword]').click(function(){
        $('#adminForm').submit();
    });

    $('#filter-bar button[name=clear-keyword]').click(function(){
        $('#filter-bar input[name=filter_search]').val('');
        $('#adminForm').submit();
    });

    $('#filter-bar select[name=filter_state]').change(function(){
        $('#adminForm').submit();
    });

    $('#filter-bar select[name=filter_special]').change(function(){
        $('#adminForm').submit();
    });

    $('#filter-bar select[name=filter_group_acp]').change(function(){
        $('#adminForm').submit();
    });

    $('#filter-bar select[name=filter_group_id]').change(function(){
        $('#adminForm').submit();
    });

    $('#filter-bar select[name=filter_category_id]').change(function(){
        $('#adminForm').submit();
    });
})
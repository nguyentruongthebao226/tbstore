function getUrlVar(key){
    var result = new RegExp(key + "=([^&]*)", "i").exec(window.location.search);
    return result && unescape(result[1]) || "";
}

function submitForm(url){
    $('#adminForm').attr('action', url);
    $('#adminForm').submit();
}

function submitFormDetail(){
    let form = document.getElementById("detailForm");
    form.submit();
}


// $(document).ready(function(){
//     var controller  = (getUrlVar('controller') == '')? 'index' : getUrlVar('controller') ;
//     var action      = (getUrlVar('action') == '')? 'index' : getUrlVar('action') ;
//     var classSelect = controller + '-' + action;
//     console.log(classSelect);
//     $('#menu nav ul li.' + classSelect). addClass('active');
// });

$(document).ready(function(){
    $('#optionselectbox select[name=filter]').change(function(){
        $('#adminForm').submit();
    });

    $('#btnSubmit').click(function() {
        $('#adminForm').submit();
    });
})

function changePage(page){
    $('input[name=filter_page]').val(page);
    $('#adminForm').submit();
}

// document.getElementById('adminForm').addEventListener('submit', function(){
//     alert('Form Submited');
// });

// $("select.filter").change(function(){
//     var selectedOptions = $(this).children("option:selected").val();
//     alert("You have selected the option - " + selectedOptions);
// });
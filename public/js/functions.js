$(document).ready(function(){
    

	$('form.task').submit(function(){
        event.preventDefault();
        hasEmpty = formValidate($(this));
        if (hasEmpty) {
            suc = function(ans){
                ans = $.parseJSON(ans);
                if (ans.status == "error") modalWindow('<div class="modal_content">' + ans.message + '</div>');
                if (ans.status == "success") {
                    $.get(
                        window.location.href,
                        {},
                        function onAjaxSuccess(data) {
                            $('body').html(data);
                            modalWindow('<div class="modal_content">' + ans.message + '</div>');
                        }
                    );
                }
            }
            send($(this), suc);
        }
    })

    $('body').on('submit', 'form.auth', function(){
        event.preventDefault();
        hasEmpty = formValidate($(this));
        if (hasEmpty) {
            suc = function(ans){
                ans = $.parseJSON(ans);
                if (ans.status == "error") modalWindow('<div class="modal_content error">' + ans.message + '</div>');
                if (ans.status == "success") {
                    modalWindow('<div class="modal_content">' + ans.message + '</div>');
                    $('.wrap_auth').hide(0);
                }
            }
            send($(this), suc);
        }
    })

    $('.open_hidden').click(function(){
        event.preventDefault();
        $(this).parent().children('.hidden').toggle('100')
    })

});

function send(form, suc=null) {
    event.preventDefault();
    act = form.attr('action');
    met = form.attr('method');
    mas = form.serializeArray();
    name = form.find(':submit').attr('name');
    mas.push({ name: name, value: '' });
    sendAjax(act, met, mas, suc);
}

function sendAjax(act, met, mas, suc) {
    $.ajax({
        type: met,
        url: act,
        data: mas,
        success: suc
    });
}

function modalWindow(message){
    $('body').append('<div class="modal_wrap"><a href="#modal_close" class="modal_close"></a><div class="modal_wrap_table"><div class="modal_wrap_table-cell"><div class="modal_container">'+message+'</div></div></div></div>');
    $('.modal_wrap').css({
        'display': 'block',
    })
    $('.modal_wrap').animate({
        'opacity': '1'
    }, 500);
}

function closeModal(modal){
    modal.animate({opacity: 0 }, 500);
    setTimeout(function() {
        modal.remove();
    },500);
}

$('html').on('click', '.modal_wrap', function(e){
    var div = $(".modal_container, .none_close");
    if (!div.is(e.target) && div.has(e.target).length === 0) {
        closeModal($(this));
    }
});

function formValidate(form){
    hasEmpty = true;
    var pattern = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    form.find('input, textarea').each(function() {
        
        if (typeof $(this).attr('required') != "undefined") {
            if ($(this).val() == '') {
                $(this).addClass('error'); 
                hasEmpty = false;
            }
        }
        if ($(this).attr('type') == 'email') {
            if (!pattern.test($(this).val())) {
                hasEmpty = false;
                $(this).addClass('error');
            }
        }  
    });
    setTimeout(function() {
        form.find('input, textarea').removeClass('error');
    }, 1000);
    return hasEmpty;
}
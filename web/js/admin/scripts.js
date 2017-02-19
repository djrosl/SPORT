(function(){
    val = 1;
    $('#all').change(function(){
       $('table input[type="checkbox"]').prop('checked',val);
        val = !val;
    });

    $('select[name="state_sort"]').change(function(){
        var state = $(this).find('option:checked').text();
        if(state != 'Все') {
            console.log(state);
            $('.prod-group-item').addClass('hidden');
            $('.prod-group-item h3:contains("'+state+'")').parents('.prod-group-item').removeClass('hidden');
        } else {
            $('.prod-group-item').removeClass('hidden');
        }
    });

    $('.show-nutrients').click(function(e){
        e.preventDefault();
        var that = this;
        var id = $(this).attr('title');
        $.get('/admin/main/get-nutrients?id='+id, function(data){
            var html = '<table class="table table-condensed">';
            $.each(data, function(){
                html+='<tr><td>'+this.parent.title_ru+'</td><td>'+this.value+' '+this.parent.unit+'</td></tr>';
            });
            html+='</table>';

            $(that).parent().prev().append(html);
            $(that).hide();
        });
    });

    setTimeout(function(){
        $('.nav.submenu.collapse').removeClass('collapse')
    }, 100)

    $('.open_subgrp').click(function(e){
        e.preventDefault();
        $(this).next().slideToggle(300);
    })
})($);



var lastChecked = null;

$(document).ready(function() {
    var $chkboxes = $('input[type="checkbox"]');
    $chkboxes.click(function(e) {
        if(!lastChecked) {
            lastChecked = this;
            return;
        }

        if(e.shiftKey) {
            var start = $chkboxes.index(this);
            var end = $chkboxes.index(lastChecked);

            $chkboxes.slice(Math.min(start,end), Math.max(start,end)+ 1).prop('checked', lastChecked.checked);

        }

        lastChecked = this;
    });
});
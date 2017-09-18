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
    });


    $('.saveTranslation').click(function(e){
        e.preventDefault();
        var val = $(this).prev().val();
        var id = $(this).data('id');

        $.post('/admin/product/save-translation', {
            val: val,
            id: id
        }, function(data){
            console.log(data)
        })
    });

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


    $('body').on('copy', '.select2-search__field', function(e){
        e.preventDefault();
        copyToClipboard($(this).parents('.select2-container').prev().val().join(', '));
    });

    function copyToClipboard(text) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(text).select();
        document.execCommand("copy");
        $temp.remove();
    }

    $('body').on('paste', '.select2-search__field', function(e){
        e.preventDefault();
        var pastedData = e.originalEvent.clipboardData.getData('text');
        $(this).parents('.select2-container').prev().val(pastedData.split(', ').map(function(v){return parseInt(v);})).trigger('change');
    });
});
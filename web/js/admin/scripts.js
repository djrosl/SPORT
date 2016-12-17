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
})($);
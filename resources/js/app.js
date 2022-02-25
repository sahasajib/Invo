require('./bootstrap');
window.$ = window.jQuery = require("jquery");

import Alpine from 'alpinejs';
import jquery from 'jquery';

window.Alpine = Alpine;

Alpine.start();
jquery(document).ready(function($){
    setTimeout(()=>{
        $('#status_message').slideUp('slow');
    },2000);

    //filter task
    $('#tesk_filter_btn').on('click',function(){
        var text = $(this).text();
        if (text == 'Filter') {
            $(this).text('Close Filter');
        }
        if (text == 'Close Filter') {
            $(this).text('Filter');
        }
        $('#task_filter').slideToggle('slow');
    });
});
CKEDITOR.replace('description');

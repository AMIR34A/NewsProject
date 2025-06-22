$(document).ready(function() { 
 
    //انتخاب لینک با نام مودال
    $('a[name=modal]').click(function(e) {
        //لغو حالت پیش فرض عملکرد لینک
        e.preventDefault();
        //دریافت آیدی عنصر پاپ آپ
        var id = $(this).attr('href');
     
        // دریافت طول و عرض صفحه نمایش
        var maskHeight = $(document).height();
        var maskWidth = $(window).width();
     
        // تنظیم طول و عرض ماسک به اندازه صفحه نمایش
        $('#mask').css({'width':maskWidth,'height':maskHeight});
         
        //اعمال افکت نمایش تدریجی بر روی ماسک      
        $('#mask').fadeIn(1000);   
        $('#mask').fadeTo("slow",0.8); 
     
        // دریافت طول و عرض پنجره مرورگر
        var winH = $(window).height();
        var winW = $(window).width();
               
        // تنظیم محل باز شدن پاپ آپ در مرکز صفحه
        $(id).css('top',0);
        $(id).css('left',0);
     
        //اعمال افکت نمایش تدریجی پاپ آپ
        $(id).fadeIn(2000);    
    });
     
    //رویداد دکمه بستن پاپ آپ
    $('.window .close').click(function (e) {
        // لغو حالت پیش فرض عملکرد لینک
        e.preventDefault();
        $('#mask, .window').hide();
    });    
     
    //بسته شدن پاپ آپ با کلیک روی ماسک اطراف آن
    $('#mask').click(function () {
        $(this).hide();
        $('.window').hide();
    });
});
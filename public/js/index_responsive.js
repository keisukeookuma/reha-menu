$('.menu-trigger').on('click',function(){
    if($(this).hasClass('active')){
      $(this).removeClass('active');
      $('.hamburger-nav').slideUp();
      $(this).html('<p>自主トレを選択</p>')
    } else {
      $(this).addClass('active');
      $('.hamburger-nav').slideDown();
      $(this).html('<p>閉じる</p>')
    }
});

$(function(){
    var x = $(window).width();
    var y = 640;
    if (x > y) {
        $('.hamburger-nav').addClass('row');
    }
});

$(window).resize(function(){
    //windowの幅をxに代入
    var x = $(window).width();
    //windowの分岐幅をyに代入
    var y = 640;
    if (x > y) {
        $('.hamburger-nav').addClass('row');
    }else{
        $('.hamburger-nav').removeClass('row');
    }
});

// mainのスクロールをスマホでは表示なしにする
var mq = window.matchMedia( "(min-width: 670px)" );
if (mq.matches) {
    $('.preview-scroll').addClass('overflow-auto preview-scroll-size');
} else {
    $('.preview-scroll').removeClass('overflow-auto preview-scroll-size');
}
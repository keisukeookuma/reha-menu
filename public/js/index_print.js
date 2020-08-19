//ブラウザの判別
var userAgent = window.navigator.userAgent.toLowerCase();

function scrollToTop() {
    scrollTo(0, 0);
}

function IePrint(){
    var hide_elm = $('.header,.footer,.sidebar');
    hide_elm.addClass('print');
    $('.print-preview').append($('#preview').html());
    window.print();

    if(contentsCount === 3){
        $('div.item').addClass('contents3');
        hide_elm.removeClass('print');
    }else if(contentsCount === 2){
        $('div.item').addClass('contents2');
        hide_elm.removeClass('print');
    }else if(contentsCount === 1){
        $('div.item').addClass('contents1');
        hide_elm.removeClass('print');
    }
    // $('.print-preview').children().remove();
};


$(".downloadBtn").click(function(){
    if(userAgent.match(/(msie|MSIE)/) || userAgent.match(/(T|t)rident/)){
        alert('Internet Explorerではダウンロードは行なえません')
    }else{
        scrollToTop();
        $('.item-delete-btn').addClass('d-none');
        html2canvas(document.querySelector("#preview"),{scale:4}).then(function(canvas){
            $('.preview-print').append(canvas);
            
                let downloadEle = document.createElement("a");
                downloadEle.href = canvas.toDataURL("image/png");
                downloadEle.download = "reha-menu.png";
                downloadEle.click();
        });
        $('canvas').remove();
        $('.item-delete-btn').removeClass('d-none')
    }
});

$("#print").click(function(print){
    if(userAgent.match(/(msie|MSIE)/) || userAgent.match(/(T|t)rident/)){
        IePrint()
    }else{
        $('.item-delete-btn').addClass('d-none');
        var hide_elm = $('.header,.footer');
        hide_elm.addClass('print');
        html2canvas(document.querySelector("#preview"),{scale:4}).then(function(canvas){
            var imageData = canvas.toDataURL();
            $('.print-preview')
                .html("<img id='Image' src=" + imageData + " style='width:100%;'></img>")
        });
        setTimeout(function() {
            window.print();
        }, 150);
        $('.print-preview').children().remove();
        $('.item-delete-btn').removeClass('d-none');
    }
});
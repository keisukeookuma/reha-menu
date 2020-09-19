function navSampleList(data_item_name, data_img, data_caption){
    var li=$("<li class= 'item-sample col-sm-3 col-md-12 col-xl-5 p-2'>");
    var navSampleName = $("<div class='item_name text-center'>");
    var previewName = $("<p class='preview-name mb-0' contentEditable='true'>");
    previewName.append(data_item_name);
    navSampleName.append(previewName);
    var navSampleImg = $("<div class='nav_sample_img text-center'>");
    navSampleImg.append("<img src=/storage/img/" + data_img +" alt='リハビリイラスト' oncontextmenu='return false;'>");
    var navSampleCaption = $("<div class='item_caption d-none'>");
    var previewCaption = $("<pre contentEditable='true' class='preview-caption mt-1 mb-0'>");
    var text = '';
    $.each(data_caption,function( index, value ) {text += '<li>' + value + '</li>'});
    previewCaption.append("<ol class='mb-0'>" + text + "</ol>")
    navSampleCaption.append(previewCaption);
    return li.append(navSampleName).append(navSampleImg).append(navSampleCaption);
}

function makeItemName(itemSample){
    var sampleItemName = $('<div>');
    sampleItemName.addClass('item_name text-center');
    //IEでは回数表示をなしにする
    if((userAgent.match(/(msie|MSIE)/) || userAgent.match(/(T|t)rident/))===null){
        sampleItemName.append("<p class='position-top-right' contentEditable='true'>回数：　　回</p>");
    }
    sampleItemName.append(itemSample);
    return sampleItemName;
}

function makeItemImg(itemSample){
    var sampleItemImg = $("<div>");
    sampleItemImg.addClass("item-img text-center");
    sampleItemImg.append(itemSample);
    return sampleItemImg;
}

function makeItemCaption(itemSample) {
    var sampleItemCaption =$("<div>");
    sampleItemCaption.addClass("item-caption p-0");
    sampleItemCaption.append(itemSample);
    return sampleItemCaption
}

function makeDeleteButton(item) {
    var sampleButton =$('<button>');
    var deleteIcon = $("<svg class='bi bi-x' width='1em' height='1em' viewBox='0 0 16 16' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M11.854 4.146a.5.5 0 010 .708l-7 7a.5.5 0 01-.708-.708l7-7a.5.5 0 01.708 0z' clip-rule='evenodd'/><path fill-rule='evenodd' d='M4.146 4.146a.5.5 0 000 .708l7 7a.5.5 0 00.708-.708l-7-7a.5.5 0 00-.708 0z' clip-rule='evenodd'/></svg>");
    sampleButton.addClass('noprint item-delete-btn').html(deleteIcon);
    sampleButton.on('click',function(){
        item.remove();
        this.remove();
    });
    return sampleButton;
}  

function makeItem(itemName, itemCaption, itemImg){
    var sampleItem = $("<div>");
    sampleItem.addClass("item");
    var itemContents = $("<div>");
    itemContents.addClass("contents3-d-flex");
    itemContents.append(itemImg).append(itemCaption);
    return sampleItem.append(itemName).append(itemContents);
}

//ajax contentsをメニュー数ごとに分ける
function addContentsClass(item, contentsCount){
    if(contentsCount === 3){
      item.find("div.contents3-d-flex").addClass("d-flex");
      item.addClass("contents3");
      item.find(".item-img").addClass("col-7 p-0");
      item.find(".item-caption").addClass("col-5");
    }else if(contentsCount === 2){
      item.addClass("contents2");
      item.find(".item-img").addClass("p-0");
    }else if(contentsCount === 1){
      item.addClass("contents1");
      item.find(".position-top-right");
      item.find(".item-img").addClass("mt-4 p-1");
    }
    return item;
  }

// template用
function navSampleTemplateList(data_item_name, data_img, data_caption, templateName){
    var navSampleName = $("<div class='item_name text-center d-none'>");
    var previewName = $("<p class='preview-name mb-0'>");
    previewName.append(data_item_name);
    navSampleName.append(previewName);
    var navSampleImg = $("<div class='nav_template_img col-4 p-1'>");
    navSampleImg.append("<img src=/storage/img/" + data_img +" alt='リハビリイラスト' oncontextmenu='return false;'>");
    var navSampleCaption = $("<div class='item_caption d-none'>");
    var previewCaption = $("<pre contentEditable='true' class='preview-caption mt-1 mb-0'>");
    var text = '';
    $.each(data_caption,function( index, value ) {text += '<li>' + value + '</li>'});
    previewCaption.append("<ol class='mb-0'>" + text + "</ol>")
    navSampleCaption.append(previewCaption);
    return templateName.append(navSampleName).append(navSampleImg).append(navSampleCaption);
}

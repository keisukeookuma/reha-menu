$(function(){

  var contentsCount = 3;
  $('#choice-contents-1').click(function(){
    $('.item').remove();
    contentsCount = 1; 
  });
  $('#choice-contents-2').click(function(){
    $('.item').remove();
    contentsCount = 2; 
  });
  $('#choice-contents-3').click(function(){
    $('.item').remove();
    contentsCount = 3; 
  });

  //item表示
  var offset = 0;
  $('.search-form').change(function(){
    offset = 0;
    $('#all_show_result').children().remove();
    getAllData($(this).val(), offset);
  });
  
  // view moreの追加
  $('.view_more').click(function(){
    offset = $(".item-sample").length;
    var searchWord = $('.search-form').val();
    getAllData(searchWord, offset);
  });

  getAllData('',offset);

  // template表示
  $('.template_all').one('click', function(){
    getTemplateData('');
  });

  $('.template_search').change(function(){
    $('#template_list').children().remove();
    var templateWord = $('option:selected').val();
    getTemplateData(templateWord)
  });
  
  
  //ajax
  function getAllData(search_word, offset){
    $.ajax({
      url:"/ajax/",
      data:{
        search_word : search_word,
        offset : offset,
        type : 'item'
      },
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type:'POST',
      datatype:'json',
      success: function(data){
        for(var i=0 ;i<data.length;i++){
          var sampleList = navSampleList(data[i].item_name, data[i].img, data[i].caption);
          $('#all_show_result').append(sampleList);
        }

        $(".item-sample").off().click(function(){
          var itemName = makeItemName($(this).find('.item_name').html());
          var itemCaption = makeItemCaption($(this).find('.item_caption').html());
          var itemImg = makeItemImg($(this).find('.nav_sample_img').html());
          var item = makeItem(itemName, itemCaption, itemImg);
          var deleteButton = makeDeleteButton(item);
          item.append(deleteButton);
          
          if(contentsCount === 3 && $("#preview").find("div.item").length === 1){
            itemImg.addClass("order-2");
            itemCaption.addClass("order-1");
          }
//*
          item = addContentsClass(item, contentsCount);

          if($("#preview").find("div.item").length < contentsCount){
            $("#preview").append(item);
          }
        })
      },
      error: function(){
        console.log("通信失敗");
        console.log(data);
      }
    });
  }

  function getTemplateData(template_word){
    $.ajax({
      url:"/ajax/",
      data:{template_word : template_word,
            type : 'template'
      },
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type:'POST',
      datatype:'json',
      success: function(data){
        console.log(data);
        $.each(data,function(index,value){
          var sampleTemplateList = $('<li class="nav-item template">');
          var templateLink = $("<a class='nav-link template-sample d-flex flex-wrap "+index+"' href='#'></a>")
          templateLink.append("<p class='col-12 mb-1 '>"+index+"</p>");
          $.each(value, function(index,val){ 
            var sampleList = navSampleTemplateList(val.item_name, val.img, val.caption, templateLink);
            templateLink.append(sampleList);
          });
          
          sampleTemplateList.append(templateLink);
          $('#template_list').append(sampleTemplateList);
        });

        $('.template-sample').off().click(function(){
          var len = $(this).find('.item_name').length;
          for (var i=0; i<len; i++) {
            var itemName = makeItemName($(this).find('.item_name').eq(i).html());
            var itemCaption = makeItemCaption($(this).find('.item_caption').eq(i).html());
            var itemImg = makeItemImg($(this).find('.nav_template_img').eq(i).html());
            var item = makeItem(itemName, itemCaption, itemImg);
            var deleteButton = makeDeleteButton(item);
            item.append(deleteButton);

            if(contentsCount === 3 && $("#preview").find("div.item").length === 1){
              itemImg.addClass("order-2");
              itemCaption.addClass("order-1");
            }

            item = addContentsClass(item, contentsCount);

            if($("#preview").find("div.item").length < contentsCount){
              $("#preview").append(item);
            }
          }
        });
      },
      error: function(){
        console.log("通信失敗");
        console.log(data);
      }
    })
  };
});
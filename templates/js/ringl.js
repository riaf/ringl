google.load('jquery', '1');
google.setOnLoadCallback(function(){
  var reloadMessages = function(){
    $.ajax({
      url: messages_url,
      data: {since_id: since_id},
      error: function(XMLHttpRequest, textStatus, errorThrown){
        console.log(XMLHttpRequest);
        console.log(textStatus);
        console.log(errorThrown);
        setTimeout(reloadMessages, 1000);
      },
      success: function(data, messages){
        console.log(data);
        console.log(messages);
        jQuery.each(data, function(){
          if(this.id > since_id){
            since_id = this.id;
          }
          $('#messages').append(
            '<dt id="'+ this.id+ '"><span class="name">'+ this.name+ '</span><span class="date">'
            + this.create_date+ '</span></dt>'
            + '<dd>'+ this.description+ '</dd>'
          ).scrollTop($(window).height());
        });
        setTimeout(reloadMessages, 200);
      },
      dataType: 'jsonp'
    });
  }
  
  $('#fields').submit(function(event){
    var name = $(this).children('input[name=name]').val();
    var description = $(this).children('textarea').val();
    $.post($(this).attr('action'), {name: name, description: description}, function(){
      $('#fields').children('textarea').val('');
      setTimeout(reloadMessages, 200);
    });
    event.preventDefault();
    return false;
  });
  
  $('#messages').css('height', $(window).height() - 180).scrollTop($(window).height());
  $(window).bind("resize", function(e){
    $(window).css('height', $(window).height() - 180);
  });
  
  setTimeout(reloadMessages, 200);
});
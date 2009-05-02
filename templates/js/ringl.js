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
          ).scrollTop(999999);
        });
        setTimeout(reloadMessages, 200);
      },
      dataType: 'jsonp'
    });
  }
  
  $('#fields').submit(function(event){
    var name = $('#fields input[name=name]').val();
    var description = $('#fields textarea').val();
    $.post($('#fields').attr('action'), {name: name, description: description}, function(){
      $('#fields textarea').val('');
      setTimeout(reloadMessages, 200);
    });
    event.preventDefault();
    return false;
  });
  $('#fields textarea').keyup(function(e){
    if(e.keyCode == 13 && e.shiftKey == false){
      $('#fields').submit();
    }
  });
  
  $('#messages').css('height', $(window).height() - 180).scrollTop(999999);
  $(window).bind("resize", function(e){
    $(window).css('height', $(window).height() - 180);
  });
  
  setTimeout(reloadMessages, 200);
});
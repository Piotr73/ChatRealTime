<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simple Realtime Message</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
  </head>
  <style>
  body { padding-top: 70px; }
  
  #load { height: 100%; width: 100%; }

  
  .RbtnMargin { margin-left: 5px; }
  
  
  </style>
  <body>
<!--    <div id="load">Please wait ...</div>-->

<nav class="navbar navbar-default navbar-fixed-top " role="navigation">
  <div class="container">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="{{ URL::to('/') }}">Mensajería Instantánea</a>
  </div>
  </div>
</nav>
    
<center><a href="{{ URL::to('message') }}">Ver la lista de mensajes</a></center><br />
<div class="container">
  <div class="row">
    <div id="notif"></div>
      <div class="col-md-6 col-md-offset-3">
        <div class="well well-sm">
          <form class="form-horizontal">
          <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
          <fieldset>
            <legend class="text-center">Contáctanos</legend>
            <div class="form-group">
              <label class="col-md-3 control-label" for="name">Nombres:</label>
              <div class="col-md-9">
                <input id="name" type="text" placeholder="Your name" class="form-control" autofocus>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label" for="email">E-mail: </label>
              <div class="col-md-9">
                <input id="email" type="email" placeholder="Your email" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label" for="subject">Asunto:</label>
              <div class="col-md-9">
                <input id="subject" type="text" placeholder="Your subject" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label" for="message">Mensaje:</label>
              <div class="col-md-9">
                <textarea class="form-control" id="message" name="message" placeholder="Please enter your message here..." rows="5"></textarea>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12 text-right">
                <button type="button" id="submit" class="btn btn-primary">Enviar</button>
              </div>
            </div>
          </fieldset>
          </form>
        </div>
      </div>
  </div>
</div>

<hr>
<footer class="text-center">Copyright Piotr73</footer>
<hr>
<script src="{{asset('js/jquery-1.11.2.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('node_modules/socket.io-client/dist/socket.io.js')}}"></script>
<script>
  $(document).ready(function(){

    $("#load").hide();

    $("#submit").click(function(){
      
       $( "#load" ).show();
       var dataString = {name : $("#name").val(),email : $("#email").val(),subject : $("#subject").val(),message : $("#message").val()};
       var token = $("input[name=_token]").val();
      
        $.ajax({
            url: '',
            headers: {'X-CSRF-TOKEN':token},
            type:'post' ,
            datatype: 'json',
            data: dataString,
            success: function(data){
              
              $( "#load" ).hide();
              $("#name").val('');
              $("#email").val('');
              $("#subject").val('');
              $("#message").val('');

              
              if(data.success == true){
                  $("#notif").html(data.notif);
                  console.log(data.success);
                  var socket = io.connect( 'http://'+window.location.hostname+':3000' );
                  console.log(socket);

                  socket.emit('new_count_message', { 
                    new_count_message: data.new_count_message
                  });

                  socket.emit('new_message', { 
                    name: data.name,
                    email: data.email,
                    subject: data.subject,
                    created_at: data.created_at,
                    id: data.id
                  });
              }
            }

        });

    });

  });
    </script>
  </body>
</html>

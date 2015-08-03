<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('/img/icon.png') }}">
    {{ HTML::style('css/bootstrap.min.css'); }}
    {{ HTML::style('css/main.css'); }}
    {{ HTML::script('js/jquery.min.js'); }}
    {{ HTML::script('js/bootstrap.min.js'); }}
    {{ HTML::script('js/send_ajax.js')}}
</head>
<body class="login_body">
    <div class="login_block">
        <h2>GuradiX Clound Backend</h2>
        <hr/>
        <div id="error-information" class="alert alert-danger"></div>
        <form role="form" id="login_form">
            <div class="form-group">
                <label for="InputUsername">Username</label>
                <input type="text" class="form-control" id="InputUsername" placeholder="Enter Username">
            </div>
            <div class="form-group">
                <label for="InputPassword">Password</label>
                <input type="password" class="form-control" id="InputPassword" placeholder="Enter Password">
            </div>
            <button type="submit" class="btn btn-info pull-right">Login</button>
        </form>
    </div>
    <script>
    $(document).ready(function(e){
        // hide error information element
        $('#error-information').hide();
        // submit action if "enter" key pressed or mouse submit clicked 
        $('#login_form').submit(function(ev){
            var username = $('#InputUsername').val();
            var password = $('#InputPassword').val();
            if(username===''||password==='') {
                animationRefresh("Username/Password can not empty.");
            }
            else {
                // send user credentials to backend
                ajaxSender(username, password);
            }
            // disable original submit action
            ev.preventDefault();
        });

        // send user credentials by ajax
        function ajaxSender(username, password) {
            var credentials = {
                'username': username,
                'password': password
            };
            sendAjax('/login',credentials, function(result){
                if (result==='Success') {
                    window.location.replace('/');
                } else {
                    $('#InputUsername').val('');
                    $('#InputPassword').val('');
                    animationRefresh(result);
                }            
            })
        }

        // animation show error message
        function animationRefresh(result) {
          var el=$('.login_block');
          var curHeight = el.height();
          $('#error-information').text(result).fadeIn('slow');
          var autoHeight=el.css('height','auto').height()+37;
          el.height(curHeight).animate({height: autoHeight}, 300);
        }      
    });
    </script>
</body>
</html>
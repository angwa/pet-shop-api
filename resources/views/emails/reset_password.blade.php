<!DOCTYPE html>
<html>
    <head>
        <title>Password reset</title>
        <style text="text/csss">
            body{
                margin:0;
                padding:0;
                background-color: rgb(232, 234, 237);
                text-align: center;
            }

            #token{
                color:#454B1B;
                width: 250px;
                margin:auto;
                padding: 20px;
                background-color: rgb(241, 243, 244);
            }
        </style>
    </head>
    <body>
        <h1>Password Reset</h1>
        <p>Hi <strong>{{$user->first_name}} {{$user->first_name}}</strong>, use the password reset token below to reset your password</p>
        <h1 id="token">{{$token}}</h1>
    </body>
</html>
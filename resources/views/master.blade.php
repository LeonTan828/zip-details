<!--This is the master template-->

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>@yield('title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .pad-bottom {
                padding-bottom: 5em;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-left {
                position: absolute;
                left: 10px;
                top: 18px;
            }

            .text-center {
                text-align: center;
            }

            .title {
                font-size: 84px;
                text-align: center;
                padding-top: 1em;
                padding-bottom: 1em;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            a:hover {
                color: #5ac18e;
            }

            .alert {
                color: #ee608b;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            table {
                border: 1px rgb(230,230,230) solid;
                border-radius: 20px;
                border-collapse: collapse;
            }

            table td {
                padding: 0.5em;
                border: 1px rgb(230,230,230) solid;
            }

            table th {
                padding: 0.5em;
                border: 1px rgb(230,230,230) solid;
            }

            table tr:first-child th:first-child{
                border-top-left-radius: 20px;
            }
        </style>
    </head>
    <body>
        <div class="title m-b-md">Zip Code to Location</div>
        <div class="flex-center position-ref pad-bottom">
            <div class="text-center">

                @yield('content')

            </div>

        </div>
        

    </body>
</html>
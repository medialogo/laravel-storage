<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

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
                /* margin: 0; */
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
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

            .m-b-md {
                margin-bottom: 30px;
            }
            th {
                background-color: #999;
                padding:10px;
            }
            td {
                background-color: #eee;
                padding:10px;
            }
        </style>
    </head>
    <body>
        <h1>{{$path}}</h1>
        @if ($path != 'C:/doc/')
        <a href="{{url()->previous()}}">戻る</a>
        @endif
        <p>{{$dcount}} dirs; &nbsp;&nbsp; {{$fcount}} files</p>
        <table>
        <tr><th>url</th><th>size</th><th>last modified</th></tr>
        @if ($dirs)
            @foreach($dirs as $item)
            <tr>
                <td>
                @if ($item['size'])
                <a href="{{url()->current()}}/{{$item['url']}}">{{$item['url']}}</a></td>
                @else
                {{$item['url']}}
                @endif
                <td>{{$item['size']}}</td>
                <td>{{$item['lastModified']}}</td>
            </tr>
            @endforeach
        @endif
        @if ($files)
            @foreach($files as $item)
            <tr>
                <td>
                <!-- <a href="file:///{{$item['path']}}"> -->
                {{$item['url']}}
                <!-- </a> -->
                </td>
                <td>{{$item['size']}}</td>
                <td>{{$item['lastModified']}}</td>
            </tr>
            @endforeach
        @endif
        </table>

    </body>
</html>

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
        <script type="text/javascript">
            function setFileName() {
                var files = document.getElementById('file').files;
                var names = '';
                if (files.length > 0) {
                    names = files[0].name;
                    for (var i=1; i< files.length; i++) {
                        names += '<br>' + files[i].name;
                    }
                }
                document.getElementById('filename').value = names;
                console.log(names);
            }
            function countItems() {
                var checked = 0;
                var nameList = [];
                if (document.form2.dirItems) {
                    document.form2.dirItems.forEach(function(item) {
                        if (item.checked) {
                            checked++;
                        }
                    }); 
                }
                if (document.form2.fileItems) {
                    var i = 0;
                    document.form2.fileItems.forEach(function(item) {
                        if (item.checked) {
                            checked++;
                            nameList.push(document.form2.fileItems[i].id)
                        }
                        i++;
                    }); 
                }
                console.log("checked: " + checked);
                console.log( nameList.join(';'));

                document.form2.selectedFiles.value =  nameList.join(';');
                var htmlText = ''
                if (checked) {
                    htmlText = checked + '個の項目が選択されました。' 
                } else {
                    htmlText  = '項目が選択されていません'
                }
                document.getElementById("selectedInfo").innerHTML =  htmlText
            }
        </script>
    </head>
    <body>
        <h1>{{$path}}</h1>
        <form method="POST" action="/disk/FS/upload/" enctype="multipart/form-data">

        {{ csrf_field() }}

        <div>
            <label for="file">ファイルを選択して、[アップロード]ボタンを押してください</label><br>
            <input type="file" id="file" name="file" onchange="setFileName()">
            <input type="hidden" id="filename" name="filename" />
            <input type="hidden" id="currentdir" name="currentdir" value="{{url()->current()}}"/> 
        </div>
        <div>
            <input type="submit" value="アップロード">
        </div>
        </form>
        <p>{{$dcount}} dirs; &nbsp;&nbsp; {{$fcount}} files @if ($parent)<a href="{{$parent}}">上へ</a>@endif
        <div id="selectedInfo"></div>

        <form name="form2" action="/disk/FS/delete/" method="POST">
        {{ csrf_field() }}
        選択された項目を <input type='submit' value='削除'>"
        <input type="hidden" id="selectedFiles" name="selectedFiles"/> 
        <input type="hidden" id="currentdir2" name="currentdir2" value="{{url()->current()}}"/> 
        <table>
        <tr><th></th><th>url</th><th>size</th><th>last modified</th></tr>
        @if ($dirs)
            @foreach($dirs as $item)
            <tr>
            <td><input type="checkbox" id="dirItems" name="dirItems"  onclick="countItems()"></td>
                <td>
                @if ($item['size'])
                <a href="{{url()->current()}}/{{$item['url']}}">{{$item['url']}}</a></td>
                @else
                {{$item['url']}}
                @endif
                <td>&nbsp;</td>
                <td>{{$item['lastModified']}}</td>
            </tr>
            @endforeach
        @endif
        @if ($files)
            @foreach($files as $item)
            <tr>
            <td><input type="checkbox" id="{{$item['url']}}" name="fileItems" onclick="countItems()"></td>
                <td>
                <!-- <a href="file:///{{$item['path']}}"> -->
                {{$item['url']}}
                <!-- </a> -->
                </td>
                <td style="text-align:right">{{number_format($item['size'])}}</td>
                <td>{{$item['lastModified']}}</td>
            </tr>
            @endforeach
        @endif
        </table>
        </form>
    </body>
</html>

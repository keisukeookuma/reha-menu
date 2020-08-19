<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>リハビリメニュー作成</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        .width-30{
            width: 30px;
        }

        .width-100{
            width: 100px;
        }

        .width-300{
            width: 300px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>ご意見まとめ</h2>
        <table border="1">
            <tr>
                <th class="width-30">id</th>
                <th class="width-100">name</th>
                <th class="width-300">opinion</th>
            </tr>
            @foreach($opinions as $opinion)
            <tr>
                <td>{{ $opinion->id }}</td>
                <td>{{ $opinion->name }}</td>
                <td>{{ $opinion->opinion }}</td>
            </tr>
            @endforeach
        </table>
        
    </div>
</body>
</html>
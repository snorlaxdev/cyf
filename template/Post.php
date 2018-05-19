<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Soal Nomor 7</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <style>
        body {
            padding-top: 5em;
            background-color: #ccc;
        }
    </style>
</head>
<body>
    <div class="container">
    <div class="card">
        <div class="card-header"><?= $data->title ?></div>
        <div class="card-body">
            <h4 class="card-title"><b><?= $data->title ?></b></h4>
            <h6 class="card-subtitle mb-2 text-muted">Ditulis oleh <?= $data->username ?></h6>
            <p class="card-text">
                <?= $data->content ?>
            </p>
            <h5>Komentar</h5>
            <div class="list-group">
                <?php
                    foreach ($data->comments as $commentIndex) {
                        echo "<li class=\"list-group-item\">".$commentIndex->comment."</li>";
                    }
                ?>
            </div>
        </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>
</html>
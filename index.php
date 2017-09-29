<?php

    require_once "vendor/autoload.php";

    $perguntasERespostas    = new QuizSerie\Common\PerguntaResposta();
    $converterPerguntaHtml  = new QuizSerie\Util\ConverterPerguntaHtml();
    $listaDePerguntasERespostas = $perguntasERespostas->listar();

?>

<!DOCTYPE html>
<html>
<head>
    <title>DZ Estudio - Quiz</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <!-- Optional Bootstrap theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <!-- Include SmartWizard CSS -->
    <link href="assets/css/smart_wizard.min.css" rel="stylesheet" type="text/css" />

    <!-- Optional SmartWizard theme -->
    <link href="assets/css/smart_wizard_theme_arrows.css" rel="stylesheet" type="text/css" />

</head>
<body>
    <div class="container">
        <h3>
            <strong>
                <span class="text-info">
                    <img class="img-thumbnail" style="width: 4%" src="assets/images/dz-estudio.png" alt=""/> Quiz - Que série melhor representa você?
                </span>
            </strong>
        </h3>
        <form action="resultado.php" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">

            <!-- SmartWizard html -->
            <div id="smartwizard" class="sw-main sw-theme-arrows">
                <ul>
                    <li><a href="#step-1">Pergunta n° 1</a></li>
                    <li><a href="#step-2">Pergunta n° 2</a></li>
                    <li><a href="#step-3">Pergunta n° 3</a></li>
                    <li><a href="#step-4">Pergunta n° 4</a></li>
                    <li><a href="#step-5">Pergunta n° 5</a></li>
                </ul>

                <div class="">
                    <?php foreach ($listaDePerguntasERespostas as $pergunta) {
                        echo $converterPerguntaHtml->converter($pergunta);
                    } ?>
                </div>
            </div>
        </form>
    </div>

    <!-- Include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include jQuery Validator plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>
    <!-- Include SmartWizard JavaScript source -->
    <script type="text/javascript" src="assets/js/jquery.smartWizard.min.js"></script>
    <!--  -->
    <script type="text/javascript" src="assets/js/wizardConfig.js"></script>
</body>
</html>

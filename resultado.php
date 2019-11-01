<?php

    require_once "vendor/autoload.php";

    $resultadoQuiz = new QuizSerie\Common\ResultadoQuiz();
    $post = $_POST;
    $serieMelhorRepresenta = null;

    if (!empty($post) || (count($post) == 5)) {
        $respostas = array_values($post);
        $serieMelhorRepresenta = $resultadoQuiz->avaliarRespostas($respostas);
    }
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

        <div class="row">
            <?php if (empty($serieMelhorRepresenta)) { ?>
            <div class="col-md-12">
                <div class="alert alert-warning" role="alert">Ops! Nenhuma série localizada.</div>
            </div>
            <?php } ?>

            <?php if (!empty($serieMelhorRepresenta)) { ?>
            <div class="col-md-12">
                <div class="panel panel-default  panel--styled">
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <img class="img-responsive" src="<?php echo sprintf('assets/images/series/%s.jpg', $serieMelhorRepresenta['referencia']); ?>" alt=""/>
                            </div>
                            <div class="col-md-8">
                                <h2><?php echo $serieMelhorRepresenta['serie']; ?></h2>
                                <p><?php echo $serieMelhorRepresenta['frase']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>

            <div class="col-md-12">
                <a class="btn btn-sm btn-info btn-lg" href="/">Responder novamente o quiz</a>
            </div>
        </div>
    </div>
</body>
</html>

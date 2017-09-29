<?php

namespace QuizSerie\Tests\Unit\Common;

use PHPUnit\Framework\TestCase;
use QuizSerie\Common\ResultadoQuiz;
use QuizSerie\Common\Serie;

class ResultadoQuizTest extends TestCase
{
    private $class  = null;
    private $series = null;

    public function setUp()
    {
        $this->class    = new ResultadoQuiz();
        $this->series   = new Serie();
    }

    public function testAvaliarRespostas()
    {
        $respostas = ['a', 'b', 'b', 'c', 'e'];
        $respostaEsperada = (array) $this->series->pesquisarPorReferencia('b');
        $this->assertEquals($respostaEsperada, $this->class->avaliarRespostas($respostas));

        $respostas = ['a', 'b', 'c', 'd', 'e'];
        $respostaEsperada = (array) $this->series->pesquisarPorReferencia('e');
        $this->assertEquals($respostaEsperada, $this->class->avaliarRespostas($respostas));
    }
}

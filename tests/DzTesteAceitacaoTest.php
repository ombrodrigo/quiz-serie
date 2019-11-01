<?php

namespace QuizSerie\Tests;

use PHPUnit\Framework\TestCase;
use QuizSerie\Common\ResultadoQuiz;
use QuizSerie\Common\Serie;

class DzTesteAceitacaoTest extends TestCase
{
    private $class  = null;

    public function setUp()
    {
        $this->class = new ResultadoQuiz();
    }

    public function testTeste1()
    {
        $respostas = ['c', 'c', 'a', 'e', 'e'];
        $resultadoEsperado = 'Silicon Valley';
        $resultado = $this->class->avaliarRespostas($respostas);
        $this->assertEquals($resultadoEsperado, $resultado['serie']);
    }

    public function testTeste2()
    {
        $respostas = ['E', 'e', 'a', 'C', 'c'];
        $resultadoEsperado = 'Lost';
        $resultado = $this->class->avaliarRespostas($respostas);
        $this->assertEquals($resultadoEsperado, $resultado['serie']);
    }

    public function testTeste3()
    {
        $respostas = ['E', 'D', 'C', 'B', 'a'];
        $resultadoEsperado = 'House of Cards';
        $resultado = $this->class->avaliarRespostas($respostas);
        $this->assertEquals($resultadoEsperado, $resultado['serie']);
    }

    public function testTeste4()
    {
        $respostas = ['A', 'b', 'C', 'd', 'E'];
        $resultadoEsperado = 'Silicon Valley';
        $resultado = $this->class->avaliarRespostas($respostas);
        $this->assertEquals($resultadoEsperado, $resultado['serie']);
    }

    public function testTeste5()
    {
        $respostas = ['A', 'A', 'A', 'B', 'B'];
        $resultadoEsperado = 'House of Cards';
        $resultado = $this->class->avaliarRespostas($respostas);
        $this->assertEquals($resultadoEsperado, $resultado['serie']);
    }

    public function testApenasUmResultado()
    {
        for ($numeroRepeticoes = 0; $numeroRepeticoes <= 20; $numeroRepeticoes++) {
            $respostas = $this->criarRespostaAleatoria();
            $resultado = $this->class->avaliarRespostas($respostas);

            // caso retorne um array com mais de um resultado, a chave "série" não existiria
            $this->assertArrayHasKey('serie', $resultado);
        }
    }

    private function criarRespostaAleatoria()
    {
        return array_map(function ($resposta) {
            $resposta = range('A', 'E');
            shuffle($resposta);
            return current($resposta);
        }, array_fill(0, 5, ''));
    }
}

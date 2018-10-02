<?php

namespace QuizSerie\Tests\Unit\Util;

use PHPUnit\Framework\TestCase;
use ReflectionMethod;
use QuizSerie\Util\ConverterPerguntaHtml;
use QuizSerie\Util\ConteudoJson;

class ConverterPerguntaHtmlTest extends TestCase
{
    private $class = null;

    public function setUp()
    {
        $this->class = new ConverterPerguntaHtml();
    }

    public function perguntasRespostasProvider()
    {
        $conteudoJson   = new ConteudoJson();
        $conteudo       = $conteudoJson->capturar('perguntas_respostas');
        return [[json_decode($conteudo)]];
    }

    /**
     * @dataProvider perguntasRespostasProvider
     */
    public function testCriaRadioButtonResposta($perguntasRespostas)
    {
        $perguntaResposta   = current($perguntasRespostas);
        $referencia         = $perguntaResposta->referencia;
        $respostas          = $perguntaResposta->respostas;
        $resposta           = end($respostas);
        $resultadoEsperado  = $this->criaRespostaEsperada($resposta, $referencia);

        $reflectionMethod = new ReflectionMethod(
            '\\QuizSerie\\Util\\ConverterPerguntaHtml', 'criaRadioButtonResposta');
        $reflectionMethod->setAccessible(true);
        $resultado = $reflectionMethod->invokeArgs($this->class, array((object) $resposta, $referencia));

        $this->assertEquals($resultadoEsperado, $resultado);
    }

    /**
     * @dataProvider perguntasRespostasProvider
     */
    public function testListaRespostas($perguntasRespostas)
    {
        $perguntaResposta   = current($perguntasRespostas);
        $referencia         = $perguntaResposta->referencia;
        $respostas          = $perguntaResposta->respostas;
        $resultadoEsperado  = $this->criaListaRespostaEsperada($respostas, $referencia);

        $reflectionMethod = new ReflectionMethod('\\QuizSerie\\Util\\ConverterPerguntaHtml', 'criaListaRespostas');
        $reflectionMethod->setAccessible(true);
        $resultado = $reflectionMethod->invokeArgs($this->class, array($respostas, $referencia));

        $this->assertEquals($resultadoEsperado, $resultado);
    }

    /**
     * @dataProvider perguntasRespostasProvider
     */
    public function testCriaPergunta($perguntasRespostas)
    {
        $perguntaResposta   = (array) current($perguntasRespostas);
        $resultadoEsperado  = $this->criaPerguntaEsperada($perguntaResposta);

        $reflectionMethod = new ReflectionMethod('\\QuizSerie\\Util\\ConverterPerguntaHtml', 'criaPergunta');
        $reflectionMethod->setAccessible(true);
        $resultado = $reflectionMethod->invokeArgs($this->class, array($perguntaResposta));

        $this->assertEquals($resultadoEsperado, $resultado);
    }

    /**
     * @dataProvider perguntasRespostasProvider
     */
    public function testConverter($perguntasRespostas)
    {
        $perguntaResposta   = (array) current($perguntasRespostas);
        $resultadoEsperado  = $this->criaPerguntaEsperada($perguntaResposta);
        $resultado          = $this->class->converter($perguntaResposta);
        $this->assertEquals($resultadoEsperado, $resultado);
    }

    private function criaRespostaEsperada($resposta, $referencia)
    {
        $resposta = (array) $resposta;
        $resultadoEsperado = '<div class="radio">' .
        '<label><input type="radio" name="pergunta@referencia" value="@resposta" required>@pergunta</label></div>';
        return str_replace(
            ['@referencia', '@resposta', '@pergunta'],
            [$referencia, key($resposta), current($resposta)],
            $resultadoEsperado
        );
    }

    private function criaListaRespostaEsperada($respostas, $referencia)
    {
        foreach ($respostas as &$resposta) {
            $resposta = $this->criaRespostaEsperada($resposta, $referencia);
        }

        $html = '<div id="form-step-@referencia" role="form" data-toggle="validator">' .
        '<div class="form-group">@respostas<div class="help-block with-errors"></div></div></div>';
        return str_replace(
            ['@referencia', '@respostas'],
            [$referencia, implode('', $respostas)],
            $html
        );
    }

    private function criaPerguntaEsperada($pergunta)
    {
        $respostas = $this->criaListaRespostaEsperada($pergunta['respostas'], $pergunta['referencia']);
        $html = '<div id="step-@referencia"><h3>@pergunta</h3>@respostas</div>';
        return str_replace(
            ['@referencia', '@pergunta', '@respostas'],
            [$pergunta['referencia'], $pergunta['pergunta'], $respostas],
            $html
        );
    }
}

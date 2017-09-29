<?php

namespace QuizSerie\Tests\Unit\Util;

use PHPUnit\Framework\TestCase;
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
        $perguntaResposta       = current($perguntasRespostas);
        $perguntaRespostaArray  = (array) $perguntaResposta;

        $referencia         = $perguntaResposta['referencia'];
        $pergunta           = $perguntaResposta['pergunta'];
        $respostas          = $perguntaResposta['respostas'];
        $resposta           = (array) end($respostas);

        $resultadoEsperado = '<div class="radio">
                                <label>
                                    <input type="radio" name="pergunta@referencia" value="@resposta">
                                    @pergunta
                                </label>
                            </div>';

        $resultadoEsperado = str_replace(
            ['@referencia', '@resposta', '@pergunta'],
            [$referencia, key($resposta), $pergunta],
            $resultadoEsperado
        );

        $reflectionMethod = new \ReflectionMethod('\\QuizSerie\\Util\\ConverterPerguntaHtml', 'criaRadioButtonResposta');
        $reflectionMethod->setAccessible(true);

        $resultado = $reflectionMethod->invokeArgs($this->class, array($perguntaResposta));

        var_dump($resultado); die();
    }
}

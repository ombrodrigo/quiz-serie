<?php

namespace QuizSerie\Tests\Unit\Common;

use PHPUnit\Framework\TestCase;
use ReflectionMethod;
use QuizSerie\Common\PerguntaResposta;
use QuizSerie\Util\ConteudoJson;

class PerguntaRespostaTest extends TestCase
{
    private $class = null;

    public function setUp()
    {
        $this->class = new PerguntaResposta();
    }

    public function perguntasRespostasProvider()
    {
        $conteudoJson = new ConteudoJson();
        $conteudo = $conteudoJson->capturar('perguntas_respostas');
        return [[json_decode($conteudo)]];
    }

    /**
     * @dataProvider perguntasRespostasProvider
     */
    public function testTrataPergunta($perguntasRespostas)
    {
        $perguntasRespostas = current($perguntasRespostas);
        $this->assertInstanceOf('StdClass', $perguntasRespostas);

        $reflectionMethod = new ReflectionMethod('\\QuizSerie\\Common\\PerguntaResposta', 'tratarPergunta');
        $reflectionMethod->setAccessible(true);

        $respostaTratada = $reflectionMethod->invokeArgs($this->class, array($perguntasRespostas));
        $this->assertInternalType('array', $respostaTratada);
    }

    /**
     * @dataProvider perguntasRespostasProvider
     */
    public function testEmbaralharResposta($perguntasRespostas)
    {
        $primeiraPergunta = (array) current($perguntasRespostas);
        $primeiraPerguntaRespostas = $primeiraPergunta['respostas'];
        $primeiraPerguntaRespostasComparar = $primeiraPerguntaRespostas;

        $reflectionMethod = new ReflectionMethod('\\QuizSerie\\Common\\PerguntaResposta', 'embaralharRespostas');
        $reflectionMethod->setAccessible(true);
        $this->assertNotEquals(
            $primeiraPerguntaRespostasComparar,
            $reflectionMethod->invokeArgs($this->class, array($primeiraPerguntaRespostas))
        );
    }

    /**
     * @dataProvider perguntasRespostasProvider
     */
    public function testLista($perguntasRespostas)
    {
        $this->assertInternalType('array', $this->class->listar());
        $this->assertNotEquals($perguntasRespostas, $this->class->listar());
    }
}

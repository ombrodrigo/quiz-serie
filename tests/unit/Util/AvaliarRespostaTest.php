<?php

namespace QuizSerie\Tests\Unit\Util;

use PHPUnit\Framework\TestCase;
use QuizSerie\Util\AvaliarResposta;

class AvaliarRespostaTest extends TestCase
{
    private $class = null;

    public function setUp()
    {
        $this->class = new AvaliarResposta();
    }

    public function testMaiorNumeroDeOcorrencias()
    {
        $respostas = ['a', 'b', 'b', 'c', 'e'];
        $resultadoEsperado = ['b' => 2];
        $this->assertEquals($resultadoEsperado, $this->class->maiorNumeroOcorrencia($respostas));

        $respostas = ['d', 'b', 'b', 'c', 'd'];
        $resultadoEsperado = ['b' => 2, 'd' => 2];
        $this->assertEquals($resultadoEsperado, $this->class->maiorNumeroOcorrencia($respostas));

        $respostas = ['d', 'c', 'c', 'c', 'd'];
        $resultadoEsperado = ['c' => 3];
        $this->assertEquals($resultadoEsperado, $this->class->maiorNumeroOcorrencia($respostas));

        $respostas = ['a', 'b', 'c', 'd', 'e'];
        $resultadoEsperado = ['a' => 1, 'b' => 1, 'c' => 1, 'd' => 1, 'e' => 1];
        $this->assertEquals($resultadoEsperado, $this->class->maiorNumeroOcorrencia($respostas));


        $respostas = ['a', 'a', 'a', 'b', 'b'];
        $resultadoEsperado = ['a' => 3];
        $this->assertEquals($resultadoEsperado, $this->class->maiorNumeroOcorrencia($respostas));
    }

    public function testMaiorPesoResposta()
    {
        $maiorPesoRespostaMethod = new \ReflectionMethod('\\QuizSerie\\Util\\AvaliarResposta', 'maiorPesoResposta');
        $maiorPesoRespostaMethod->setAccessible(true);

        $respostas = ['e', 'c', 'a', 'c', 'e'];
        $resultadoEsperado = 5;
        $this->assertEquals(
            $resultadoEsperado,
            $maiorPesoRespostaMethod->invokeArgs($this->class, array('e', $respostas))
        );

        $respostas = ['e', 'e', 'a', 'c', 'c'];
        $resultadoEsperado = 5;
        $this->assertEquals(
            $resultadoEsperado,
            $maiorPesoRespostaMethod->invokeArgs($this->class, array('c', $respostas))
        );
    }

    public function testMaiorPeso()
    {
        $respostas = ['e', 'c', 'a', 'c', 'e'];
        $resultadoEsperado = ['e' => 5, 'c' => 4];
        $this->assertEquals(array_values($resultadoEsperado), array_values($this->class->maiorPeso($respostas)));

        $respostas = ['c', 'c', 'a', 'e', 'e'];
        $resultadoEsperado = ['e' => 5, 'c' => 2];
        $this->assertEquals(array_values($resultadoEsperado), array_values($this->class->maiorPeso($respostas)));

        $respostas = ['e', 'e', 'a', 'c', 'c'];
        $resultadoEsperado = ['c' => 5, 'e' => 2];
        $this->assertEquals(array_values($resultadoEsperado), array_values($this->class->maiorPeso($respostas)));

        $respostas = ['a', 'b', 'c', 'd', 'e'];
        $resultadoEsperado = ['e' => 5, 'd' => 4, 'c' => 3, 'b' => 2, 'a' => 1];
        $this->assertEquals(array_values($resultadoEsperado), array_values($this->class->maiorPeso($respostas)));

        $respostas = ['e', 'd', 'c', 'b', 'a'];
        $resultadoEsperado = ['a' => 5, 'b' => 4, 'c' => 3, 'd' => 2, 'e' => 1];
        $this->assertEquals(array_values($resultadoEsperado), array_values($this->class->maiorPeso($respostas)));

        $respostas = ['e', 'd', 'c', 'b', 'a'];
        $resultadoEsperado = array_reverse($resultadoEsperado);
        $this->assertNotEquals(array_values($resultadoEsperado), array_values($this->class->maiorPeso($respostas)));
    }
}

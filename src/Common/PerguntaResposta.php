<?php

namespace QuizSerie\Common;

use QuizSerie\Util\ConteudoJson;
use StdClass;

/**
 * Classe responsável por gerenciar as perguntas e respostas
 *
 * @author Rodrigo Conceição de Araujo <omb.rodrigo@gmail.com>
 *
 * @package QuizSerie\Common
 **/
class PerguntaResposta
{
    /**
     * Método responsável por listar todas as perguntas e respostas
     *
     * @access public
     *
     * @return Array
     */
    public function listar()
    {
        $conteudoJson = new ConteudoJson();
        $perguntas = $conteudoJson->capturar('perguntas_respostas');
        $perguntas = json_decode($perguntas);
        return array_map(function ($pergunta) {
            return $this->tratarPergunta($pergunta);
        }, $perguntas);
    }

    /**
     * Método responsável por tratar o conteúdo de uma pergunta
     *
     * @access private
     *
     * @param \StdClass $pergunta pergunta as ser tratada
     *
     * @return Array
     */
    private function tratarPergunta(StdClass $pergunta)
    {
        $pergunta = (array) $pergunta;
        $respostas = $pergunta['respostas'];
        $pergunta['respostas'] = $this->embaralharRespostas($respostas);
        return $pergunta;
    }

    /**
     * Método responsável por embaralhar as respostas de uma pergunta
     *
     * @access private
     *
     * @param Array $respostas respostas que serão embaralhadas
     *
     * @return Array
     */
    private function embaralharRespostas($respostas)
    {
        shuffle($respostas);
        return $respostas;
    }
}

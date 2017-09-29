<?php

namespace QuizSerie\Util;

/**
 * Classe responsável por converter uma pergunta para HTML
 *
 * @author Rodrigo Conceição de Araujo <omb.rodrigo@gmail.com>
 *
 * @package QuizSerie\Util
 **/
class ConverterPerguntaHtml
{
    /**
     * Método responsável por criar o HTML de uma pergunta
     *
     * @access public
     *
     * @param Array $pergunta pergunta a ser convertida
     *
     * @return String
     */
    public function converter($pergunta)
    {
        return $this->criaPergunta($pergunta);
    }

    /**
     * Método responsável pro criar o HTML de uma pergunta
     *
     * @access private
     *
     * @param Array $pergunta pergunta a ser convertida
     *
     * @return string
     */
    private function criaPergunta($pergunta)
    {
        $respostas = $this->criaListaRespostas($pergunta['respostas'], $pergunta['referencia']);

        $html = '<div id="step-@referencia"><h3>@pergunta</h3>@respostas</div>';
        return str_replace(
            ['@referencia', '@pergunta', '@respostas'],
            [$pergunta['referencia'], $pergunta['pergunta'], $respostas],
            $html
        );
    }

    /**
     * Método responspavel por converter as repostas de uma pergunta para HTML
     *
     * @access private
     *
     * @access private
     *
     * @param Array     $respostas      respostas que serão convertidas
     * @param Integer   $referencia     referencia da pergunta
     *
     * @return string
     */
    private function criaListaRespostas($respostas, $referencia)
    {
        foreach ($respostas as &$resposta) {
            $resposta = $this->criaRadioButtonResposta($resposta, $referencia);
        }

        $html = '<div id="form-step-@referencia" role="form" data-toggle="validator">' .
        '<div class="form-group">@respostas<div class="help-block with-errors"></div></div></div>';
        return str_replace(
            ['@referencia', '@respostas'],
            [$referencia, implode('', $respostas)],
            $html
        );
    }

    /**
     * Método responsável por converter uma resposta para HTML
     *
     * @access private
     *
     * @param \stdClass $resposta       resposta a ser convertida
     * @param Integer   $referencia     referencia da pergunta
     *
     * @return string
     */
    private function criaRadioButtonResposta(\StdClass $resposta, $referencia)
    {
        $html = '<div class="radio">' .
        '<label><input type="radio" name="pergunta@referencia" value="@resposta" required>@pergunta</label></div>';
        $respostaArray = (array) $resposta;

        return str_replace(
            ['@referencia', '@resposta', '@pergunta'],
            [$referencia, key($respostaArray), current($respostaArray)],
            $html
        );
    }
}

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

    private function criaPergunta($pergunta)
    {
        $respostas = $this->criaListaRespostas($pergunta['respostas'], $pergunta['referencia']);

        $html = '<div id="step-@referencia">
                    <h3>@pergunta</h3>
                    @respostas
                </div>';

        return str_replace(
            ['@referencia', '@pergunta', '@respostas'],
            [$pergunta['referencia'], $pergunta['pergunta'], $respostas],
            $html
        );
    }

    private function criaListaRespostas($respostas, $referencia)
    {
        foreach ($respostas as &$resposta) {
            $resposta = $this->criaRadioButtonResposta($resposta, $referencia);
        }

        $html = '<div id="form-step-@referencia" role="form" data-toggle="validator">
                    <div class="form-group">
                        @respostas
                        <div class="help-block with-errors"></div>
                    </div>
                </div>';

        return str_replace(
            ['@referencia', '@respostas'],
            [$referencia, implode('', $respostas)],
            $html
        );
    }

    private function criaRadioButtonResposta($resposta, $referencia)
    {
        $html = '<div class="radio">
                    <label>
                        <input type="radio" name="pergunta@referencia" value="@resposta">
                        @pergunta
                    </label>
                </div>';

        $respostaArray = (array) $resposta;

        return str_replace(
            ['@referencia', '@resposta', '@pergunta'],
            [$referencia, key($respostaArray), current($respostaArray)],
            $html
        );
    }
}

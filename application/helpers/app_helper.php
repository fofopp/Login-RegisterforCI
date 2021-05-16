<?php
/**
 * Project Login&RegisterforCI.
 * User: Peter Lauf
 * Copyright: Peter Lauf
 * Date: 16.05.2021
 * Time: 13:42
 * mail: karbonsk@gmail.com
 */

/**
 * @param $str
 * @param string $separator
 * @param bool $lowercase
 * @return string
 * Vytvára so stringu retazec vhodný ako url
 */
function url_create($str, $separator = '-', $lowercase = FALSE){
    if ($separator === 'dash')
    {
        $separator = '-';
    }
    elseif ($separator === 'underscore')
    {
        $separator = '_';
    }

    $q_separator = preg_quote($separator, '#');

    $trans = array(
        'ľ'									=> 'l',
        'š'									=> 's',
        'č'									=> 'c',
        'ť'									=> 't',
        'ž'									=> 'z',
        'ý'									=> 'y',
        'á'									=> 'a',
        'í'									=> 'i',
        'é'									=> 'e',
        'ú'									=> 'u',
        'ä'									=> 'a',
        'ň'									=> 'n',
        'ô'									=> 'o',
        'ó'									=> 'o',
        'ĺ'									=> 'l',
        'ď'									=> 'd',
        'Ľ'									=> 'l',
        'Š'									=> 's',
        'Č'									=> 'c',
        'Ť'									=> 't',
        'Ž'									=> 'z',
        'Ý'									=> 'y',
        'Á'									=> 'a',
        'Í'									=> 'i',
        'É'									=> 'e',
        'Ú'									=> 'u',
        'Ä'									=> 'a',
        'Ň'									=> 'n',
        'Ô'									=> 'o',
        'Ó'									=> 'o',
        'Ĺ'									=> 'l',
        'ě'									=> 'e',
        'ö'									=> 'o',
        'Ď'									=> 'd',
        'ř'									=> 'r',
        'ŕ'									=> 'r',
        'Ŕ'									=> 'R',
        'ů'									=> 'u',
        'Ř'									=> 'r',
        'Ě'									=> 'e',
        '&.+?;'			=> '',
        '[^\w\d _-]'		=> '',
        '\s+'			=> $separator,
        '('.$q_separator.')+'	=> $separator
    );
    $str = strip_tags($str);
    foreach ($trans as $key => $val)
    {
        $str = preg_replace('#'.$key.'#i'.(UTF8_ENABLED ? 'u' : ''), $val, $str);
    }

    if ($lowercase === TRUE)
    {
        $str = strtolower($str);
    }

    return trim(trim($str, $separator));
}

/**
 * @param $img Zmenší obrázok
 */
function resize ($img){

    $CI = & get_instance();
    $CI->load->library('image_lib');

    $configi['image_library'] = 'gd2';
    $configi['source_image'] =  $img;
    $configi['create_thumb'] = FALSE;
    $configi['maintain_ratio'] = TRUE;
    $configi['master_dim'] = 'width';
    $configi['max_size'] = '0';
    $configi['quality'] = "90%";
    $configi[ 'x_axis' ]  =  100 ;
    $configi[ 'y_axis' ]  =  100 ;
    $configi['width'] = 400;
    $configi['height'] = 400;
    $CI->image_lib->initialize($configi);
    $CI->image_lib->resize();

}
/**
 * @param $img Oreže obrázok na 200x200 pc
 */
function crop ($img){

    $CI = & get_instance();


        $config['image_library'] = 'gd2';
        $config['source_image'] = $img;

        $imageSize = $CI->image_lib->get_image_properties($config['source_image'], TRUE);
        unset($imageSize['image_type']);
        unset($imageSize['size_str']);
        unset($imageSize['mime_type']);

        $newSize = min($imageSize);
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = FALSE;
        $config['width'] = $newSize;
        $config['height'] = $newSize;
        $config['y_axis'] = ($imageSize['height'] - $newSize) / 2;
        $config['x_axis'] = ($imageSize['width'] - $newSize) / 2;
        $config['new_image'] = $img;

        $CI->load->library('image_lib', $config);

        $CI->image_lib->initialize($config);
        if (!$CI->image_lib->crop()){
            echo $CI->image_lib->display_errors();
        }

}
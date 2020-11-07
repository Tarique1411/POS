<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_remote_contents')) {

    function get_remote_contents($url, $post_fields = NULL) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        if ($post_fields) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post_fields);
        }
        $resp = curl_exec($curl);
        if ($resp) {
            $result = $resp;
        } else {
            $result = json_encode(array('status' => 'Failed', 'message' => 'Curl Error: "' . curl_error($curl) . '"'));
        }
        curl_close($curl);
        return $result;
    }

}

if (!function_exists('save_remote_file')) {

    function save_remote_file($file) {
        $protocol = is_https() ? 'https://' : 'http://';
        file_put_contents('./files/updates/' . $file, fopen($protocol . 'tecdiary.com/api/v1/download/file/' . $file, 'r'));
        return true;
    }

}

if (!function_exists('get_return_sale')) {

    function get_return_sale($return_id) {
        //get main CodeIgniter object
        $ci = & get_instance();
        //load databse library
        $ci->load->database();
        //get data from database
        $query = $ci->db->get_where('return_sales', array('id' => $return_id));
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return false;
        }
    }

}

if (!function_exists('pr')) {

    function pr($myArray = array(), $terminate = true) {
        echo "<pre>";
        print_r($myArray);
        if ($terminate) {
            die;
        }
        echo "<pre>";
    }

}


if (!function_exists('prx')) {

    function prx($data, $terminate = true) {
        // capture the output of print_r
        $out = print_r($data, true);

        // replace something like '[element] => <newline> (' with <a href="javascript:toggleDisplay('...');">...</a><div id="..." style="display: none;">
        $out = preg_replace('/([ \t]*)(\[[^\]]+\][ \t]*\=\>[ \t]*[a-z0-9 \t_]+)\n[ \t]*\(/iUe', "'\\1<a href=\"javascript:toggleDisplay(\''.(\$id = substr(md5(rand().'\\0'), 0, 7)).'\');\">\\2</a><div id=\"'.\$id.'\" style=\"display: none;\">'", $out);

        // replace ')' on its own on a new line (surrounded by whitespace is ok) with '</div>
        $out = preg_replace('/^\s*\)\s*$/m', '</div>', $out);
        echo '<pre>';
        // print the javascript function toggleDisplay() and then the transformed output
        echo '<script language="Javascript">function toggleDisplay(id) { document.getElementById(id).style.display = (document.getElementById(id).style.display == "block") ? "none" : "block"; }</script>' . "\n$out";
        if ($terminate) {
            die;
        }
    }

}


if (!function_exists('dd')) {

    function dd($data, $label = '', $return = false) {

        $debug = debug_backtrace();
        $callingFile = $debug[0]['file'];
        $callingFileLine = $debug[0]['line'];

        ob_start();
        print_r($data);
        $c = ob_get_contents();
        ob_end_clean();

        $c = preg_replace("/\r\n|\r/", "\n", $c);
        $c = str_replace("]=>\n", '] = ', $c);
        $c = preg_replace('/= {2,}/', '= ', $c);
        $c = preg_replace("/\[\"(.*?)\"\] = /i", "[$1] = ", $c);
        $c = preg_replace('/  /', "    ", $c);
        $c = preg_replace("/\"\"(.*?)\"/i", "\"$1\"", $c);
        $c = preg_replace("/(int|float)\(([0-9\.]+)\)/i", "$1() <span class=\"number\">$2</span>", $c);

// Syntax Highlighting of Strings. This seems cryptic, but it will also allow non-terminated strings to get parsed.
        $c = preg_replace("/(\[[\w ]+\] = string\([0-9]+\) )\"(.*?)/sim", "$1<span class=\"string\">\"", $c);
        $c = preg_replace("/(\"\n{1,})( {0,}\})/sim", "$1</span>$2", $c);
        $c = preg_replace("/(\"\n{1,})( {0,}\[)/sim", "$1</span>$2", $c);
        $c = preg_replace("/(string\([0-9]+\) )\"(.*?)\"\n/sim", "$1<span class=\"string\">\"$2\"</span>\n", $c);

        $regex = array(
            // Numberrs
            'numbers' => array('/(^|] = )(array|float|int|string|resource|object\(.*\)|\&amp;object\(.*\))\(([0-9\.]+)\)/i', '$1$2(<span class="number">$3</span>)'),
            // Keywords
            'null' => array('/(^|] = )(null)/i', '$1<span class="keyword">$2</span>'),
            'bool' => array('/(bool)\((true|false)\)/i', '$1(<span class="keyword">$2</span>)'),
            // Types
            'types' => array('/(of type )\((.*)\)/i', '$1(<span class="type">$2</span>)'),
            // Objects
            'object' => array('/(object|\&amp;object)\(([\w]+)\)/i', '$1(<span class="object">$2</span>)'),
            // Function
            'function' => array('/(^|] = )(array|string|int|float|bool|resource|object|\&amp;object)\(/i', '$1<span class="function">$2</span>('),
        );

        foreach ($regex as $x) {
            $c = preg_replace($x[0], $x[1], $c);
        }

        $style = '
                    /* outside div - it will float and match the screen */
                    .dumpr {
                        margin: 2px;
                        padding: 2px;
                        background-color: #fbfbfb;
                        float: left;
                        clear: both;
                    }
                    /* font size and family */
                    .dumpr pre {
                        color: #000000;
                        font-size: 9pt;
                        font-family: "Courier New",Courier,Monaco,monospace;
                        margin: 0px;
                        padding-top: 5px;
                        padding-bottom: 7px;
                        padding-left: 9px;
                        padding-right: 9px;
                    }
                    /* inside div */
                    .dumpr div {
                        background-color: #fcfcfc;
                        border: 1px solid #d9d9d9;
                        float: left;
                        clear: both;
                    }
                    /* syntax highlighting */
                    .dumpr span.string {color: #c40000;}
                    .dumpr span.number {color: #ff0000;}
                    .dumpr span.keyword {color: #007200;}
                    .dumpr span.function {color: #0000c4;}
                    .dumpr span.object {color: #ac00ac;}
                    .dumpr span.type {color: #0072c4;}
                    ';

        $style = preg_replace("/ {2,}/", "", $style);
        $style = preg_replace("/\t|\r\n|\r|\n/", "", $style);
        $style = preg_replace("/\/\*.*?\*\//i", '', $style);
        $style = str_replace('}', '} ', $style);
        $style = str_replace(' {', '{', $style);
        $style = trim($style);

        $c = trim($c);
        $c = preg_replace("/\n<\/span>/", "</span>\n", $c);

        if ($label == '') {
            $line1 = '';
        } else {
            $line1 = "<strong>$label</strong> \n";
        }

        $out = "\n<!-- Dumpr Begin -->\n" .
                "<style type=\"text/css\">" . $style . "</style>\n" .
                "<div class=\"dumpr\">
    <div><pre>$line1 $callingFile : $callingFileLine \n$c\n</pre></div></div><div style=\"clear:both;\">&nbsp;</div>" .
                "\n<!-- Dumpr End -->\n";
        if ($return) {
            return $out;
        } else {
            echo $out;
        }
        die;
    }

}


if (!function_exists('vd')) {

    function vd($data, $label = '', $return = false) {

        $debug = debug_backtrace();
        $callingFile = $debug[0]['file'];
        $callingFileLine = $debug[0]['line'];

        ob_start();
        var_dump($data);
        $c = ob_get_contents();
        ob_end_clean();

        $c = preg_replace("/\r\n|\r/", "\n", $c);
        $c = str_replace("]=>\n", '] = ', $c);
        $c = preg_replace('/= {2,}/', '= ', $c);
        $c = preg_replace("/\[\"(.*?)\"\] = /i", "[$1] = ", $c);
        $c = preg_replace('/  /', "    ", $c);
        $c = preg_replace("/\"\"(.*?)\"/i", "\"$1\"", $c);
        $c = preg_replace("/(int|float)\(([0-9\.]+)\)/i", "$1() <span class=\"number\">$2</span>", $c);

// Syntax Highlighting of Strings. This seems cryptic, but it will also allow non-terminated strings to get parsed.
        $c = preg_replace("/(\[[\w ]+\] = string\([0-9]+\) )\"(.*?)/sim", "$1<span class=\"string\">\"", $c);
        $c = preg_replace("/(\"\n{1,})( {0,}\})/sim", "$1</span>$2", $c);
        $c = preg_replace("/(\"\n{1,})( {0,}\[)/sim", "$1</span>$2", $c);
        $c = preg_replace("/(string\([0-9]+\) )\"(.*?)\"\n/sim", "$1<span class=\"string\">\"$2\"</span>\n", $c);

        $regex = array(
            // Numberrs
            'numbers' => array('/(^|] = )(array|float|int|string|resource|object\(.*\)|\&amp;object\(.*\))\(([0-9\.]+)\)/i', '$1$2(<span class="number">$3</span>)'),
            // Keywords
            'null' => array('/(^|] = )(null)/i', '$1<span class="keyword">$2</span>'),
            'bool' => array('/(bool)\((true|false)\)/i', '$1(<span class="keyword">$2</span>)'),
            // Types
            'types' => array('/(of type )\((.*)\)/i', '$1(<span class="type">$2</span>)'),
            // Objects
            'object' => array('/(object|\&amp;object)\(([\w]+)\)/i', '$1(<span class="object">$2</span>)'),
            // Function
            'function' => array('/(^|] = )(array|string|int|float|bool|resource|object|\&amp;object)\(/i', '$1<span class="function">$2</span>('),
        );

        foreach ($regex as $x) {
            $c = preg_replace($x[0], $x[1], $c);
        }

        $style = '
                    /* outside div - it will float and match the screen */
                    .dumpr {
                        margin: 2px;
                        padding: 2px;
                        background-color: #fbfbfb;
                        float: left;
                        clear: both;
                    }
                    /* font size and family */
                    .dumpr pre {
                        color: #000000;
                        font-size: 9pt;
                        font-family: "Courier New",Courier,Monaco,monospace;
                        margin: 0px;
                        padding-top: 5px;
                        padding-bottom: 7px;
                        padding-left: 9px;
                        padding-right: 9px;
                    }
                    /* inside div */
                    .dumpr div {
                        background-color: #fcfcfc;
                        border: 1px solid #d9d9d9;
                        float: left;
                        clear: both;
                    }
                    /* syntax highlighting */
                    .dumpr span.string {color: #c40000;}
                    .dumpr span.number {color: #ff0000;}
                    .dumpr span.keyword {color: #007200;}
                    .dumpr span.function {color: #0000c4;}
                    .dumpr span.object {color: #ac00ac;}
                    .dumpr span.type {color: #0072c4;}
                    ';

        $style = preg_replace("/ {2,}/", "", $style);
        $style = preg_replace("/\t|\r\n|\r|\n/", "", $style);
        $style = preg_replace("/\/\*.*?\*\//i", '', $style);
        $style = str_replace('}', '} ', $style);
        $style = str_replace(' {', '{', $style);
        $style = trim($style);

        $c = trim($c);
        $c = preg_replace("/\n<\/span>/", "</span>\n", $c);

        if ($label == '') {
            $line1 = '';
        } else {
            $line1 = "<strong>$label</strong> \n";
        }

        $out = "\n<!-- Dumpr Begin -->\n" .
                "<style type=\"text/css\">" . $style . "</style>\n" .
                "<div class=\"dumpr\">
    <div><pre>$line1 $callingFile : $callingFileLine \n$c\n</pre></div></div><div style=\"clear:both;\">&nbsp;</div>" .
                "\n<!-- Dumpr End -->\n";
        if ($return) {
            return $out;
        } else {
            echo $out;
        }
        die;
    }

}

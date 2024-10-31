<?php

function setupad_lazy_load($placement_content, $placement_id, $wrapper_classname){

    //Extract only javascript from placements
    $doc = new DOMDocument();
    //Silenced warning message, because it throws warning if "style" attribute is used, but still parses HTML fine
    @$doc->loadHTML('<div>'.$placement_content.'</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    $xpath = new DOMXpath($doc);

    $lazy_loaded_placement_js = "";
    foreach($xpath->query('//script[string-length(text()) > 1]') as $javaScript) {
        $lazy_loaded_placement_js .= $javaScript->nodeValue;
    }

    //Extract everything except javascript
    $script = $doc->getElementsByTagName('script');
    $remove = [];
    foreach($script as $item) { $remove[] = $item; }
    foreach ($remove as $item) { $item->parentNode->removeChild($item); }
    $html = $doc->saveHTML();

    $lazy_loaded_placement =
        '<script>
            inView("#lazy-'. $wrapper_classname ."-". $placement_id.'").once(\'enter\', (function () {
                document.getElementById("lazy-'. $wrapper_classname ."-". $placement_id.'").innerHTML += `'.$html.'`;
                '.$lazy_loaded_placement_js.'
            }));
        </script>';

    return $lazy_loaded_placement;
}
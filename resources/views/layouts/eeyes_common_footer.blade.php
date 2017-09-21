<?php
$eeyes_common_footer = \Illuminate\Support\Facades\Cache::remember('eeyes_common_footer', 1440, function () {
    $js = file_get_contents("http://img.eeyes.net/eeyes_common/eeyes_common_footer.js");
    if (1 === preg_match('/document.write\((.*)\);/', $js, $matches)) {
        return json_decode($matches[1], true);
    }
    return null;
});
?>
@if($eeyes_common_footer)
    {!! $eeyes_common_footer !!}
@else
    <script src="//img.eeyes.net/eeyes_common/eeyes_common_footer.js"></script>
@endif

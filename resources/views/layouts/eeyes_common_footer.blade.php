<?php
$eeyes_common_footer = \Illuminate\Support\Facades\Cache::remember('eeyes_common_footer', 1440, function () {
    return  \Eeyes\Common\Img\View::footer();
});
?>
@if($eeyes_common_footer)
    {!! $eeyes_common_footer !!}
@else
    <script src="//img.eeyes.net/eeyes_common/eeyes_common_footer.js"></script>
@endif
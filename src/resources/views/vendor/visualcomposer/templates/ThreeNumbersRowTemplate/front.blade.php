<div class="vc-three-numbers row">
    <div class="col-xs-4">
        <div class="circle" data-value="{{ json_decode($content)[0] }}">
        <strong></strong>
        </div>
    </div>
    <div class="col-xs-4">
        <div class="circle" data-value="{{ json_decode($content)[1] }}">
        <strong></strong>
        </div>
    </div>
    <div class="col-xs-4">
        <div class="circle" data-value="{{ json_decode($content)[2] }}">
        <strong></strong>
        </div>
    </div>
</div>
<script>
(function($) {
$('.circle').each(function(n,i){
    $(i).circleProgress({
        value: parseInt($(i).data('value'))/100,
        fill: {gradient: [['#0681c4', .5], ['#4ac5f8', .5]], gradientAngle: Math.PI / 4}
    })
    .on('circle-animation-progress', function(event, progress, stepValue) {
        $(i).find('strong').text((stepValue*100).toFixed(0)+'%');
    });
});
})(jQuery);
</script>
<style>
.vc-three-numbers {
  text-align: center;
  margin: 25px 0;
}
.circle {
  width: 100px;
  display: inline-block;
  position: relative;
  text-align: center;
  line-height: 1.2;
}
.circle strong {
  position: absolute;
  top: 30px;
  left: 0;
  width: 100%;
  text-align: center;
  line-height: 40px;
  font-size: 30px;
}
</style>

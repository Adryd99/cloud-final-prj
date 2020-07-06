<?php $this->layout('Common/layout', ['title' => 'photo Maps', 'user' => $user]) ?>
<?php $this->start('head') ?>
    <script src="/js/jMaps.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?=$gMapsKey?>&libraries=&v=weekly"></script>
<?php $this->stop() ?>

<h1>Photo Maps</h1>

<h3 class="text-center my-5">Your Pictures' Locations</h3>
<!--The div element for the map -->
<div class="container">
  <div class="row">
    <div class="col">
      <div id="map"></div>
    </div>
  </div>
</div>

<script>
  window.onload = function(){
    initMap(<?= json_encode($images) ?>)
  }
</script>
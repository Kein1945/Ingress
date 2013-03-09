<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key=AIzaSyB2CgqtLBYhe6W4nfb2DGza7v79p65TEhc"></script>
<div id="map_canvas" class="container"></div>
<script type="text/javascript">
var centerMap, mapOptions, googleMap;
$(function(){
	centerMap = new google.maps.LatLng(59.9341,30.3151);
	mapOptions = {
		zoom: 13,
		center: centerMap,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	googleMap = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
})
</script>
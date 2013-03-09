<?php
template('head');
template('map');
?>
<script type="text/javascript">
	var getBoundStatTimer = null, getPlayersBoundTimer = null
		, openedBuble, lastMarkers = {};

	$(function(){
		google.maps.event.addListener(googleMap, 'bounds_changed', function(){
			var bounds = googleMap.getBounds()
					, ne = bounds.getNorthEast()
					, sw = bounds.getSouthWest()
					, region = {
						HLat: ne.lat()*1000000
						, RLon: ne.lng()*1000000
						, LLat: sw.lat()*1000000
						, LLon: sw.lng()*1000000
					};
			if( null != getBoundStatTimer ){
				clearTimeout(getBoundStatTimer)
			}
			getBoundStatTimer = setTimeout(function(){
				$.ajax({
					url: '?controller=place&action=regionAjax'
					, data: region
					, success: function(data){
						for(var i=0; i < data.length; i++){
							var point = data[i];
							(function(point){
								console.log('Add marker '+point.name)
								if(lastMarkers[point.id]){
									return;
								}
								var pointLL = new google.maps.LatLng(point.lat, point.lon)
										, marker = new google.maps.Marker({
											position: pointLL
											, map: googleMap
											, title: point.name
										})

										,content = '<h5>'+point.name+'</h5><dl>'
												+ '<dt>Players</dt><dd>'+point.player+'</dd>'
												+ '<dt>Date</dt><dd>'+point.date+'</dd>'
												+ '<dt>Actions count</dt><dd>'+point.ap+'</dd>'
												+ '<dt>Fraction</dt><dd>'+point.fraction+'</dd>'
												+ '</dl>'
										, infoWindow = new google.maps.InfoWindow({
											content: content
										})
										, opened = false;
								lastMarkers[point.id] = marker;
								google.maps.event.addListener(marker, 'click', function() {
									if(!opened){
										if(openedBuble){
											openedBuble.close()
										}
										infoWindow.open(googleMap, marker);
										openedBuble = infoWindow;
									} else {
										openedBuble = false;
										infoWindow.close();
									}
									opened = !opened;
								});
							})(point)
						}
					}
				});
			}, 1000)
			/**/
			if( null != getPlayersBoundTimer ){
				clearTimeout(getPlayersBoundTimer)
			}
			getPlayersBoundTimer = setTimeout(function(){
				$('#players_activity').load('?controller=player&action=regionListAjax', region)
			}, 1000)
		})
	})
</script>
<?php
template('player/listResult', array('players'=>$players));

template('footer');
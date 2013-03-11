$(function(){

    $.ajax({
        url: '/player_stat.php?action=points&id='+$('#player').val()
        , success: function(data){
            var openedBuble;
            for(var i=0; i < data.length; i++){
                var point = data[i];
                (function(point){
                    var pointLL = new google.maps.LatLng(point.lat, point.lon)
                        , marker = new google.maps.Marker({
                            position: pointLL
                            , map: googleMap 
                            , title: point.name
                        })

                        ,content = '<h5>'+point.name+'</h5><dl>'
                            + '<dt>Actions</dt><dd>'+point.ap+'</dd>'
                            + '<dt>Date</dt><dd>'+point.date+'</dd>'
                            + '<dt>Time</dt><dd>'+point.time+' hr.</dd>'
                            + '</dl>'
                        , infoWindow = new google.maps.InfoWindow({
                            content: content
                        })
                        , opened = false;

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
        , dataType: 'json'
    })
})

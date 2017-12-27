var gmaps = window.jobboard_maps || {},
    gm    = google.maps;

// Google map functions
function GmapsInitialize() {

  var latitude  = ( gmaps.latitude.length ) ? parseFloat( gmaps.latitude ) : 50.0;
  var longitude = ( gmaps.longitude.length ) ? parseFloat( gmaps.longitude ) : 0;

	var latlng  = new gm.LatLng( latitude, longitude ),
		  zoom    = parseInt( gmaps.zoom ),
		  target  = gmaps.target;

	var mapOptions = {
		center: latlng,
		zoom: zoom,
    draggable: true,
		scrollwheel: false,
		disableDefaultUI: true,
    mapTypeId: gm.MapTypeId.ROADMAP
	};

	var map = new gm.Map( document.getElementById(target), mapOptions );

  if ( gmaps.marker === '1' ) {

    var marker = new gm.Marker({
      position: latlng,
      map: map,
      title: gmaps.title,
      animation: gm.Animation.DROP
    });

    if ( gmaps.infowindow === '1' && gmaps.content.length ) {

      var contentString = '<div id="map-content">'+
      '<h4 id="firstHeading" class="firstHeading"><strong>'+gmaps.title+'</strong></h4>'+
      '<div id="bodyContent" style="width:260px"><p>'+gmaps.content+'</p></div>'+
      '</div>';

      var infowindow = new gm.InfoWindow({
        content: contentString
      });

      gm.event.addListener( marker, 'click', function() {
        infowindow.open( map, marker );
      });

    }

  }

}
gm.event.addDomListener( window, 'load', GmapsInitialize );

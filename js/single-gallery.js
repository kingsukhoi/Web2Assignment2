window.addEventListener('load', function () {

    function initMap(lat, long) {
        var map = new window.google.maps.Map(document.getElementById('#map'), {
            center: {
                lat: lat,
                lng: long
            },
            mapTypeId: 'satellite',
            zoom: 18
        });
    }

    initMap(lat, long);
});
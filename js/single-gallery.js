let map;
let mapUp=false;
let galleryID = 0;

/**
 * initialize the map
 */
function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 41.89474, lng: 12.4839},
        mapTypeId: 'satellite',
        zoom: 18
    });
    mapUp = true;
}

/**
 * set map coords
 * @param lat latitude
 * @param lng longitude
 */
function setMap(lat, lng) {
    /*document.querySelector(".d").setAttribute('style', 'display:;');*/
    if(!mapUp){
        initMap();
    }
    map.setCenter({lat:lat, lng: lng});
    map.setZoom(18);
}



/**
 * get gallery id from query string and set the global var
 * @returns {string} gallery id
 */
function setGalleryID() {
    galleryID = getCurrentID();
}

/**
 * main function
 */
function main(){

    setGalleryID();
    doWebCall(`services/painting.php?gallery=${galleryID}`, (response)=>{
        addPaintings(response);
    });
    doWebCall(`services/gallery.php?id=${galleryID}`, (r)=>{

        let lat = parseFloat((r['Latitude']));
        let long = parseFloat((r['Longitude']));
        setMap(lat, long);
    });
    addTableHeaderClicks();

}

window.addEventListener('load', main);
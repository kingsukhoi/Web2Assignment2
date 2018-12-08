let map;
let mapUp=false;
let galleryID = 0;

/**
 * initialize the map
 * @param lat
 * @param long
 */
function initMap(lat, long) {
    map = new google.maps.Map(document.getElementById('#map'), {
        center: {
            lat: lat,
            lng: long
        },
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
    map.setTilt(45);

}



/**
 * get gallery id from query string and set the global var
 * @returns {string} gallery id
 */
function setGalleryID() {
    galleryID = getCurrentID();
}

/**
 * add paintings list
 */
function addPaintings(response) {
    clearLoadingGif();
    const elem = document.querySelector('#painting-table > table > tbody');

    response.forEach((curr)=>{
        const tr = document.createElement('tr');
        let img = document.createElement('img');
        img.setAttribute('src',
            `make-image.php?type=paintings&file=${curr['ImageFileName']}`);
        img.setAttribute('alt', curr['Title']);
        img = makeTD(img, 'growable');
        const title = makeTD(curr['Title']);
        const year = makeTD(curr['YearOfWork']);
        // get the artist id
        doWebCall(`./services/artist.php?id=${curr['ArtistID']}`, (response)=>{
            // this is where stuff get's appended
            // need to query the artist name since that dose not come with the painting info
            let firstName = '';
            let lastName = '';
            if (response['FirstName']){
                firstName = response['FirstName']
            }
            if (response['LastName']){
                firstName = response['LastName']
            }
            const artist = makeTD(`${firstName} ${lastName}`);
            tr.appendChild(img);
            tr.appendChild(title);
            tr.appendChild(artist);
            tr.appendChild(year);
            elem.appendChild(tr);
        })
    });


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
        setMap(r['Latitude'], r['Longitude']);
    })

}

window.addEventListener('load', main);
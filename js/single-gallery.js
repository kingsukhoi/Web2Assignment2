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
 * can't remove loading gif the normal way so we doing this
 */
function clearLoadingGif() {
    const elem = document.querySelector('.loading');
    elem.parentElement.removeChild(elem);

}

/**
 * get gallery id from query string and set the global var
 * @returns {string} gallery id
 */
function setGalleryID() {
//copied from https://stackoverflow.com/questions/9870512/how-to-obtain-the-query-string-from-the-current-url-with-javascript
    const params = (new URL(document.location)).searchParams;
    galleryID = params.get("id");
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
            const artist = makeTD(`${response['FirstName']} ${response['LastName']}`);
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
let map;
let mapUp=false;
let galleryID = 0;
function initMap(lat, long) {
    map = new window.google.maps.Map(document.getElementById('#map'), {
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

function addPaintings() {
    //copied from https://stackoverflow.com/questions/9870512/how-to-obtain-the-query-string-from-the-current-url-with-javascript
    const params = (new URL(document.location)).searchParams;
    const id = params.get("id");
    function done(response){
        clearLoadingGif();
        const elem = document.querySelector('#painting-table > table > tbody');
        function makeTD(elem, classList){
            const rtnMe = document.createElement('td');
            rtnMe.classList.add(classList);
            if (typeof elem !== 'string')
                rtnMe.appendChild(elem);
            else {
                rtnMe.innerText = elem;
            }
            return rtnMe;
        }
        response.forEach((curr)=>{
            const tr = document.createElement('tr');
            let img = document.createElement('img');
            img.setAttribute('src',
                `make-image.php?type=paintings&file=${curr['ImageFileName']}`);
            img.setAttribute('alt', curr['Title']);
            img = makeTD(img, 'image');
            const title = makeTD(curr['Title']);
            const year = makeTD(curr['YearOfWork']);
            doWebCall(`./services/artist.php?id=${curr['ArtistID']}`, (response)=>{
                response = response[0];
                const artist = makeTD(`${response['FirstName']} ${response['LastName']}`)
                tr.appendChild(img);
                tr.appendChild(title);
                tr.appendChild(artist);
                tr.appendChild(year);
                elem.appendChild(tr);
            })
        })
    }
    doWebCall(`services/painting.php?gallery=${id}`, done)
}

function main(){
    addPaintings();
}

window.addEventListener('load', main);
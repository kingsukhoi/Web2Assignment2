window.addEventListener('load', main);

function main() {
    addGalleries();
    addArtists();
    addGenres();
}

function addArtists() {
    doWebCall('./services/artist.php', done);
    function done(response) {
        const elem = document.querySelector('#artist > div');
        response.forEach((curr)=>{
            const div = document.createElement('div');
            div.classList.add('three', 'columns');
            const img = document.createElement("img");
            img.setAttribute('src', `./make-image.php?type=artists&file=${curr['ArtistID']}`);
            const p = document.createElement('p');
            p.innerText = `${curr['FirstName']} ${curr['LastName']}`;
            div.appendChild(img);
            div.appendChild(p);
            elem.appendChild(div);
        })
    }
}

function addGenres() {
    function done(response) {
        const elem = document.querySelector('#genres-list > ul');
        response.forEach((curr)=>{
            const li = document.createElement('li');
            li.classList.add('six', 'columns');

            const img = document.createElement('img');
            img.setAttribute('src', `./make-image.php?type=genres&file=${curr['GenreID']}`);
            li.appendChild(img);

            const p = document.createElement('p');
            p.textContent = curr['GenreName'];
            li.appendChild(p);

            elem.appendChild(li);
        })
    }
    doWebCall('./services/genre.php', done);
}

/**
 * do a web call
 * @param url url to query
 * @param done done call back. Needs response parameter
 */
function doWebCall(url, done) {
    function catchError(reason) {
        console.error(reason)
    }
    function checkResponse(response) {
        if(response.ok)
            return response.json();
        else {
            return Promise.reject({
                status: response.status,
                statusText: response.statusText
            })
        }
    }
    fetch(url)
        .then((checkResponse))
        .then(done)
        .catch(catchError);
}

/**
 * add gallery list
 */
function addGalleries() {
    doWebCall('./services/gallery.php', done);
    function done(response) {
        const elem = document.querySelector('#gallery-list div ul');
        response.forEach((curr)=>{
            const li = document.createElement('li');
            const link = document.createElement('a');
            link.setAttribute('href',`./single-gallery.php?id=${curr['GalleryID']}`)
            link.textContent = curr['GalleryName'];
            li.appendChild(link);
            elem.appendChild(li);
        })
    }
}

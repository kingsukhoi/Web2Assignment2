window.addEventListener('load', main);

function main() {
    addGalleries();
    addArtists();
}

function addArtists() {
    fetch('services/artist.php')
        .then()
}



/**
 * do a web call
 * @param done done call back
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

var carrouselopts = {
    slidesToShow: 4,
    slidesToScroll: 4,
    rows: 2, // Removes the linear order. Would expect card 5 to be on next row, not stacked in groups.
    responsive: [
        { breakpoint: 992,
            settings: {
                slidesToShow: 3
            }
        },
        { breakpoint: 776,
            settings: {
                slidesToShow: 1,
                rows: 1 // This doesn't appear to work in responsive (Mac/Chrome)
            }
        }]
};

$('.carousel').slick(carrouselopts);
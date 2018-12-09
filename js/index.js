window.addEventListener('load', main);

/*function addGalleryEvent() {
    function hideList() {
        const list = document.querySelector('#gallery-list > div > ul');
        list.classList.toggle('dropdown-show');
    }
    const galleryHeader = document.querySelector('#gallery-list > div > h2');
    galleryHeader.addEventListener('click', hideList);
}*/

function main() {
    addGalleries();
    addArtists();
    addGenres();
    /*addGalleryEvent();*/
}


function addArtists() {
    doWebCall('./services/artist.php', done);

    function done(response) {
        const elem = document.querySelector('#artist > div');
        clearDiv(elem);
        response.forEach((curr) => {
            const div = document.createElement('div');
            // div.classList.add('three', 'columns');
            div.classList.add('item');
            const img = document.createElement("img");
            img.setAttribute('src', `./make-image.php?type=artists&file=${curr['ArtistID']}`);
            const p = document.createElement('p');
            p.innerText = `${curr['FirstName']} ${curr['LastName']}`;
            div.appendChild(img);
            div.appendChild(p);
            elem.appendChild(div);
        });
        const slider = tns({
            container: '.slider1',
            items: 6,
            slideBy: 'page',
            controls: false,
            gutter: 2,
            navPosition: 'bottom',
            edgePadding: 30,

        });
    }
}

function addGenres() {
    doWebCall('./services/genre.php', done);

    function done(response) {
        const elem = document.querySelector('#genres > div');
        clearDiv(elem);
        response.forEach((curr) => {
            const div = document.createElement('div');
            // li.classList.add('six', 'columns');
            div.classList.add('item');
            const img = document.createElement('img');
            img.setAttribute('src', `./make-image.php?type=genres&file=${curr['GenreID']}`);
            div.appendChild(img);

            const p = document.createElement('p');
            p.textContent = curr['GenreName'];
            div.appendChild(p);

            elem.appendChild(div);
        });

        const slider = tns({
            container: '.slider2',
            items: 6,
            slideBy: 'page',
            controls: false,
            gutter: 2,
            navPosition: 'bottom',
            edgePadding: 30,

        });
    }

}


/**
 * add gallery list
 */
function addGalleries() {
    doWebCall('./services/gallery.php', done);

    function done(response) {
        const elem = document.querySelector('#gallery-list div ul');
        clearDiv(elem);
        response.forEach((curr) => {
            const li = document.createElement('li');
            li.classList.add("menu")
            const link = document.createElement('a');
            link.setAttribute('href', `./single-gallery.php?id=${curr['GalleryID']}`)
            link.textContent = curr['GalleryName'];
            li.appendChild(link);
            elem.appendChild(li);
        });
    }
}

function showMenu() {
    let button = document.querySelector('#gallery-list button');

    button.onclick = function () {
        let content = button.nextElementSibling;
        if (content.style.display === "block") {
            content.style.display = "none";
        } else {
            content.style.display = "block";
        }

    }

}







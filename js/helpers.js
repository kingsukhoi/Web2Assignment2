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
        if (response.ok)
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
 * clear inside of a div
 * @param div
 */
function clearDiv(div) {
    div.innerHTML = '';
}

/**
 * make a td element and add element or text content
 * @param elem
 * @param classList
 * @returns {HTMLElement}
 */
function makeTD(elem, classList = '') {
    const rtnMe = document.createElement('td');
    if (classList.trim()) rtnMe.classList.add(classList);
    if (typeof elem !== 'string')
        rtnMe.appendChild(elem);
    else {
        rtnMe.innerText = elem;
    }
    return rtnMe;
}

/**
 * can't remove loading gif the normal way so we doing this
 */
function clearLoadingGif() {
    const elem = document.querySelector('.loading');
    elem.parentElement.removeChild(elem);

}

/**
 * get current id from query string
 * @returns {string}
 */
function getCurrentID() {
    //copied from https://stackoverflow.com/questions/9870512/how-to-obtain-the-query-string-from-the-current-url-with-javascript
    const params = (new URL(document.location)).searchParams;
    return params.get("id");
}

/**
 * add paintings to painting tables
 * @param response
 */
function addPaintings(response) {
    clearLoadingGif();
    const elem = document.querySelector('#painting-table > table > tbody');
    response.forEach((curr) => {
        const tr = document.createElement('tr');
        let img = document.createElement('img');
        img.setAttribute('src', `make-image.php?type=paintings&file=${curr['ImageFileName']}`);
        img.setAttribute('alt', curr['Title']);
        img = makeTD(img, 'growable');
        const title = makeTD(curr['Title']);
        title.classList.add('table-title');
        const year = makeTD(curr['YearOfWork']);
        year.classList.add('table-year');
        doWebCall(`./services/artist.php?id=${curr['ArtistID']}`, (response) => {
            // this is where stuff get's appended
            // need to query the artist name since that dose not come with the painting info
            let firstName = '';
            let lastName = '';
            if (response['FirstName']) {
                firstName = response['FirstName']
            }
            if (response['LastName']) {
                firstName = response['LastName']
            }
            const artist = makeTD(`${firstName} ${lastName}`);
            artist.classList.add('title-artist');
            tr.appendChild(img);
            tr.appendChild(title);
            tr.appendChild(artist);
            tr.appendChild(year);
            elem.appendChild(tr);
        })
    });
}

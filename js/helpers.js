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

function makeA(link, elem) {
    const rtnMe = document.createElement('a');
    rtnMe.href = link;
    rtnMe.target = '_blank';
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
    removeElement(elem);
}

/**
 * remove singular element.
 * does this the js way.
 * @param elem
 */
function removeElement(elem) {
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

const imageFileTag = 'data-image-file';

function imageFollow(e) {
// copied from https://stackoverflow.com/questions/7143806/make-an-image-follow-mouse-pointer/7144024#7144024
    const currFile = e.target.getAttribute(imageFileTag);
    let img;
    function makeImage() {
        img = document.createElement('img');
        img.setAttribute('src', `make-image.php?size=square&width=200&type=paintings&file=${currFile}`);
        img.style.position = 'absolute';
        img.style.margin = '0';
        document.body.appendChild(img);
    }
    function updatePosition(e) {
        e = e || window.event;
        console.log("x"+e.clientX)
        img.style.left  = (e.pageX + 5) + 'px';
        img.style.top = (e.pageY + 5) + 'px';
    }
    console.log('start');
    makeImage();
    e.target.addEventListener('mousemove', updatePosition);
    e.target.addEventListener('mouseleave', ()=> {
        console.log('end');
        removeElement(img);
    });
}

/**
 * add paintings to painting tables
 * @param response
 */
function addPaintings(response) {
    clearLoadingGif();
    const elem = document.querySelector('#painting-table > table > tbody');

    function makeImage(curr) {
        const fileName = curr['ImageFileName'];
        let img = document.createElement('img');
        img.setAttribute('src', `make-image.php?size=square&width=100&type=paintings&file=${fileName}`);
        img.setAttribute('alt', curr['Title']);
        img.addEventListener('mouseenter', imageFollow);
        img.setAttribute(imageFileTag, fileName);
        img = makeTD(img);
        return img;
    }

    response.forEach((curr) => {
        const tr = document.createElement('tr');
        let img = makeImage(curr);
        const title = makeTD(makeA(`single-painting.php?id=${curr['PaintingID']}`, curr['Title']));
        const year = makeTD(curr['YearOfWork']);
        doWebCall(`./services/artist.php?id=${curr['ArtistID']}`, (response) => {
            // this is where stuff get's appended
            // need to query the artist name since that dose not come with the painting info
            let firstName = '';
            let lastName = '';
            if (response['FirstName']) {
                firstName = response['FirstName']
            }
            if (response['LastName']) {
                lastName = response['LastName']
            }
            const artist = makeTD(makeA(`single-artist.php?id=${curr['ArtistID']}`, `${firstName} ${lastName}`));
            tr.appendChild(img);
            tr.appendChild(title);
            tr.appendChild(artist);
            tr.appendChild(year);
            elem.appendChild(tr);
            sortTable();// due to the nature of async, I'm using the janky solution of resorting every time
        })
    });
}

/**
 * figure out the sort order
 * @param a string 1
 * @param b string 2
 * @returns {number} sort order
 */
function resolveSort(a, b) {
    //https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/localeCompare
    //this correctly handles years
    if (a.localeCompare(b) < 0)
        return -1;
    if (a.localeCompare(b) > 0)
        return 1;
    return 0
}

/**
 * sort table on page
 * @param byWhat which column to sort by
 */
function sortTable(byWhat="title") {
    const elem = document.querySelector('#painting-table > table > tbody');
    let TableRows = Array.from(elem.children);
    clearDiv(elem);
    TableRows.sort((a, b)=>{
        console.log("sorting");
        let aString=getData(a, byWhat);
        let bString=getData(b, byWhat);

        return resolveSort(aString, bString);
    });
    TableRows.forEach((curr)=>elem.appendChild(curr));
    /**
     * extract desired field
     * @param tableRow entire row
     * @param field which column you want one of [ artist, title, year ]
     * @returns string textContent in the tag
     */
    function getData(tableRow, field) {
        const children = tableRow.childNodes;
        switch (field) {
            case 'artist':
                return children[2].textContent;
            case 'title':
                return children[1].textContent;
            case 'year':
                return children[3].textContent;
        }
    }

}

/**
 * add on click elements to table
 */
function addTableHeaderClicks() {
    const onclickFunc = (e)=>{
        const sortType = e.target.getAttribute('data-sort');
        sortTable(sortType)
    };
    const clickElems = Array.from(document.querySelectorAll('th')).filter((i)=> i.getAttribute('data-sort'));
    clickElems.forEach((i)=>{
        i.addEventListener('click', onclickFunc);
    })
}
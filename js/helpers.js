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

function clearDiv(div) {
    div.innerHTML = '';
}

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
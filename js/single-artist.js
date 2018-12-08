window.addEventListener('load', main);

let artistID = 0;

function main() {
    setArtistID();
    doWebCall(`./services/painting.php?artist=${artistID}`, addPaintings)
}

function setArtistID(){
    artistID = getCurrentID();
}

function addPaintings(response) {
    clearLoadingGif();
    const elem = document.querySelector('#painting-table > table > tbody');
    response.forEach((curr)=>{
        const tr = document.createElement('tr');
        let img = document.createElement('img');
        img.setAttribute('src', `make-image.php?type=paintings&file=${curr['ImageFileName']}`);
        img.setAttribute('alt', curr['Title']);
        img=makeTD(img, 'growable');
        const title = makeTD(curr['Title']);
        const year = makeTD(curr['YearOfWork']);
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
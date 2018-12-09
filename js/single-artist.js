window.addEventListener('load', main);

let artistID = 0;

function main() {
    setArtistID();
    doWebCall(`./services/painting.php?artist=${artistID}`, addPaintings);
    addTableHeaderClicks();
}

function setArtistID(){
    artistID = getCurrentID();
}

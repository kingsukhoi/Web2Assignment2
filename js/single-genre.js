let genreID;
/**
 * main function
 */
function main(){
    setGenreID();
    doWebCall(`services/painting.php?genre=${genreID}`, (response)=>{
        addPaintings(response);
    });
    addTableHeaderClicks();

}

/**
 * get gallery id from query string and set the global var
 * @returns {string} gallery id
 */
function setGenreID() {
    genreID = getCurrentID();
}

window.addEventListener('load', main);
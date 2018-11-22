window.addEventListener('load', main);

function main() {
    addGalleries();
}

/**
 * add gallery list
 */
function addGalleries() {
    fetch('services/gallery.php')
        .then(((response) => {
            if(response.ok)
                return response.json();
            else {
                return Promise.reject({
                    status: response.status,
                    statusText: response.statusText
                })
            }
        })).then(done)
        .catch(reason => console.error(reason));
    function done(response) {
        const elem = document.querySelector('#gallery-list div ul');
        response.forEach((curr)=>{
            const li = document.createElement('li');
            li.textContent = curr['GalleryName'];
            elem.appendChild(li);
        })
    }
}
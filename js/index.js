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
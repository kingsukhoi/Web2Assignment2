window.addEventListener('load', main);

    var $this = $(this),
        label = $this.prev('label');

function removeElem(elem) {
    elem.parentNode.removeChild(elem)
}

function main() {
    addIsBlankCheck();
}

/**
 * adds the is blank check to all elements
 */
function addIsBlankCheck() {
    const elems = document.querySelectorAll(".five.columns input");
    elems.forEach((curr)=>{
        curr.addEventListener('blur', (e)=>{
            const elem = e.target;
            const existingErrMsg = Array.from(e.target.parentElement.children).find(x=>x.classList.contains('error'));
            if (existingErrMsg) removeElem(existingErrMsg);
            if (!elem.value.trim()) {
                const fieldName = elem.getAttribute('placeholder');
                addError(elem, `${fieldName} cannot be empty`)
            }
        })
    });
}

/**
 * add error message in div
 * NEEDS INPUT ELEMENT TO BE INSIDE A DIV!!!!!!!!
 * @param element an input element on the signup page
 * @param message Message you want displayed
 */
function addError(element, message) {
    //<p class="error">Email cannot be empty</p>
    const newElement = document.createElement('p');
    newElement.classList.add('error');
    newElement.textContent = message;
    element.parentElement.appendChild(newElement);
}
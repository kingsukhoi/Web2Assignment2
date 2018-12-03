window.addEventListener('load', main);

// regex from https://emailregex.com/
const emailRegex = /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/;

const errTypes = {blank: 'blank', email:'email'};

const errAttributeName = 'data-error';

function main() {
    addIsBlankCheck();
    addEmailCheck();
}

/**
 * adds the is blank check to all elements
 */
function addIsBlankCheck() {
    const elems = document.querySelectorAll(".five.columns input");
    elems.forEach((curr)=>{
        curr.addEventListener('blur', (e)=>{
            const elem = e.target;
            rmError(e, errTypes.blank);
            if (!elem.value.trim()) {
                const fieldName = elem.getAttribute('placeholder');
                addError(elem, `${fieldName} cannot be empty`, errTypes.blank)
            }
        })
    });
}

/**
 * adds the email check to email element
 */
function addEmailCheck(){
    const elem = document.getElementById('email');
    elem.addEventListener('input', (e)=>{
        rmError(e, errTypes.email);
        const email = e.target.value;
        if (!emailRegex.test(email))
            addError(elem, 'Email is invalid', errTypes.email);
    })
}

/**
 * add error message in div
 * NEEDS INPUT ELEMENT TO BE INSIDE A DIV!!!!!!!!
 * @param element an input element on the signup page
 * @param message Message you want displayed
 * @param type error type from error type obj
 */
function addError(element, message, type) {
    //<p class="error">Email cannot be empty</p>
    const newElement = document.createElement('p');
    newElement.classList.add('error');
    newElement.textContent = message;
    newElement.setAttribute(errAttributeName, type);
    element.parentElement.appendChild(newElement);
}

/**
 * Remove error message from element
 * @param elem input element on the page
 * @param type error type from errType obj
 */
function rmError(elem, type) {
    const existingErrMsg = Array.from(elem.target.parentElement.children).find(
        (x) => x.getAttribute(errAttributeName) === type
    );
    if (existingErrMsg) removeElem(existingErrMsg);
}

/**
 * Removes element from dom
 * @param elem element to remove
 */
function removeElem(elem) {
    elem.parentNode.removeChild(elem)
}

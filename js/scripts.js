/** MENU HEADER */

/** @type {HTMLElement} */
const siteNavigation = document.querySelector( 'nav' );

/**
 * @param {HTMLElement} el
 * @param {string}      attr
 * @param {any}         value
 */
 const setAttr = ( el, attr, value ) => el.setAttribute( attr, value );

if (siteNavigation) {
        const mobileButton = siteNavigation.querySelector('button.menu_button');

        if (mobileButton) {
            mobileButton.addEventListener('click', function() {
                siteNavigation.classList.toggle('toggled');

                if (mobileButton.getAttribute('aria-expanded') === 'true') {
                    setAttr(mobileButton, 'aria-expanded', 'false');
                } else {
                    setAttr(mobileButton, 'aria-expanded', 'true');
                }
            });
        }
    }


/* MODALE HEADER CONTACT */

var modal = document.getElementById('myModal');
var btn = document.getElementById("myBtn");
var span = document.getElementsByClassName("close")[0];

btn.onclick = function() {
    modal.style.display = "block";
}

span.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
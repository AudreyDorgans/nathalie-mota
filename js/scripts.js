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



/**/
/* MODALE HEADER CONTACT */
/**/
var modal = document.getElementById('myModal');
var btns = document.getElementsByClassName("myBtnContact");
var span = document.getElementsByClassName("close")[0];

for (var i = 0; i < btns.length; i++) {
    btns[i].onclick = function(event) {
        event.stopPropagation(); // Arrête la propagation de l'événement
        if (modal.style.display !== "block") {
            modal.style.display = "block";
        }
    }
}

// Fermeture de la modale au clic en dehors de celle-ci
window.addEventListener('click', function(event) {
    if (modal.style.display == "block" && event.target !== modal && !modal.contains(event.target)) {
        modal.style.display = "none";
    }
});



/**/
/* FONCTIONNALITE REFERENCE CONTACT  */
/**/
jQuery(document).ready(function() {

    jQuery(".bouton-avec-reference").click(function() {

        var reference = jQuery(".reference").text();
        console.log(reference);
        jQuery("#input-reference").val(reference);
    });
});


/**/
/* FONCTIONNALITES HOVER THUMBNAILS SINGLE PHOTO */
/**/

const prevPhoto = document.querySelector('.photo-prev');
const nextPhoto = document.querySelector('.photo-next');
const prevThumbnail = document.querySelector('.nav-thumbnails-prev');
const nextThumbnail = document.querySelector('.nav-thumbnails-next');

function handleHover(element, thumbnail) {
    element.addEventListener('mouseenter', () => {
        thumbnail.classList.add('thumbnails_visible');
    });

    element.addEventListener('mouseleave', () => {
        thumbnail.classList.remove('thumbnails_visible');
    });
}

handleHover(prevPhoto, prevThumbnail);
handleHover(nextPhoto, nextThumbnail);


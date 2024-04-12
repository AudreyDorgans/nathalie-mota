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

if (document.body.classList.contains('single-photo')) {
        // Les fonctions suivantes ne s'exécuteront que si nous sommes sur la page single-photo.php

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
    }


/**
 * REQUETE AJAX POUR CHARGEMENT DES POSTS SUR FRONTPAGE
 */
(function ($) {
    $(document).ready(function () {
        let Paged = 1;

        // Chargement des photos en Ajax
        $('.load-catalogue-photos').click(function (e){
            Paged++;

            // Empêcher l'envoi classique du formulaire
            e.preventDefault();

            // L'URL qui réceptionne les requêtes Ajax dans l'attribut "action" de <form>
            const ajaxurl = $(this).data('ajaxurl');

            const data = {
                action: $(this).data('action'), 
                nonce:  $(this).data('nonce'),
                paged: Paged,
            }

            // Requête Ajax en JS natif via Fetch
            fetch(ajaxurl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'Cache-Control': 'no-cache',
                },
                body: new URLSearchParams(data),
            })
            .then(response => response.json())
            .then(body => {

                // En cas d'erreur
                if (!body.success) {
                    alert(body.data);
                    return;
                }

                // Afficher les photos dans la div load-result
                body.data.forEach(photo => {
                    const colImgCatalogue = $('<div>').addClass('col-img-catalogue');
                    const image = $('<img>').attr('src', photo.image_photo).attr('alt', 'Photo');
                    const displayFrontHover = $('<a>').attr('href', photo.permalien).addClass('display-front-hover');
                    const reference = $('<span>').addClass('uppercase reference').text(photo.reference);
                    const categorie = $('<span>').addClass('uppercase categorie').text(photo.nom_categories);
                    const viewLink = $('<a>').attr('href', photo.permalien).append($('<i>').addClass('fa-regular fa-eye'));
                    const expandIcon = $('<i>').addClass('fa-sharp fa-solid fa-expand');

                    colImgCatalogue.append(image, displayFrontHover, reference, categorie, viewLink, expandIcon);

                    $('.load-result').append(colImgCatalogue);
                });

               // Masquer le bouton de chargement si aucune photo n'est renvoyée dans la réponse
                if (!data.id_photo) {
                    $('.load-catalogue-photos').hide();
                }

            });
        });
    });
})(jQuery);













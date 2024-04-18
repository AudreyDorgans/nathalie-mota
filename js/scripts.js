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

jQuery(document).ready(function($) {
   
    let Paged = 1; // Définir la variable Paged ici
    
    $('.load-catalogue-photos').click(function (e){
        Paged++;

        e.preventDefault();

        const categorieValue = $('select[name="categorie"]').val() || ''; // Valeur par défaut : ''
        const formatValue = $('select[name="format"]').val() || ''; // Valeur par défaut : ''
        const ajaxurl = $(this).data('ajaxurl');

        const data = {
            action: $(this).data('action'), 
            nonce:  $(this).data('nonce'),
            paged: Paged,
            categorie: categorieValue,
            format: formatValue,
        }

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

            if (!body.success) {
                alert(body.data);
                return;
            }

            if (Array.isArray(body.data) && body.data.length > 0) {
 
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
                     $('.no-photo-message-2').hide(); 
                });
            } else {
                $('.no-photo-message-2').show(); 
            }
        });
    });

    $('.form-catalogue').on('change', function() {
        Paged = 1;
          $('.no-photo-message-2').hide(); 
    });
});



/*************************************
 * FILTRES FORMULAIRE CATALOGUE PHOTO
 *************************************/

(function ($) {
    $(document).ready(function () {
  
        $('.form-catalogue').on('change', function() {
 
            var formData = $('.form-catalogue').serialize(); 

            var ajaxUrl = $('.form-catalogue').data('ajaxurl');

            $.ajax({
                method: 'POST',
                url: ajaxUrl, 
                data: {
                    action: 'filtres_photos', 
                    formData: formData, 
                },
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'Cache-Control': 'no-cache',
                },
                success: function (response) {
                 
                    if (response.success) {
                        $('.catalogue-photos').empty();
                        
                        if (response.data.length > 0) {

                            response.data.forEach(function (photo) {
            
                                var colImgCatalogue = $('<div>').addClass('col-img-catalogue');
                                colImgCatalogue.append(
                                    $('<img>').attr('src', photo.image_photo).attr('alt', 'Photo'),
                                    $('<a>').attr('href', photo.permalien).addClass('display-front-hover'),
                                    $('<span>').addClass('uppercase reference').text(photo.reference),
                                    $('<span>').addClass('uppercase categorie').text(photo.nom_categories),
                                    $('<a>').attr('href', photo.permalien).append($('<i>').addClass('fa-regular fa-eye')),
                                    $('<i>').addClass('fa-sharp fa-solid fa-expand')
                                );
      
                                $('.load-result').append(colImgCatalogue);
                            });
                        } else {
                            // Si aucune photo n'est disponible, afficher un message
                            $('.no-photo-message-1').append('<p>Aucune photo ne correspond à vos critères de recherche. Modifiez vos choix ! </p>');
                        }
                    } else {
                        console.error('Une erreur est survenue lors du chargement des photos.');
                    }
                },
                error: function () {
                    console.error('Une erreur est survenue lors de la requête AJAX.');
                }
            });
        });
    });
})(jQuery);





/*************************************
 * LIGHTBOX PHOTO EN COURS
 *************************************/


(function ($) {
    $(document).ready(function () {
  
        $('.load-lightbox-photo').click(function (e){
            e.preventDefault();
            var ajaxUrl = $(this).data('ajaxurl');
            const postId = $(this).data('postid');
            const action = $(this).data('action');
            const nonce =  $(this).data('nonce');
            
            $.ajax({
                method: 'POST',
                url: ajaxUrl, 
                data: {
                    id: postId,
                    action: action,
                    nonce: nonce,
                },
                success: function (response) {

                    if (response.success) {
                        
                        // Remplir les éléments de la lightbox avec les données de l'image
                        $('.lightbox-image').attr('src', response.data.image_photo);
                        $('.reference').text(response.data.reference);
                        $('.categorie').text(response.data.nom_categories);
                        // Afficher la lightbox
                        $('.lightbox').fadeIn();
                    } else {

                    }
                },
                error: function (xhr, status, error) {
                }
            });
        });

        // Gestion de la fermeture de la lightbox
        $('.lightbox_close').click(function () {
            $('.lightbox').fadeOut();
        });
    });
})(jQuery);




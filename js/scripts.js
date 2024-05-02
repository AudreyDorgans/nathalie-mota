/***************************************************
/* MENU HEADER */
/*************************************************/

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



/*************************************************/
/* FONCTIONNALITES HOVER THUMBNAILS SINGLE PHOTO */
/*************************************************/

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


/******************************************************
 * REQUETE AJAX POUR CHARGEMENT DES POSTS SUR FRONTPAGE
 ******************************************************/

jQuery(document).ready(function($) {
   
    let Paged = 1; 
    
    $('.load-catalogue-photos').click(function (e){
        Paged++;

        e.preventDefault();
        const categorieValue = $('select[name="categorie"]').val() || ''; 
        const formatValue = $('select[name="format"]').val() || ''; 
        const ordreValue = $('select[name="ordre"]').val() || ''; 
        const ajaxurl = $(this).data('ajaxurl');

        const data = {
            action: $(this).data('action'), 
            nonce:  $(this).data('nonce'),
            paged: Paged,
            categorie: categorieValue,
            format: formatValue,
            ordre: ordreValue,
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
                    const expandButton = $('<button>')
                    .addClass('load-lightbox-photo')
                    .attr('data-postid', photo.id_photo)
                    .attr('data-nonce', photo.nonce)
                    .attr('data-action', 'NM_load_lightbox_photo')
                    .attr('data-ajaxurl', ajaxurl)
                    .append($('<i>').addClass('fa-sharp fa-solid fa-expand'));

                    colImgCatalogue.append(image, displayFrontHover, reference, categorie, viewLink, expandButton);

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
                                $('<button>').addClass('load-lightbox-photo')
                                    .attr('data-postid', photo.id_photo)
                                    .attr('data-nonce', photo.nonce) 
                                    .attr('data-action', 'NM_load_lightbox_photo')
                                    .attr('data-ajaxurl', ajaxUrl)
                                    .append($('<i>').addClass('fa-sharp fa-solid fa-expand'))
                            );
                            $('.load-result').append(colImgCatalogue);
                        });
                    } else {
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
 * APPARENCE FORMULAIRE CATALOGUE PHOTO
 *************************************/

(function ($) {
    $(document).ready(function () {
        // Stocker le label initial et l'option sélectionnée pour chaque select
        $('.col-select-form select').each(function() {
            var select = $(this);
            var initialLabel = select.closest('.col-select-form').find('.taxonomy-label').text();
            var selectedOptionText = select.find('option:selected').text();
            select.data('initial-label', initialLabel);
            select.data('selected-option-text', selectedOptionText);

             // Ajouter ou supprimer la classe uppercase en fonction du contenu initial du label
            updateUppercaseClass(select);
        });

        $('.col-select-form select').on('change', function() {
            var select = $(this);
            var selectedOption = select.find('option:selected');
            
            // Mettre à jour le texte du label avec l'option sélectionnée
            select.closest('.col-select-form').find('.taxonomy-label').text(selectedOption.text());
            // Ajouter ou supprimer la classe uppercase en fonction du contenu du label
            updateUppercaseClass(select);
        });

        $('.col-select-form select').on('click', function() {
            var select = $(this);
            var initialLabel = select.data('initial-label');
            
            // Réafficher le label initial lorsque le select est cliqué à nouveau
            select.closest('.col-select-form').find('.taxonomy-label').text(initialLabel);
            // Ajouter ou supprimer la classe uppercase en fonction du contenu du label
            updateUppercaseClass(select);
            // Si le label initial est affiché, sélectionner l'option avec la valeur vide
            if (initialLabel === select.find('#option-tout').text()) {
                select.val('');

                // Si une option était déjà sélectionnée, déclencher le changement pour réinitialiser les filtres
                select.trigger('change');
            }
        });

        function updateUppercaseClass(select) {
            var label = select.closest('.col-select-form').find('.taxonomy-label');
            var initialLabel = select.data('initial-label');
            
            if (label.text().trim() === initialLabel) {
                label.addClass('uppercase');
            } else {
                label.removeClass('uppercase');
            }
        }
    });
})(jQuery);


/*************************************
 * LIGHTBOX PHOTO
 *************************************/
(function ($) {
    $(document).ready(function () {

        $(document).on('click', '.load-lightbox-photo', function (e) {
            e.preventDefault();
            var ajaxUrl = $(this).data('ajaxurl');
            const postId = $(this).data('postid');
            const action = $(this).data('action');
            const nonce = $(this).data('nonce');
            
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

                        $('.lightbox-image').attr('src', response.data.image_photo);
                        $('.lightbox-reference').text(response.data.reference);
                        $('.lightbox-categorie').text(response.data.nom_categories);
                        $('.lightbox').fadeIn();

                        var prevPostId = response.data.prev_post_id;
                        var nextPostId = response.data.next_post_id;
                        
                        if (prevPostId !== null) {
                            $('.lightbox-prev').attr('data-postid', prevPostId);
                            $('.lightbox-prev').show();
                        } else {
                            $('.lightbox-prev').attr('data-postid', '');
                            $('.lightbox-prev').hide();
                        }

                        if (nextPostId !== null) {
                            $('.lightbox-next').attr('data-postid', nextPostId);
                            $('.lightbox-next').show();
                        } else {
                            $('.lightbox-next').attr('data-postid', '');
                            $('.lightbox-next').hide();
                        }
                    } else {
                        console.error("Une erreur est survenue lors de l'affichage de la photo");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Une erreur est survenue lors de la requête AJAX.");
                }
            });
        });

        $('.lightbox-close').click(function () {
            $('.lightbox').fadeOut();
        });

        $('.lightbox-prev, .lightbox-next').click(function () {

            var button = $(this); // Référence au bouton cliqué

            var postId = button.data('postid');
            var ajaxUrl = button.data('ajaxurl');
            var action = button.data('action');
            var nonce = button.data('nonce');

            // Vérifier si l'ID est null avant d'effectuer la requête AJAX
            if (postId === null || postId === undefined || postId === '') {
                return; // Arrêter l'exécution de la fonction
            }

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
                        $('.lightbox-image').attr('src', response.data.image_photo);
                        $('.lightbox-reference').text(response.data.reference);
                        $('.lightbox-categorie').text(response.data.nom_categories);

                        var prevPostId = response.data.prev_post_id;
                        var nextPostId = response.data.next_post_id;

                        // Mettre à jour les attributs data-postid des boutons précédent et suivant
                        $('.lightbox-prev').data('postid', prevPostId);
                        $('.lightbox-next').data('postid', nextPostId);

                        // Masquer le bouton si l'ID est null
                        if (prevPostId === null || prevPostId === undefined || prevPostId === '') {
                            $('.lightbox-prev').hide();
                        } else {
                            $('.lightbox-prev').show();
                        }

                        if (nextPostId === null || nextPostId === undefined || nextPostId === '') {
                            $('.lightbox-next').hide();
                        } else {
                            $('.lightbox-next').show();
                        }
                    } else {
                        console.error("Une erreur est survenue lors de l'affichage de la photo");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Une erreur est survenue lors de la requête AJAX.");
                }
            });
        });
    });
})(jQuery);

<div class="container-form">
    <form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="post" class="form-catalogue" data-ajaxurl="<?php echo admin_url( 'admin-ajax.php' ); ?>">		 	
        <input 
            type="hidden" 
            name="nonce" 
            value="<?php echo wp_create_nonce( 'NC_filtres_photos' ); ?>"
        > 

        <div class="col-form col-form-1">
        <?php
            $taxonomies = get_object_taxonomies('photo', 'objects');
            foreach ($taxonomies as $taxonomy) {
                $terms = get_terms($taxonomy->name, array('hide_empty' => false));
            
                echo '<div class="col-select-form">';
                
                    echo '<label class="taxonomy-label uppercase">' . $taxonomy->label . '</label>';
                    echo '<div class="custom-select"><i class="fa-solid fa-chevron-down"></i>';
                        echo '<select name="' . $taxonomy->name . '">';
                            foreach ($terms as $term) {
                                echo '<option value="' . $term->slug . '">' . $term->name . '</option>';
                            }
                        echo '</select>';
                    echo '</div>';
               
                echo '</div>';
            }
        ?>
        </div>

        <div class="col-form col-2-form">
            <div class="col-select-form">
                <label for="ordre" class="uppercase taxonomy-label"> Trier par </label>
                <div class="custom-select"><i class="fa-solid fa-chevron-down"></i>
                    <select name="ordre">
                        <option value="asc">Du plus ancien au plus récent</option>
                        <option value="desc">Du plus récent au plus ancien</option>
                    </select>
                </div>
            </div>
        </div>
    </form>
</div>

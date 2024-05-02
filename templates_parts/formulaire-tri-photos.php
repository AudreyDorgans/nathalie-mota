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
                
                    echo '<label for="' . $taxonomy->name . '" class="taxonomy-label uppercase" >' . $taxonomy->label . '</label>';
                    echo '<select name="' . $taxonomy->name . '" id="' . $taxonomy->name . '">';
                        echo '<option value="" id="option-tout">' . $taxonomy->label . '</option>';
                        foreach ($terms as $term) {
                            echo '<option value="' . $term->slug . '">' . $term->name . '</option>';
                        }
                    echo '</select>';
               
                echo '</div>';
            }
        ?>
        </div>

        <div class="col-form col-2-form">
            <div class="col-select-form">
                <label for="ordre" class="uppercase taxonomy-label"> Trier par </label>
                <select name="ordre" id="ordre">
                    <option value="desc" id="option-defaut">A partir des plus récentes</option>
                    <option value="desc">A partir des plus récentes</option>
                    <option value="asc">A partir des plus anciennes</option>
                </select>
            </div>
        </div>
    </form>
</div>

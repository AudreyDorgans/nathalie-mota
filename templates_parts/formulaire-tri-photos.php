<form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="post" class="form-catalogue" data-ajaxurl="<?php echo admin_url( 'admin-ajax.php' ); ?>">		 	
	<input 
        type="hidden" 
        name="nonce" 
        value="<?php echo wp_create_nonce( 'NC_filtres_photos' ); ?>"
    > 
	<?php
    	$taxonomies = get_object_taxonomies('photo', 'objects');
    	foreach ($taxonomies as $taxonomy) {
        	$terms = get_terms($taxonomy->name, array('hide_empty' => false));
        
        echo '<div>';
            echo '<label class="taxonomy-label">' . $taxonomy->label;
            echo '<select name="' . $taxonomy->name . '">';
                echo '<option value="" id="option-defaut"></option>'; 
                foreach ($terms as $term) {
                    echo '<option value="' . $term->slug . '">' . $term->name . '</option>';
                }
            echo '</select>';
            echo '</label>';
        echo '</div>';
    			}
    ?>

	<div>
        <label for="ordre"> Trier par :</label>
        <select name="ordre" id="ordre">
			<option value="" id="option-defaut"></option>
           	<option value="asc">Du plus ancien au plus récent</option>
            <option value="desc">Du plus récent au plus ancien</option>
        </select>
    </div>
</form>
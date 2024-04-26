/*************************************************/
/* MODALE HEADER CONTACT */
/*************************************************/
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



/*************************************************/
/* FONCTIONNALITE REFERENCE CONTACT  */
/*************************************************/
jQuery(document).ready(function() {

    jQuery(".bouton-avec-reference").click(function() {

        var reference = jQuery(".reference").text();

        jQuery("#input-reference").val(reference);
    });
});
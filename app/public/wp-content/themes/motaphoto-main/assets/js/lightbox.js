// lightbox.js

document.addEventListener('DOMContentLoaded', function() {
    function openLightbox(event) {
        event.preventDefault();
        console.log("Lightbox.js Prêt !")
        
        // Afficher la lightbox
        var lightbox = document.querySelector('.lightbox');
        lightbox.classList.remove('hidden');
        
        // Charger l'image dans la lightbox
        var imgSrc = this.getAttribute('data-img-src');
        lightbox.querySelector('img').setAttribute('src', imgSrc);
    }
    
    function closeLightbox() {
        var lightbox = document.querySelector('.lightbox');
        lightbox.classList.add('hidden');
    }

    // Ajouter des écouteurs d'événements aux boutons
    document.querySelectorAll('.openLightbox').forEach(function(button) {
        button.addEventListener('click', openLightbox);
    });

    // Ajouter un écouteur d'événement au bouton de fermeture
    var closeButton = document.querySelector('.lightbox .close');
    if (closeButton) {
        closeButton.addEventListener('click', closeLightbox);
    }
});

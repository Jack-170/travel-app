import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
function updateUrl(newUrl) {
    history.pushState({}, '', '/travel-app');
}

document.querySelectorAll('.navigate-button').forEach(button => {
    button.addEventListener('click', function() {
        updateUrl();
        // Carica il contenuto dinamico per la nuova sezione via AJAX
        loadContent();
    });
});

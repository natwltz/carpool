var modalSuppressionTrajet = document.getElementById('modal-suppression');
var inputTrajetId = document.getElementById('modal-trajet-id');

function ouvrirModal(id) {
    if (inputTrajetId && modalSuppressionTrajet) {
        inputTrajetId.value = id;
        modalSuppressionTrajet.style.display = 'flex';
    } else {
        console.error("Erreur : la modale n'a pas été trouvée dans le DOM.");
    }
}

function fermerModal() {
    if (modalSuppressionTrajet && inputTrajetId) {
        modalSuppressionTrajet.style.display = 'none';
        inputTrajetId.value = '';
    }
}

// Fermer la modale si on clique en dehors de la boîte de dialogue
window.onclick = function(event) {
    if (event.target === modalSuppressionTrajet) {
        fermerModal();
    }
}
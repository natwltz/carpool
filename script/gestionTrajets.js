const modal = document.getElementById('modal-suppression');
const inputId = document.getElementById('modal-trajet-id');

function ouvrirModal(id) {
    inputId.value = id;
    modal.style.display = 'flex';
}

function fermerModal() {
    modal.style.display = 'none';
    inputId.value = '';
}

// Fermer la modale si on clique en dehors de la boîte de dialogue
window.onclick = function(event) {
    if (event.target === modal) {
        fermerModal();
    }
}
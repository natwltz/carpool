document.querySelectorAll(".modal-ouverture").forEach(function(btn){
    btn.addEventListener("click",function(){
        // Récupère l'ID de la modale cible via l'attribut data-modal
        let modalId = this.getAttribute("data-modal");
        let targetModal = document.getElementById(modalId);
        if(targetModal) {
            targetModal.style.display = "flex";
        }
    });
});

document.querySelectorAll(".fermer-modal").forEach(function(btn){
    btn.addEventListener("click",function(){
        this.closest(".modal").style.display = "none";
    });
});

window.addEventListener("click", function(event) {
    // Permet de fermer la modale si l'on clique à l'extérieur (sur le fond grisé)
    if (event.target.classList.contains("modal")) {
        event.target.style.display = "none";
    }
});
function supprimerStockageLocal() {
    localStorage.removeItem('prenom');
    localStorage.removeItem('nom');
    window.location.reload();
}
supprimerStockageLocal();
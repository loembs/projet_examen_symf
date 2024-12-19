export default class ClientModalController {
  load() {
    const mainContainer = document.getElementById("clientModal");
    if (mainContainer) {
      fetch("./HTML/ClientModal.html")
        .then((response) => response.text())
        .then((html) => {
          mainContainer.innerHTML = html;
        })
        .catch((error) => {
          console.error("Erreur lors du chargement du clientModal :", error);
        });
    } else {
      console.error('Élément avec l\'ID "main" introuvable dans le DOM.');
    }
  }
}

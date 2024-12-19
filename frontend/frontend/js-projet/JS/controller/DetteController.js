export default class DetteController {
  load() {
    const mainContainer = document.getElementById("main");
    if (mainContainer) {
      fetch("./HTML/layout.html")
        .then((response) => response.text())
        .then((html) => {
          mainContainer.innerHTML = html;
        })
        .catch((error) => {
          console.error("Erreur lors du chargement du detteIndex :", error);
        });
    } else {
      console.error('Élément avec l\'ID "main" introuvable dans le DOM.');
    }
  }
}

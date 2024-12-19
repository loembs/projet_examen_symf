export default class Controller {
  constructor(containerId, htmlPath) {
    this.containerId = containerId; // ID du conteneur HTML (e.g., "sidebar" ou "main")
    this.htmlPath = htmlPath; // Chemin vers le fichier HTML à charger
  }

  loadContent() {
    const mainContainer = document.getElementById(this.containerId);
    if (mainContainer) {
      fetch(this.htmlPath)
        .then((response) => response.text())
        .then((html) => {
          mainContainer.innerHTML = html;
        })
        .catch((error) => {
          console.error(
            `Erreur lors du chargement du contenu de ${this.htmlPath}:`,
            error
          );
        });
    } else {
      console.error(
        `Élément avec l'ID "${this.containerId}" introuvable dans le DOM.`
      );
    }
  }
}

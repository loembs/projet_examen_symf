export default class DashbordController {
  load() {
    const mainContainer = document.getElementById("main");
    if (mainContainer) {
      fetch("./HTML/Dashbord.html") // Charge le fichier HTML
        .then((response) => response.text())
        .then((html) => {
          mainContainer.innerHTML = html;
          // Initialisation des popovers
        })
        .catch((error) => {
          console.error("Erreur lors du chargement du dashboard:", error);
        });
    } else {
      console.error('Élément avec l\'ID "moi" introuvable dans le DOM.');
    }
  }
}

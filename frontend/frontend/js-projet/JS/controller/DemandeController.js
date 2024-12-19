export default class DemandeController {
  constructor() {
    this.apiEndpoint = "http://localhost:8000/api/demandes"; // URL de l'API
  }

  // Méthode principale pour charger les données et mettre à jour la vue
  load() {
    const mainContainer = document.getElementById("main");

    if (mainContainer) {
      fetch(this.apiEndpoint)
        .then((response) => {
          if (!response.ok) {
            throw new Error("Erreur réseau : " + response.status);
          }
          return response.json();
        })
        .then((data) => {
          mainContainer.innerHTML = this.generateHtml(data);
        })
        .catch((error) => {
          console.error("Erreur lors du chargement des demandes :", error);
          mainContainer.innerHTML =
            "<p>Impossible de charger les demandes pour le moment.</p>";
        });
    } else {
      console.error('Élément avec l\'ID "main" introuvable dans le DOM.');
    }
  }

  // Génération dynamique du HTML à partir des données JSON
  generateHtml(demandes) {
    let html = `
      <h2 class="text-xl font-bold mb-4">Liste des demandes</h2>
      <div>
        <label for="statut">Statut :</label>
        <select id="statut" class="p-2 border rounded">
          <option value="">Tous</option>
          <option value="En cours">En cours</option>
          <option value="Accepté">Accepté</option>
          <option value="Annulé">Annulé</option>
        </select>
      </div>

      <table class="table-auto w-full mt-4">
        <thead>
          <tr>
            <th>DATE</th>
            <th>MONTANT</th>
            <th>NOM COMPLET</th>
            <th>TÉLÉPHONE</th>
            <th>STATUT</th>
            <th>ACTION</th>
          </tr>
        </thead>
        <tbody>
    `;

    // Boucle pour ajouter chaque ligne de demande dynamiquement
    demandes.forEach((demande) => {
      html += `
        <tr class="border-b">
          <td>${demande.dateRelance}</td>
          <td>${demande.montantDemande}</td>
          <td>${demande.client.surname}</td>
          <td>${demande.client.telephone}</td>
          <td>${demande.etat}</td>
          <td>
            <button 
              onclick="alert('Détails de ${demande.client.surname}')"
              class="bg-blue-500 text-white px-2 py-1 rounded">
              Détails
            </button>
          </td>
        </tr>
      `;
    });

    html += `
        </tbody>
      </table>
    `;

    return html;
  }
}





























/*export default class DemandeController {
  load() {
    const mainContainer = document.getElementById("main");
    if (mainContainer) {
      fetch("./HTML/DemandeIndex.html")
        .then((response) => response.text())
        .then((html) => {
          mainContainer.innerHTML = html;
        })
        .catch((error) => {
          console.error("Erreur lors du chargement du demandeIndex :", error);
        });
    } else {
      console.error('Élément avec l\'ID "main" introuvable dans le DOM.');
    }
  }
}*/

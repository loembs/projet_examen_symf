export default class DemandeRepository {
  async GetDemandes() {
    try {
      const apiUrl = "http://127.0.0.1:8000/api/clients";
      const response = await fetch(apiUrl);
      const clients = await response.json();
      return clients;
    } catch (error) {
      console.error("Erreur lors de la récupération des clients:", error);
    }
  }
}

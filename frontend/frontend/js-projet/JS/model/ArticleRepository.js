export default class ArticleRepository {
  async GetArticles() {
    try {
      const apiUrl = "http://127.0.0.1:8000/api/articles";
      const response = await fetch(apiUrl);
      const articles = await response.json();
      return articles ;
    } catch (error) {
      console.error("Erreur lors de la récupération des articles:", error);
    }
  }
}

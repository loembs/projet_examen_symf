import ArticleRepository from "../model/ArticleRepository.js";

export default class ArticleController {
articleRepository = new ArticleRepository();

  async load() {
    const mainContainer = document.getElementById("main");
    
    try {
      const articles = await this.articleRepository.getArticles();
      
      if (mainContainer) {
        const response = await fetch("./HTML/ArticleIndex.html");
        const html = await response.text();
        mainContainer.innerHTML = html;

        const tbody = document.getElementById("articlesTable");
        const searchInput = document.querySelector('input[placeholder="libelle"]');
        const searchButton = searchInput.nextElementSibling;

        this.fillTable(tbody, articles);

        // Gestionnaire de recherche
        searchInput.addEventListener('input', () => {
          const searchValue = searchInput.value.trim();
          const filteredArticles = this.searchArticles(articles, searchValue);
          this.fillTable(tbody, filteredArticles);
        });

        // Gestionnaire pour les boutons de filtre
        const filterButtons = document.querySelectorAll('.mb-4 button');
        filterButtons.forEach(button => {
          button.addEventListener('click', () => {
            // Retirer la classe active de tous les boutons
            filterButtons.forEach(btn => btn.classList.remove('bg-red-500', 'text-white'));
            button.classList.add('bg-red-500', 'text-white');
            // Implémenter la logique de filtrage ici
          });
        });

      }
    } catch (error) {
      console.error("Erreur lors du chargement des articles :", error);
    }
  }

  fillTable(tbody, articles) {
    if (!Array.isArray(articles)) {
      console.error('Les articles ne sont pas un tableau');
      return;
    }

    tbody.innerHTML = "";
    
    articles.forEach((article) => {
      const row = document.createElement("tr");
      row.innerHTML = `
        <td class="p-2 text-center">
          <input
            type="checkbox"
            name="article[]"
            value="${article.id}"
            class="form-checkbox h-4 w-4 text-blue-600"
          />
        </td>
        <td class="border border-gray-300 p-2 text-center">${article.libelle || 'N/A'}</td>
        <td class="border border-gray-300 p-2 text-center">${article.prix || '0'}</td>
        <td class="border border-gray-300 p-2 text-center">${article.qtstock || '0'}</td>
      `;
      tbody.appendChild(row);
    });
  }

  searchArticles(articles, searchTerm) {
    if (!searchTerm) return articles;
    
    return articles.filter((article) =>
      article.libelle.toLowerCase().includes(searchTerm.toLowerCase())
    );
  }
}

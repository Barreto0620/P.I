// Barra de pesquisa 
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const tableRows = document.querySelectorAll('#table_body tr');

    searchInput.addEventListener('keyup', () => {
        let searchTerm = searchInput.value.toLowerCase().trim();

        if (searchTerm.length < 2) {
            tableRows.forEach(row => {
                row.style.display = ''; // Exibe todas as linhas da tabela se o termo de pesquisa for muito curto
            });
            return;
        }

        tableRows.forEach(row => {
            let rowContent = row.innerHTML.toLowerCase();
            if (rowContent.includes(searchTerm)) {
                row.style.display = ''; // Exibe a linha se o termo de pesquisa estiver presente nela
            } else {
                row.style.display = 'none'; // Oculta a linha se o termo de pesquisa não estiver presente nela
            }
        });
    });
});

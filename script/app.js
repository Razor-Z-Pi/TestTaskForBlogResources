document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchButton = document.getElementById('searchButton');
    const errorMessage = document.getElementById('errorMessage');
    const resultsDiv = document.getElementById('results');
    const loadingDiv = document.getElementById('loading');
    
    // Включаем/выключаем кнопку в зависимости от длины ввода
    searchInput.addEventListener('input', function() {
        searchButton.disabled = this.value.length < 3;
        if (this.value.length > 0 && this.value.length < 3) {
            errorMessage.textContent = 'Введите минимум 3 символа!!!';
        } else {
            errorMessage.textContent = '';
        }
    });
    
    // Обработка формы
    document.getElementById('searchForm').addEventListener('submit', function(event) {
        event.preventDefault();
        let searchTerm = searchInput.value.trim();
        
        if (searchTerm.length < 3) {
            errorMessage.textContent = 'Введите минимум 3 символа!!!';
            return;
        }
        
        // Показываем индикатор загрузки
        loadingDiv.style.display = 'block';
        resultsDiv.innerHTML = '';
        
        // AJAX-запрос
        fetch(`http://localhost/TestTaskForBlogResources/script/search_comments.php?q=${encodeURIComponent(searchTerm)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Ошибка сети');
                }
                return response.json();
            })
            .then(data => {
                loadingDiv.style.display = 'none';
                
                if (data.error) {
                    errorMessage.textContent = data.error;
                    return;
                }
                
                if (data.length === 0) {
                    resultsDiv.innerHTML = '<b>Ничего не найдено!!!</b>';
                    return;
                }
                
                // Отображаем результаты
                data.forEach(post => {
                    let postElement = document.createElement('div');
                    postElement.className = 'post';
                    
                    let titleElement = document.createElement('div');
                    titleElement.className = 'post-title';
                    titleElement.textContent = post.title;
                    
                    let commentElement = document.createElement('div');
                    commentElement.className = 'comment';
                    
                    // Подсветка искомого текста
                    let commentText = post.commentBody;
                    let regex = new RegExp(searchTerm, 'gi');
                    commentText = commentText.replace(regex, match => 
                        `<span class="highlight">${match}</span>`
                    );
                    
                    commentElement.innerHTML = commentText;
                    
                    postElement.appendChild(titleElement);
                    postElement.appendChild(commentElement);
                    resultsDiv.appendChild(postElement);
                });
            })
            .catch(error => {
                loadingDiv.style.display = 'none';
                errorMessage.textContent = 'Произошла ошибка: ' + error.message;
            });
    });
});
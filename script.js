window.onload = function () {
  fetch('download.php')
    .then(response => {
      if (!response.ok) throw new Error('Server responded with status ' + response.status);
      return response.json();
    })
    .then(files => {
      console.log('Files received:', files); // Add this line
      const list = document.getElementById('downloadList');
      list.innerHTML = ''; // Clear previous content

      files.forEach(file => {
        // Check if both fields exist
        if (file.filename && file.display) {
          const li = document.createElement('li');
          li.innerHTML = `<a href="downloads/${file.filename}" download>${file.display}</a>`;
          list.appendChild(li);
        } else {
          console.warn('Missing filename or display value:', file);
        }
      });
    })
    .catch(error => {
      console.error('Fetch Error:', error);
      const list = document.getElementById('downloadList');
      list.innerHTML = '<li>عذراً، تعذر تحميل الملفات حالياً</li>';
    });
};

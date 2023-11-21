<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias</title>
    <style>
        #carrusel {
            width: 70%;
            margin: auto;
            overflow: hidden;
        }

        #carrusel .noticia {
            display: none;
        }
    </style>
</head>
<body>
    <div id="carrusel"></div>

    <script>
        let slideIndex = 0;

        function obtenerNoticias() 
        {
            fetch('api/apiNoticia.php')
                .then(response => response.json())
                .then(data => {
                    mostrarNoticias(data);
                })
                .catch(error => console.error('Error al obtener noticias:', error));
        }

        function mostrarNoticias(noticias) 
        {
            const carrusel = document.getElementById('carrusel');
            
            noticias.forEach(noticia => {
                const noticiaElement = document.createElement('div');
                noticiaElement.classList.add('noticia');
                noticiaElement.innerHTML = `
                    <h3>${noticia['titulo']}</h3>
                    <p>${noticia['contenido']}</p>
                `;
                carrusel.appendChild(noticiaElement);
            });

            mostrarSlide();
        }

        function mostrarSlide() 
        {
            const noticias = document.getElementsByClassName('noticia');
            for (let i = 0; i < noticias.length; i++) {
                noticias[i].style.display = 'none';
            }
            slideIndex++;
            if (slideIndex > noticias.length) {
                slideIndex = 1;
            }
            noticias[slideIndex - 1].style.display = 'block';
            setTimeout(mostrarSlide, 2000); 
        }

        obtenerNoticias();
    </script>
</body>
</html>

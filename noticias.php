<?php
$user = $_GET['user'];

session_start();

if (isset($user) && !empty($user)) 
{
    $_SESSION['user'] = $user;
} 
else 
{
    echo "Error: Debes proporcionar un usuario en la URL.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias</title>
    <link rel="stylesheet" href="css/noticia.css">
</head>
<body>
    <div id="carrusel"></div>
    <div class="paginacion" id="paginacion"></div>

    <script>
        let slideIndex = 0;
        let noticiasUsuario = [];

        const user = '<?php echo $user; ?>';

        function obtenerNoticias() {
            fetch('api/apiNoticia.php')
                .then(response => response.json())
                .then(data => {
                    noticiasUsuario = data.filter(noticia => noticia.perfil === user);
                    mostrarNoticias(noticiasUsuario);
                })
                .catch(error => console.error('Error al obtener noticias:', error));
        }
       

        /*function obtenerNoticias() {
            fetch('api/apiNoticia.php')
                .then(response => response.json())
                .then(data => {
                    mostrarNoticias(data);
                })
                .catch(error => console.error('Error al obtener noticias:', error));
        } */

        function mostrarNoticias(noticias) {
            const carrusel = document.getElementById('carrusel');
            const paginacion = document.getElementById('paginacion');

            noticias.forEach((noticia, index) => {
                const noticiaElement = document.createElement('div');
                noticiaElement.classList.add('noticia');
                noticiaElement.innerHTML = `
                    <h3>${noticia['titulo']}</h3>
                    <p>${noticia['contenido']}</p>
                    ${(noticia['tipoUrl'] === 'foto') ? `<img src='${noticia['url']}' alt='imagen'>` : ''}
                    ${(noticia['tipoUrl'] === 'video') ? `<video src='${noticia['url']}' autoplay muted loop controls></video>` : ''}
                `;
                carrusel.appendChild(noticiaElement);

                const paginacionBtn = document.createElement('button');
                paginacionBtn.onclick = () => cambiarSlide(index + 1);
                paginacion.appendChild(paginacionBtn);
            });

            mostrarSlide();
        }

        function mostrarSlide() {
            const noticias = document.getElementsByClassName('noticia');
            const paginacionBtns = document.querySelectorAll('.paginacion button');

            for (let i = 0; i < noticias.length; i++) {
                noticias[i].style.display = 'none';
                noticias[i].style.transform = 'translateX(100%)';
                paginacionBtns[i].classList.remove('active');
            }
            slideIndex++;
            if (slideIndex > noticias.length) {
                slideIndex = 1;
            }
            noticias[slideIndex - 1].style.display = 'block';
            noticias[slideIndex - 1].style.transform = 'translateX(0)';
            paginacionBtns[slideIndex - 1].classList.add('active');
            setTimeout(mostrarSlide, 5000);
        }

        obtenerNoticias();
    </script>
</body>
</html>

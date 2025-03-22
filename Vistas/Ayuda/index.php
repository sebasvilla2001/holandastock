<?php include "Vistas/Templates/header.php"; ?>

<body>
    <link href="<?php echo base_url; ?>Assets/css/estilos.css" rel="stylesheet" />
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Centro de Ayuda</li>
    </ol>
    <div class="container">
        <h2>Centro de Ayuda</h2>
        <div class="image">
            <a href="manual_de_usuario.pdf" target="_blank">
                <img src="Assets/img/manual.png" alt="Manual de Usuario">
            </a>
        </div>
        <div class="info-box">
            <p>Si necesitas asistencia con el uso de nuestro sistema, consulta el <strong>Manual de Usuario</strong> haciendo clic en la imagen de arriba.</p>
        </div>
        <ul>
            <li class="lista">Paso 1: Descarga el manual</li>
            <li class="lista">Paso 2: Revisa las secciones según tu necesidad</li>
            <li class="lista">Paso 3: Si sigues teniendo dudas, contáctanos</li>
        </ul>
        <div class="footer-message">
            <p>Si necesitas más ayuda, contáctanos a 7276-1434</p>
        </div>
    </div>
</body>

<?php include "Vistas/Templates/footer.php"; ?>

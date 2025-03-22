<?php include "Vistas/Templates/header.php";?>

<body>
    <link href="<?php echo base_url; ?>Assets/css/estilos.css" rel="stylesheet" />
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Bienvenida HolandaStock</li>
    </ol>

    <div class="welcome-container">
        <h1>¡Bienvenido a HolandaStock!</h1>
        <p class="welcome-message">Estamos encantados de tenerte aquí. HolandaStock es tu solución integral para la gestión de inventarios. Navega a través de nuestras funcionalidades y optimiza tu experiencia de gestión.</p>
        <a href="<?php echo base_url;?>Productos">
            <button class="start-button">Ir a Productos</button>
        </a>
    </div>
</body>

<?php include "Vistas/Templates/footer.php";?>
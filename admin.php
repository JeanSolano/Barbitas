<?php
echo <<<HTML
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel de Administrador - Gentlemen's Barber Shop</title>
    <!-- CSS FILES -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@300;500&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-barber-shop.css" rel="stylesheet">
</head>
<body class="admin-dark">
    <div class="container-fluid">
        <div class="row">

            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse p-0">
                <div class="position-sticky sidebar-sticky d-flex flex-column justify-content-center align-items-center h-100">
                    <a class="navbar-brand" href="index.html">
                        <img src="images/templatemo-barber-logo.png" class="logo-image img-fluid" alt="Barber Shop Logo">
                    </a>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="index.html">Inicio</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="col-md-1 ms-sm-auto col-lg-10 p-0" style="min-height: 100vh; background: #181818;">
                <section class="booking-section w-100 py-5" style="background: none; min-height: auto;">
                    <div class="container">
                        <div class="row mb-3">
                            <div class="col-12 text-center">
                                <h2 class="mb-3">Panel de Administrador</h2>
                                <p>Modifica citas agendadas o agrega un nuevo barbero</p>
                            </div>
                        </div>
                        <div class="row g-4">
                            <!-- Modificar cita -->
                            <div class="col-lg-7">
                                <div class="admin-panel-card p-4 mb-4">
                                    <h4 class="mb-4">Citas Agendadas</h4>
                                    <table class="table table-dark table-hover">
                                        <thead>
                                            <tr>
                                                <th>Cliente</th>
                                                <th>Fecha</th>
                                                <th>Hora</th>
                                                <th>Barbero</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Juan Pérez</td>
                                                <td>2025-05-20</td>
                                                <td>10:00</td>
                                                <td>Carlos</td>
                                                <td>
                                                    <button class="btn btn-sm custom-btn" data-bs-toggle="modal" data-bs-target="#editarCitaModal">Editar</button>
                                                    <button class="btn btn-sm btn-danger">Eliminar</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Ana López</td>
                                                <td>2025-05-21</td>
                                                <td>12:00</td>
                                                <td>Mario</td>
                                                <td>
                                                    <button class="btn btn-sm custom-btn">Editar</button>
                                                    <button class="btn btn-sm btn-danger">Eliminar</button>
                                                </td>
                                            </tr>
                                            <!-- Más filas aquí -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Agregar barbero -->
                            <div class="col-lg-5">
                                <div class="admin-panel-card p-4 mb-4">
                                    <h4 class="mb-4">Agregar Barbero</h4>
                                    <form action="#" method="post">
                                        <div class="mb-3">
                                            <input type="text" name="barber_name" class="form-control" placeholder="Nombre del barbero" required>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" name="barber_specialty" class="form-control" placeholder="Especialidad" required>
                                        </div>
                                        <div class="d-grid">
                                            <button type="submit" class="btn custom-btn">Agregar Barbero</button>
                                        </div>
                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
                        <!-- Modal para editar cita -->
            <div class="modal fade" id="editarCitaModal" tabindex="-1" aria-labelledby="editarCitaModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editarCitaModalLabel">Editar Cita</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                Aquí puedes poner el formulario o información para editar la cita.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <!-- JAVASCRIPT FILES -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/click-scroll.js"></script>
    <script src="js/custom.js"></script>
</body>
</html>
HTML;
?>

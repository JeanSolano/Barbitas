<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Datos de la Cita</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        .factura-container {
            max-width: 500px;
            margin: 40px auto;
            padding: 30px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .factura-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .factura-datos {
            font-size: 1.1em;
        }
        .factura-datos dt {
            font-weight: bold;
        }
        .factura-footer {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="factura-container">
        <div class="factura-header">
            <h2>Factura de Cita Agendada</h2>
            <p>Gracias por agendar tu cita con nosotros.</p>
        </div>
        <dl class="factura-datos row">
            <dt class="col-sm-5">Nombre:</dt>
            <dd class="col-sm-7"><?php echo htmlspecialchars($_POST['bb-name'] ?? ''); ?></dd>

            <dt class="col-sm-5">Teléfono:</dt>
            <dd class="col-sm-7"><?php echo htmlspecialchars($_POST['bb-phone'] ?? ''); ?></dd>

            <dt class="col-sm-5">Hora:</dt>
            <dd class="col-sm-7"><?php echo htmlspecialchars($_POST['bb-time'] ?? ''); ?></dd>

            <dt class="col-sm-5">Sucursal:</dt>
            <dd class="col-sm-7"><?php echo htmlspecialchars($_POST['bb-branch'] ?? ''); ?></dd>

            <dt class="col-sm-5">Fecha:</dt>
            <dd class="col-sm-7"><?php echo htmlspecialchars($_POST['bb-date'] ?? ''); ?></dd>

            <dt class="col-sm-5">Número de personas:</dt>
            <dd class="col-sm-7"><?php echo htmlspecialchars($_POST['bb-number'] ?? ''); ?></dd>

            <dt class="col-sm-5">Barbero:</dt>
            <dd class="col-sm-7"><?php echo htmlspecialchars($_POST['bb-message'] ?? ''); ?></dd>
        </dl>
        <div class="factura-footer">
            <a href="index.html" class="btn btn-primary">Gracias por preferir Barbitas Barbershop</a>
        </div>
    </div>
</body>
</html>
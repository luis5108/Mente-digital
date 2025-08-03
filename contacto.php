<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Mente-digital</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <main>
        <section id="contacto" class="section-padding">
            <h2 class="section-title">Contáctanos</h2>
            <p class="section-description">¿Tienes alguna pregunta, sugerencia o necesitas ayuda? Envíanos un mensaje y
                te responderemos a la brevedad.</p>
            <div class="container contact-form-container">
                <form class="contact-form">
                    <div class="form-group">
                        <label for="name">Nombre:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="subject">Asunto:</label>
                        <input type="text" id="subject" name="subject">
                    </div>
                    <div class="form-group">
                        <label for="message">Mensaje:</label>
                        <textarea id="message" name="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn-primary">Enviar Mensaje</button>
                </form>
                <div class="contact-details">
                    <h3>Información de Contacto</h3>
                    <p><strong>Email:</strong> <span class="neon-text">info@celularinfo.com</span></p>
                    <p><strong>Teléfono:</strong> <span class="neon-text">+123 456 7890</span></p>
                    <p><strong>Dirección:</strong> Calle Ficticia 123, Ciudad Digital, País Virtual</p>
                    <p><strong>Horario:</strong> Lunes a Viernes, 9:00 AM - 6:00 PM</p>
                </div>
            </div>
        </section>
    </main>

    <?php include 'footer.php'; ?>
</body>

</html>
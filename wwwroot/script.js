/******************************************
 *  Author : Author
 *  Created On : Sun Jul 05 2026
 *  File : script.js
 *******************************************/
$(function () {

  // ── Generate ──────────────────────────────────────────
  $(".header > h1").on("click", function() {
    $(".header").toggleClass("hidden");
    $("form").toggleClass("hidden");
    $("form input").val('');
    $("textarea").val('');
  });

  function generate() {
    const $btn = $("#generate > button");
    $btn.prop("disabled", true).toggleClass("hidden");
    $("#error-alert").addClass("d-none");

    var form = new FormData($("form").not('.hidden')[0]);

    $.ajax({
      url: $("form").not('.hidden').attr('action'),
      method: "POST",
      data: form,
      dataType: "json",
      processData: false,
      contentType: false,
      success: function (rsa) {
        $("#key").val(rsa.key);
        $("#key_ssh").val(rsa.key_ssh);
        $("#pub").val(rsa.pub);
        $("#ssh").val(rsa.ssh);
        $("#ppk").val(rsa.ppk);
        // Solo actualiza comment si el servidor devuelve un valor distinto
        if (rsa.comment && rsa.comment !== $("form").not('.hidden').find("#comment").val()) {
          $("form").not('.hidden').find("#comment").val(rsa.comment);
        }
      },
      error: function (xhr) {
        $("#key, #pub, #ssh, #ppk").val("");
        const msg = xhr.responseJSON && xhr.responseJSON.error
          ? xhr.responseJSON.error
          : "Error al generar las claves. Inténtalo de nuevo.";
        $("#error-msg").text(msg);
        $("#error-alert").removeClass("d-none");
      },
      complete: function () {
        $btn.prop("disabled", false).toggleClass("hidden");
      }
    });
  }

  $("#generate > button").on("click", generate);
  $("#options").on("submit", function (e) { e.preventDefault(); generate(); });

  // ── Toggle password ───────────────────────────────────
  $("#toggle-password").on("click", function () {
    const $input = $("#password");
    const show   = $input.attr("type") === "password";
    $input.attr("type", show ? "text" : "password");
    $(this).find("i").toggleClass("fa-eye", !show).toggleClass("fa-eye-slash", show);
  });

  // ── Upload ─────────────────────────────────────────────
  $(".tool-action-btn.reset").on("click", function () {
    $(this).closest(".card").find("input[type='file']").val('');
    $(this).closest(".card").find("textarea").val('');
    $(this).parent().find('input[type="file"]').trigger("change");
  });

  $(".tool-action-btn.upload").on("click", function () {
    $(this).blur();
    $(this).closest(".card").find("input[type='file']").click();
  });

  $("input[type='file']").on("change", function() {
    $(this).closest(".card").find("textarea").val($(this)[0].files[0].name);
  });

  $(".tool-action-btn.upload").closest(".card").on({
    'dragover': function(event) {
      $(this).addClass('dragover');
      event.preventDefault();
    },
    'dragleave dragend': function(event) {
      $(this).removeClass('dragover');
      event.preventDefault();
    },
    'drop': function(event) {
      $(this).removeClass('dragover');
      event.preventDefault();

      var files =  event.originalEvent.dataTransfer.files;
      if (undefined == $(this).parent().find('input[type="file"]').attr('multiple')) {
        var dt = new DataTransfer();
        dt.items.add(files[0]);
        files = dt.files;
      }

      $(this).parent().find('input[type="file"]')[0].files = files;
      $(this).parent().find('input[type="file"]').trigger("change");
    }
  });

  // ── Paste ──────────────────────────────────────────────
  $(".tool-action-btn.paste").on("click", async function () {
    const $btn    = $(this);
    const textarea = $btn.closest(".card").find("textarea");
    const origHtml = $btn.html();

    if (!navigator.clipboard?.readText) {
      $btn.html('<i class="fa-solid fa-xmark me-2"></i>No soportado');
      setTimeout(() => $btn.html(origHtml), 2000);
      return;
    }

    $btn.prop("disabled", true);

    try {
      const text = await navigator.clipboard.readText();

      textarea.val(text).trigger("input").trigger("change");

      $btn.html('<i class="fa-solid fa-check me-2"></i>Pegado');
    } catch (err) {
      console.error(err);
      // Fallback para contextos sin HTTPS
      try {
        textarea[0].select();
        document.execCommand("paste");
        $btn.html('<i class="fa-solid fa-check me-2"></i>Pegado');
        setTimeout(function () { $btn.html(origHtml); }, 1800);
      } catch (e) {
        $btn.html('<i class="fa-solid fa-xmark me-2"></i>Error');
        setTimeout(function () { $btn.html(origHtml); }, 2000);
      }
    } finally {
      setTimeout(() => {
        $btn.html(origHtml);
        $btn.prop("disabled", false);
      }, 1800);
    }
  });

  // ── Copy ──────────────────────────────────────────────
  $(".tool-action-btn.copy").on("click", function () {
    const $btn    = $(this);
    const textarea = $btn.closest(".card").find("textarea").not('.hidden');
    const text    = textarea.val();

    if (!text) return;

    const origHtml = $btn.html();

    navigator.clipboard.writeText(text)
      .then(function () {
        $btn.html('<i class="fa-solid fa-check me-2"></i>Copiado');
        setTimeout(function () { $btn.html(origHtml); }, 1800);
      })
      .catch(function () {
        // Fallback para contextos sin HTTPS
        try {
          textarea[0].select();
          document.execCommand("copy");
          $btn.html('<i class="fa-solid fa-check me-2"></i>Copiado');
          setTimeout(function () { $btn.html(origHtml); }, 1800);
        } catch (e) {
          $btn.html('<i class="fa-solid fa-xmark me-2"></i>Error');
          setTimeout(function () { $btn.html(origHtml); }, 2000);
        }
      });
  });

  // ── Download ──────────────────────────────────────────
  $(".tool-action-btn.download").on("click", function () {
    const textarea = $(this).closest(".card").find("textarea").not('.hidden');
    const text     = textarea.val();

    if (!text) return;

    const file = document.createElement("a");
    file.download = ($("#comment").val() || "id_rsa") + $(this).data("extension");
    file.href = URL.createObjectURL(
      new Blob([text], { type: $(this).data("mimetype") })
    );
    file.click();
    URL.revokeObjectURL(file.href);
  });

  // ── Toogle OpenSSH/PKCS8 ────────────────────────────────
  $(".tool-action-btn.toogle-ssh").on("click", function () {
    $(this).closest(".card").find("textarea").toggleClass('hidden');
    $(this).closest(".card").find(".tool-action-btn.download").toggleClass('hidden');
    $(".tool-action-btn.toogle-ssh").toggleClass('hidden');
  });
});

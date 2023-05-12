$(document).ready(function () {
  if (localStorage.getItem("success_cadastro_hagro")) {
    window.location.href = "./concluido.html";
  }

  $("#cep").mask("00000-000");
  $("#whatsapp").mask("(00)00000-0000");

  $("#form_cadastro").on("submit", function (e) {
    e.preventDefault();
    let data = $("#form_cadastro").serialize();

    $.ajax({
      type: "POST",
      url: "./assets/backend/Transactions.php",
      data: data,
      dataType: "JSON",
      success: function (value) {
        console.log(value);
        if (value.type != "success") {
          Swal.fire({
            title: value.title,
            text: value.message,
            icon: value.type,
            confirmButtonText: "Ok",
          });
        } else {
          Swal.fire({
            title: value.title,
            text: value.message,
            icon: value.type,
            confirmButtonText: "Ok",
          }).then(function (result) {
            console.log(result);
            if (result.isConfirmed) {
              localStorage.setItem("success_cadastro_hagro", true);
              window.location.href = "./concluido.html";
            }
          });
        }
      },
      error: function (jqXHR) {
        console.log({ jqXHR });
      },
    });
  });
});

let nameInput = $("#name");
let last_nameInput = $("#last_name");
let phoneInput = $("#phone");
let emailInput = $("#email");
let userToDelet = 0;
//global
let titleForm = "Crear nuevo usuario";
let update = false;

let pathRequest = "";

let table = $("#usuarios").DataTable({
  ajax: "api/getUsers",
  columns: [
    { data: "name" },
    { data: "last_name" },
    { data: "phone" },
    { data: "email" },
    { data: "created_at" },
    { data: "actions" },
  ],
  order: [[4, "desc"]],
  columnDefs: [{ responsivePriority: 1, targets: 5 }],
});

$("#crearUsuario").on("click", () => {
  titleForm = "Crear nuevo usuario";
  pathRequest = "api/createUser";
  update = false;
  $("#title-form").text(titleForm);
  $("#formNuevoUsuario").modal("show");
});

$("#guardarUsuario").on("click", async () => {
  $(".loader").addClass("show_loader");
  if (update) {
    await fetch(pathRequest, {
      method: "PUT",
      body: JSON.stringify({
        name: nameInput.val(),
        last_name: last_nameInput.val(),
        phone: phoneInput.val(),
        email: emailInput.val(),
      }),
      headers: {
        "Content-Type": "application/json",
      },
    })
      .then((res) => res.json())
      .then((data) => {
        table.ajax.reload();
        $(".loader").removeClass("show_loader");
        $("#success_dialog").addClass("show_success_dialog");
        $(".message").text(data.message);
      })
      .catch((err) => {
        $(".loader").removeClass("show_loader");
        $(".message").text(data.message);
        $("#error_dialogo").addClass("show_error_dialogo");
      });

    return;
  }
  await fetch(pathRequest, {
    method: "POST",
    body: JSON.stringify({
      name: nameInput.val(),
      last_name: last_nameInput.val(),
      phone: phoneInput.val(),
      email: emailInput.val(),
    }),
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((res) => res.json())
    .then((data) => {
      table.ajax.reload();
      $(".loader").removeClass("show_loader");
      $("#success_dialog").addClass("show_success_dialog");
      $(".message").text(data.message);
    })
    .catch((err) => {
      $(".loader").removeClass("show_loader");
      $("#error_dialogo").addClass("show_error_dialogo");
      $(".message").text(data.message);
    });
});

$(".close").on("click", () => {
  $(".loader").removeClass("show_loader");
  $("#success_dialog").removeClass("show_success_dialog");
  $("#error_dialogo").removeClass("show_error_dialogo");
  $("#formNuevoUsuario").modal("hide");
  clearForm();
});

$("#formNuevoUsuario").on("hide.bs.modal", () => {
  clearForm();
});

function eliminar(e) {
  userToDelet = $(e).data("id");
  $("#eliminarDialog").modal("show");
}

$("#eliminarUsuario").on("click", () => {
  $(".loader").addClass("show_loader");

  fetch("api/deleteUser?id=" + userToDelet, {
    method: "DELETE",
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((response) => response.json())
    .then((res) => {
      $(".message").text(res.message);
      $("#success_dialog").addClass("show_success_dialog");
      $(".loader").removeClass("show_loader");
    })
    .catch((err) => {
      $(".message").text(res.message);
      $(".loader").removeClass("show_loader");
      $("#error_dialogo").addClass("show_error_dialogo");
    });
});

function closeDeletDialog() {
  userToDelet = 0;
  $("#eliminarDialog").modal("hide");
}
function editar(e) {
  let id = $(e).data("id");
  $("#title-form").text(titleForm);
  titleForm = "Editar usuario";
  pathRequest = "api/updateUser?id=" + id;
  update = true;
  fetch("api/getUser?id=" + id)
    .then((response) => response.json())
    .then((datos) => {
      nameInput.val(datos.data.user.name);
      last_nameInput.val(datos.data.user.last_name);
      phoneInput.val(datos.data.user.phone);
      emailInput.val(datos.data.user.email);
      $("#formNuevoUsuario").modal("show");
    });
}

function clearForm() {
  name: nameInput.val("");
  last_name: last_nameInput.val("");
  phone: phoneInput.val("");
  email: emailInput.val("");
}

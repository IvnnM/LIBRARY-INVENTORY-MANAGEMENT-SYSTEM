function sendLoginRequest(form) {
  const formData = new FormData(form);

  $.ajax({
    type: "POST",
    url: "./php/client-login-process.php",
    data: formData,
    processData: false, // Prevent jQuery from processing the data
    contentType: false, // Prevent jQuery from setting the content type
    success: function (response) {
      var data = JSON.parse(response);

      if (data.status === "error") {
        Swal.fire({
          position: "center",
          icon: "error",
          title: "Invalid login",
          text: data.message,
          showConfirmButton: true
        });
        form.querySelector('[name="password"]').value = '';
      } else if (data.status === "success") {
        Swal.fire({
          title: data.message,
          text: 'Please wait...',
          timer: 2000,
          timerProgressBar: true,
          didOpen: () => {
            Swal.showLoading()
          },
          willClose: () => {
            if (data.role === "Client") {
              window.location.href = "client.php";
            } else {
              window.location.href = "index.html";
            }
          }
        });
        form.reset();
      } else if (data.status === "warning") {
        Swal.fire({
          position: "center",
          icon: "warning",
          title: "Incorrect password",
          text: data.message,
          showConfirmButton: true
        });
        form.querySelector('[name="password"]').value = '';
      }
    },
    error: function () {
      alert("An error occurred while processing your request. Please try again later.");
    }
  });

  // Prevent the default form submission
  return false;
}
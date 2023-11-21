function sendLoginRequest(form) {
  const formData = new FormData(form);

  $.ajax({
    type: "POST",
    url: "./php/admin-login-process.php",
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
      } else if (data.status === "warning") {
        Swal.fire({
          position: "center",
          icon: "warning",
          title: "Incorrect password",
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
            if (data.role === "Admin") {
              window.location.href = "admin.php";
            } else {
              window.location.href = "index.html";
            }
          }
        });
        form.reset();
      }
    },
    error: function () {
      alert("An error occurred while processing your request. Please try again later.");
    }
  });

  // Prevent the default form submission
  return false;
}

function editRole(userID, userEmail) {
  Swal.fire({
    title: 'Change Role',
    html: roleDropdown(userEmail), // Pass the user's email to the function
    input: 'select',
    inputOptions: {
      'Client': 'Client',
      'Librarian': 'Librarian'
    },
    inputPlaceholder: 'Select a new role',
    showCancelButton: true,
    inputValidator: (value) => {
      if (value === '') {
        return 'You need to select a role';
      }
      return null;
    }
  }).then((result) => {
    if (result.isConfirmed) {
      const selectedRole = result.value; // Get the selected role here
      updateRole(userID, selectedRole);
    }
  });
}

function roleDropdown(userEmail) {
  return `
    <div>
      <label for="roleDropdown">Select a new role for 
      <span id="userEmail" style="font-weight: bold;">${userEmail}</span></label>
    </div>`;
}

function updateRole(userID, newRole) {
  // Send an AJAX request to update the role
  const xhr = new XMLHttpRequest();
  xhr.open('POST', './php/update-role.php', true); // Specify the correct PHP file URL
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onload = function () {
    if (xhr.status === 200) {
      Swal.fire('Role Updated!', '', 'success');
      // You can update the role displayed in the table here if needed
    } else {
      Swal.fire('Error!', 'Role could not be updated.', 'error');
    }
  };
  xhr.send(`userID=${userID}&newRole=${newRole}`);
}





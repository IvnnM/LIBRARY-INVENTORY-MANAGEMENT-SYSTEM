//Login
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
          icon: 'warning',
          title: 'Incorrect password',
          text: data.message,
          footer: '<a href="#" id="forgotPasswordLink">Forgot password?</a>',
        });
        
        form.querySelector('[name="password"]').value = '';
        
        // Add a click event listener to the "Forgot password?" link
        document.getElementById('forgotPasswordLink').addEventListener('click', function (e) {
          e.preventDefault(); // Prevent the link from navigating
          Swal.fire({
            title: '',
            text: 'Relax and try to remember your password.',
            imageUrl: 'https://unsplash.it/400/200',
            imageWidth: 400,
            imageHeight: 200,
            imageAlt: 'Relax image',
            confirmButtonText: 'THANKS',
          });
        });
        // Add a click event listener to the "Forgot password?" link
      } else if (data.status === "success") {
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 2500,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
          },
        });
        
        Toast.fire({
          icon: 'success',
          title: data.message,
          willClose: () => {
            if (data.role === "Admin") {
              window.location.href = "admin.php";
            } else {
              window.location.href = "index.html";
            }
          },
        });
        
        form.reset();
        
      }
    },
    error: function () {
      alert("An error occurred while processing your request. Please try again later.");
    }
  });

  return false;
}

// Book Search
document.addEventListener('DOMContentLoaded', function () {
  const bookSearchInput = document.getElementById('bookSearchInput');
  const bookTable = document.getElementById('bookTable');
  let originalBookTableContent = bookTable.innerHTML;

  bookSearchInput.addEventListener('input', performBookSearch);

  function performBookSearch() {
    const searchValue = bookSearchInput.value.trim();

    if (searchValue !== '') {
      const xhr = new XMLHttpRequest();
      xhr.open('GET', `php/search_books.php?search=${searchValue}`, true);
      xhr.onload = function () {
        if (xhr.status === 200) {
          bookTable.innerHTML = xhr.responseText;
        }
      };
      xhr.send();
    } else {
      // Restore the original content
      bookTable.innerHTML = originalBookTableContent;
    }
  }
});

// Account Search
document.addEventListener('DOMContentLoaded', function () {
  const userSearchInput = document.getElementById('userSearchInput');
  const userTable = document.getElementById('userTable');
  let originalUserTableContent = userTable.innerHTML;

  userSearchInput.addEventListener('input', performAccountSearch);

  function performAccountSearch() {
    const searchValue = userSearchInput.value.trim();

    if (searchValue !== '') {
      const xhr = new XMLHttpRequest();
      xhr.open('GET', `php/search_users.php?search=${searchValue}`, true);
      xhr.onload = function () {
        if (xhr.status === 200) {
          userTable.innerHTML = xhr.responseText;
        }
      };
      xhr.send();
    } else {
      // Restore the original content
      userTable.innerHTML = originalUserTableContent;
    }
  }
});



//Accounts
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
    confirmButtonText: "Save",
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


function addBook() {
  Swal.fire({
    title: "Publish Book",
    html:
    '<div class="title-container">' +
      '<br>' +
      '<h6 class="text-start title">Book details</h6>' +
    '</div>' +
    '<div class="input-group mb-3">' +
      '<span class="input-group-text">ISBN and Title</span>' +
      '<input id="isbn" type="text" placeholder="International Standard Book Number" aria-label="isbn" class="form-control">' +
      '<input id="title" type="text" placeholder="Title of the book" aria-label="title" class="form-control">' +
    '</div>' +
    '<div class="input-group mb-3">' +
      '<span class="input-group-text" id="addon-wrapping">Author</span>' +
      '<input id="author" type="text" class="form-control" placeholder="Who is the author of the book?" aria-label="author" aria-describedby="addon-wrapping">' +
    '</div>' +
    '<div class="input-group mb-3">' +
      '<span class="input-group-text">Genre</span>' +
      '<input id="genre" type="text" class="form-control" placeholder="Specify the genre of the book" aria-label="genre">' +
      '<span class="input-group-text">Quantity</span>' +
      '<input id="quantity" type="number" class="form-control" placeholder="How many copies are available?" aria-label="quantity">' +
    '</div>' +
    '<div class="input-group mb-3">' +
      '<span class="input-group-text">Description</span>' +
      '<textarea id="description" class="form-control" aria-label="Description"></textarea>' +
    '</div>',  
    showCancelButton: true,
    confirmButtonText: "Publish",
    customClass: {
      popup: 'custom-modal-class',
      confirmButton: 'custom-confirm-button-class',
      cancelButton: 'custom-cancel-button-class',
      title: 'left-align-title'
    },
    width: '60%',
    preConfirm: () => {
      const isbn = Swal.getPopup().querySelector("#isbn").value.trim();
      const title = Swal.getPopup().querySelector("#title").value.trim();
      const author = Swal.getPopup().querySelector("#author").value.trim();
      const genre = Swal.getPopup().querySelector("#genre").value.trim();
      const description = Swal.getPopup().querySelector("#description").value.trim();
      const quantity = Swal.getPopup().querySelector("#quantity").value.trim();

      // Validate the inputs
      if (!isbn || !title || !author || !genre || !description || !quantity) {
        Swal.showValidationMessage("Please fill in all required fields.");
        return false;
      }

      // Send the data to your server to add the book
      const xhr = new XMLHttpRequest();
      xhr.open('POST', './php/add-book.php', true); // Specify the correct PHP file URL
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onload = function () {
        if (xhr.status === 200) {
          Swal.fire('Book Added!', '', 'success');
          // You can perform any additional actions here, like updating the book list
        } else {
          Swal.fire('Error!', 'Book could not be added.', 'error');
        }
      };
      xhr.send(`title=${title}&author=${author}&genre=${genre}&isbn=${isbn}&description=${description}&quantity=${quantity}`);
    },
  });
}





function sendLoginRequest(form) {
  const formData = new FormData(form);

  $.ajax({
    type: "POST",
    url: "./php/librarian-login-process.php",
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
            if (data.role === "Librarian") {
              window.location.href = "librarian.php";
            } else {
              window.location.href = "index.html";
            }
          },
        });
        form.reset();
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
      }
    },
    error: function () {
      alert("An error occurred while processing your request. Please try again later.");
    }
  });

  // Prevent the default form submission
  return false;
}

async function handleInventory(action, bookID) {
  try {
    const { value: quantity } = await Swal.fire({
      title: `Enter Quantity to ${action}`,
      input: 'number',
      inputLabel: 'Quantity',
      inputPlaceholder: 'Enter quantity...',
      showCancelButton: true,
      confirmButtonText: 'Submit',
      inputValidator: (value) => {
        if (!/^\d+$/.test(value) || parseInt(value) <= 0) {
          return 'Please enter a valid positive quantity';
        }
      },
    });

    if (quantity) {
      // Check if the requested "OUT" quantity exceeds the available quantity
      if (action === "OUT" && parseInt(quantity) > parseInt($(`#quantity_${bookID}`).text())) {
        Swal.fire('Error', 'Requested OUT quantity exceeds available quantity', 'error');
        return;
      }

      // Send an AJAX request to update the inventory
      const response = await updateInventory(action, bookID, quantity);

      if (response.success) {
        // Update the displayed quantity on success
        const element = document.getElementById(`quantity_${bookID}`);
        if (element) {
          element.textContent = response.newQuantity;
        }

        // Show a success message
        Swal.fire('Success', response.message, 'success');
      } else {
        // Show an error message on failure
        Swal.fire('Error', response.message, 'error');
      }
    }
  } catch (error) {
    console.error('Error issuing book:', error);
  }
}

async function updateInventory(action, bookID, quantity) {
  try {
    const response = await $.ajax({
      type: 'POST',
      url: './php/update-inventory.php',
      data: {
        action: action,
        bookID: bookID,
        quantity: quantity,
      },
      dataType: 'json',
    });

    return response;
  } catch (error) {
    console.error('Error updating inventory:', error);
    return { success: false, message: 'An error occurred while updating inventory' };
  }
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
      xhr.open('GET', `php/search_books_librarian.php?search=${searchValue}`, true);
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
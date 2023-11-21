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
        Swal.fire({
          title: data.message,
          text: 'Please wait...',
          timer: 2000,
          timerProgressBar: true,
          didOpen: () => {
            Swal.showLoading()
          },
          willClose: () => {
            if (data.role === "Librarian") {
              window.location.href = "librarian.php";
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
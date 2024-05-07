// Script for navbar.php //

// Script for scheduling.php //

//Pop-up form for inserting schedule
function openForm() {
  document.getElementById("pop-up").style.display = "flex";
}
function closeForm() {
  document.getElementById("pop-up").style.display = "none";
}

//Pop-up form for editing schedule
function openEditForm() {
  document.getElementById("edit-pop-up").style.display = "flex";
}
function closeEditForm() {
  document.getElementById("edit-pop-up").style.display = "none";
}
//fetch data for editing schedule
document.querySelectorAll(".edit-btn").forEach((button) => {
  button.addEventListener("click", function () {
    let title = this.getAttribute("data-title");
    let startDate = this.getAttribute("data-start-date");
    let endDate = this.getAttribute("data-end-date");
    let eventId = this.getAttribute("data-event-id");

    // Set the values in the edit form fields
    document.getElementById("editTitle").value = title;
    document.getElementById("editId").value = eventId;
    document.getElementById("editStartDate").value = startDate;
    document.getElementById("editEndDate").value = endDate;

    openEditForm(); // Open the edit form modal
    console.log("title: ", title, "ID :", eventId); // debug
  });
});
//Pop-up form for deleting schedule
//fetch data for delete schedule
document.querySelectorAll(".delete-btn").forEach((button) => {
  button.addEventListener("click", function () {
    let deleteId = this.getAttribute("data-event-id");
    let deleteTitle = this.getAttribute("data-title");
    let deleteStart = this.getAttribute("data-start-date");
    let deleteEnd = this.getAttribute("data-end-date");

    document.getElementById("deleteId").value = deleteId;
    document.getElementById("deleteTitle").value = deleteTitle;
    document.getElementById("deleteStart").value = deleteStart;
    document.getElementById("deleteEnd").value = deleteEnd;

    console.log("Title : ", deleteTitle, deleteStart, deleteEnd);
    console.log("Id : ", deleteId);
    openDelForm();
  });
});
function openDelForm() {
  document.getElementById("delete-pop-up").style.display = "flex";
}
function closeDelForm() {
  document.getElementById("delete-pop-up").style.display = "none";
}

// -----------------------------------------------------------------------------------------//

// Script for ticketing.php //

document.getElementById("searchTerm").addEventListener("input", function () {
  var searchTerm = this.value.toLowerCase();
  var tableRows = document.querySelectorAll(".table-design tbody tr");
  tableRows.forEach(function (row) {
    var text = row.textContent.toLowerCase();
    if (text.includes(searchTerm)) {
      row.style.display = "";
    } else {
      row.style.display = "none";
    }
  });
});
function EditcloseForm() {
  document.getElementById("editTicketPop").style.display = "none";
  console.log("click");
}
// -----------------------------------------------------------------------------------------//

// Script for files.php //

// Function to update the file name display and image preview
function updateFileNameAndPreview(input) {
  var fileName = input.files[0] ? input.files[0].name : "No file chosen";
  var fileNameDisplay = document.getElementById("file-name-display");
  fileNameDisplay.textContent = fileName;

  // Preview the image
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      document
        .getElementById("preview-image")
        .setAttribute("src", e.target.result);
    };
    reader.readAsDataURL(input.files[0]);
  }
}
// Trigger the file input click event when the custom button is clicked
document.getElementById("custom-button").addEventListener("click", function () {
  document.getElementById("file-input").click();
});

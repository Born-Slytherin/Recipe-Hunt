let button = document.querySelector(".addBtn");
let modal = document.querySelector(".modal");

// Open modal when button is clicked
button.addEventListener("click", (event) => {
  event.preventDefault();
  modal.style.display = "grid";
});

// Close modal when clicking outside the form
modal.addEventListener("click", (event) => {
  if (event.target === modal) {
    modal.style.display = "none";
  }
});

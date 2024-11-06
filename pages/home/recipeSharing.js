let button = document.querySelector(".addBtn");
let modal = document.querySelector(".modal");
let form = document.querySelector(".addRecipeForm");

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

form.addEventListener("submit", (event) => {

  event.preventDefault();

  let formData = new FormData();

  le
  let title = document.getElementById("title").value;
  
  let servings = document.getElementById("servings").value;
  let cuisine = document.getElementById("cuisine").value;
});

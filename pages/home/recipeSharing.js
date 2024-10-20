let button = document.querySelector(".addBtn");

button.addEventListener("click", (event) => {
  event.preventDefault();
  let modal = document.querySelector(".modal");
  modal.style.display = "block";
});

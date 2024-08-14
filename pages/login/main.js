let eye_open = document.querySelector(".eye-open");
let eye_closed = document.querySelector(".eye-closed");

eye_open.addEventListener("click", function () {
  eye_closed.style.display = "none";
  eye_open.style.display = "block";
});

eye_closed.addEventListener("click", function () {
  console.log("clicked");
  eye_closed.style.display = "block";
  eye_open.style.display = "none";
});

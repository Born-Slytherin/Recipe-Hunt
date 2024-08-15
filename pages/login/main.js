let eye_open = document.querySelector(".eye-open");
let eye_closed = document.querySelector(".eye-closed");
let pwd = document.querySelector("#pwd");
eye_open.addEventListener("click", function () {
  pwd.type = "password";
  eye_closed.style.display = "block";
  eye_open.style.display = "none";
});

eye_closed.addEventListener("click", function () {
  pwd.type = "text";
  eye_closed.style.display = "none";
  eye_open.style.display = "block";
});

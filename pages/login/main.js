import { showToast } from '../../components/toast.js';

let eye_open = document.querySelector(".eye-open");
let eye_closed = document.querySelector(".eye-closed");
let pwd = document.querySelector("#pwd");
eye_open.addEventListener("click", function () {
  pwd.type = "password";
  eye_closed.style.display = "none";
  eye_open.style.display = "block";
});

eye_closed.addEventListener("click", function () {
  pwd.type = "text";
  eye_closed.style.display = "block";
  eye_open.style.display = "none";
});

const loginForm = document.querySelector("#loginForm");

loginForm.addEventListener("submit", async function (e) {
  e.preventDefault();

  const formData = new FormData(this);

  const response = await fetch("../../utils/login.php", {
    method: "POST",
    body: formData,
  });

  const result = await response.json();

  if (result.status === "success") {
    showToast(result.message, "success");
    console.log("Routing...");
    window.location.href = "../home/index.php";
  } else {
    showToast(result.message, "error");
  }
});

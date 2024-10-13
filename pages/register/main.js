import { showToast } from '../../components/toast.js';

const pwdEyeOpen = document.querySelector("#password-eye-open");
const pwdEyeClosed = document.querySelector("#password-eye-closed");
const confirmEyeOpen = document.querySelector("#confirm-eye-open");
const confirmEyeClosed = document.querySelector("#confirm-eye-closed");
const passwordInput = document.querySelector(".pwd");
const confirmPasswordInput = document.querySelector(".confirm-pwd");

const togglePasswordVisibility = (eyeOpen, eyeClosed, input) => {
  eyeOpen.style.display = "none";
  eyeClosed.style.display = "inline-block";
  input.setAttribute("type", "password");
};

const togglePasswordVisibilityBack = (eyeOpen, eyeClosed, input) => {
  eyeClosed.style.display = "none";
  eyeOpen.style.display = "inline-block";
  input.setAttribute("type", "text");
};

const passwordParent = passwordInput.parentElement;
const confirmPasswordParent = confirmPasswordInput.parentElement;

passwordParent.addEventListener("click", (event) => {
  if (event.target === pwdEyeOpen) {
    togglePasswordVisibility(pwdEyeOpen, pwdEyeClosed, passwordInput);
  } else if (event.target === pwdEyeClosed) {
    togglePasswordVisibilityBack(pwdEyeOpen, pwdEyeClosed, passwordInput);
  }
});

confirmPasswordParent.addEventListener("click", (event) => {
  if (event.target === confirmEyeOpen) {
    togglePasswordVisibility(
      confirmEyeOpen,
      confirmEyeClosed,
      confirmPasswordInput
    );
  } else if (event.target === confirmEyeClosed) {
    togglePasswordVisibilityBack(
      confirmEyeOpen,
      confirmEyeClosed,
      confirmPasswordInput
    );
  }
});

document.getElementById("signUpForm").addEventListener("submit", async function (e) {
  e.preventDefault();

  const formData = new FormData(this);

  try {
    const response = await fetch("../../utils/register.php", {
      method: "POST",
      body: formData,
    });

    const result = await response.json();
    console.log(result); 

    if (result.status === "success") {
      showToast(result.message, "success");
      window.location.href = "../home/index.php";
    } else {
      showToast(result.message, "error");
    }
  } catch (error) {
    showToast("An error occurred. Please try again.", "error");
    console.error("Error during registration:", error);
  }
});


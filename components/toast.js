// components/toast.js

export function showToast(message, type) {
  const toastContainer = document.getElementById("toast-container");

  // Create toast element
  const toast = document.createElement("div");
  toast.classList.add("toast", type);

  // Add icon image
  const icon = document.createElement("img");
  icon.classList.add("icon");
  icon.src =
    type === "success"
      ? "../../assets/toast/tick.svg"
      : "../../assets/toast/cross.svg";
  icon.alt = type === "success" ? "Success Icon" : "Error Icon";
  toast.appendChild(icon);

  // Add message text
  const messageText = document.createElement("span");
  messageText.classList.add("message");
  messageText.innerText = message;
  toast.appendChild(messageText);

  toastContainer.appendChild(toast);

  setTimeout(() => {
    toast.classList.add("show");
  }, 100);

  setTimeout(() => {
    toast.classList.remove("show");
    setTimeout(() => {
      toast.remove();
    }, 500); 
  }, 3000);
}

function fetchAllUsers() {
  const searchQuery = document.getElementById("searchInput").value;
  const url =
    "../../utils/fetchAllUsers.php?search=" + encodeURIComponent(searchQuery);

  fetch(url)
    .then((response) => response.json())
    .then((data) => {
      const container = document.querySelector(".userFetchContainer");
      container.innerHTML = "";

      if (data.status === 200 && data.users.length > 0) {
        data.users.forEach((user) => {
          const userElement = document.createElement("div");
          userElement.classList.add("userItem");
          userElement.innerHTML = `
                        <span>${user.username}</span>
                        <span>${user.email}</span>
                    `;
          container.appendChild(userElement);
        });
      } else {
        container.innerHTML = "<p>No users found</p>";
      }
    })
    .catch((error) => {
      console.error("Error fetching users:", error);
    });
}

fetchAllUsers();

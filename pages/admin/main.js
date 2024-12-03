// Get the current page from the URL
const urlParams = new URLSearchParams(window.location.search);
const currentPage = urlParams.get("page") || "user_management";

// **User Management Functions**
function initializeUserManagement() {
  let searchInput = document.querySelector("#searchInput");
  const container = document.querySelector(".userFetchContainer");

  // Function to fetch users
  const fetchUsers = () => {
    const url = "../../utils/fetchAllUsers.php";

    fetch(url)
      .then((response) => response.json())
      .then((data) => {
        container.innerHTML = ""; // Clear previous results

        if (data.status === 200 && data.users.length > 0) {
          // Display users
          data.users.forEach((user) => {
            const userElement = document.createElement("div");
            userElement.classList.add("userItem");
            userElement.innerHTML = `
              <span>${user.username}</span>
              <span>${user.email}</span>
              <button class='deleteUserBtn' data-username='${user.username}'>delete</button>
            `;
            container.appendChild(userElement);
          });

          // Attach delete event listeners
          const deleteButtons = document.querySelectorAll(".deleteUserBtn");
          deleteButtons.forEach((btn) => {
            btn.addEventListener("click", () =>
              deleteUser(btn.dataset.username)
            );
          });
        } else {
          container.innerHTML = "<p>No users found</p>";
        }
      })
      .catch((error) => {
        console.error("Error fetching users:", error);
      });
  };

  // Fetch users initially
  fetchUsers();

  // Event listener for 'input' event to filter users
  if (searchInput) {
    searchInput.addEventListener("input", function (event) {
      const searchQuery = event.target.value.toLowerCase(); // Get the value from the input field
      const url = "../../utils/fetchAllUsers.php";

      fetch(url)
        .then((response) => response.json())
        .then((data) => {
          container.innerHTML = ""; // Clear previous results

          if (data.status === 200 && data.users.length > 0) {
            // Filter users based on search query
            const filteredUsers = data.users.filter((user) => {
              return (
                user.username.toLowerCase().includes(searchQuery) ||
                user.email.toLowerCase().includes(searchQuery)
              );
            });

            if (filteredUsers.length > 0) {
              filteredUsers.forEach((user) => {
                const userElement = document.createElement("div");
                userElement.classList.add("userItem");
                userElement.innerHTML = ` 
                  <span>${user.username}</span>
                  <span>${user.email}</span>
                  <button class='deleteUserBtn' data-username='${user.username}'>delete</button>
                `;
                container.appendChild(userElement);
              });

              const deleteButtons = document.querySelectorAll(".deleteUserBtn");
              deleteButtons.forEach((btn) => {
                btn.addEventListener("click", () =>
                  deleteUser(btn.dataset.username)
                );
              });
            } else {
              container.innerHTML = "<p>No users found</p>";
            }
          } else {
            container.innerHTML = "<p>No users found</p>";
          }
        })
        .catch((error) => {
          console.error("Error fetching users:", error);
        });
    });
  }
}

function deleteUser(userName) {
  fetch("../../utils/deleteUser.php", {
    method: "DELETE",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ userName }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === 200) {
        alert(data.message);
        fetchAllUsers();
      } else {
        alert(data.message || "Failed to delete user");
      }
    })
    .catch((error) => {
      console.error("Error deleting user:", error);
    });
}

// **Recipe Management Functions**
async function fetchAllRecipe() {
  const container = document.querySelector(".recipeFetchContainer");
  if (!container) return;
  container.innerHTML = ""; // Clear any previous content

  // Create and append the heading row
  const headingRow = document.createElement("div");
  headingRow.classList.add("headingRow");
  headingRow.innerHTML = `
    <span><strong>ID</strong></span>
    <span><strong>Title</strong></span>
    <span><strong>Created By</strong></span>
    <span><strong>Actions</strong></span>
  `;
  container.appendChild(headingRow);

  try {
    const response = await fetch("../../utils/fetchAllRecipe.php"); // Await the fetch response
    const data = await response.json();
    console.log("data: " + JSON.stringify(data));

    if (!response.ok) {
      throw new Error(`Failed to fetch recipes: ${response.statusText}`);
    }

    if (data.status == 200) {
      if (data.data.length > 0) {
        data.data.forEach((recipe) => {
          const recipeElement = document.createElement("div");
          recipeElement.classList.add("recipeItem");

          recipeElement.innerHTML = `
            <span>${recipe.id}</span>
            <span>${recipe.title}</span>
            <span>${recipe.created_by}</span>
            <button class="deleteRecipeBtn" data-id="${recipe.id}">Delete</button>
          `;

          container.appendChild(recipeElement);
        });

        // Attach delete event listeners
        document.querySelectorAll(".deleteRecipeBtn").forEach((btn) => {
          btn.addEventListener("click", () => deleteRecipe(btn.dataset.id));
        });
      } else {
        container.innerHTML = "<p>No recipes found</p>";
      }
    } else {
      container.innerHTML =
        "<p>Error fetching recipes: " + data.message + "</p>";
    }
  } catch (error) {
    console.error("Error fetching recipes:", error);
    container.innerHTML = "<p>Error loading recipes</p>";
  }
}

async function deleteRecipe(recipeId) {
  try {
    const response = await fetch("../../utils/deleteRecipe.php", {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ recipeId }),
    });

    const data = await response.json();

    if (data.status === 200) {
      alert(data.message);
      fetchAllRecipe();
    } else {
      alert(data.message || "Failed to delete recipe");
    }
  } catch (error) {
    console.error("Error deleting recipe:", error);
    alert("An error occurred while deleting the recipe.");
  }
}

// **Recipe Approval Functions**
// Placeholder for food management functions
function fetchAllFoodsForAdmin() {
  // Implement food management functionality here if needed
}

function initializePage() {
  switch (currentPage) {
    case "user_management":
      initializeUserManagement(); // Initialize user management functionalities
      break;
    case "recipe_management":
      fetchAllRecipe();
      break;
    case "recipe_approval":
      fetchAllFoodsForAdmin(); // Call food management functions here
      break;
    default:
      console.error("Unknown page:", currentPage);
  }
}

// Initialize based on the current page
initializePage();

// Get the current page from the URL
const urlParams = new URLSearchParams(window.location.search);
const currentPage = urlParams.get("page") || "user_management";

// **User Management Functions**
function fetchAllUsers() {
  const searchQuery = document.getElementById("searchInput")?.value;
  const url =
    "../../utils/fetchAllUsers.php?search=" + encodeURIComponent(searchQuery);

  fetch(url)
    .then((response) => response.json())
    .then((data) => {
      const container = document.querySelector(".userFetchContainer");
      container.innerHTML = ""; // Clear previous results

      if (data.status === 200 && data.users.length > 0) {
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

        const deleteButtons = document.querySelectorAll(".deleteUserBtn");
        deleteButtons.forEach((btn) => {
          btn.addEventListener("click", () => deleteUser(btn.dataset.username));
        });
      } else {
        container.innerHTML = "<p>No users found</p>";
      }
    })
    .catch((error) => {
      console.error("Error fetching users:", error);
    });
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
async function fetchAllRecipes() {
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
    const response = await fetch("../../utils/fetchAllRecipe.php", {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    });

    if (!response.ok) {
      throw new Error(`Failed to fetch recipes: ${response.statusText}`);
    }

    const data = await response.json();
    const recipes = data.data;
    console.log(data);
    console.log(recipes);

    if (data.status == 200) {
      recipes.forEach((recipe) => {
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
      fetchAllRecipes();
    } else {
      alert(data.message || "Failed to delete recipe");
    }
  } catch (error) {
    console.error("Error deleting recipe:", error);
    alert("An error occurred while deleting the recipe.");
  }
}

function initializePage() {
  switch (currentPage) {
    case "user_management":
      fetchAllUsers();
      break;
    case "recipe_management":
      fetchAllRecipes();
      break;
    case "food_management":
      // Call food management functions here
      break;
    default:
      console.error("Unknown page:", currentPage);
  }
}

// Initialize based on the current page
initializePage();

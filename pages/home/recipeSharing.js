// recipeSharing.js

// Check if we're on the recipe sharing page by looking for the container div
if (document.querySelector(".share-recipe-container")) {
  let button = document.querySelector(".addBtn");
  let modal = document.querySelector(".modal");
  let form = document.querySelector(".addRecipeForm");

  button.addEventListener("click", (event) => {
    event.preventDefault();
    modal.style.display = "grid";
  });

  modal.addEventListener("click", (event) => {
    if (event.target === modal) {
      modal.style.display = "none";
    }
  });

  form.addEventListener("submit", async (event) => {
    event.preventDefault();

    const formData = new FormData(event.target);
    console.log("formData", formData);

    try {
      const response = await fetch("../../utils/submitRecipe.php", {
        method: "POST",
        body: formData,
      });

      if (!response.ok) {
        throw new Error("Network response was not ok " + response.statusText);
      }

      const result = await response.text();
      console.log("result:", result);

      if (result.success) {
        alert("Recipe added successfully!");
        event.target.reset();
        fetchUpdatedRecipes();
      } else {
        alert("Error adding recipe: " + result.message);
      }
    } catch (error) {
      console.error("Error:", error);
      alert("An error occurred while submitting the recipe: " + error.message);
    }
  });

  // Additional functionality for filtering recipes
  const filterItems = document.querySelectorAll(".filters button");
  let selectedFilter = "all";
  let recipesData = [];

  filterItems.forEach((item) => {
    item.addEventListener("click", (event) => {
      filterItems.forEach((i) => i.classList.remove("selected"));
      item.classList.add("selected");
      selectedFilter = item.dataset.filter;
      filterAndRenderRecipes(selectedFilter);
    });
  });

  // Fetch all recipes and store them
  async function fetchUpdatedRecipes() {
    let container = document.querySelector(".share-recipe-container");

    try {
      const response = await fetch("../../utils/fetchAllRecipe.php");

      if (!response.ok) {
        throw new Error("Failed to fetch recipes: " + response.statusText);
      }

      const recipes = await response.json();
      recipesData = recipes.data;
      filterAndRenderRecipes(selectedFilter);
    } catch (error) {
      console.error("Error fetching recipes:", error);
    }
  }

  async function filterAndRenderRecipes(filter) {
    let filteredRecipes = recipesData;

    if (filter === "veg") {
      filteredRecipes = recipesData.filter((recipe) => recipe.vegetarian);
    } else if (filter === "non-veg") {
      filteredRecipes = recipesData.filter((recipe) => !recipe.vegetarian);
    } else if (filter === "mine") {
      const response = await fetch("../../utils/returnUserID.php");

      if (!response.ok) {
        throw new Error("Failed to fetch user ID: " + response.statusText);
      }

      const result = await response.json();
      const userId = parseInt(result.data, 10);

      filteredRecipes = recipesData.filter(
        (recipe) => recipe.created_by === userId
      );
    } else if (filter === "user-generated") {
      filteredRecipes = recipesData.filter((recipe) => !recipe.isGenerated);
    }

    renderRecipes(filteredRecipes);
  }

  // Render recipes to the page
  function renderRecipes(recipes) {
    let container = document.querySelector(".share-recipe-container");
    container.innerHTML = recipes
      .map(
        (recipe) => `
                  <div class="recipe-card">
                    <div class="left_container">
                      <h3>${recipe.title}</h3>
                      <img src="${recipe.image_url}" alt="${
          recipe.title
        } image" />
                      <div class='cuisine_meal_servings'>
                        <ul>
                          <li><strong>Cuisine:</strong> ${recipe.cuisine}</li>
                          <li><strong>Meal:</strong> ${recipe.meal}</li>
                          <li><strong>Servings:</strong> ${recipe.servings}</li>
                          <li><strong>${
                            recipe.vegetarian ? "Vegetarian" : "Non Vegetarian"
                          }</strong></li>
                        </ul>
                      </div>
                    </div>
                    <div class="right_container">
                      <div>
                        <h4>Ingredients:</h4>
                        <ul class="ingredients">
                          ${recipe.ingredients
                            .map(
                              (ingredient) => `
                              <li>${ingredient.quantity} ${ingredient.name}</li>
                            `
                            )
                            .join("")}
                        </ul>
                      </div>
                      <div>
                        <h4>Steps:</h4>
                        <ol>
                          ${recipe.steps
                            .map(
                              (step) => `
                              <li>${step.description}</li>
                            `
                            )
                            .join("")}
                        </ol>
                      </div>
                      <div>
                        <h4>Tips:</h4>
                        <ul>
                          ${recipe.tips
                            .map(
                              (tip) => `
                              <li>${tip.tip}</li>
                            `
                            )
                            .join("")}
                        </ul>
                      </div>
                    </div>
                  </div>
                `
      )
      .join("");
  }

  fetchUpdatedRecipes();
}

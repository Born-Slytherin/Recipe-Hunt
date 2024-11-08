let button = document.querySelector(".addBtn");
let modal = document.querySelector(".modal");
let form = document.querySelector(".addRecipeForm");

// Show the modal when "Add Recipe" button is clicked
button.addEventListener("click", (event) => {
  event.preventDefault();
  modal.style.display = "grid";
});

// Close the modal if the user clicks outside the form
modal.addEventListener("click", (event) => {
  if (event.target === modal) {
    modal.style.display = "none";
  }
});

// Handle form submission to submit the recipe
form.addEventListener("submit", async (event) => {
  event.preventDefault();

  const formData = new FormData(event.target);

  try {
    const response = await fetch("../../utils/submitRecipe.php", {
      method: "POST",
      body: formData,
    });

    if (!response.ok) {
      throw new Error("Network response was not ok " + response.statusText);
    }

    const result = await response.json();
    console.log("result:", result);

    if (result.success) {
      alert("Recipe added successfully!");
      event.target.reset();  // Reset the form inputs
      fetchUpdatedRecipes(); // Fetch the updated list of recipes
    } else {
      alert("Error adding recipe: " + result.message);
    }
  } catch (error) {
    console.error("Error:", error);
    alert("An error occurred while submitting the recipe: " + error.message);
  }
});

// Function to fetch and display updated recipes
async function fetchUpdatedRecipes() {
  let container = document.querySelector(".container");

  try {
    const response = await fetch("../../utils/fetchAllRecipe.php");

    if (!response.ok) {
      throw new Error("Failed to fetch recipes: " + response.statusText);
    }

    const recipes = await response.json();
    console.log(recipes);

    container.innerHTML = recipes.data
      .map(
        (recipe) => `
        <div class="recipe-card">
          <h3>${recipe.title}</h3>
          <p>${recipe.cuisine} - ${recipe.meal}</p>
        </div>
      `
      )
      .join("");
  } catch (error) {
    console.error("Error fetching recipes:", error);
  }
}

// Periodically fetch updated recipes every 5 seconds
setInterval(fetchUpdatedRecipes, 5000);

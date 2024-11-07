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

  try {
    const response = await fetch("../../utils/submitRecipe.php", {
      method: "POST",
      body: formData,
    });

    if (!response.ok) {
      throw new Error("Network response was not ok " + response.statusText);
    }

    const result = await response.json();

    console.log("result: " + JSON.stringify(result));

    if (result.success) {
      alert("Recipe added successfully!");
      event.target.reset();
    } else {
      alert("Error adding recipe: " + result.message);
    }
  } catch (error) {
    console.error("Error:", error);
    alert("An error occurred while submitting the recipe: " + error.message);
  }
});

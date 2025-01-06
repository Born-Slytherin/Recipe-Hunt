import { isRecipeOrIngredient } from "../../utils/isRecipeOrIngredients.js"

if (document.querySelector(".generate-recipe-container")) {

  const geminiApiKey = "AIzaSyBSKu-NdEfFCGWcoZ0o0egZmO9DVqRdZc4";
  const geminiUrl = `https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=${geminiApiKey}`;

  let form = document.querySelector(".ingredients-form");
  let output = document.querySelector(".output");
  output.innerHTML =
    "<p>Please enter ingredients and submit to generate a recipe.</p>";

  let cuisine, meal, servings;

  let cuisineSelect = document.querySelector(".cuisine");
  cuisineSelect.addEventListener("change", (event) => {
    cuisine = event.target.value; // Update cuisine
    console.log("Selected cuisine:", cuisine); // Debugging line
  });

  let mealSelect = document.querySelector(".meal");
  mealSelect.addEventListener("change", (event) => {
    meal = event.target.value; // Update meal
    console.log("Selected meal:", meal); // Debugging line
  });

  let servingsSelect = document.querySelector(".servings-select");
  servingsSelect.addEventListener("change", (event) => {
    servings = event.target.value; // Update servings
    console.log("Selected servings:", servings); // Debugging line
  });

  form.addEventListener("submit", async (event) => {


    event.preventDefault();

    meal = mealSelect.value;
    servings = servingsSelect.value;
    cuisine = cuisineSelect.value


    // Check if cuisine, meal, and servings are selected
    if (!cuisine || !meal || !servings) {
      output.textContent = "Please select cuisine, meal, and servings before submitting.";
      return;
    }

    let ingredients = document.getElementById("search_box").value.trim();
    let prompt = "";

    output.innerHTML = "<p>Generating recipe, please wait...</p>";

    let isRecipe = await isRecipeOrIngredient(ingredients, geminiUrl);
    console.log("is recipe : ", isRecipe);

    if (isRecipe.success) {
      if (isRecipe.message === "Complete Food") {
        prompt = `Generate a recipe for a complete ${meal} named "${ingredients}". Cuisine: ${cuisine}. Servings: ${servings}. Include ingredients, steps, and optional tips. Ensure the recipe is suitable for the given cuisine.`;
        console.log("complete food prompt : ", prompt);

      }
      if (isRecipe.message === "Ingredients") {
        prompt = `Generate a recipe for a ${meal} using only the ingredients "${ingredients}". Cuisine: ${cuisine}. Servings: ${servings}. Include steps, optional tips, and ensure the recipe is suitable for the given cuisine.`;
        console.log("Ingredient prompt : ", prompt);
      }

      try {
        const requestBody = {
          contents: [
            {
              parts: [
                {
                  text: prompt,
                },
              ],
            },
          ],
          generationConfig: {
            response_mime_type: "application/json",
            response_schema: {
              type: "object",
              properties: {
                title: { type: "string" },
                ingredients: {
                  type: "array",
                  items: {
                    type: "object",
                    properties: {
                      quantity: { type: "string" },
                      name: { type: "string" },
                    },
                    required: ["quantity", "name"],
                  },
                },
                steps: {
                  type: "array",
                  items: { type: "string" },
                },
                tips: {
                  type: "array",
                  items: { type: "string" },
                },
                vegetarian: { type: "boolean" },
              },
              required: ["title", "ingredients", "steps", "vegetarian"],
            },
          },
        };


        const response = await fetch(geminiUrl, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(requestBody),
        });

        if (response.ok) {
          const data = await response.json();
          console.log("recipe data : ", data);

          const recipeData = JSON.parse(data.candidates[0].content.parts[0].text);
          const { title, ingredients, steps, tips, vegetarian } = recipeData;

          const prompt = title;
          let pollinationUrl = `https://image.pollinations.ai/prompt/${prompt}`;

          console.log("imgUrl", pollinationUrl);
          

          let defaultImg = "../../assets/home/default_image.png";

          output.innerHTML = `
          <h2>${title}</h2>
          ${defaultImg
              ? `<img id="recipe-img" src="${defaultImg}" alt="${title} image" />`
              : "<p>No image available</p>"
            }
          <p>${vegetarian ? "Vegetarian" : "Non Vegetarian"}</p>
          <h3>Ingredients:</h3>
          <ul>${ingredients
              .map((item) => `<li>${item.quantity} ${item.name}</li>`)
              .join("")}</ul>
          <h3>Steps:</h3>
          <ol>${steps.map((step) => `<li>${step}</li>`).join("")}</ol>
          ${tips && tips.length
              ? `<h3>Tips:</h3><ul>${tips
                .map((tip) => `<li>${tip}</li>`)
                .join("")}</ul>`
              : ""
            }
          
        `;

          const fetchImage = async () => {
            try {
              const response = await fetch(pollinationUrl, {
                method: "GET",
                headers: { "Content-Type": "image/png" },
              });

              if (response.ok) {
                const blob = await response.blob();
                const dataUrl = await new Promise((resolve, reject) => {
                  const reader = new FileReader();
                  reader.onloadend = () => resolve(reader.result);
                  reader.onerror = reject;
                  reader.readAsDataURL(blob);
                });

                return dataUrl;
              } else {
                console.error("Error fetching the image:", response.statusText);
                return null;
              }
            } catch (error) {
              console.error("Error:", error);
              return null;
            }
          };

          const imageUrl = await fetchImage();

          document.querySelector('#recipe-img').src = imageUrl;

          const result = await fetch("../../utils/insertRecipe.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
              title,
              steps,
              tips,
              ingredients,
              cuisine: cuisine,
              meal: meal,
              servings: servings,
              vegetarian: vegetarian,
              image: imageUrl || null,
            }),
          });

          let resultData = await result.json();
          console.log("resultData : ", resultData);

        } else {
          output.textContent = "Error: Failed to fetch recipe.";
          console.log("Error Status:", response.status);
        }
      } catch (error) {
        console.error("Fetch Error:", error);
        output.textContent =
          "Error: An error occurred while generating the recipe.";
      }
    } else {
      output.textContent =
        "Error: Please provide valid food items as ingredients.";
      return;
    }
  });
}






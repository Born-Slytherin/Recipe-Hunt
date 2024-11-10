import isRecipeOrIngredient from "../../utils/isRecipeOrIngredients.js";

const geminiApiKey = "AIzaSyDt5P5wU_GCCllAGLbLVBoz6kTbPHpwDMk";
const geminiUrl = `https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=${geminiApiKey}`;

let form = document.querySelector(".ingredients-form");
let output = document.querySelector(".output");
output.innerHTML =
  "<p>Please enter ingredients and submit to generate a recipe.</p>";

form.addEventListener("submit", async (event) => {
  event.preventDefault();

  let ingredients = document.getElementById("search_box").value.trim();
  let cuisine = document.getElementById("cuisine").value.trim();
  let servings = document.getElementById("servings-select").value.trim();
  let meal = document.getElementById("meal").value.trim();
  let prompt = "";

  let isRecipe = await isRecipeOrIngredient(ingredients, geminiUrl);
  console.log("isRecipe:", isRecipe);

  if (isRecipe.success) {
    if (isRecipe.message === "Complete Food") {
      prompt = `Generate a recipe for a complete ${meal} named "${ingredients}". Cuisine: ${cuisine}. Servings: ${servings}. Include ingredients, steps, and optional tips. Ensure the recipe is suitable for the given cuisine.`;
    }
    if (isRecipe.message === "Ingredients") {
      prompt = `Generate a recipe for a ${meal} using only the ingredients "${ingredients}". Cuisine: ${cuisine}. Servings: ${servings}. Include steps, optional tips, and ensure the recipe is suitable for the given cuisine.`;
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

      output.innerHTML = "<p>Generating recipe, please wait...</p>";

      const response = await fetch(geminiUrl, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(requestBody),
      });

      if (response.ok) {
        const data = await response.json();
        const recipeData = JSON.parse(data.candidates[0].content.parts[0].text);
        console.log(recipeData);
        const { title, ingredients, steps, tips, vegetarian } = recipeData;

        const prompt = `${title}`;
        const noLogo = "true";
        const pollinationUrl = `https://image.pollinations.ai/prompt/${prompt}?nologo=${noLogo}`;

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

        output.innerHTML = `
        <h2>${title}</h2>
        ${
          imageUrl
            ? `<img src="${imageUrl}" alt="${title} image" />`
            : "<p>No image available</p>"
        }
        <p>${vegetarian ? "Vegetarian" : "Non Vegetarian"}</p>
        <h3>Ingredients:</h3>
        <ul>${ingredients
          .map((item) => `<li>${item.quantity} ${item.name}</li>`)
          .join("")}</ul>
        <h3>Steps:</h3>
        <ol>${steps.map((step) => `<li>${step}</li>`).join("")}</ol>
        ${
          tips && tips.length
            ? `<h3>Tips:</h3><ul>${tips
                .map((tip) => `<li>${tip}</li>`)
                .join("")}</ul>`
            : ""
        }
        
      `;

        const result = await fetch("../../utils/insertRecipe.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            title,
            steps,
            tips,
            ingredients,
            cuisine,
            meal,
            servings,
            vegetarian,
            image: imageUrl || null,
          }),
        });

        const resultData = await result.json();
        console.log(resultData);
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

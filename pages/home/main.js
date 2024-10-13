const geminiApiKey = "AIzaSyDt5P5wU_GCCllAGLbLVBoz6kTbPHpwDMk";
const geminiUrl = `https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=${geminiApiKey}`;

let form = document.querySelector(".ingredients-form");
let output = document.querySelector(".output");

form.addEventListener("submit", async (event) => {
  event.preventDefault();

  let ingredients = document.getElementById("search_box").value;
  let cuisine = document.getElementById("cuisine").value;
  let servings = document.getElementById("servings-select").value;
  let meal = document.getElementById("meal").value;

  try {
    const requestBody = {
      contents: [
        {
          parts: [
            {
              text: `Generate a recipe for ${meal} using only the ingredients ${ingredients}. Cuisine: ${cuisine}. Servings: ${servings}`,
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
          },
          required: ["title", "ingredients", "steps"],
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
      const recipeData = JSON.parse(data.candidates[0].content.parts[0].text);

      const { title, ingredients, steps, tips } = recipeData;

      // Pollination Image Generation
      const prompt = `image of ${title}`;
      const PollinationUrl = `https://image.pollinations.ai/prompt/${encodeURIComponent(
        prompt
      )}`;

      const fetchImage = async () => {
        try {
          const response = await fetch(PollinationUrl, {
            method: "GET",
            headers: { "Content-Type": "image/png" },
          });
          if (response.ok) {
            const blob = await response.blob();
            const imageUrl = URL.createObjectURL(blob);
            return imageUrl; // Return the generated image URL
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

      // Sending the recipe data to the PHP backend
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
        }),
      });

      const resultData = await result.json();
      console.log(resultData.message);
    } else {
      output.textContent = "Error: Failed to fetch recipe.";
      console.log("Error Status:", response.status);
    }
  } catch (error) {
    console.error("Fetch Error:", error);
    output.textContent =
      "Error: An error occurred while generating the recipe.";
  }
});

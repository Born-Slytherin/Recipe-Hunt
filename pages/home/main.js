import { GoogleGenerativeAI } from "@google/generative-ai";

let form = document.querySelector(".ingredients-form");
let output = document.querySelector(".output");

form.addEventListener("submit", async (event) => {
  event.preventDefault();

  let ingredients = document.getElementById("search_box").value;

  const genAI = new GoogleGenerativeAI(
    "AIzaSyDBkKGJd2N_beeIiLz761lTR83znW_mQgk"
  );
  const model = genAI.getGenerativeModel({ model: "gemini-1.5-flash" });

  const prompt = `Generate a recipe using only the ingredients ${ingredients} . It should contain title, ingredients, steps, and tips. Return in JSON. No code blocks`;

  const result = await model.generateContent(prompt);

  let recipe = JSON.parse(result.response.text());

  output.innerHTML = "";

  // Create and append the recipe title
  const title = document.createElement("h2");
  title.textContent = recipe.title;
  output.appendChild(title);

  // Create and append the ingredients list
  const ingredientsList = document.createElement("h3");
  ingredientsList.textContent = "Ingredients:";
  output.appendChild(ingredientsList);
  const ingredientsUl = document.createElement("ul");
  recipe.ingredients.forEach((ingredient) => {
    const li = document.createElement("li");
    li.textContent = ingredient;
    ingredientsUl.appendChild(li);
  });
  output.appendChild(ingredientsUl);

  // Create and append the steps
  const stepsList = document.createElement("h3");
  stepsList.textContent = "Steps:";
  output.appendChild(stepsList);
  const stepsOl = document.createElement("ol");
  recipe.steps.forEach((step) => {
    const li = document.createElement("li");
    li.textContent = step;
    stepsOl.appendChild(li);
  });
  output.appendChild(stepsOl);

  // Create and append the tips
  const tipsList = document.createElement("h3");
  tipsList.textContent = "Tips:";
  output.appendChild(tipsList);
  const tipsUl = document.createElement("ul");
  recipe.tips.forEach((tip) => {
    const li = document.createElement("li");
    li.textContent = tip;
    tipsUl.appendChild(li);
  });
  output.appendChild(tipsUl);
});

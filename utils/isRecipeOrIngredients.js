export default async function isRecipeOrIngredient(item, geminUrl) {
  let isRecipePrompt = `Identify whether "${item}" is a complete dish that can be served as food, a standalone ingredient used in other dishes, or a non-food item. Respond only with "Complete Food", "Ingredients", or "Non-Food Items". Return success as true for "Complete Food" or "Ingredients", and false for "Non-Food Items".`;
  console.log(isRecipePrompt);

  try {
    const requestBody = {
      contents: [
        {
          parts: [{ text: `${isRecipePrompt}` }],
        },
      ],
      generationConfig: {
        response_mime_type: "application/json",
        response_schema: {
          type: "OBJECT",
          properties: {
            success: { type: "STRING" },
            message: { type: "STRING" },
          },
        },
      },
    };

    const response = await fetch(geminUrl, {
      method: "POST",
      body: JSON.stringify(requestBody),
      headers: {
        "Content-Type": "application/json",
      },
    });

    if (response.ok) {
      const result = await response.json();
      const data = result.candidates[0].content.parts[0].text;
      const isRecipeData = JSON.parse(data);
      console.log("isRecipeData: ", isRecipeData);

      if (
        isRecipeData.message === "Complete Food" ||
        isRecipeData.message === "Ingredients"
      ) {
        return { success: true, message: isRecipeData.message };
      } else {
        return { success: false, message: "Non-food items" };
      }
    } else {
      console.error("HTTP error:", response.status, response.statusText);
      return null;
    }
  } catch (error) {
    console.error("Fetch error:", error);
    return null;
  }
}

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home</title>
  <link rel="stylesheet" href="./style.css" />
  <script type="importmap">
  {
    "imports": {
      "@google/generative-ai": "https://esm.run/@google/generative-ai"
    }
  }
</script>
</head>

<body>
  <div>
    <form method="POST">
      <button type="submit" name="share">Share Recipe</button>
      <button type="submit" name="generate">Generate Recipe</button>
    </form>
  </div>
  <div class="import-container">
    <?php

    if (isset($_POST['share'])) {
      require("../../components/ShareRecipe.php");
    }
    if (isset($_POST['generate'])) {
      require("../../components/GenerateRecipe.php");
    }
    ?>
  </div>
  <script src="./main.js" type="module" defer></script>
</body>

</html>
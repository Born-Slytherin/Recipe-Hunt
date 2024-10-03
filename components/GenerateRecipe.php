<div class="container">
    <form action="" class="advanced-features">
        <div>
            <label for="cuisine">Cuisine</label>
            <select name="cuisine" id="cuisine">
                <option value="">Select Cuisine</option>
                <?php
                $cuisines = ["Indian", "Italian", "Chinese", "Mexican", "American"];
                foreach ($cuisines as $cuisine) {
                    echo "<option value='" . $cuisine . "'>" . $cuisine . "</option>";
                }
                ?>
            </select>
        </div>
        <div>
            <label for="meal">Select Meal</label>
            <select name="meal" id="meal">
                <option value="">Select Meal</option>
                <option value="breakfast">Breakfast</option>
                <option value="lunch">Lunch</option>
                <option value="dinner">Dinner</option>
                <option value="dessert">Dessert</option>
            </select>
        </div>
    </form>
    <div class="chat_box">
        <div class="output">

        </div>
        <div class="search_btn">
            <form action="" name="ingredients-form" class="ingredients-form">
                <input type="text" id="search_box" placeholder="Enter ingredients seperated by comma">
                <button class="plane_btn">
                    <img src="../../assets/home/paper-plane.svg" alt="">
                </button>
            </form>
        </div>
    </div>
</div>
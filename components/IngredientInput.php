<div class="ingredientInput">
    <label>Ingredients:</label>
    <div class="ingredient-input-group">
        <input type="text" name="ingredient[]" placeholder="Ingredient">
        <input type="text" name="quantity[]" placeholder="Quantity">
        <button type="button" class="add-ingredient">+</button>
    </div>
</div>

<style>
    .ingredientInput {
        margin-top: 10px;
        display: flex;
        flex-direction: column;
        gap: 10px;

        label {
            display: block;
            font-weight: bold;
        }

        .ingredient-input-group {
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr 40px 40px;

            place-content: center;
            gap: 10px;

            input {
                padding: 10px;
                height: 100%;
                box-sizing: border-box;
                background: #00000050;
                border: none;
                border-bottom: 1px solid #ff8e26;
                font-size: 15px;
            }

            button.add-ingredient {
                width: 100%;
                height: 100%;
                aspect-ratio: 1;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 0;
                background-color: #ffffff;
                color: #000000;
                cursor: pointer;
                font-weight: bold;
            }

            button.remove-ingredient {
                width: 100%;
                height: 100%;
                aspect-ratio: 1;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 0;
                background-color: #ff4c4c;
                font-weight: bold;
                color: #ffffff;
                cursor: pointer;
            }
        }
    }
</style>

<script>
    function addNewInputGroup() {
        // Create a new input group
        const newInputGroup = document.createElement('div');
        newInputGroup.classList.add('ingredient-input-group');

        const ingredientInput = document.createElement('input');
        ingredientInput.type = 'text';
        ingredientInput.name = 'ingredient[]';
        ingredientInput.placeholder = 'Ingredient';

        const quantityInput = document.createElement('input');
        quantityInput.type = 'text';
        quantityInput.name = 'quantity[]';
        quantityInput.placeholder = 'Quantity';

        const addButton = document.createElement('button');
        addButton.type = 'button';
        addButton.classList.add('add-ingredient');
        addButton.textContent = '+';

        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.classList.add('remove-ingredient');
        removeButton.textContent = '-';

        newInputGroup.appendChild(ingredientInput);
        newInputGroup.appendChild(quantityInput);
        newInputGroup.appendChild(addButton);
        newInputGroup.appendChild(removeButton);

        document.querySelector('.ingredientInput').appendChild(newInputGroup);

        updateAddButtonListeners();

        removeButton.addEventListener('click', () => {
            newInputGroup.remove();
            updateAddButtonListeners();
        });
    }

    function updateAddButtonListeners() {
        const addButtons = document.querySelectorAll('.add-ingredient');

        addButtons.forEach((button, index) => {
            button.removeEventListener('click', addNewInputGroup);
            if (index === addButtons.length - 1) {
                button.addEventListener('click', addNewInputGroup);
            }
        });
    }

    updateAddButtonListeners();
</script>
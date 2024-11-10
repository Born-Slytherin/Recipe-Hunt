<style>
    form.filters {
        margin-left: 50px;
        list-style-type: none;
        position: absolute;
        top: 30px;
        left: 50%;
        display: flex;
        align-items: center;
        padding: 1px;
        transform: translateX(-50%);
    }

    form.filters :first-child {
        border-radius: 60px 0 0 60px;
    }

    form.filters :last-child {
        border-radius: 0 60px 60px 0;
    }

    form.filters button {
        padding: 6px 0;
        width: 120px;
        font-size: 14px;
        text-align: center;
        color: white;
        background: #676767;
        border: 2px solid transparent;
        cursor: pointer;
        transition: border 0.3s ease;
    }

    form.filters button.selected {
        border: 2px solid black;
        background: #333333;
    }

    form.filters button:hover {
        border: 2px solid white;
    }

    form.filters button:not(.selected) {
        border: 2px solid rgba(255, 255, 255, 0.5);
    }
</style>

<form class="filters">
    <button class="selected" data-filter="all">All</button>
    <button data-filter="veg">Veg</button>
    <button data-filter="non-veg">Non veg</button>
    <button data-filter="user-generated">User generated</button>
    <button data-filter="mine">Mine</button>
</form>

<script>
    const form = document.querySelector('.filters');
    form.addEventListener("submit", (event) => {
        event.preventDefault();
    })
</script>
<script setup>
const props = defineProps(['structure'])
</script>

<template>
    <div class="table">
        <table v-if="structure.tables">
            <tr>
                <th>
                    Actions
                </th>
                <th>
                    Table
                </th>
                <th>
                    Rows
                </th>
                <th>
                    Type
                </th>
                <th>
                    Collation
                </th>
                <th>
                    Size
                </th>
            </tr>
            <tr v-for="(item, index) in structure.tables" :key="index">
                <td class="action-btn">
                    <button class="button-no-style structure-btn">
                        <img src="@/assets/icons/drop.svg" alt="Drop" />
                        Drop
                    </button>
                    <button class="button-no-style structure-btn">
                        <img src="@/assets/icons/empty.svg" alt="Empty" />
                        Empty
                    </button>
                    <button class="button-no-style structure-btn">
                        <img src="@/assets/icons/structure-black.svg" alt="Structure" />
                        Structure
                    </button>
                    <button class="button-no-style structure-btn">
                        <img src="@/assets/icons/browse.svg" alt="Browse" />
                        Browse
                    </button>
                    <button class="button-no-style structure-btn">
                        <img src="@/assets/icons/edit.svg" alt="Edit" />
                        Edit
                    </button>
                </td>
                <td v-for="(value, key) in item" :key="key">
                    {{ value }}
                </td>
            </tr>
        </table>
    </div>
</template>

<style scoped>
table,
th,
td {
    border: 1px solid white;
    border-collapse: collapse;
    font-size: 0.8rem;
    padding: 0.5rem;
    text-align: left;
}

.table {
    margin-top: 1rem;
    overflow-x: scroll;
    max-height: calc(100vh - 160px);
}

th {
    background-color: var(--main-color);
    color: white;
}

td {
    background-color: var(--secondary-color);
}
</style>
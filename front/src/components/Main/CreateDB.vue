<script setup>
import Dropdown from 'primevue/dropdown';
import { ref } from 'vue';

const collations = ref([
    { name: 'utf8_general_ci' },
    { name: 'utf8_unicode_ci' },
    { name: 'utf8_bin' },
    { name: 'utf8mb4_general_ci' },
    { name: 'utf8mb4_unicode_ci' },
    { name: 'utf8mb4_bin' },
    { name: 'latin1_swedish_ci' },
    { name: 'latin1_danish_ci' },
    { name: 'latin1_german1_ci' },
    { name: 'latin1_general_ci' },
    { name: 'latin1_general_cs' },
    { name: 'latin1_bin' },
    { name: 'cp1251_bulgarian_ci' },
    { name: 'cp1251_ukrainian_ci' },
    { name: 'cp1251_bin' },
    { name: 'cp1251_general_ci' },
    { name: 'cp1251_general_cs' },
    { name: 'utf16_general_ci' },
    { name: 'utf16_unicode_ci' },
    { name: 'utf16_bin' },
    { name: 'utf16le_general_ci' },
    { name: 'utf16le_bin' },
    { name: 'cp1256_general_ci' },
    { name: 'cp1256_bin' },
    { name: 'cp1257_lithuanian_ci' },
    { name: 'cp1257_bin' },
    { name: 'cp1257_general_ci' },
    { name: 'utf32_general_ci' },
    { name: 'utf32_unicode_ci' },
    { name: 'utf32_bin' },
    { name: 'binary' },
    { name: 'geostd8_general_ci' },
    { name: 'geostd8_unicode_ci' },
    { name: 'geostd8_bin' },
    { name: 'armscii8_general_ci' },
    { name: 'armscii8_bin' },
    { name: 'ascii_general_ci' },
    { name: 'ascii_bin' },
    { name: 'cp1250_general_ci' },
    { name: 'cp1250_czech_cs' },
    { name: 'cp1250_croatian_ci' },
    { name: 'cp1250_bin' },
    { name: 'cp1250_polish_ci' },
    { name: 'cp1250_general_cs' },
    { name: 'utf8mb4_0900_ai_ci' },
    { name: 'utf8mb4_0900_as_cs' },
    { name: 'utf8mb4_0900_as_ci' },
    { name: 'utf8mb4_0900_bin' },
    { name: 'utf8mb4_0900_bin' },
    { name: 'utf8mb4_bin' },
    { name: 'utf8mb4_unicode_520_ci' },
    { name: 'utf8mb4_unicode_520_ci' },
    { name: 'utf8mb4_vietnamese_ci' },
    { name: 'utf8mb4_vietnamese_ci' },
]);
const selectedCollation = ref(null);
</script>

<template>
    <h2>Création de base de données</h2>
    <form>
        <div class="form">
            <div class="form-block">
                <label for="name">Nom de la base de données</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-block">
                <label for="collation">Collation</label>
                <Dropdown v-model="selectedCollation" :options="collations" optionLabel="name"
                    placeholder="Sélectionner une collation" />
            </div>
        </div>
        <button type="submit">Créer</button>
    </form>
</template>

<style scoped>
h2 {
    margin: 1rem 0;
}

.form-block {
    margin: 1rem 0;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

label {
    font-weight: 400;
}

input {
    padding: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 0.25rem;
    margin-right: 0.5rem;
}

.form {
    display: flex;
}
</style>
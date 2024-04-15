<script setup>
import { ref, onMounted } from 'vue'
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'

const emit = defineEmits(['getDbName'])

const loading = ref(true)
const databases = ref([
    {
        database: 'Database 1',
        tables: [
            {
                table: 'Table 1',
                columns: [
                    {
                        column: 'Column 1',
                        type: 'Type 1'
                    }
                ]
            },
            {
                table: 'Table 2',
                columns: [
                    {
                        column: 'Column 1',
                        type: 'Type 1'
                    },
                    {
                        column: 'Column 2',
                        type: 'Type 2'
                    }
                ]
            },
            {
                table: 'Table 3',
                columns: [
                    {
                        column: 'Column 1',
                        type: 'Type 1'
                    },
                    {
                        column: 'Column 2',
                        type: 'Type 2'
                    },
                    {
                        column: 'Column 3',
                        type: 'Type 3'
                    }
                ]
            }
        ]
    },
    {
        database: 'Database 2',
        tables: [
            {
                table: 'Table 1',
                columns: [
                    {
                        column: 'Column 1',
                        type: 'Type 1'
                    }
                ]
            },
            {
                table: 'Table 2',
                columns: [
                    {
                        column: 'Column 1',
                        type: 'Type 1'
                    },
                    {
                        column: 'Column 2',
                        type: 'Type 2'
                    }
                ]
            },
            {
                table: 'Table 3',
                columns: [
                    {
                        column: 'Column 1',
                        type: 'Type 1'
                    },
                    {
                        column: 'Column 2',
                        type: 'Type 2'
                    },
                    {
                        column: 'Column 3',
                        type: 'Type 3'
                    }
                ]
            }
        ]
    },
    {
        database: 'Database 3',
        tables: [
            {
                table: 'Table 1',
                columns: [
                    {
                        column: 'Column 1',
                        type: 'Type 1'
                    }
                ]
            },
            {
                table: 'Table 2',
                columns: [
                    {
                        column: 'Column 1',
                        type: 'Type 1'
                    },
                    {
                        column: 'Column 2',
                        type: 'Type 2'
                    }
                ]
            },
            {
                table: 'Table 3',
                columns: [
                    {
                        column: 'Column 1',
                        type: 'Type 1'
                    },
                    {
                        column: 'Column 2',
                        type: 'Type 2'
                    },
                    {
                        column: 'Column 3',
                        type: 'Type 3'
                    }
                ]
            }
        ]
    },
    {
        database: 'Database 4',
        tables: [
            {
                table: 'Table 1',
                columns: [
                    {
                        column: 'Column 1',
                        type: 'Type 1'
                    }
                ]
            },
            {
                table: 'Table 2',
                columns: [
                    {
                        column: 'Column 1',
                        type: 'Type 1'
                    },
                    {
                        column: 'Column 2',
                        type: 'Type 2'
                    }
                ]
            },
            {
                table: 'Table 3',
                columns: [
                    {
                        column: 'Column 1',
                        type: 'Type 1'
                    },
                    {
                        column: 'Column 2',
                        type: 'Type 2'
                    },
                    {
                        column: 'Column 3',
                        type: 'Type 3'
                    }
                ]
            }
        ]
    }
])
const activeDbIndex = ref(-1)

const toggleTables = (index) => {
    activeDbIndex.value = activeDbIndex.value === index ? -1 : index;
}

const getDatabases = async () => {
    console.log('Getting databases')
    await new Promise(resolve => setTimeout(resolve, 2000))
}

onMounted(async () => {
    await getDatabases()
    loading.value = false
})
</script>

<template>
    <section id="loader" v-if="loading">
        <p>Chargement ...</p>
        <pulse-loader :loading="loading" :color="color" :size="size"></pulse-loader>
    </section>
    <section id="databases" v-if="!loading">
        <ul>
            <li v-for="(database, index) in databases" :key="database" class="db-item"
                @click="emit('getDbName', database.database)">
                <button class="db button-no-style" @click="toggleTables(index)">
                    <img src="../../assets/icons/menu-arrow.svg"
                        :class="activeDbIndex === index ? 'selected-arrow' : 'menu-arrow'" alt="arrow" />
                    <img src="../../assets/icons/db.svg" alt="Database" />
                    {{ database.database }}
                </button>
                <button class="btn-add-table button-no-style">
                    <img src="../../assets/icons/add.svg" alt="Add" />
                    ajouter une table
                </button>
                <ul>
                    <li v-for="table in database.tables" :key="table" v-if="activeDbIndex === index">
                        <button class="table button-no-style"><img src="../../assets/icons/list-arrow.svg"
                                alt="Table" />
                            {{ table.table }}
                        </button>
                        <ul>
                            <li v-for="column in table.columns" :key="column">
                                <button class="column button-no-style"><img src="../../assets/icons/list-arrow.svg"
                                        alt="Column" />
                                    {{ column.column }}
                                </button>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </section>
</template>

<style scoped>
.db {
    margin: 0.5rem 0;
    font-weight: 400;
    width: 100%;
    display: flex;
    justify-content: flex-start;
}

#loader {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 10rem;
    flex-direction: column;
    text-align: center;
}

#loader p {
    margin-bottom: 1rem;
}

.db-item {
    margin: 1rem 0;
}

.menu-arrow {
    width: 5px;
}

.selected-arrow {
    width: 5px;
    margin-right: 10px;
    transform: rotate(90deg);
    transition: 0.3s;
}

.btn-add-table {
    font-size: 10px;
    color: black;
    margin-top: -10px;
}

.btn-add-table:hover {
    font-size: 11px;
    transition: 0.3s;
}

.table {
    margin-left: 1rem;
}

.column {
    margin-left: 2rem;
}

.table:hover,
.column:hover,
.db:hover {
    text-decoration: underline;
}
</style>

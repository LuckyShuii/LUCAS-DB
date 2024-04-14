<script setup>
import { ref, onMounted } from 'vue'

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

const getDatabases = async () => {
    console.log('Getting databases')
}

onMounted(async () => {
    await getDatabases()
    console.log("bruh")
})
</script>

<template>
    <section id="databases">
        <ul>
            <li v-for="database in databases" :key="database" class="db-item">
                <button class="db button-no-style">
                    <img src="../../assets/icons/menu-arrow.svg" class="menu-arrow" alt="arrow" />
                    <img src="../../assets/icons/db.svg" alt="Database" />
                    {{ database.database }}
                </button>
                <button class="btn-add-table button-no-style">
                    <img src="../../assets/icons/add.svg" alt="Add" />
                    ajouter une table
                </button>
                <ul>
                    <li v-for="table in database.tables" :key="table">
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
}

.db-item {
    margin: 1rem 0;
}

.menu-arrow {
    width: 5px;
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

<template>
    <v-dialog v-model="state.dialog" persistent @after-leave="leaveOrder">
        <template #activator="{ props: activatorProps }">
            <v-tooltip text="New Transaction" location="bottom" v-bind="activatorProps">
                <template #activator="{ props }">
                    <v-btn v-bind="props" icon="mdi-plus" color="primary" @click="state.dialog = true" />
                </template>
            </v-tooltip>
        </template>

        <!-- dialog content -->
        <v-card class="v-col-12 v-col-lg-8 v-col-md-9 v-col-sm-11 pa-0 ma-auto bg-surface" height="400" width="100%" variant="tonal">
            <v-toolbar title="New Order">
                <v-toolbar-items>
                    <v-btn icon="mdi-close" color="error" @click="state.dialog = false"></v-btn>
                </v-toolbar-items>
            </v-toolbar>
            <v-card-text>
                <!-- :items="[store.gold_price]" store.gold_price is object but my datatable needs object of array so we use this [] to convert to array -->
                <DataTable :items="[store.gold_price]" :headers="state.headers" :loading="store.loading">

                    <!-- actions -->
                    <template #item.actions="{ item }">
                        <slot :item="item" :name="item">
                            <v-btn color="primary">select</v-btn>
                        </slot>
                    </template>

                    <!-- change percnet -->
                    <template #item.change="{ item }">
                        <slot :item="item" :name="item">
                            <span>{{ item.change }}</span>
                            <v-chip size="small" :color="Number(item.change_percent.slice(0, 4)) > 0 ? 'success' : 'error'" class="ml-1">{{ item.change_percent }}</v-chip>
                        </slot>
                    </template>
                </DataTable>
            </v-card-text>

            <!-- buy / sell form -->
            <v-card-text class="pb-3">
                <v-row class="ma-0">
                    <v-col cols="12" md="4" class="pa-1">
                        <v-text-field hide-details v-model="store.gold_price.buy_price" readonly variant="outlined" label="Price" />
                    </v-col>
                    <v-col cols="12" md="4" class="pa-1">
                        <v-text-field hide-details v-model="state.weight" variant="outlined" label="Weight" />
                    </v-col>
                    <v-col cols="12" md="4" class="pa-1">
                        <v-text-field hide-details v-model="state.fee" readonly variant="outlined" label="Fee" />
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-text class="pt-0 d-flex align-center justify-end">
                <v-btn color="success" @click="addOrder" :loading="state.saving">buy</v-btn>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script setup lang="ts">
import { reactive, watch } from 'vue'

// componenets
import DataTable from '@/components/ui/table/DataTable.vue';

// store
import { useTransactionStore } from '@/stores/transaction';
const store = useTransactionStore()

// reactive state
const state = reactive({
    dialog: false,
    headers:[
        { title:'#', value:'name', align:'' },
        { title:'Price', value:'buy_price', align:'' },
        { title:'Hight Price', value:'sell_price', align:'' },
        { title:'Low Price', value:'low_price', align:'' },
        { title:'chage', value:'change', align:'' },
        // { title:'', value:'change_percent', align:'' },
        { title:'Date Time', value:'date_time', align:'' },
        { title:'Actions', value:'actions', align:'' },
    ],
    weight: 0,
    fee: 1.1,
    saving: false
})

// price loads when dialog is true
watch (
    () => state.dialog,
    async (n, o) => {
        if (n === true) await store.goldPrice()
    }
)

// new order
const addOrder = async() => {
    state.saving = true

    const payload = {
        user_id: "03aef993-e46b-4727-9be6-0861001b9fc6",
        price: Number(store.gold_price.buy_price.replace(/,/g, '')),
        weight: Number(state.weight),
        fee: Number(state.fee),
        type: 'buy'
    }

    try {
        await store.storeTransaction(payload)
    } catch (error) {
        return error
    }
    finally {
        state.saving = false
        state.dialog = false
    }
}

// clear inputs
const leaveOrder = () => {
    state.dialog = false,
    state.weight = 0
}
</script>

<style lang="scss" scoped>
.create {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 1rem;
}
</style>

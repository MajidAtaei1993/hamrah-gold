<template>
    <div class="Welcome">
        <!-- toolbar -->
        <v-toolbar variant="tonal" title="Transactions" class="rounded-t">
            <v-toolbar-items>
                <CreateTransaction />
            </v-toolbar-items>
        </v-toolbar>
        <v-card variant="tonal" width="100%" height="70vh" class="rounded-t-0 d-flex align-start" :loading="store.loading">

            <!-- left panel show all transactions -->
            <v-card-text class="w-75 h-100 border-r pa-2 position-relative overflow-hidden">
                <DataTable :items="store.transactions" :headers="store.headers" :loading="store.loading">

                    <!-- slot for footer -->
                    <template #bottom>
                        <div class="border-t px-6 pt-3 d-flex align-center justify-space-between position-absolute bottom-0 w-100 left-0 mb-3">
                            <span class="text-h6 text-capitalize">total order: {{ store.transactions.length }}</span>
                            <span class="text-h6 text-capitalize">total Weight: {{ totalWeight }}</span>
                            <span class="text-h6 text-capitalize">total IRR: {{ formattedTotalIRR }}</span>
                        </div>
                        <v-pagination></v-pagination>
                    </template>

                    <!-- type -->
                     <template #item.type="{ item }">
                        <slot :item="item" :name="item">
                            <v-chip :color="item.type === 'buy' ? 'primary' : 'secondary'">{{ item.type }}</v-chip>
                        </slot>
                     </template>

                    <!-- result -->
                    <template #item.total="{ item }">
                        <slot :item="item" :name="item">
                            <strong>{{ item.total }}</strong>
                        </slot>
                    </template>

                    <!-- create date -->
                     <template #item.created_at="{ item }">
                        <slot :item="item" :name="item">
                            <span>{{ new Date(item.created_at).toLocaleDateString('fa-IR-u-nu-latn') }}</span>
                        </slot>
                     </template>
                </DataTable>
            </v-card-text>


            <!-- Right panel live price -->
            <v-card-text class="w-25 h-100 pa-2">
                <v-list-item class="border rounded">

                    <!-- title -->
                    <template #title>
                        <div class="d-flex align-center justify-space-between">
                            <span class="text-capitalize">{{ store.gold_price.name }}</span>
                            <span>{{ store.gold_price.buy_price }} IRR</span>
                        </div>
                    </template>
                    
                    <!-- subtitle -->
                    <template #subtitle>
                        <div class="d-flex align-center justify-space-between w-100">
                            <span class="change-percent" :class="[Math.floor((new Date(store.gold_price.date_time).getTime() - state.timeToday) / (1000 * 60 * 60 * 24)) < 0 ? 'text-grey' : 'text-success']">
                                ({{ store.gold_price.change_percent }}) {{ store.gold_price.change }}
                                
                                <!-- live animation -->
                                <span class="live" :class="[Math.floor((new Date(store.gold_price.date_time).getTime() - state.timeToday) / (1000 * 60 * 60 * 24)) < 0 ? 'bg-grey' : 'bg-success']" />
                            </span>
                            <span class="time-date" :class="[Math.floor((new Date(store.gold_price.date_time).getTime() - state.timeToday) / (1000 * 60 * 60 * 24)) < 0 ? 'text-grey' : 'text-success']">
                                {{ store.gold_price.date_time }}
                            </span>
                        </div>
                    </template>
                </v-list-item>
            </v-card-text>
        </v-card>
    </div>
</template>

<script setup lang="ts">
import { reactive, onMounted, onUnmounted, computed } from 'vue'
import { useTransactionStore } from '@/stores/transaction'

const store = useTransactionStore()

// components
import CreateTransaction from '@/components/transactions/Create.vue'
import DataTable from '@/components/ui/table/DataTable.vue'

const state = reactive({
   count: 0,
   timeToday: new Date().getTime()
})

onMounted(async() => {
    await store.allTranaction();
    await store.goldPrice()

    // const interval = setInterval(() => {
    //     store.allTranaction();
    // }, 10000);

    // // cleanup on unmount
    // onUnmounted(() => clearInterval(interval));
})

const totalWeight = computed(() => {
    return store.transactions.reduce(
        (sum, tr) => sum + Number(tr.weight || 0),
        0
    )
})

const totalIRR = computed(() => {
    return store.transactions.reduce((sum, tr) => {
        const total = Number((tr.total || '0').toString().replace(/,/g, ''))
        return sum + total
    }, 0)
})

const formattedTotalIRR = computed(() => {
    return totalIRR.value.toLocaleString('en-US')
})
</script>

<style lang="scss" scoped>
.Welcome {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 5% 15%;
    & span.time-date{
        font-size: 10px;
        width: fit-content;
    }
    & span.change-percent{
        position: relative;
        font-size: 12px;
        display: flex;
        align-items: center;
        padding: 6px 2px;
        padding-left: 1rem;
        span.live {
            display: block;
            position: absolute;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            left: 0;
            bottom: 0;
            top: 0;
            left: 0;
            bottom: 0;
            margin: auto 0;
            margin-left: .25rem;
    
            &:before {
                content: "";
                position: absolute;
                display: block;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                width: 150%;
                height: 150%;
                box-sizing: border-box;
                border-radius: 50%;
                background-color: inherit;
                animation: pulse 1.25s infinite;
                margin: auto;
                margin-right: -0.15rem;
            }
        }
    }
}
@keyframes pulse {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    100% {
        transform: scale(1.5);
        opacity: 0;
    }
}

@keyframes circle {
    0% {
        transform: scale(0.8);
        opacity: 0.5;
    }
    50% {
            transform: scale(1);
        }
    100% {
        transform: scale(0.8);
    }
}
</style>